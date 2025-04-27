<?php

use App\Enums\PermissionEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin',
            'password' => bcrypt('admin'),
        ]);

        $adminRole = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ])->givePermissionTo(
                collect(PermissionEnum::cases())->map(fn($permission) => \App\Models\Permission::create([
                    'name' => $permission->value,
                    'guard_name' => 'web',
                ]))
            );

        $adminUser->assignRole($adminRole);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('admin_user');
    }
};
