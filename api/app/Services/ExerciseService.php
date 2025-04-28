<?php

namespace App\Services;

use App\Models\Exercise;
use Exception;
use Illuminate\Http\UploadedFile;
use Str;

class ExerciseService {
    protected ?Exercise $exercise;

    public function __construct(Exercise $exercise = null) {
        $this->exercise = $exercise ?? new Exercise();
    }

    public static function make(Exercise $exercise = null): self {
        return new self($exercise);
    }

    protected function setExercise(Exercise $exercise): self {
        $this->exercise = $exercise;

        return $this;
    }

    protected function storeGif(UploadedFile $gif, string $exerciseName): string {
        try {
            $gifName = sprintf(
                '%s_%s.gif',
                Str::snake($exerciseName),
                Str::uuid()
            );

            return $gif->storeAs(Exercise::GIF_PATH, $gifName, 'public');
        } catch (Exception $e) {
            throw new Exception(__('Error while storing the GIF: ') . $e->getMessage());
        }
    }

    protected function validate(array $data): self {
        if (empty($data['name'])) {
            throw new Exception(__('The exercise name is required.'));
        }

        if (empty($data['gif']) || !($data['gif'] instanceof UploadedFile)) {
            throw new Exception(__('The exercise GIF is required.'));
        }

        return $this;
    }

    protected function beforeCreate(array $data): self {
        $data['gif'] = $this->storeGif($data['gif'], $data['name']);
        $this->exercise->fill($data);

        return $this;
    }

    protected function handleCreate(): self {
        $this->exercise->saveOrFail();

        return $this;
    }

    public function create(array $data): Exercise {
        $this->validate($data)
            ->beforeCreate($data)
            ->handleCreate();

        return $this->exercise;
    }

    protected function beforeUpdate(array $data): self {
        if (isset($data['gif']) && $data['gif'] instanceof UploadedFile) {
            $data['gif'] = $this->storeGif($data['gif'], $data['name']);
        } else {
            unset($data['gif']);
        }

        $this->exercise->fill($data);

        return $this;
    }

    protected function handleUpdate(): self {
        $this->exercise->saveOrFail();

        return $this;
    }


    public function update(array $data, Exercise $exercise): Exercise {
        $this->setExercise($exercise)
            ->validate($data)
            ->beforeUpdate($data)
            ->handleUpdate();

        return $this->exercise;
    }
}
