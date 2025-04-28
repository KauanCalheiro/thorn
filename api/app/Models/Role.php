<?php

namespace App\Models;

use App\Traits\LogsAll;
use Illuminate\Database\Eloquent\Model;
use \Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole {
    use LogsAll;
    public const ADMIN = 'admin';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
