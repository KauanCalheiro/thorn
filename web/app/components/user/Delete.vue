<script setup lang="ts">
import type User from "~~/types/User";
import { USER_ENPOINT } from "~~/constants/api";

const { user } = defineProps<{ user: User }>();
const emit = defineEmits(["after-delete"]);
const open = defineModel<boolean>();
</script>

<template>
  <BaseDeleteDialog
    v-model:open="open"
    :entity="user"
    :endpoint="USER_ENPOINT"
    entity-name="Usuário"
    @after-delete="$emit('after-delete')"
  />
</template>
