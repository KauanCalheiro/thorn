<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\RequestLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RequestLogPolicy {
    public function viewAny(User $user): bool {
        return $user->can(PermissionEnum::VIEW_REQUEST_LOG);
    }
}
