<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class Block extends BaseResource
{
    public static $model = \Tipoff\Scheduler\Models\Block::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    /** @psalm-suppress UndefinedClass */
    protected array $filterClassList = [
        \Tipoff\Scheduler\Nova\Filters\FutureBlocks::class,
        \Tipoff\Scheduler\Nova\Filters\SlotRoomLocation::class,
        \Tipoff\Scheduler\Nova\Filters\SlotRoom::class,
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->hasPermissionTo('all locations')) {
            return $query
                ->select('blocks.*')
                ->leftJoin('escaperoom_slots as slot', 'slot.id', '=', 'blocks.escaperoom_slot_id')
                ->leftJoin('rooms as room', 'room.id', '=', 'slot.room_id');
        }

        return $query->whereHas('room', function ($room) use ($request) {
            return $room
                ->whereIn('room.location_id', $request->user()->locations->pluck('id'));
        })->select('blocks.*')
            ->leftJoin('escaperoom_slots as slot', 'slot.id', '=', 'blocks.escaperoom_slot_id')
            ->leftJoin('rooms as room', 'room.id', '=', 'slot.room_id');
    }

    public static $group = 'Operations Scheduler';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            nova('escaperoom_slot') ? BelongsTo::make('EscaperoomSlot', 'slot', nova('slot'))->sortable() : null,
            Number::make('Participants')->sortable(),
            Date::make('Created', 'created_at')->sortable(),
            // May include type here was a custom badge like on Feedback
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([

            nova('escaperoom_slot') ? BelongsTo::make('EscaperoomSlot', 'slot', nova('slot'))->hideWhenUpdating()->searchable() : null,
            Number::make('Participants')->hideWhenCreating()->min(0)->max(20)->step(1),
            Select::make('Type')->options([
                'staffing' => 'Staffing Availability or Issue',
                'consolidation' => 'Consolidation',
                'closed' => 'Closed',
                'repairs' => 'Waiting on Repairs or Maintenance',
                'conflict' => 'Scheduler Conflict',
                'training' => 'Staff training or meeting',
                'resova' => 'Booked in Resova',
                'other' => 'Other reason',
            ])->required(),
            nova('note') ? MorphMany::make('Notes', 'notes', nova('note')) : null,

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            $this->creatorDataFields(),
            [
                DateTime::make('Updated At')->exceptOnForms(),
            ],
        );
    }
}
