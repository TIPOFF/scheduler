<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;

class Block extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;

    protected $casts = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($block) {
            if (empty($block->escaperoom_slot_id)) {
                throw new \Exception('A participant block must be for an availability slot.');
            }
            if (empty($block->participants)) {
                $block->participants = 20; // This completely blocks the slot since there are no rooms with a 20 participant capacity
            }
        });

        static::saved(function ($block) {
            $block->updateEscaperoomSlot();
        });
        static::deleted(function ($block) {
            $block->updateEscaperoomSlot();
        });
    }

    public function updateEscaperoomSlot()
    {
        /** @var EscaperoomSlot $slot */
        $slot = EscaperoomSlot::find($this->escaperoom_slot_id);

        $slot->participants_blocked = $slot->blocks->sum('participants');

        if (auth()->check()) {
            $slot->updater_id = auth()->id();
        }

        $slot->save();

        return $this;
    }

    public function slot()
    {
        return $this->belongsTo(app('escaperoom_slot'));
    }

    public function room()
    {
        return $this->hasOneThrough(app('room'), app('escaperoom_slot'), 'id', 'id', 'escaperoom_slot_id', 'room_id');
    }

    public function notes()
    {
        return $this->morphMany(app('note'), 'noteable');
    }
}
