<?php

declare(strict_types=1);

namespace Tipoff\Scheduling\Nova;

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
    public static $model = \Tipoff\Scheduling\Models\Block::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    /** @psalm-suppress UndefinedClass */
    protected array $filterClassList = [
        \Tipoff\Scheduling\Filters\FutureBlocks::class,
        \Tipoff\Scheduling\Filters\SlotRoomLocation::class,
        \Tipoff\Scheduling\Filters\SlotRoom::class,
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->hasRole([
            'Admin',
            'Owner',
            'Accountant',
            'Executive',
            'Reservation Manager',
            'Reservationist',
        ])) {
            return $query
                ->select('blocks.*')
                ->leftJoin('slots as slot', 'slot.id', '=', 'blocks.slot_id')
                ->leftJoin('rooms as room', 'room.id', '=', 'slot.room_id');
        }

        return $query->whereHas('room', function ($orderlocation) use ($request) {
            return $orderlocation
                ->whereIn('room.location_id', $request->user()->locations->pluck('id'));
        })->select('blocks.*')
            ->leftJoin('slots as slot', 'slot.id', '=', 'blocks.slot_id')
            ->leftJoin('rooms as room', 'room.id', '=', 'slot.room_id');
    }

    public static $group = 'Operations Scheduling';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            nova('slot') ? BelongsTo::make('Slot', 'slot', nova('slot'))->sortable() : null,
            Number::make('Participants')->sortable(),
            Date::make('Created', 'created_at')->sortable(),
            // May include type here was a custom badge like on Feedback
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            nova('slot') ? BelongsTo::make('Slot', 'slot', nova('slot'))->hideWhenUpdating()->searchable() : null,
            Number::make('Participants')->hideWhenCreating()->min(0)->max(20)->step(1),
            Select::make('Type')->options([
                'staffing' => 'Staffing Availability or Issue',
                'consolidation' => 'Consolidation',
                'closed' => 'Closed',
                'repairs' => 'Waiting on Repairs or Maintenance',
                'conflict' => 'Scheduling Conflict',
                'training' => 'Staff training or meeting',
                'resova' => 'Booked in Resova',
                'other' => 'Other reason',
            ])->required(),
            nova('note') ? MorphMany::make('Notes', 'notes', nova('note')) : null,

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function dataFields():array
    {
        return array_filter([
            ID::make(),
            nova('user') ? BelongsTo::make('Creator', 'creator', nova('user'))->exceptOnForms() : null,
            DateTime::make('Created At')->exceptOnForms(),
            DateTime::make('Updated At')->exceptOnForms(),
        ]);
    }
}
