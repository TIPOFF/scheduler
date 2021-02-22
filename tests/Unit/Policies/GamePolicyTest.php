<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Scheduler\Models\Game;
use Tipoff\Scheduler\Tests\TestCase;
use Tipoff\Support\Contracts\Models\UserInterface;

class GamePolicyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_any()
    {
        $user = self::createPermissionedUser('view games', true);
        $this->assertTrue($user->can('viewAny', Game::class));

        $user = self::createPermissionedUser('view games', false);
        $this->assertFalse($user->can('viewAny', Game::class));
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_as_creator
     */
    public function all_permissions_as_creator(string $permission, UserInterface $user, bool $expected)
    {
        $game = Game::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $game));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-true' => [ 'view', self::createPermissionedUser('view games', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view games', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create games', true), false ],
            'create-false' => [ 'create', self::createPermissionedUser('create games', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update games', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update games', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete games', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete games', false), false ],
        ];
    }

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_not_creator
     */
    public function all_permissions_not_creator(string $permission, UserInterface $user, bool $expected)
    {
        $game = Game::factory()->make();

        $this->assertEquals($expected, $user->can($permission, $game));
    }

    public function data_provider_for_all_permissions_not_creator()
    {
        // Permissions are identical for creator or others
        return $this->data_provider_for_all_permissions_as_creator();
    }
}
