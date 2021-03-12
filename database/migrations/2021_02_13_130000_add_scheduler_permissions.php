<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddSchedulerPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
             'view blocks',
             'create blocks',
             'update blocks',
             'delete blocks',
             'view games',
             'update games',
             'view schedules',
             'create schedules',
             'update schedules',
             'delete schedules',
             'view slots',
             'create slots',
             'update slots',
             'delete slots',
        ];
        $this->createPermissions($permissions);
    }
}
