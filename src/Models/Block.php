<?php namespace Tipoff\Scheduling\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class Block extends BaseModel
{
    use HasPackageFactory;

    protected $guarded = ['id'];

    protected $casts = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($block) {
            if (empty($block->slot_id)) {
                throw new \Exception('A participant block must be for an availability slot.');
            }
            if (empty($block->participants)) {
                $block->participants = 20; // This completely blocks the slot since there are no rooms with a 20 participant capacity
            }
            if (auth()->check()) {
                $block->creator_id = auth()->id();
            }
        });

        static::saved(function ($block) {
            $block->updateSlot();
        });
        static::deleted(function ($block) {
            $block->updateSlot();
        });
    }

    public function updateSlot()
    {
        $slot = Slot::find($this->slot_id);
        $slot->participants_blocked = $slot->blocks->sum('participants');
        if (auth()->check()) {
            $slot->updater_id = auth()->id();
        }
        $slot->save();

        return $this;
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function room()
    {
        return $this->hasOneThrough(config('tipoff.model_class.room'), Slot::class, 'id', 'id', 'slot_id', 'room_id');
    }

    public function creator()
    {
        return $this->belongsTo(config('tipoff.model_class.user'), 'creator_id');
    }

    public function notes()
    {
        return $this->morphMany(config('tipoff.model_class.note'), 'noteable');
    }
}
