<script setup lang="ts"></script>

<template>
  <div
    class="space-y-4 w-full py-5 px-5 md:px-70 md:py-10 rounded-2xl flex flex-col gap-2 mx-auto"
  >
    <div class="flex flex-col gap-2">
      <div class="flex flex-row gap-2 text-center">
        <UIcon name="solar:cloud-sun-2-bold-duotone" size="1.5rem" />
        <h1>Aparência</h1>
      </div>
      <ColorModeSelector />
    </div>
    <div class="flex flex-col gap-2">
      <div class="flex flex-row gap-2 text-center">
        <UIcon name="solar:palette-round-bold-duotone" size="1.5rem" />
        <h1>Cores</h1>
      </div>
      <ColorPicker />
    </div>
  </div>
</template>
