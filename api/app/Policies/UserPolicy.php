<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy {
    public function viewAny(User $user): bool {
        return $user->can(PermissionEnum::READ_USER);
    }

    public function view(User $user): bool {
        return $user->can(PermissionEnum::READ_USER);
    }

    public function create(User $user): bool {
        return $user->can(PermissionEnum::CREATE_USER);
    }

    public function update(User $user): bool {
        return $user->can(PermissionEnum::UPDATE_USER);
    }

    public function delete(User $user): bool {
        return $user->can(PermissionEnum::DELETE_USER);
    }

    public function assignRole(User $user): bool {
        return $user->can(PermissionEnum::ASSIGN_ROLE);
    }

    public function revokeRole(User $user): bool {
        return $user->can(PermissionEnum::REVOKE_ROLE);
    }

    public function assignPermission(User $user): bool {
        return $user->can(PermissionEnum::ASSIGN_PERMISSION);
    }

    public function revokePermission(User $user): bool {
        return $user->can(PermissionEnum::REVOKE_PERMISSION);
    }
}
