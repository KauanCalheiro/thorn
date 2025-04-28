<?php

namespace App\Models;

use App\Traits\LogsAll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Exercise extends Model {
    use SoftDeletes, LogsAll;

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

    public function getGifUrlAttribute() {
        return Storage::url($this->gif);
    }

    public function toSearchableArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'muscle_group_id' => $this->muscle_group_id,
            'muscle_group_name' => $this->muscleGroup->name,
        ];
    }
}
