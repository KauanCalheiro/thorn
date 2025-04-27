<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('muscle_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        $muscleGroups = [
            'Chest',
            'Back',
            'Lower Back',
            'Shoulders',
            'Traps',
            'Biceps',
            'Triceps',
            'Forearms',
            'Abs',
            'Quadriceps',
            'Hamstrings',
            'Adductors',
            'Abductors',
            'Glutes',
            'Calves',
        ];

        foreach ($muscleGroups as $muscleGroup) {
            \App\Models\MuscleGroup::create([
                'name' => $muscleGroup,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('muscle_groups');
    }
};
