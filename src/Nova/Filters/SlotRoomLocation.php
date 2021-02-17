<?php

declare(strict_types=1);

namespace Tipoff\Scheduling\Nova\Filters;

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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query
            ->join('slots', 'slots.id', 'slot_id')
            ->join('rooms', 'rooms.id', 'slots.room_id')
            ->where('rooms.location_id', $value)
            ->get();
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return \Tipoff\Locations\Models\Location::pluck('id', 'name');
    }
}
