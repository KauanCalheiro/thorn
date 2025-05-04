<script setup lang="ts">
import type User from "~~/types/User";
const user = useSanctumUser<User>().value;
const route = useRoute();

const activeRouteIsSettings = (): boolean => {
  return route.path === '/settings';
};

const emits = defineEmits<{
  (e: "selected"): void;
}>();
</script>

<template>
  <UAccordion
    :items="[1]"
  >
    <template #default>
      <div
        class="flex items-center gap-3 px-1 rounded-xl w-full overflow-hidden"
      >
        <div
          class="w-12 h-12 rounded-full flex items-center justify-center text-neutral text-lg font-medium overflow-hidden bg-accented"
        >
          <img
            v-if="user?.picture"
            :src="user.picture"
            alt="Foto do usuário"
            class="w-full h-full object-cover"
          />
          <span v-else>
            {{ user?.name?.charAt(0) || "?" }}
          </span>
        </div>

        <div class="flex flex-col min-w-0 max-w-[55dvw] overflow-hidden">
          <span class="font-bold truncate">
            {{ user?.name }}
          </span>
          <span class="text-sm font-light truncate">
            {{ user?.email }}
          </span>
        </div>
      </div>
    </template>
    <template #body>
      <ul class="flex flex-col gap-2">
        <li>
          <NuxtLink to="/settings">
            <UButton
              :color="activeRouteIsSettings() ? 'primary' : 'neutral'"
              class="w-full"
              :class="{
                underline: activeRouteIsSettings(),
              }"
              size="lg"
              icon="solar-settings-bold"
              @click="() => emits('selected')"
            >
              Configurações
            </UButton>
          </NuxtLink>
        </li>
        <li>
          <BaseButtonLogout text="Sair" class="w-full" />
        </li>
      </ul>
    </template>
  </UAccordion>
</template>
