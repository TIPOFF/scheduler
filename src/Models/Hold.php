<?php namespace Tipoff\Scheduling\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class Hold extends BaseModel
{
    use HasPackageFactory;

    // find the slot
    public function slot()
    {
        return $this->belongsTo(app('slot'), 'slot_id');
    }

    // find the creator
    public function creator()
    {
        return $this->belongsTo(app('user'), 'creator_id');
    }
}
