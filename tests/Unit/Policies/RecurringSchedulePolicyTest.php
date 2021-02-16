<?php

declare(strict_types=1);

namespace Tipoff\Scheduling\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Scheduling\Models\RecurringSchedule;
use Tipoff\Scheduling\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class RecurringSchedulePolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view schedules', true);
        $this->assertTrue($user->can('viewAny', RecurringSchedule::class));

        $user = self::createPermissionedUser('view schedules', false);
        $this->assertFalse($user->can('viewAny', RecurringSchedule::class));
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_as_creator
     */
    public function all_permissions_as_creator(string $permission, UserInterface $user, bool $expected)
    {
        $schedule = RecurringSchedule::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $schedule));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view schedules', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view schedules', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create schedules', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create schedules', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update schedules', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update schedules', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete schedules', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete schedules', false), false ],
        ];
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_not_creator
     */
    public function all_permissions_not_creator(string $permission, UserInterface $user, bool $expected)
    {
        $schedule = RecurringSchedule::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $schedule));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
