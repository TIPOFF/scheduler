<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Scheduler\Models\Block;
use Tipoff\Scheduler\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class BlockPolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view blocks', true);
        $this->assertTrue($user->can('viewAny', Block::class));

        $user = self::createPermissionedUser('view blocks', false);
        $this->assertFalse($user->can('viewAny', Block::class));
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_as_creator
     */
    public function all_permissions_as_creator(string $permission, UserInterface $user, bool $expected)
    {
        $block = Block::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $block));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view blocks', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view blocks', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create blocks', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create blocks', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update blocks', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update blocks', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete blocks', true), true ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete blocks', false), false ],
        ];
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_not_creator
     */
    public function all_permissions_not_creator(string $permission, UserInterface $user, bool $expected)
    {
        $block = Block::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $block));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
