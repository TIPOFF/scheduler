<?php

declare(strict_types=1);

namespace Tipoff\Scheduling\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class Filters
{
    /**
     * The Eloquent builder.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * Requested filters.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $availableFilters = [];

    /**
     * Create a new filter instance.
     *
     * @param array $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * Apply the filters.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            $method = Str::camel($filter);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this->builder;
    }

    /**
     * Fetch all relevant filters.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFilters()
    {
        return collect($this->filters)
            ->only($this->availableFilters);
    }
}
