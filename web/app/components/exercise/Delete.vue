<script setup lang="ts">
import { EXERCISE_ENDPOINT } from "~~/constants/api";
import type ApiResponse from "~~/types/ApiResponse";
import type Exercise from "~~/types/Exercise";

const { exercise } = defineProps<{ exercise: Exercise }>();
const emit = defineEmits(["after-delete"]);
const isOpen = defineModel<boolean>();

async function onDelete() {
  return useSanctumFetch<ApiResponse>(`${EXERCISE_ENDPOINT}/${exercise.id}`, {
    method: "DELETE",
  })
    .then(() => {
      isOpen.value = false;
      emit("after-delete");
      toast().success({
        description: "Exercício excluido com sucesso"
      })
    })
    .catch(() => {
      let error: any = useNuxtApp().$lastSanctumError;
      toast().error({
        description: error?.value?._data?.message || "Ocorreu um erro",
      });
    });
}

async function onCancel() {
  isOpen.value = false;
}
</script>

<template>
  <BaseQuest
    v-model="isOpen"
    :accept-fn="onDelete"
    :decline-fn="onCancel"
    accept-text="Excluir exercício"
    decline-text="Cancelar"
  >
    Confirme a exclusão do exercício
    <strong>"{{ exercise.id }} - {{ exercise.name }}"</strong>
  </BaseQuest>
</template>
