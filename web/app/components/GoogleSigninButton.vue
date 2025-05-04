<script setup lang="ts">
import {
  type AuthCodeFlowErrorResponse,
  type AuthCodeFlowSuccessResponse,
} from "vue3-google-signin";
import type ApiResponse from "~~/types/ApiResponse";

const { login: sanctumLogin } = useSanctumAuth<ApiResponse>();

const { isReady, login } = useTokenClient({
  onSuccess: handleOnSuccess,
  onError: handleOnError,
});

const loading = ref<boolean>(false);

async function handleLogin() {
  login();
}

async function handleOnSuccess(response: AuthCodeFlowSuccessResponse) {
  try {
    loading.value = true;
    await sanctumLogin({
      driver: "google",
      token: response.access_token,
    });
    toast().success({
      description: "Login realizado com sucesso",
    });
  } catch (error) {
    toast().error({
      description:
        (error as { message?: string })?.message || "Ocorreu um erro",
    });
  } finally {
    loading.value = false;
  }
}

async function handleOnError(errorResponse: AuthCodeFlowErrorResponse) {
  loading.value = false;
  toast().error({
    description: errorResponse.error_description ?? "Erro ao fazer login",
  });
}
</script>

<template>
  <UButton
    class="justify-center"
    color="neutral"
    type="button"
    icon="logos:google-icon"
    :trailing="loading || !isReady"
    :loading="loading || !isReady"
    :disabled="!isReady"
    loading-icon="svg-spinners:90-ring-with-bg"
    @click="() => handleLogin()"
  >
    <span>Entrar com Google</span>
  </UButton>
</template>
