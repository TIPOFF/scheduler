<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddSchedulerPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
             'view blocks' => ['Owner', 'Staff'],
             'create blocks' => ['Owner'],
             'update blocks' => ['Owner'],
             'delete blocks' => [],
             'view games' => ['Owner', 'Staff'],
             'update games' => ['Owner'],
             'view schedules' => ['Owner', 'Staff'],
             'create schedules' => ['Owner'],
             'update schedules' => ['Owner'],
             'delete schedules' => [],
        ];
        $this->createPermissions($permissions);
    }
}
