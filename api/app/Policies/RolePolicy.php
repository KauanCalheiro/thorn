<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Role;
use App\Models\User;

class RolePolicy {
    public function viewAny(User $user): bool {
        return $user->can(PermissionEnum::READ_ROLE);
    }

    public function view(User $user, Role $role): bool {
        return $user->can(PermissionEnum::READ_ROLE);
    }

    public function create(User $user): bool {
        return $user->can(PermissionEnum::CREATE_ROLE);
    }

    public function update(User $user, Role $role): bool {
        return $user->can(PermissionEnum::UPDATE_ROLE);
    }

    public function delete(User $user, Role $role): bool {
        return $user->can(PermissionEnum::DELETE_ROLE);
    }
}
