export default defineNuxtPlugin((nuxtApp) => {
    const lastSanctumError = ref<any>(null)

    nuxtApp.provide('lastSanctumError', lastSanctumError)

    nuxtApp.hook('sanctum:error', (response) => {
        lastSanctumError.value = response
    })
})