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
             'view slots' => ['Owner', 'Staff'],
             'create slots' => ['Owner', 'Staff'],
             'update slots' => ['Owner', 'Staff'],
             'delete slots' => [],
        ];
        $this->createPermissions($permissions);
    }
}
