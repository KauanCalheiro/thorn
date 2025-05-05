<template>
  <div class="flex flex-row justify-center flex-wrap gap-2 p-4">
    <div
      v-for="color in primaryColors"
      :key="color.value"
      class="flex flex-col items-center justify-center cursor-pointer w-21 h-21 gap-2.5 rounded-md"
      @click="primary = color"
      :class="{
        'bg-accented': primary?.value === color.value,
      }"
    >
      <span
        class="inline-block size-7 rounded-full border-2 border-transparent"
        :style="{
          backgroundColor: color.hex,
        }"
      />
      <span class="text-xs text-center capitalize">
        {{ color.text }}
      </span>
    </div>
  </div>
</template>

<script setup lang="ts">
import colorPalette from "~~/utils/colorPalette";

const colorMode = useColorMode();
const appConfig = useAppConfig();

const colors: any = colorPalette;

const allColors = Object.keys(colors);

const primaryColors = computed(() =>
  allColors.map((color: string) => ({
    value: color,
    text: color,
    hex: colors[color][colorMode.value === "dark" ? 400 : 500],
  }))
);

const primary = computed({
  get() {
    return primaryColors.value.find(
      (option) => option.value === appConfig.ui.colors.primary
    );
  },
  set(option) {
    if (option?.value) {
      appConfig.ui.colors.primary = option.value;
      document.cookie = `nuxt-ui-primary=${appConfig.ui.colors.primary}; path=/;`;
    }
  },
});
</script>
