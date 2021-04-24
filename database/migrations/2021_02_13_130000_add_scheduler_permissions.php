<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddSchedulerPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
             'view blocks' => ['Owner', 'Executive', 'Staff'],
             'create blocks' => ['Owner', 'Executive', 'Staff'],
             'update blocks' => ['Owner', 'Executive', 'Staff'],
             'delete blocks' => ['Owner', 'Executive', 'Staff'],
             'view games' => ['Owner', 'Executive', 'Staff'],
             'update games' => ['Owner', 'Executive', 'Staff'],
             'view schedules' => ['Owner', 'Executive', 'Staff'],
             'create schedules' => ['Owner', 'Executive', 'Staff'],
             'update schedules' => ['Owner', 'Executive', 'Staff'],
             'delete schedules' => ['Owner', 'Executive', 'Staff'],
             'view escape room slots' => ['Owner', 'Executive', 'Staff'],
             'create escape room slots' => ['Owner', 'Executive', 'Staff'],
             'update escape room slots' => ['Owner', 'Executive', 'Staff'],
             'delete escape room slots' => [],
        ];
        $this->createPermissions($permissions);
    }
}
