<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Permission;

class PermissionPolicy {
    public function viewAny(User $user): bool {
        return $user->can(PermissionEnum::READ_PERMISSION);
    }

    public function view(User $user, Permission $permission): bool {
        return $user->can(PermissionEnum::READ_PERMISSION);
    }

    public function create(User $user): bool {
        return $user->can(PermissionEnum::CREATE_PERMISSION);
    }

    public function update(User $user, Permission $permission): bool {
        return $user->can(PermissionEnum::UPDATE_PERMISSION);
    }

    public function delete(User $user, Permission $permission): bool {
        return $user->can(PermissionEnum::DELETE_PERMISSION);
    }
}
