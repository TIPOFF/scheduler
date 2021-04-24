<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Nova\Filters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class SlotRoomLocation extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Location';

    /**
     * Apply the filter to the given query.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query
            ->join('slots', 'slots.id', 'escaperoom_slot_id')
            ->join('rooms', 'rooms.id', 'slots.room_id')
            ->where('rooms.location_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        /** @var Model $locationModel */
        $locationModel = app('location');

        return $locationModel::pluck('id', 'name');
    }
}
