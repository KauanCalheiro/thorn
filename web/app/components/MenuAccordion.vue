<script setup lang="ts">
import type { AccordionItem } from "@nuxt/ui";
import { useRoute } from "#app";

const route = useRoute();

const isActiveRoute = (path: string): boolean => {
  return route.path === path;
};

const items: AccordionItem[] = [
  {
    label: "Cadastro Básico",
    icon: "icon-park-outline:system",
    links: [
      { label: "Usuários", to: "/user", icon: "i-lucide-users" },
      { label: "Exercícios", to: "/exercise", icon: "hugeicons:equipment-gym-03" },
    ],
  },
];

const emits = defineEmits<{
  (e: "selected", item: AccordionItem): void;
}>();
</script>

<template>
  <UAccordion
    :items="items"
  >
    <template #body="{ item }">
      <ul class="flex flex-col gap-2">
        <li v-for="subItem in item.links" :key="subItem.label">
          <NuxtLink :to="subItem.to">
            <UButton
              variant="soft"
              :color="isActiveRoute(subItem.to) ? 'primary' : 'neutral'"
              class="w-full"
              :class="{
                underline: isActiveRoute(subItem.to),
              }"
              @click="() => emits('selected', item)"
              :icon="subItem.icon"
            >
              {{ subItem.label }}
            </UButton>
          </NuxtLink>
        </li>
      </ul>
    </template>
  </UAccordion>
</template>
