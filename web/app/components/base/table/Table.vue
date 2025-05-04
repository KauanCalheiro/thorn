<script setup lang="ts" generic="T">
import type { TableColumn } from "@nuxt/ui";
import AsyncDataRequestStatusEnum from "~~/enum/AsyncDataRequestStatus";
import type { SortingState } from "~~/types/ui/Sort";
import type TableSort from "~~/types/ui/TableSort";

const { title, columns, rows, status, total, currentPage, perPage } =
  defineProps<{
    title?: string;
    columns: TableColumn<T, unknown>[];
    rows: T[];
    status: string;
    total: number;
    currentPage?: number;
    perPage?: number;
  }>();

const route = useRoute();

const table = useTemplateRef("table");

const search = ref<string>("");
search.value = (route.query.search as string) ?? "";

const emit = defineEmits<{
  "update:sort": [sort: TableSort];
  add: [];
  edit: [row: T];
  delete: [row: T];
}>();

const loading = computed(
  () =>
    status == AsyncDataRequestStatusEnum.IDLE ||
    status == AsyncDataRequestStatusEnum.PENDING
);

async function onUpdateSort(sort: SortingState) {
  await navigateTo({
    path: route.path,
    query: {
      ...route.query,
      sort: useSort(sort[0]?.id ?? "id", sort[0]?.desc ? "desc" : "asc"),
    },
  });
}

async function onUpdatePage(page: number) {
  await navigateTo({
    path: route.path,
    query: {
      ...route.query,
      page: page,
    },
  });
}

async function onUpdateSearch() {
  await navigateTo({
    path: route.path,
    query: {
      ...route.query,
      search: search.value,
      page: 1,
    },
  });
}

watch(search, async (newValue) => {
  await onUpdateSearch();
});
</script>

<template>
  <div
    class="flex flex-col w-full mx-auto gap-4 py-4 px-8 rounded-lg mb-5 bg"
  >
    <div class="flex flex-col gap-2">
      <BaseTitle v-if="title" :title="title" />
      <div class="flex flex-row gap-4 justify-between w-full">
        <UInput
          icon="i-lucide-search"
          class="md:w-4/10"
          size="md"
          variant="soft"
          placeholder="Buscar..."
          v-model="search"
        >
          <template #trailing v-if="search.length > 0" class="p-5">
            <UButton
              icon="i-lucide-circle-x"
              size="sm"
              color="error"
              variant="ghost"
              @click="search = ''"
            />
          </template>
        </UInput>
        <UButton
          icon="material-symbols:add"
          size="md"
          color="primary"
          class="flex items-center"
          @click="emit('add')"
        >
          Novo
        </UButton>
      </div>
    </div>
    <UTable
      ref="table"
      :columns="columns"
      :data="rows"
      :loading="loading"
      @update:sorting="onUpdateSort"
      class="h-[70dvh] bg-accented/30 rounded-lg"
      :ui="{
        thead:
          'divide-none [&>tr>th:first-child]:rounded-s-lg [&>tr>th:last-child]:rounded-e-lg',
        tbody: 'divide-none border-none',
        th: 'divide-none border-none'
      }"
    >
      <template #empty>
        <div
          class="flex flex-col h-full items-center justify-center py-10 text-center text-neutral-400"
        >
          <UIcon name="solar:notification-lines-remove-bold" size="4rem" />
          <br />
          <p class="text-lg text-accented font-bold">
            Nenhum resultado encontrado
          </p>
          <p class="text-sm text-muted font-light">
            Tente ajustar os filtros ou realizar outra busca.
          </p>
          <br />
          <p class="text-sm text-muted font-light mb-2">
            Não encontrou o que procurava?<br />
            Adicione um novo registro:
          </p>
          <UButton
            icon="material-symbols:add"
            size="md"
            color="primary"
            class="flex items-center"
            @click="emit('add')"
          >
            Novo
          </UButton>
        </div>
      </template>
    </UTable>
    <div class="flex justify-center">
      <UPagination
        :page="currentPage"
        variant="soft"
        :default-page="
          (table?.tableApi?.getState().pagination.pageIndex || 0) + 1
        "
        :items-per-page="perPage"
        :total="total"
        @update:page="onUpdatePage"
      />
    </div>
  </div>
</template>
