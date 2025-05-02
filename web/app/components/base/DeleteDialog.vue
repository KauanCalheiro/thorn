<script setup lang="ts">
import type ApiResponse from "~~/types/ApiResponse";

const props = defineProps<{
  entity: { id: number; name?: string };
  entityName: string;
  entityGender?: string;
  endpoint: string;
  dialog?: string;
  modelDialog?: string;
  successMessage?: string;
  acceptText?: string;
  declineText?: string;
  deleteFn?: () => Promise<void>;
  cancelFn?: () => Promise<void>;
}>();

const emit = defineEmits(["after-delete"]);
const open = defineModel<boolean>("open");

const gender = props.entityGender ?? "o";

const dialog = computed(
  () =>
    props.dialog ??
    `Confirme a exclusão d${gender} ${props.entityName.toLowerCase()}`
);

const modelDialog = computed(
  () => props.modelDialog ?? `${props.entity.id} - ${props.entity.name ?? ""}`
);

const successMessage = computed(
  () =>
    props.successMessage ??
    `${props.entityName.charAt(0).toUpperCase()}${props.entityName
      .slice(1)
      .toLowerCase()} excluid${gender} com sucesso`
);

const acceptText = computed(
  () => props.acceptText ?? `Excluir ${props.entityName.toLowerCase()}`
);

const declineText = computed(() => props.declineText ?? "Cancelar");

const finalDeleteFn = props.deleteFn ?? onDelete;
const finalCancelFn = props.cancelFn ?? onCancel;

async function onDelete() {
  return useSanctumFetch<ApiResponse>(`${props.endpoint}/${props.entity.id}`, {
    method: "DELETE",
  })
    .then((response) => success(response))
    .catch(() => error());
}

async function onCancel() {
  open.value = false;
}

function success(response: any) {
  if(response.error.value){
    throw new Error()
  }
  toast().success({ description: successMessage.value });
  emit("after-delete");
  open.value = false;
}

function error() {
  const error: any = useNuxtApp().$lastSanctumError;
  toast().error({
    description: error?.value?._data?.message || "Ocorreu um erro",
  });
}
</script>

<template>
  <BaseQuest
    v-model="open"
    :accept-fn="finalDeleteFn"
    :decline-fn="finalCancelFn"
    :accept-text="acceptText"
    :decline-text="declineText"
  >
    {{ dialog }}
    <strong>"{{ modelDialog }}"</strong>
  </BaseQuest>
</template>
