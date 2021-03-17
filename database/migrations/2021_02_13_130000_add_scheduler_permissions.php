<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddSchedulerPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
             'view blocks' => ['Owner', 'Staff'],
             'create blocks' => ['Owner', 'Staff'],
             'update blocks' => ['Owner', 'Staff'],
             'delete blocks' => ['Owner', 'Staff'],
             'view games' => ['Owner', 'Staff'],
             'update games' => ['Owner', 'Staff'],
             'view schedules' => ['Owner', 'Staff'],
             'create schedules' => ['Owner', 'Staff'],
             'update schedules' => ['Owner', 'Staff'],
             'delete schedules' => ['Owner', 'Staff'],
             'view escape room slots' => ['Owner', 'Staff'],
             'create escape room slots' => ['Owner', 'Staff'],
             'update escape room slots' => ['Owner', 'Staff'],
             'delete escape room slots' => [],
        ];
        $this->createPermissions($permissions);
    }
}
