<?php 

declare(strict_types=1);

namespace Tipoff\Schediling\Filters;

use Illuminate\Database\Eloquent\Builder;

class GameFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $availableFilters = [
        'date',
        'location',
    ];

    /**
     * Filter the query by a given date.
     *
     * @param string $date
     * @return Builder
     */
    protected function date($date)
    {
        return $this->builder->whereDate('date', $date);
    }

    /**
     * Filter the query by a given location slug.
     *
     * @param string $location
     * @return Builder
     */
    protected function location($location)
    {
        return $this->builder->whereHas('room', function ($query) use ($location) {
            $query->whereHas('location', function ($query) use ($location) {
                return $query->where('slug', $location);
            });
        });
    }
}
