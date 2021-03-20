<?php

namespace Tipoff\Scheduler\Collections;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

/**
 * Slots collection is used to hold Slots models, and virtual Slots models (unsaved slots).
 */
class SlotsCollection extends Collection
{
    /**
     * Rows used in where filtering.
     *
     * @var array
     */
    protected $whereFilters = [
        'slot_number' => '=',
        'room_id' => '=',
        'rate_id' => '=',
        'schedule_id' => '=',
        'schedule_type' => '=',
    ];

    /**
     * Remove conflicts.
     *
     * @return self
     */
    public function removeConflicts()
    {
        $slots = $this
            ->whereNull('schedule_type');

        if ($slots->isEmpty()) {
            return $this;
        }

        $output = $this
            ->filter(function ($slot) use ($slots) {
                if (empty($slot->schedule_type)) {
                    return true;
                }

                return $slots
                    ->where('room_id', $slot->room_id)
                    ->activeAtTimeRange($slot->start_at, $slot->slot_available_at)
                    ->isEmpty();
            });

        return $output;
    }

    /**
     * Apply erasers to collection.
     *
     * @param Collection $erasers
     * @return self
     */
    public function applyErasers($erasers)
    {
        if ($erasers->isEmpty()) {
            return $this;
        }

        $output = $this
            ->filter(function ($slot) use ($erasers) {
                if (! $slot->isRecurring()) {
                    return true;
                }

                foreach ($erasers as $eraser) {
                    if ($slot->room_id !== $eraser->room_id) {
                        continue;
                    }
                    if ($slot->isActiveAtTimeRange($eraser->start_at, $eraser->end_at)) {
                        return false;
                    }
                }

                return true;
            });

        return $output;
    }

    /**
     * Generate slots from recurring schedules.
     *
     * @param Collection $schedules
     * @param string $initialDate
     * @param string $finalDate
     * @return self
     */
    public function applyRecurringSchedules($schedules, $initialDate, $finalDate = null)
    {
        if (empty($finalDate)) {
            $finalDate = $initialDate;
        }

        $schedules->each(function ($recurringSchedule) use ($initialDate, $finalDate) {
            $recurringSchedule
                ->generateSlotsForPeriod($initialDate, $finalDate)
                ->each(function ($slot) {
                    if ($this->where('slot_number', $slot->slot_number)->isEmpty()) {
                        $this->push($slot);
                    }
                });
        });

        return $this;
    }

    /**
     * Filter slots to those with or without holds.
     *
     * @param string|bool $value
     * @return self
     */
    public function filterHold($value)
    {
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);

        return $this->filter(function ($slot) use ($value) {
            return $slot->hasHold() === $value;
        });
    }

    /**
     * Filter slots to those with sprcific hold token.
     *
     * @param string|bool $value
     * @return self
     */
    public function filterHoldToken($value)
    {
        return $this->filter(function ($slot) use ($value) {
            if (! $hold = $slot->getHold()) {
                return false;
            }

            return $hold['hold_token'] === $value;
        });
    }

    /**
     * Filter slots to those active at time (UTC).
     *
     * @param null|string|Carbon $value
     * @return self
     */
    public function filterActiveAt($value)
    {
        return $this->filter(function ($slot) use ($value) {
            if ($slot->start_at < $value && $slot->slot_available_at > $value) {
                return true;
            }

            return false;
        });
    }

    /**
     * Find slots active at time range (UTC).
     *
     * @param string $initialTime
     * @param string $finalTime
     * @return self
     */
    public function activeAtTimeRange($initialTime, $finalTime)
    {
        $initialTime = Carbon::parse($initialTime, 'UTC');
        $finalTime = Carbon::parse($finalTime, 'UTC');

        return $this->filter(function ($slot) use ($initialTime, $finalTime) {
            if (
                ($slot->start_at >= $initialTime && $slot->start_at <= $finalTime) ||
                ($slot->slot_available_at >= $initialTime && $slot->slot_available_at <= $finalTime) ||
                ($slot->start_at <= $initialTime && $slot->slot_available_at >= $finalTime)
            ) {
                return true;
            }

            return false;
        });
    }

    /**
     * Filter slots to bookable ones.
     *
     * @param string|bool $value
     * @return self
     */
    public function filterBookable($value)
    {
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);

        if (! $value) {
            return $this;
        }

        return $this->filter(function ($slot) {
            return $slot->isBookable();
        });
    }

    /**
     * Filter items inside collection.
     *
     * Array got format [['key' => 'value']].
     *
     * @param array $filters
     * @return self
     */
    public function applyFilters($filters)
    {
        if (empty($filters)) {
            return $this;
        }

        $output = $this;

        foreach ($filters as $key => $value) {
            // Check if its simple where()
            if (isset($this->whereFilters[$key])) {
                $output = $output->where($key, $this->whereFilters[$key], $value);
            }

            // Check if its custom method like $this->filterSomething
            $filterMethod = 'filter' . Str::camel($key);
            if (method_exists($this, $filterMethod)) {
                $output = $output->{$filterMethod}($value);
            }
        }

        return $output;
    }
}
