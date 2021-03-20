<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Tipoff\Scheduler\Collections\SlotsCollection;
use Tipoff\Scheduler\Models\RecurringSchedule;
use Tipoff\Scheduler\Models\ScheduleEraser;
use Tipoff\Scheduler\Models\Slot;

class EscaperoomSchedulingService
{
    /**
     * Generate date from slot number.
     *
     * @param string $slotNumber
     * @return Carbon|false
     */
    public function generateDateFromSlotNumber($slotNumber)
    {
        $date = substr($slotNumber, 0, 6);

        return Carbon::createFromFormat('ymd', $date);
    }

    /**
     * Get location id by slot number.
     *
     * @param string $slotNumber
     * @return int
     */
    public function getLocationIdBySlotNumber($slotNumber)
    {
        return (int) explode('-', $slotNumber)[1];
    }

    /**
     * Get location slots by date range.
     *
     * @param int $locationId
     * @param string $initialDate
     * @param string|null $finalDate
     * @return SlotsCollection
     */
    public function getLocationSlotsForDateRange($locationId, $initialDate, $finalDate = null)
    {
        if (empty($finalDate)) {
            $finalDate = $initialDate;
        }

        $items = app('slot')->whereDate('date', '<=', $finalDate)
            ->whereDate('date', '>=', $initialDate)
            ->whereHas('room', function ($query) use ($locationId) {
                return $query->where('location_id', $locationId);
            })
            ->get()
            ->all();

        return new SlotsCollection($items);
    }

    /**
     * Get room slots by date range.
     *
     * @param int $roomId
     * @param string $initialDate
     * @param string|null $finalDate
     * @return SlotsCollection
     */
    public function getRoomSlotsForDateRange($roomId, $initialDate, $finalDate = null)
    {
        if (empty($finalDate)) {
            $finalDate = $initialDate;
        }

        $items = app('slot')
            ->whereDate('date', '<=', $finalDate)
            ->whereDate('date', '>=', $initialDate)
            ->where('room_id', $roomId)
            ->get()
            ->all();

        return new SlotsCollection($items);
    }

    /**
     * Get room recurring schedule for date range.
     *
     * @param int $roomId
     * @param string $initialDate
     * @param string|null $finalDate
     * @return Collection
     */
    public function getRoomRecurringScheduleForDateRange($roomId, $initialDate, $finalDate = null)
    {
        if (empty($finalDate)) {
            $finalDate = $initialDate;
        }

        return RecurringSchedule::whereDate('valid_from', '<=', $finalDate)
            ->whereDate('expires_at', '>=', $initialDate)
            ->where('room_id', $roomId)
            ->get();
    }

    /**
     * Get location recurring schedule for date range.
     *
     * @param int $locationId
     * @param string $initialDate
     * @param string|null $finalDate
     * @return Collection
     */
    public function getLocationRecurringScheduleForDateRange($locationId, $initialDate, $finalDate = null)
    {
        if (empty($finalDate)) {
            $finalDate = $initialDate;
        }

        return RecurringSchedule::whereDate('valid_from', '<=', $finalDate)
            ->where(function ($query) use ($initialDate) {
                return $query
                    ->whereDate('expires_at', '>=', $initialDate)
                    ->orWhereNull('expires_at');
            })
            ->whereHas('room', function ($query) use ($locationId) {
                return $query->where('location_id', $locationId);
            })
            ->get();
    }

    /**
     * Get schedule blockers for date range.
     *
     * @param int $locationId
     * @param Carbon $initialDate
     * @param Carbon|null $finalDate
     * @return Collection
     */
    public function getLocationScheduleErasersForDateRange($locationId, $initialDate, $finalDate = null)
    {
        if (empty($finalDate)) {
            $finalDate = $initialDate;
        }

        $initialDate = $initialDate
            ->setTimezone('UTC')
            ->toDateTimeString();

        $finalDate = $finalDate
            ->setTimezone('UTC')
            ->toDateTimeString();

        return ScheduleEraser::where('start_at', '<=', $finalDate)
            ->where('end_at', '>=', $initialDate)
            ->whereHas('room', function ($query) use ($locationId) {
                return $query->where('location_id', $locationId);
            })
            ->get();
    }

    /**
     * Get room schedule blockers for date range.
     *
     * @param string $initialDate
     * @param string $finalDate
     * @return Collection
     */
    public function getRoomScheduleErasersForDateRange($roomId, $initialDate, $finalDate = null)
    {
        if (empty($finalDate)) {
            $finalDate = $initialDate;
        }

        return ScheduleEraser::whereDate('start_at', '<=', $finalDate)
            ->whereDate('end_at', '>=', $initialDate)
            ->where('room_id', $roomId)
            ->get();
    }
}
