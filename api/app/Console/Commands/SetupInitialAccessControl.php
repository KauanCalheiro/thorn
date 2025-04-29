<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Enums\PermissionEnum;
use Illuminate\Support\Facades\Hash;

class SetupInitialAccessControl extends Command {
    protected $signature = 'app:setup:access-control';
    protected $description = 'Synchronize Admin/User roles and permissions in the system.';

    protected const USER_PERMISSIONS = [
        PermissionEnum::READ_MUSCLE_GROUP,
        PermissionEnum::READ_EXERCISE,
    ];

    public function handle() {
        $this->info('Starting roles and permissions synchronization...');

        $adminUser = $this->createOrUpdateAdminUser();

        $adminRole = $this->createOrUpdateRole('admin');
        $userRole = $this->createOrUpdateRole('user');

        $this->syncPermissions();
        $this->cleanOrphanPermissions();

        $this->assignAllPermissionsToRole($adminRole);
        $this->assignSpecificPermissionsToRole($userRole, $this->userPermissions());

        $this->assignRoleToUser($adminUser, $adminRole);

        $this->info('Synchronization completed successfully!');
    }

    protected function createOrUpdateAdminUser(): User {
        $user = User::firstOrCreate([
            'email' => 'admin@admin',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('admin'),
        ]);

        $this->info('Admin user verified/created.');

        return $user;
    }

    protected function createOrUpdateRole(string $roleName): Role {
        $role = Role::firstOrCreate([
            'name' => $roleName,
            'guard_name' => 'web',
        ]);

        $this->info("Role '{$roleName}' verified/created.");

        return $role;
    }

    protected function syncPermissions(): void {
        foreach (PermissionEnum::cases() as $permissionEnum) {
            Permission::firstOrCreate([
                'name' => $permissionEnum->value,
                'guard_name' => 'web',
            ]);
        }

        $this->info('Permissions synchronized.');
    }

    protected function cleanOrphanPermissions(): void {
        $validPermissions = collect(PermissionEnum::cases())->pluck('value')->toArray();

        $deleted = Permission::whereNotIn('name', $validPermissions)->delete();

        if ($deleted > 0) {
            $this->warn("Removed $deleted orphan permissions.");
        } else {
            $this->info('No orphan permissions found.');
        }
    }

    protected function assignAllPermissionsToRole(Role $role): void {
        $role->syncPermissions(Permission::pluck('name'));

        $this->info("All permissions assigned to role '{$role->name}'.");
    }

    protected function assignSpecificPermissionsToRole(Role $role, array $permissions): void {
        $role->syncPermissions($permissions);

        $this->info("Specific permissions assigned to role '{$role->name}'.");
    }

    protected function assignRoleToUser(User $user, Role $role): void {
        if (!$user->hasRole($role)) {
            $user->assignRole($role);
            $this->info("Role '{$role->name}' assigned to Admin user.");
        }
    }

    protected function userPermissions(): array {
        // Mapeia os enums para seus valores string
        return array_map(fn($permission) => $permission->value, self::USER_PERMISSIONS);
    }
}
