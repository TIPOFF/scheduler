<?php

declare(strict_types=1);

namespace Tipoff\Scheduling\Models;

use Tipoff\Support\Contracts\Scheduling\HoldInterface;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;

class Hold extends BaseModel implements HoldInterface
{
    use HasPackageFactory;
    use HasCreator;

    // find the slot
    public function slot()
    {
        return $this->belongsTo(app('slot'), 'slot_id');
    }
}
