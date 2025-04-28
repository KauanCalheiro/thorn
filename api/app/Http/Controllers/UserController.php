<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserPermissionRequest;
use App\Http\Requests\UserRoleRequest;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller {
    public function __construct() {
        $this->authorizeResource(User::class, 'user');
    }

    public function index() {
        try {
            $users = QueryBuilder::for(User::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    'name',
                    'email',
                    AllowedFilter::scope('search', 'whereScout')
                ])
                ->allowedIncludes([
                    'roles',
                    'permissions',
                ])
                ->allowedSorts([
                    'id',
                    'name',
                    'email',
                ])
                ->jsonPaginate();

            return ResponseService::success(data: $users, count: $users->toArray()['total']);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function store(StoreUserRequest $request) {
        try {
            $user = User::create($request->validated());
            return ResponseService::success(data: $user);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function show(User $user) {
        try {
            $user->load(request('with', []));
            return ResponseService::success(data: $user);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function update(UpdateUserRequest $request, User $user) {
        try {
            $user->updateOrFail($request->validated());
            return ResponseService::success(data: $user);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function destroy(User $user) {
        try {
            if ($user->id === auth()->user()->id) {
                throw new Exception('You cannot delete your own account', 403);
            }

            $user->delete();
            return ResponseService::success($user);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function assignRole(UserRoleRequest $request, User $user) {
        try {
            $user->assignRole($request->role);
            return ResponseService::success(data: $user);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function revokeRole(UserRoleRequest $request, User $user) {
        try {
            $user->removeRole($request->role);
            return ResponseService::success(data: $user);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function assignPermission(UserPermissionRequest $request, User $user) {
        try {
            $user->givePermissionTo($request->permission);
            return ResponseService::success(data: $user);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function revokePermission(UserPermissionRequest $request, User $user) {
        try {
            $user->revokePermissionTo($request->permission);
            return ResponseService::success(data: $user);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }
}
