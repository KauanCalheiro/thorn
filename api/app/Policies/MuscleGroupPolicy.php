<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\MuscleGroup;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MuscleGroupPolicy {
    public function viewAny(User $user): bool {
        return $user->hasPermissionTo(PermissionEnum::READ_MUSCLE_GROUPS);
    }

    public function view(User $user, MuscleGroup $muscleGroup): bool {
        return $user->hasPermissionTo(PermissionEnum::READ_MUSCLE_GROUPS);
    }

    public function create(User $user): bool {
        return $user->hasPermissionTo(PermissionEnum::CREATE_MUSCLE_GROUPS);
    }

    public function update(User $user, MuscleGroup $muscleGroup): bool {
        return $user->hasPermissionTo(PermissionEnum::UPDATE_MUSCLE_GROUPS);
    }

    public function delete(User $user, MuscleGroup $muscleGroup): bool {
        return $user->hasPermissionTo(PermissionEnum::DELETE_MUSCLE_GROUPS);
    }
}
