export default defineNuxtPlugin(() => {
    const cookie = useCookie('nuxt-ui-primary');
    const appConfig = useAppConfig();

    if (cookie.value) {
        appConfig.ui.colors.primary = cookie.value;
    }
});
