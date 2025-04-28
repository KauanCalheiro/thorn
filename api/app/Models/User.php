<?php

namespace App\Models;

use App\Traits\LogsAll;
use App\Traits\QueryBuilderSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, QueryBuilderSearchable, LogsAll;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Accessor for the user's roles.
     */
    public function getRolesListAttribute(): array {
        return $this->roles->pluck('name')->toArray();
    }

    /**
     * Accessor for the user's permissions.
     */
    public function getPermissionsListAttribute(): array {
        return $this->getAllPermissions()->pluck('name')->toArray();
    }

    /**
     * Override the toArray method to include roles and permissions.
     */
    public function toArray(): array {
        $array = parent::toArray();

        if (!isset($array['roles'])) {
            $array['roles'] = $this->getRolesListAttribute();
        }

        if (!isset($array['permissions'])) {
            $array['permissions'] = $this->getPermissionsListAttribute();
        }

        return $array;
    }

    public function toSearchableArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
