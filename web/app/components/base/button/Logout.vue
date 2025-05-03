<script setup lang="ts">
const { text, trailing = false } = defineProps<{
  text?: string;
  trailing?: boolean;
}>();

const loading = ref<boolean>(false);

async function onLogout() {
  loading.value = true;
  useSanctumAuth()
    .logout()
    .then(() => {
      toast().success({
        description: "Logout efetuado com sucesso",
      });
    })
    .catch(() => {
      toast().error({
        description: "Erro ao efetuar logout",
      });
    })
    .finally(() => {
      loading.value = false;
    });
}
</script>

<template>
  <UButton
    icon="solar:logout-3-bold"
    size="lg"
    color="neutral"
    variant="ghost"
    :trailing="trailing"
    :loading="loading"
    :loading-icon="useLoadingIcon()"
    @click="onLogout"
  >
    {{ text }}
  </UButton>
</template>
