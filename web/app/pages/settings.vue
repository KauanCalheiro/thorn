<script setup lang="ts"></script>

<template>
  <div
    class="space-y-4 w-full py-5 px-5 md:px-70 md:py-10 rounded-2xl flex flex-col gap-2 mx-auto"
  >
    <h1 class="text-2xl font-bold">Configurações</h1>
    <UDrawer class="">
      <UButton
        color="neutral"
        class="w-full px-4 py-4 justify-center"
        size="xl"
        icon="solar:cloud-sun-2-bold"
      >
        <span class="text-sm">Aparência</span>
      </UButton>

      <template #body>
        <div class="min-h-[50dvh]">
          <ColorModeSelector
            class="min-h-[50dvh] m-auto flex flex-col justify-center"
          />
        </div>
      </template>
    </UDrawer>

    <UDrawer>
      <UButton
        color="neutral"
        class="w-full px-4 py-4 justify-center"
        size="xl"
        icon="solar:palette-round-bold-duotone"
      >
        <span class="text-sm">Cores</span>
      </UButton>

      <template #body>
        <ColorPicker />
      </template>
    </UDrawer>
  </div>
</template>
