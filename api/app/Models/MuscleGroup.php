<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuscleGroup extends Model {
    use SoftDeletes;

    protected $table = 'muscle_groups';

    protected $fillable = [
        'name',
    ];

    public function toArray() {
        return array_merge(parent::toArray(), [
            'name' => __($this->name),
        ]);
    }
}
