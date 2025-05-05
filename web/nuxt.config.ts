// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },

  modules: [
    '@nuxt/ui',
    '@nuxt/eslint',
    '@nuxt/content',
    '@nuxt/fonts',
    '@nuxt/icon',
    '@nuxt/image',
    '@nuxt/scripts',
    '@nuxt/test-utils',
    'nuxt-auth-sanctum',
    '@formkit/auto-animate/nuxt',
    'nuxt-vue3-google-signin',
    '@vite-pwa/nuxt',
  ],

  plugins: [
    '~/plugins/sanctum-listener.ts',
    '~/plugins/ui-primary.ts',
  ],

  css: ['~/assets/css/main.css'],

  future: {
    compatibilityVersion: 4
  },

  compatibilityDate: '2024-11-27',

  colorMode: {
    preference: 'dark',
    fallback: 'dark',
  },

  app: {
    head: {
      title: 'Thorn',
      link: [
        { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico', },
        { rel: 'apple-touch-icon', href: '/apple-touch-icon.png', },
      ],
    },
    baseURL: '/',
  },

  pwa: {
    registerType: 'autoUpdate',
    manifest: {
      name: 'Thorn',
      short_name: 'Thorn',
      description: 'Thorn is a simple, elegant and centered system for gym use',
      start_url: "/",
      display: "fullscreen",
      background_color: "#9956FE",
      theme_color: "#FFFFFF",
      icons: [
        {
          src: "/pwa-192x192.png",
          sizes: "192x192",
          type: "image/png",
          purpose: "any"
        },
        {
          src: "/pwa-512x512.png",
          sizes: "512x512",
          type: "image/png",
          purpose: "any"
        },
        {
          src: "/pwa-maskable-192x192.png",
          sizes: "192x192",
          type: "image/png",
          purpose: "maskable"
        },
        {
          src: "/pwa-maskable-512x512.png",
          sizes: "512x512",
          type: "image/png",
          purpose: "maskable"
        }
      ],
    },
    workbox: {
      navigateFallback: '/',
      globPatterns: ['**/*.{js,css,html,png,svg,ico}'],
    },
    devOptions: {
      enabled: true,
      type: 'module',
    }
  },

  googleSignIn: {
    clientId: process.env.GOOGLE_SING_IN_CLIENT_ID
  },

  sanctum: {
    baseUrl: process.env.SANCTUM_BASE_URL,

    mode: 'token',
    userStateKey: 'sanctum.user.identity',

    endpoints: {
      csrf: '/sanctum/csrf-cookie',
      login: '/auth/login',
      logout: '/auth/logout',
      user: '/auth/user',
    },

    client: {
      retry: false,
      initialRequest: true,
    },

    redirect: {
      keepRequestedRoute: true,
      onLogin: '/',
      onLogout: '/login',
      onAuthOnly: '/login',
    },

    globalMiddleware: {
      enabled: true,
      allow404WithoutAuth: true,
    },

    logLevel: 0,
    appendPlugin: false,
  },
})