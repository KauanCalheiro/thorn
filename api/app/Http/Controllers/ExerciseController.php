<?php

namespace App\Http\Controllers;

use App\Helpers\Spatie\QueryBuilder\Sorts\RelationColumnSort;
use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use App\Models\Exercise;
use App\Policies\ExercisePolicy;
use App\Services\ExerciseService;
use App\Services\ResponseService;
use Exception;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ExerciseController extends Controller {
    protected $policy = ExercisePolicy::class;
    private ExerciseService $exerciseService;

    public function __construct() {
        $this->exerciseService = new ExerciseService();
        $this->authorizeResource(Exercise::class, 'exercise');
    }

    public function index() {
        try {
            $exercises = QueryBuilder::for(Exercise::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    'name',
                    'gif',
                    'muscle_group_id',
                    AllowedFilter::scope('search', 'whereScout')
                ])
                ->allowedIncludes([
                    'muscleGroup'
                ])
                ->allowedSorts([
                    'id',
                    'name',
                    AllowedSort::custom('muscle_group_name', new RelationColumnSort(), 'muscleGroup.name')
                ])
                ->jsonPaginate();
            return ResponseService::success(data: $exercises, count: $exercises->toArray()['total']);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function store(StoreExerciseRequest $request) {
        try {
            $exercise = $this->exerciseService->create($request->validated());
            return ResponseService::success(data: $exercise);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function show(Exercise $exercise) {
        try {
            return ResponseService::success(data: $exercise);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function update(UpdateExerciseRequest $request, Exercise $exercise) {
        try {
            $exercise = $this->exerciseService->update($request->validated(), $exercise);
            return ResponseService::success(data: $exercise);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function destroy(Exercise $exercise) {
        try {
            $exercise->delete();
            return ResponseService::success(message: 'Exercise deleted successfully');
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }
}
