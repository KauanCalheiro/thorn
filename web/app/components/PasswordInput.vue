<script setup lang="ts">
const show = ref(false);
</script>

<template>
  <UInput
    v-bind="{ ...$attrs }"
    :type="show ? 'text' : 'password'"
    v-on="$listeners"
    >
    <template #trailing>
      <UButton
        color="neutral"
        variant="link"
        size="md"
        :icon="show ? 'solar:eye-broken' : 'solar:eye-closed-bold-duotone'"
        @click="show = !show"
      />
    </template>
  </UInput>
</template>
