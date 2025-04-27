<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMuscleGroupRequest;
use App\Http\Requests\UpdateMuscleGroupRequest;
use App\Models\MuscleGroup;
use App\Services\ResponseService;
use Exception;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MuscleGroupController extends Controller {
    public function __construct() {
        $this->authorizeResource(MuscleGroup::class, 'muscleGroup');
    }

    public function index() {
        try {
            $muscleGroups = QueryBuilder::for(MuscleGroup::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    'name'
                ])
                ->allowedSorts([
                    'id',
                    'name'
                ])
                ->jsonPaginate();

            return ResponseService::success(data: $muscleGroups, count: $muscleGroups->toArray()['total']);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function store(StoreMuscleGroupRequest $request) {
        try {
            $muscleGroup = MuscleGroup::create($request->validated());
            return ResponseService::success(data: $muscleGroup);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function show(MuscleGroup $muscleGroup) {
        try {
            return ResponseService::success(data: $muscleGroup);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function update(UpdateMuscleGroupRequest $request, MuscleGroup $muscleGroup) {
        try {
            $muscleGroup->updateOrFail($request->validated());
            return ResponseService::success(data: $muscleGroup);
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }

    public function destroy(MuscleGroup $muscleGroup) {
        try {
            $muscleGroup->delete();
            return ResponseService::success(message: 'Muscle group deleted successfully');
        } catch (Exception $e) {
            return ResponseService::error($e);
        }
    }
}
