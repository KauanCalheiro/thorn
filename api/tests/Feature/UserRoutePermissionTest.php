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

class UserRoutePermissionTest extends TestCase {
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();

        Artisan::call('app:setup:access-control');

        $user = User::factory()->create([
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
        ]);

        $role = Role::firstOrCreate(['name' => 'user']);
        $user->assignRole($role);

        Exercise::create([
            'name' => 'Test Exercise',
            'gif' => 'path/to/exercise.gif',
            'muscle_group_id' => MuscleGroup::first()->id,
        ]);

        Sanctum::actingAs($user);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('routesProviderCan')]
    public function test_admin_can_access_route(string $method, string $uri, array $payload) {
        $response = $this->json($method, $uri, $payload);
        $response->assertSuccessful();
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('routesProviderCannot')]
    public function test_admin_canot_access_route(string $method, string $uri, array $payload) {
        $response = $this->json($method, $uri, $payload);
        $response->assertStatus(403);
    }


    public static function routesProviderCan(): array {
        return [
            'get muscle-group list' => ['GET', '/thorn-api/muscle-group', []],
            'get specific muscle-group' => ['GET', '/thorn-api/muscle-group/1', []],
            'get exercise list' => ['GET', '/thorn-api/exercise', []],
        ];
    }

    public static function routesProviderCannot(): array {
        return [
            'post create muscle-group' => ['POST', '/thorn-api/muscle-group', ['name' => 'Test Muscle Group']],
            'put update muscle-group' => ['PUT', '/thorn-api/muscle-group/1', ['name' => 'Updated Muscle Group']],
            'delete muscle-group' => ['DELETE', '/thorn-api/muscle-group/1', []],
            'post create exercise' => ['POST', '/thorn-api/exercise', [
                'name' => 'Test Exercise',
                'muscle_group_id' => 1,
                'gif' => \Illuminate\Http\UploadedFile::fake()->image('exercise.gif'),
            ]],
            'put update exercise' => ['PUT', '/thorn-api/exercise/1', [
                'name' => 'Updated Exercise',
                'muscle_group_id' => 1,
            ]],
            'delete exercise' => ['DELETE', '/thorn-api/exercise/1', []],
        ];
    }
}
