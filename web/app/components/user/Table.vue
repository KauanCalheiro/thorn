<script setup lang="ts">
import AsyncDataRequestStatusEnum from "~~/enum/AsyncDataRequestStatus";
import type User from "~~/types/User";
import type ApiResponse from "~~/types/ApiResponse";
import type { TableColumn } from "@nuxt/ui";
import type { AsyncDataRequestStatus, NuxtError } from "#app";
import { USER_ENPOINT } from "~~/constants/api";

const route = useRoute();

const emit = defineEmits<{
  add: [];
  edit: [row: User];
  delete: [row: User];
}>();

const sort = computed(() => (route.query.sort as string) ?? "id");
const page = computed(() => (route.query.page as string) ?? 1);
const search = computed(() => (route.query.search as string) ?? "");

const columns: TableColumn<User>[] = [
  {
    header: ({ column }) => useSortTableHeader<User>("ID", column),

    accessorKey: "id",
  },
  {
    header: ({ column }) => useSortTableHeader<User>("Nome", column),
    accessorKey: "name",
  },
  {
    header: ({ column }) => useSortTableHeader<User>("Email", column),
    accessorKey: "email",
  },
  useTableActions<User>(emit),
];

function onEdit(row: User) {
  emit("edit", row);
}

function onDelete(row: User) {
  emit("delete", row);
}

function fetch(page: string, sort: string, search: string) {
  return useSanctumFetch<ApiResponse<User[]>>(USER_ENPOINT, {
    method: "GET",
    query: {
      "page[number]": page,
      sort: sort,
      "filter[search]": search,
    },
  });
}

async function fetchData() {
  status.value = AsyncDataRequestStatusEnum.PENDING;
  var response = await fetch(page.value, sort.value, search.value);
  data.value = response.data.value ?? null;
  error.value = response.error.value ?? null;
  status.value = response.status.value;
}

const data = ref<ApiResponse<User[]> | null>(null);
const error = ref<NuxtError<unknown> | null>(null);
const status = ref<AsyncDataRequestStatus | null>(null);

watchEffect(async () => {
  await fetchData();
});

defineExpose({
  fetchData,
});
</script>

<template>
  <BaseTable
    title="Usuários"
    :loading="status === AsyncDataRequestStatusEnum.PENDING"
    :columns="columns"
    :total="data?.payload.total ?? 0"
    :current-page="data?.payload.current_page ?? 1"
    :per-page="data?.payload.per_page ?? 10"
    :rows="data?.payload.data ?? []"
    :status="status ?? AsyncDataRequestStatusEnum.IDLE"
    :error="error?.message"
    :use-actions="true"
    @edit="onEdit"
    @delete="onDelete"
    @add="$emit('add')"
  />
</template>
