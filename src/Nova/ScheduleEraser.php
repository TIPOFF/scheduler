<?php

namespace Tipoff\Scheduling\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\EscapeRoom\Filters\Room;
use Tipoff\EscapeRoom\Filters\RoomLocation;
use Tipoff\Support\Nova\BaseResource;

class ScheduleEraser extends BaseResource
{
    public static $model = \Tipoff\Scheduling\Models\ScheduleEraser::class;

    public static $title = 'id';

    public static $search = [
        'id',
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
            return $query;
        }

        return $query->whereHas('room', function ($roomlocation) use ($request) {
            return $roomlocation->whereIn('location_id', $request->user()->locations->pluck('id'));
        })->select('schedule_erasers.*')
            ->leftJoin('rooms as room', 'room.id', '=', 'schedule_erasers.room_id');
    }

    public static $group = 'Operations Scheduling';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('Room', 'room.id', function () {
                return $this->room->name;
            })->sortable(),
            DateTime::make('Start at')->sortable(),
            DateTime::make('End at')->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            nova('room') ? BelongsTo::make('Room', 'room', nova('room'))->required() : null,
            DateTime::make('Start at')->required(),
            DateTime::make('End at')->required(),

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function dataFields(): array
    {
        return array_filter([
            ID::make(),
            nova('user') ? BelongsTo::make('Created By', 'creator', nova('user'))->exceptOnForms() : null,
            DateTime::make('Created At')->exceptOnForms(),
            DateTime::make('Updated At')->exceptOnForms(),
        ]);
    }

    public function filters(Request $request)
    {
        return [
            // TODO replace these stubs. Add $filters from $request?
            new RoomLocation($filters = []),
            new Room($filters = []),
        ];
    }
}
