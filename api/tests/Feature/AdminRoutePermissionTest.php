<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\MuscleGroup;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Artisan;

class AdminRoutePermissionTest extends TestCase {
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();

        Artisan::call('app:setup:access-control');

        $admin = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $role = Role::firstOrCreate(['name' => 'admin']);
        $admin->assignRole($role);

        Exercise::create([
            'name' => 'Test Exercise',
            'gif' => 'path/to/exercise.gif',
            'muscle_group_id' => MuscleGroup::first()->id,
        ]);

        Sanctum::actingAs($admin);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('routesProvider')]
    public function test_admin_can_access_route(string $method, string $uri, array $payload) {
        $response = $this->json($method, $uri, $payload);
        $response->assertSuccessful();
    }


    public static function routesProvider(): array {
        return [
            'get muscle-group list' => ['GET', '/thorn-api/muscle-group', []],
            'post create muscle-group' => ['POST', '/thorn-api/muscle-group', ['name' => 'Test Muscle Group']],
            'get specific muscle-group' => ['GET', '/thorn-api/muscle-group/1', []],
            'put update muscle-group' => ['PUT', '/thorn-api/muscle-group/1', ['name' => 'Updated Muscle Group']],
            'delete muscle-group' => ['DELETE', '/thorn-api/muscle-group/1', []],

            'get exercise list' => ['GET', '/thorn-api/exercise', []],
            'post create exercise' => ['POST', '/thorn-api/exercise', [
                'name' => 'Test Exercise',
                'muscle_group_id' => 1,
                'gif' => \Illuminate\Http\UploadedFile::fake()->image('exercise.gif'),
            ]],
            'get specific exercise' => ['GET', '/thorn-api/exercise/1', []],
            'put update exercise' => ['PUT', '/thorn-api/exercise/1', [
                'name' => 'Updated Exercise',
                'muscle_group_id' => 1,
            ]],
            'delete exercise' => ['DELETE', '/thorn-api/exercise/1', []],
            // ['GET', '/thorn-api/permission', []],
            // ['POST', '/thorn-api/permission', ['name' => 'create-post']],
            // ['GET', '/thorn-api/permission/1', []],
            // ['PUT', '/thorn-api/permission/1', ['name' => 'edit-post']],
            // ['DELETE', '/thorn-api/permission/1', []],

            // ['GET', '/thorn-api/role', []],
            // ['POST', '/thorn-api/role', ['name' => 'manager']],
            // ['GET', '/thorn-api/role/1', []],
            // ['PUT', '/thorn-api/role/1', ['name' => 'super-manager']],
            // ['DELETE', '/thorn-api/role/1', []],
            // ['POST', '/thorn-api/role/1/assign/permission', ['permission_id' => 1]],
            // ['POST', '/thorn-api/role/1/revoke/permission', ['permission_id' => 1]],

            // ['GET', '/thorn-api/user', []],
            // ['POST', '/thorn-api/user', ['name' => 'New User', 'email' => 'newuser@example.com', 'password' => 'password']],
            // ['GET', '/thorn-api/user/1', []],
            // ['PUT', '/thorn-api/user/1', ['name' => 'Updated User']],
            // ['DELETE', '/thorn-api/user/1', []],
            // ['POST', '/thorn-api/user/1/assign/permission', ['permission_id' => 1]],
            // ['POST', '/thorn-api/user/1/assign/role', ['role_id' => 1]],
            // ['POST', '/thorn-api/user/1/revoke/permission', ['permission_id' => 1]],
            // ['POST', '/thorn-api/user/1/revoke/role', ['role_id' => 1]],

            // ['POST', '/thorn-api/auth/login', ['email' => 'admin@admin.com', 'password' => 'password']],
            // ['POST', '/thorn-api/auth/logout', []],
            // ['POST', '/thorn-api/auth/register', ['name' => 'Another User', 'email' => 'another@example.com', 'password' => 'password']],
            // ['GET', '/thorn-api/auth/user', []],

            // ['GET', '/thorn-api/up', []],
            // ['GET', '/thorn-api/log', []],
            // ['GET', '/thorn-api/test', []],
        ];
    }
}
