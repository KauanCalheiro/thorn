<?php

namespace App\Models;

use App\Traits\HideTimestamps;
use App\Traits\LogsAll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuscleGroup extends Model {
    use SoftDeletes, HideTimestamps, LogsAll;

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
