<template>
  <UContainer class="w-full min-h-screen">
    <BaseHeader />
    <slot />
  </UContainer>
</template>

<script setup>
useHead({
  meta: [
    {
      name: "viewport",
      content:
        "width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover",
    },
  ],
});
</script>

<style scoped>
main {
  display: flex;
  flex-direction: column;
  flex-wrap: nowrap;
}
</style>
