<script setup lang="js">

const colorMode = useColorMode();

const options = ref([
  {
    label: "Claro",
    value: "light",
    icon: "solar:sun-2-bold",
    bg: "bg-neutral-100",
    skeletonBorderClass: "border-black/10",
    skeletonClass: "bg-neutral-300 animate-none",
    textClass: "text-neutral-700",
    iconClass: "bg-neutral-700",
  },
  {
    label: "Escuro",
    value: "dark",
    icon: "solar:moon-bold",
    bg: "bg-neutral-800",
    skeletonBorderClass: "border-white/10",
    skeletonClass: "bg-neutral-600 animate-none",
    textClass: "text-neutral-200",
    iconClass: "bg-neutral-200",
  },
]);

const selected = ref(colorMode.preference);

watch(selected, (val) => {
  colorMode.preference = val;
});
</script>

<template>
  <div class="space-y-4">
    <URadioGroup
      v-model="selected"
      legend="Tema"
      :items="options"
      class="gap-2"
      variant="card"
      indicator="hidden"
      :ui="{
        fieldset:
          'flex flex-row flex-wrap gap-2 justify-center md:justify-start',
        item: 'p-0 rounded-xl',
      }"
    >
      <template #label="{ item }">
        <div
          class="flex flex-col items-center gap-2 w-[35dvw] max-w-[200px] text-xs p-3.5 rounded-xl"
          :class="item.bg"
        >
          <div
            class="rounded-lg p-2 w-full space-y-1 shadow-md border-1"
            :class="item.skeletonBorderClass"
          >
            <div class="flex items-center gap-2">
              <USkeleton
                class="w-6 h-6 rounded-full"
                :class="item.skeletonClass"
              />
              <div class="space-y-1 w-full">
                <USkeleton
                  class="h-2 w-3/4 rounded"
                  :class="item.skeletonClass"
                />
                <USkeleton
                  class="h-2 w-1/2 rounded"
                  :class="item.skeletonClass"
                />
              </div>
            </div>
            <USkeleton class="h-2 w-full rounded" :class="item.skeletonClass" />
            <USkeleton class="h-2 w-5/6 rounded" :class="item.skeletonClass" />
          </div>

          <div class="text-center flex flex-row gap-2">
            <UIcon :name="item.icon" class="text-lg" :class="item.iconClass" />
            <p class="text-[0.75rem] mt-1" :class="item.textClass">
              {{ item.label }}
            </p>
          </div>
        </div>
      </template>
    </URadioGroup>
  </div>
</template>
