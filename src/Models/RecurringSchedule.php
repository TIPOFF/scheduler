<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Models;

use Assert\Assert;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Tipoff\Support\Contracts\Models\UserInterface;
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
            Assert::lazy()
                ->that($schedule->room_id)->notEmpty('Schedule must be assigned to a room.')
                ->that($schedule->day)->notEmpty('Recurring Schedules must have a day of the week.')
                ->that($schedule->time)->notEmpty('Schedule must have a time set in the location\'s timezone.')
                ->verifyNow();

            /** @var Model $roomModel */
            $roomModel = app('room');
            $room = $roomModel::findOrFail($schedule->room_id);

            if (empty($schedule->escaperoom_rate_id)) {
                $schedule->escaperoom_rate_id = $room->escaperoom_rate_id;
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
                case 'escaperoom_rate_id':
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

    public function escaperoom_rate()
    {
        return $this->belongsTo(app('escaperoom_rate'), 'escaperoom_rate_id');
    }

    /**
     * Generate collection of slots for specific period.
     *
     * @return Collection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function generateEscaperoomSlotsForPeriod($initialDate, $finalDate)
    {
        $slots = collect([]);

        $period = CarbonPeriod::create($initialDate, $finalDate);
        foreach ($period as $date) {
            $slots = $slots->merge($this->generateEscaperoomSlotsForDate($date));
        }

        return $slots;
    }

    /**
     * Generate collection of slots for specified date.
     *
     * @return Collection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function generateEscaperoomSlotsForDate($date)
    {
        $slot_model = app('escaperoom_slot');

        $slots = [];
        if ($this->matchDate($date)) {
            $startAt = Carbon::parse($date->format('Y-m-d') . ' ' . $this->time, $this->room->location->php_tz)->setTimeZone('UTC');

            /** @var Model $slot_model */
            $slots[] = $slot_model::make([
                'room_id' => $this->room_id,
                'schedule_type' => 'recurring_schedules',
                'schedule_id' => $this->id,
                'escaperoom_rate_id' => $this->escaperoom_rate_id,
                'start_at' => $startAt,
            ])
                ->generateDates()
                ->generateEscaperoomSlotNumber()
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
     * @param \Tipoff\Support\Contracts\Models\UserInterface $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisibleBy(Builder $query, UserInterface $user) : Builder
    {
        return $query;
    }
}
