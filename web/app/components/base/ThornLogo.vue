<template>
  <div
    :class="width"
    :style="{
      maskImage: 'url(/logo.png)',
      WebkitMaskImage: 'url(/logo.png)',
      maskRepeat: 'no-repeat',
      WebkitMaskRepeat: 'no-repeat',
      maskSize: 'contain',
      WebkitMaskSize: 'contain',
      backgroundColor: `${
        colors[color][colorMode.value === 'dark' ? 400 : 500]
      }`,
    }"
  ></div>
</template>

<script setup lang="ts">
import colorPalette from "~~/utils/colorPalette";

const { width = "w-[150px] h-13" } = defineProps<{
  width?: string;
}>();

const colorMode = useColorMode();
const appConfig = ref(useAppConfig());

const colors: any = colorPalette;

const color = computed(() => appConfig.value.ui.colors.primary);
</script>
