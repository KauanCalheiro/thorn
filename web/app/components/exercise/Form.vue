<script setup lang="ts">
import type Exercise from "~~/types/Exercise";
import { mixed, number, object, string, type InferType } from "yup";
import type { Form, FormSubmitEvent } from "@nuxt/ui";
import type ApiResponse from "~~/types/ApiResponse";
import { EXERCISE_ENDPOINT, MUSCLE_GROUP_ENDPOINT } from "~~/constants/api";
import type { MuscleGroup } from "~~/types/MuscleGroup";

const { exercise } = defineProps<{
  exercise: Exercise | undefined;
}>();

const emit = defineEmits<{
  afterSave: [];
}>();

const form = useTemplateRef<Form<Exercise>>("form");

const isEditing = !!exercise;

const schema = object({
  id: number().optional(),
  name: string()
    .required("O nome é obrigatório")
    .trim()
    .min(3, "Deve ter pelo menos 3 caracteres"),
  gif: mixed()
    .required("O GIF é obrigatório")
    .test(
      "is-gif",
      "O arquivo deve ser um GIF",
      (value) => value instanceof File && value.type === "image/gif"
    ),
  muscle_group_id: number()
    .required("O grupo muscular é obrigatório")
    .positive("Deve ser um número positivo")
    .integer("Deve ser um número inteiro"),
});

type ExerciseSchema = InferType<typeof schema>;

const state = reactive<{
  id: number | undefined;
  name: string | undefined;
  gif: Promise<File> | File | undefined;
  muscle_group_id: number | undefined;
}>({
  id: exercise?.id,
  name: exercise?.name,
  gif: exercise?.gif as File,
  muscle_group_id: exercise?.muscle_group_id,
});

const loading = ref(false);

if (isEditing) {
  try {
    state.gif = useFileFromSanctum(exercise?.gif as string);
  } catch (_) {}
}

const muscleGroupsData = ref<{ value: number; label: string }[]>([]);
const loadingMuscleGroups = ref(true);

useSanctumFetch<ApiResponse<MuscleGroup[]>>(MUSCLE_GROUP_ENDPOINT, {
  method: "GET",
})
  .then((response) => {
    muscleGroupsData.value =
      response.data.value?.payload.data.map((group) => ({
        value: group.id,
        label: group.name,
      })) || [];
  })
  .finally(() => {
    loadingMuscleGroups.value = false;
  });

async function onSubmit(event: FormSubmitEvent<ExerciseSchema>) {
  loading.value = true;

  try {
    const formData = new FormData();
    formData.append("name", event.data.name);
    formData.append("muscle_group_id", String(event.data.muscle_group_id));

    if (event.data.gif instanceof File) {
      formData.append("gif", event.data.gif);
    }

    const { error } = await useSanctumFetch<ApiResponse<Exercise>>(
      isEditing ? `${EXERCISE_ENDPOINT}/${state.id}` : EXERCISE_ENDPOINT,
      {
        method: isEditing ? "PUT" : "POST",
        body: formData,
      }
    );

    if (error.value) {
      throw new Error();
    }

    toast().success({
      description: isEditing
        ? "Exercício editado com sucesso"
        : "Exercício cadastrado com sucesso",
    });

    emit("afterSave");
  } catch {
    let error: any = useNuxtApp().$lastSanctumError;
    toast().error({
      description: error?.value?._data?.message || "Ocorreu um erro",
    });
  } finally {
    loading.value = false;
  }
}
</script>

<template>
  <UForm
    :schema="schema"
    :state="state"
    @submit="onSubmit"
    ref="form"
    class="flex flex-col gap-8 px-8 py-8 rounded-lg w-full md:min-h-[80vh] md:w-[30vw] mx-auto justify-center"
  >
    <BaseTitle
      :title="isEditing ? 'Editar Exercício' : 'Cadastrar Exercício'"
    />

    <div class="flex flex-col gap-4">
      <UInput v-model="state.id" type="hidden" />

      <UFormField label="Nome" name="name" required>
        <UInput
          v-model="state.name"
          variant="soft"
          placeholder="Digite o nome do exercício"
          class="w-full"
        />
      </UFormField>

      <UFormField label="Grupo Muscular" name="muscle_group_id" required>
        <USelectMenu
          :loading="loadingMuscleGroups"
          :disabled="loadingMuscleGroups"
          :trailing="true"
          variant="soft"
          value-key="value"
          v-model="state.muscle_group_id"
          :placeholder="
            loadingMuscleGroups ? 'Carregando...' : 'Selecione o grupo muscular'
          "
          :loading-icon="useLoadingIcon()"
          class="w-full"
          :items="muscleGroupsData"
        />
      </UFormField>

      <UFormField label="GIF" name="gif" required v-slot="{ error }">
        <BaseFileInput
          :error="error"
          :form="form"
          name="gif"
          v-model="state.gif"
          placeholder="Selecione o GIF do exercício"
          class="w-full"
        />
      </UFormField>
    </div>

    <div class="flex flex-row gap-4 justify-between mt-6">
      <div />
      <UButton
        variant="soft"
        size="xl"
        type="submit"
        trailing
        :loading-icon="useLoadingIcon()"
        :loading="loading"
      >
        Salvar
      </UButton>
    </div>
  </UForm>
</template>
