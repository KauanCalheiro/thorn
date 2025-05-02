<script setup lang="ts">
import { ExerciseTable } from "#components";
import type Exercise from "~~/types/Exercise";

const isFormOpen = ref<boolean>(false);
const isExcludeOpen = ref<boolean>(false);

const refExerciseTable = ref();

const exerciseToPerformAction = ref<Exercise | undefined>(undefined);

function onAdd() {
  exerciseToPerformAction.value = undefined;
  openForm();
}

function onEdit(row: Exercise) {
  exerciseToPerformAction.value = row;
  openForm();
}

function onDelete(row: Exercise) {
  exerciseToPerformAction.value = row;
  openExclude();
}

async function onAfterSave() {
  closeForm();
  await refExerciseTable.value.fetchData();
}

function onAfterDelete() {
  refExerciseTable.value.fetchData();
}

function openForm() {
  isFormOpen.value = true;
}

function closeForm() {
  isFormOpen.value = false;
}

function openExclude() {
  isExcludeOpen.value = true;
}
</script>

<template>
  <ExerciseTable
    ref="refExerciseTable"
    @add="onAdd"
    @edit="onEdit"
    @delete="onDelete"
  />

  <UDrawer v-model:open="isFormOpen">
    <template #body>
      <ExerciseForm
        @after-save="onAfterSave"
        @cancel="closeForm"
        :exercise="exerciseToPerformAction"
      ></ExerciseForm>
    </template>
  </UDrawer>

  <ExerciseDelete
    v-model="isExcludeOpen"
    :exercise="(exerciseToPerformAction ?? {} as Exercise)"
    @after-delete="onAfterDelete"
  />
</template>
