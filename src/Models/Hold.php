<?php namespace Tipoff\Scheduling\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasCreator;

class Hold extends BaseModel
{
    use HasPackageFactory;
    use HasCreator;

    // find the slot
    public function slot()
    {
        return $this->belongsTo(app('slot'), 'slot_id');
    }

}
