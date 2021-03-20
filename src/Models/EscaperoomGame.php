<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Models;

use Assert\Assert;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Tipoff\Scheduler\Filters\GameFilters;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class EscaperoomGame extends BaseModel
{
    use HasPackageFactory;
    use HasUpdater;

    protected $guarded = [
        'id',
        'game_number',
        'room_id',
        'date',
        'escaped',
    ];


    protected $casts = [
        'initiated_at' => 'datetime',
        'date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($game) {
            do {
                $token = Str::of(Carbon::parse($game->slot->start_at)->setTimeZone($game->room->location->php_tz)->format('ymdB'))->substr(1, 7).Str::upper(Str::random(3));
            } while (self::where('game_number', $token)->first()); // check if the token already exists and if it does, try again

            /** @var EscaperoomSlot $slot */
            $slot = EscaperoomSlot::findOrFail($game->escaperoom_slot_id);

            $game->game_number = $token;
            $game->initiated_at = $slot->start_at;
            $game->participants = $game->slot->participants;
        });

        static::saving(function ($game) {
            Assert::lazy()
                ->that($game->escaperoom_slot_id)->notEmpty('A game must have a time slot.')
                ->verifyNow();
            $game->room_id = $game->slot->room_id;
            $game->date = $game->slot->date;
            if (empty($game->supervision_id)) {
                $game->supervision_id = $game->slot->supervision_id;
            }
            if (isset($game->time)) {
                $min = $game->time / 60;
                if ($min < $game->room->theme->duration) {
                    $game->escaped = true;
                    $game->reached_final_stage = true;
                    $game->finished = true;
                }
            }
            if (isset($game->clues)) {
                $game->finished = true;
            }
        });
    }

    public function slot()
    {
        return $this->belongsTo(app('escaperoom_slot'), 'escaperoom_slot_id');
    }

    public function room()
    {
        return $this->belongsTo(app('room'));
    }

    public function supervision()
    {
        return $this->belongsTo(app('supervision'));
    }

    public function monitor()
    {
        return $this->belongsTo(app('user'), 'monitor_id');
    }

    public function receptionist()
    {
        return $this->belongsTo(app('user'), 'receptionist_id');
    }

    public function manager()
    {
        return $this->belongsTo(app('user'), 'manager_id');
    }

    public function notes()
    {
        return $this->morphMany(app('note'), 'noteable');
    }

    public function booking()
    {
        return $this->morphMany(app('booking'), 'experience');
    }

    public function scopeFilter($query, array $filters = [])
    {
        return (new GameFilters($filters))->apply($query);
    }
}
