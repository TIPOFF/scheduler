<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class ScheduleEraser extends BaseResource
{
    public static $model = \Tipoff\Scheduler\Models\ScheduleEraser::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    /** @psalm-suppress UndefinedClass */
    protected array $filterClassList = [
        \Tipoff\EscapeRoom\Nova\Filters\Room::class,
        \Tipoff\EscapeRoom\Nova\Filters\RoomLocation::class,
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->hasPermissionTo('all locations')) {
            return $query;
        }

        return $query->whereHas('room', function ($roomlocation) use ($request) {
            return $roomlocation->whereIn('location_id', $request->user()->locations->pluck('id'));
        })->select('schedule_erasers.*')
            ->leftJoin('rooms as room', 'room.id', '=', 'schedule_erasers.room_id');
    }

    public static $group = 'Operations Scheduler';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            Text::make('Room', 'room.id', function () {
                return $this->resource->room->name;
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
        return array_merge(
            parent::dataFields(),
            $this->creatorDataFields(),
            [
                DateTime::make('Updated At')->exceptOnForms(),
            ],
        );
    }
}
