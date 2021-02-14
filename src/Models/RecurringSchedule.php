<?php

declare(strict_types=1);

namespace Tipoff\Scheduling\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class RecurringSchedule extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;
    use HasUpdater;

    protected $casts = [
        'date' => 'date',
        'valid_from' => 'date',
        'expires_at' => 'date',
    ];

    public static function boot()
    {
        parent::boot();


        static::saving(function ($schedule) {
            if (empty($schedule->room_id)) {
                throw new \Exception('Schedule must be assigned to a room.');
            }
            if (empty($schedule->day)) {
                throw new \Exception('Recurring Schedules must have a day of the week.');
            }
            if (empty($schedule->time)) {
                throw new \Exception('Schedule must have a time set in the location\'s timezone.');
            }
            
            /** @var Model $roomModel */
            $roomModel = app('room');
            $room = $roomModel::findOrFail($schedule->room_id);
            
            if (empty($schedule->rate_id)) {
                $schedule->rate_id = $room->rate_id;
            }
            if (empty($schedule->valid_from)) {
                $schedule->valid_from = Carbon::today();
            }
        });
    }

    /**
     * Scope a query to apply filters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $filters array
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $filters)
    {
        if (empty($filters)) {
            return $query;
        }

        foreach ($filters as $filterKey => $filterValue) {
            switch ($filterKey) {
                case 'room_id':
                case 'rate_id':
                case 'date':
                case 'valid_from':
                case 'expires_at':
                case 'day':
                    $query->where($filterKey, $filterValue);

                    break;
            }
        }

        return $query;
    }

    public function room()
    {
        return $this->belongsTo(app('room'));
    }

    public function rate()
    {
        return $this->belongsTo(app('rate'));
    }

    /**
     * Generate collection of slots for specific period.
     *
     * @return Collection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function generateSlotsForPeriod($initialDate, $finalDate)
    {
        $slots = collect([]);

        $period = CarbonPeriod::create($initialDate, $finalDate);
        foreach ($period as $date) {
            $slots = $slots->merge($this->generateSlotsForDate($date));
        }

        return $slots;
    }

    /**
     * Generate collection of slots for specified date.
     *
     * @return Collection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function generateSlotsForDate($date)
    {
        $slot_model = app('slot');

        $slots = [];
        if ($this->matchDate($date)) {
            $startAt = Carbon::parse($date->format('Y-m-d') . ' ' . $this->time, $this->room->location->php_tz)->setTimeZone('UTC');

            /** @var Model $slot_model */
            $slots[] = $slot_model::make([
                'room_id' => $this->room_id,
                'schedule_type' => 'recurring_schedules',
                'schedule_id' => $this->id,
                'rate_id' => $this->rate_id,
                'start_at' => $startAt,
            ])
                ->generateDates()
                ->generateSlotNumber()
                ->updateParticipants();
        }

        return collect($slots);
    }

    /**
     * Determine if schedule is matching date.
     *
     * @param string|Carbon|\DateTime $date
     * @return bool
     */
    public function matchDate($date)
    {
        if (is_string($date)) {
            $date = new \DateTime($date);
        }

        return in_array($date->format('N'), [$this->day]);
    }

    /**
     * Scope a query to rows visible by user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisibleBy($query, $user)
    {
        return $query;
    }
}
