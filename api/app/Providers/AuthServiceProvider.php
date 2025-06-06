<?php
namespace App\Providers;

use App\Models\Exercise;
use App\Models\MuscleGroup;
use App\Models\Permission;
use App\Models\RequestLog;
use App\Models\Role;
use App\Models\User;
use App\Policies\ExercisePolicy;
use App\Policies\MuscleGroupPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RequestLogPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {
    protected $policies = [
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        User::class => UserPolicy::class,
        RequestLog::class => RequestLogPolicy::class,
        MuscleGroup::class => MuscleGroupPolicy::class,
        Exercise::class => ExercisePolicy::class,
    ];

    public function boot() {
        $this->registerPolicies();
    }
}