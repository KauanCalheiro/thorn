<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\MuscleGroup;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MuscleGroupPolicy {
    public function viewAny(User $user): bool {
        return $user->can(PermissionEnum::READ_MUSCLE_GROUP);
    }

    public function view(User $user, MuscleGroup $muscleGroup): bool {
        return $user->can(PermissionEnum::READ_MUSCLE_GROUP);
    }

    public function create(User $user): bool {
        return $user->can(PermissionEnum::CREATE_MUSCLE_GROUP);
    }

    public function update(User $user, MuscleGroup $muscleGroup): bool {
        return $user->can(PermissionEnum::UPDATE_MUSCLE_GROUP);
    }

    public function delete(User $user, MuscleGroup $muscleGroup): bool {
        return $user->can(PermissionEnum::DELETE_MUSCLE_GROUP);
    }
}
