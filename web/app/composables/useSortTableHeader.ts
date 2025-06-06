import { UButton } from '#components'
import type { Column } from '@tanstack/vue-table'

export function useSortTableHeader<T>(label: string, column: Column<T>) {
  const route = useRoute();
  const routeSort = route.query.sort?.toString();
  const isSortedAsc = routeSort?.includes('-') ? false : true;
  const isRouteColumn = routeSort === column.id || routeSort === `-${column.id}`;

  const icon = isRouteColumn
    ? isSortedAsc
      ? 'eva:arrow-down-fill'
      : 'eva:arrow-up-fill'
    : 'fa-solid:sort';

  return h(UButton, {
    color: 'neutral',
    variant: 'ghost',
    label,
    icon,
    class: '-mx-2.5',
    onClick: () => column.toggleSorting(!route.query.sort?.toString().includes('-')),
  });
}
