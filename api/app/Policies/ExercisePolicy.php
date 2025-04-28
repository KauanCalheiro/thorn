<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExercisePolicy {
    public function viewAny(User $user): bool {
        return $user->hasPermissionTo(PermissionEnum::READ_EXERCISE);
    }

    public function view(User $user, Exercise $exercise): bool {
        return $user->hasPermissionTo(PermissionEnum::READ_EXERCISE);
    }

    public function create(User $user): bool {
        return $user->hasPermissionTo(PermissionEnum::CREATE_EXERCISE);
    }

    public function update(User $user, Exercise $exercise): bool {
        return $user->hasPermissionTo(PermissionEnum::UPDATE_EXERCISE);
    }

    public function delete(User $user, Exercise $exercise): bool {
        return $user->hasPermissionTo(PermissionEnum::DELETE_EXERCISE);
    }
}
