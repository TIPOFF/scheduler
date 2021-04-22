<?php

namespace Tipoff\Scheduler\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class EscaperoomSlot extends BaseResource
{
    public static $model = \Tipoff\Scheduler\Models\EscaperoomSlot::class;

    public static $title = 'title';

    public static $search = [
        'start_at',
    ];

    /** @psalm-suppress UndefinedClass */
    protected array $filterClassList = [
        \Tipoff\Scheduler\Filters\FutureEscaperoomSlots::class,
        \Tipoff\EscapeRoom\Filters\RoomLocation::class,
        \Tipoff\EscapeRoom\Filters\Room::class,
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
                ->select('escaperoom_slots.*')
                ->leftJoin('rooms as room', 'room.id', '=', 'escaperoom_slots.room_id');
        }

        return $query->whereHas('room', function ($roomlocation) use ($request) {
            return $roomlocation
                ->whereIn('location_id', $request->user()->locations->pluck('id'));
        })->select('escaperoom_slots.*')
            ->leftJoin('rooms as room', 'room.id', '=', 'escaperoom_slots.room_id');
    }

    public static $group = 'Operations Scheduler';

    public static $defaultAttributes = [
        'supervision_id' => 2,
    ];

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('Slot Number')->sortable(),
            Text::make('Room', 'room.id', function () {
                return $this->room->name;
            })->sortable(),
            Text::make('Start', 'start_at', function () {
                return $this->formatted_start;
            })->sortable(),
            Date::make('Date', 'date')->sortable(),
            Number::make('Participants'),
            Number::make('Available', 'participants_available'),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Title')->exceptOnForms(),
            nova('room') ? BelongsTo::make('Room', 'room', nova('room'))->hideWhenUpdating()->required() : null,
            Text::make('Game Start', 'start_at', function () {
                return $this->formatted_start;
            })->exceptOnForms(),
            DateTime::make('Start At')->required(),
            #nova('rate') ? BelongsTo::make('Rate', 'rate', nova('rate'))->hideWhenCreating()->nullable() : null,
            nova('supervision') ? BelongsTo::make('Supervision', 'supervision', nova('supervision'))->hideWhenCreating()->nullable() : null,
            new Panel('Participant Details', $this->participantFields()),
            nova('block') ? HasMany::make('Blocks', 'blocks', nova('block')) : null,
            nova('note') ? MorphMany::make('Notes', 'notes', nova('note')) : null,
            nova('game') ? HasOne::make('Game', 'game', nova('game'))->nullable()->exceptOnForms() : null,

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function participantFields()
    {
        return [
            Number::make('Participants')->exceptOnForms(),
            Number::make('Participants Blocked')->exceptOnForms(),
            Number::make('Participants Available')->exceptOnForms(),
            Date::make('Date')->exceptOnForms(),
            DateTime::make('End At')->exceptOnForms(),
            DateTime::make('Room Available At')->exceptOnForms(),
        ];
    }

    protected function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            [
                Text::make('EscaperoomSlot Number')->exceptOnForms(),
                DateTime::make('Created At')->exceptOnForms(),
            ],
            $this->updaterDataFields(),
        );
    }
}
