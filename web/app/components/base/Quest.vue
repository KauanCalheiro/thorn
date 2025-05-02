<script setup lang="ts">
import { createReusableTemplate, useMediaQuery } from "@vueuse/core";

const isOpen = defineModel<boolean>();
const isDesktop = useMediaQuery("(min-width: 768px)");
const [DefineTemplate, ReuseTemplate] = createReusableTemplate();

const {
  acceptText = "Sim",
  declineText = "Não",
  acceptFn = () => Promise.resolve(),
  declineFn = () => Promise.resolve(),
} = defineProps<{
  acceptText?: string;
  declineText?: string;
  acceptFn?: () => Promise<any>;
  declineFn?: () => Promise<any>;
}>();

const emit = defineEmits<{
  accept: [];
  decline: [];
}>();

const acceptLoading = ref<boolean>(false);

async function handleAccept() {
  acceptLoading.value = true;
  emit("accept");
  acceptFn().finally(() => {
    acceptLoading.value = false;
  });
}

const declineLoading = ref<boolean>(false);

async function handledecline() {
  declineLoading.value = true;
  emit("decline");
  declineFn().finally(() => {
    declineLoading.value = false;
  });
}
</script>

<template>
  <DefineTemplate>
    <div class="flex flex-col gap-8 items-center py-12 px-8">
      <slot />
      <div class="flex flex-row gap-4 justify-between md:justify-end w-full">
        <UButton
          @click="handledecline"
          trailing
          :loading-icon="useLoadingIcon()"
          :loading="declineLoading"
          color="neutral"
          variant="soft"
          size="xl"
          class="min-w-24 flex justify-center"
        >
          <slot name="decline">{{ declineText }}</slot>
        </UButton>
        <UButton
          @click="handleAccept"
          trailing
          :loading-icon="useLoadingIcon()"
          :loading="acceptLoading"
          color="primary"
          variant="soft"
          size="xl"
          class="min-w-24 flex justify-center"
        >
          <slot name="accept">{{ acceptText }}</slot>
        </UButton>
      </div>
    </div>
  </DefineTemplate>

  <UModal v-if="isDesktop" v-model:open="isOpen" :dismissible="false">
    <template #content>
      <ReuseTemplate />
    </template>
  </UModal>
  <UDrawer v-else v-model:open="isOpen" :dismissible="true">
    <template #body>
      <ReuseTemplate />
    </template>
  </UDrawer>
</template>
