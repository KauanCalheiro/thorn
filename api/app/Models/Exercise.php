<?php

namespace App\Models;

use App\Contracts\JoinableContract;
use App\Helpers\Models\Relation;
use App\Traits\Joinable;
use App\Traits\LogsAll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Exercise extends Model implements JoinableContract {
    use SoftDeletes, LogsAll, Joinable;

    public const GIF_PATH = 'exercises/gifs';

    protected $table = 'exercises';

    protected $fillable = [
        'name',
        'gif',
        'muscle_group_id',
    ];

    public function muscleGroup() {
        return $this->belongsTo(MuscleGroup::class);
    }

    public function toSearchableArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'muscle_group_id' => $this->muscle_group_id,
            'muscle_group_name' => $this->muscleGroup->name,
        ];
    }

    public function getJoinRelations(): array {
        return [
            new Relation(MuscleGroup::class, 'muscle_group_id'),
        ];
    }
}
