<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;

class AddSchedulingPermissions extends Migration
{
    public function up()
    {
        if (app()->has(Permission::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ([
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
                 ] as $name) {
                app(Permission::class)::findOrCreate($name, null);
            };
        }
    }
}
