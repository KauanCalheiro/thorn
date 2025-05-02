<script setup lang="ts">
import { EXERCISE_ENDPOINT } from "~~/constants/api";
import type Exercise from "~~/types/Exercise";

const { exercise } = defineProps<{ exercise: Exercise }>();
const emit = defineEmits(["after-delete"]);
const open = defineModel<boolean>();
</script>

<template>
  <BaseDeleteDialog
    v-model:open="open"
    :entity="exercise"
    :endpoint="EXERCISE_ENDPOINT"
    entity-name="Exercício"
    @after-delete="$emit('after-delete')"
  />
</template>
