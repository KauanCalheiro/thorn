import type { FetchContext } from 'ofetch';
import type { ConsolaInstance } from 'consola';
import type { NuxtApp } from '#app';
import inputTheme from '~~/src/theme/input';
import buttonTheme from '~~/src/theme/button';
import accordionTheme from '~~/src/theme/accordion';
import tableTheme from '~~/src/theme/table';

export default defineAppConfig({
  // https://ui.nuxt.com/getting-started/theme#design-system
  ui: {
    colors: {
      primary: 'violet',
      neutral: 'neutral',
    },
    input: inputTheme,
    button: buttonTheme,
    accordion: accordionTheme,
    table: tableTheme,
  },

  sanctum: {
    interceptors: {
      onRequest: async (app: NuxtApp, ctx: FetchContext, logger: ConsolaInstance): Promise<void> => {
        ctx.options.credentials = 'omit'
      },
    },
  },
})

