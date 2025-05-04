<script setup lang="ts">
import type { FormSubmitEvent } from "#ui/types";
import * as yup from "yup";
import GoogleSigninButton from "~/components/GoogleSigninButton.vue";
import type ApiResponse from "~~/types/ApiResponse";

definePageMeta({
  layout: "login",
});

const waitingLogin = ref(false);

const schema = yup.object({
  email: yup
    .string()
    .required("O email é obrigatório")
    .trim()
    .email("Email deve ser válido")
    .max(50, "Email deve ter no máximo 50 caracteres"),
  password: yup
    .string()
    .required("Senha é obrigatória")
    .trim()
    .min(5, "Senha deve ter no mínimo 5 caracteres")
    .max(20, "Senha deve ter no máximo 20 caracteres"),
});

type Schema = yup.InferType<typeof schema>;

const state = reactive<{
  email: string | undefined;
  password: string | undefined;
}>({
  email: undefined,
  password: undefined,
});

const { login } = useSanctumAuth<ApiResponse>();

async function onSubmit(event: FormSubmitEvent<Schema>) {
  try {
    waitingLogin.value = true;
    await login(event.data);
    toast().success({
      description: "Login realizado com sucesso",
    });
  } catch (error) {
    toast().error({
      description:
        (error as { message?: string })?.message || "Ocorreu um erro",
    });
  } finally {
    waitingLogin.value = false;
  }
}
</script>

<template>
  <div
    class="h-[100dvh] flex justify-center items-center mx-auto w-10/12 md:w-4/12"
  >
    <UForm
      :schema="schema"
      :state="state"
      class="space-y-4 w-screen py-10 px-10 bg-default rounded-xl flex flex-col gap-2 border-1 border-accented/60"
      @submit="onSubmit"
    >
      <div class="flex flex-col gap-6">
        <UFormField label="Email" name="email" :required="true">
          <UInput
            type="email"
            v-model="state.email"
            class="w-full"
          />
        </UFormField>

        <UFormField label="Senha" name="password" :required="true">
          <PasswordInput
            v-model="state.password"
            class="w-full"
          />
        </UFormField>
      </div>

      <div class="flex flex-col justify-between gap-3">
        <UButton
          type="submit"
          class="justify-center"
          trailing
          loading-icon="svg-spinners:90-ring-with-bg"
          :loading="waitingLogin"
        >
          Entrar
        </UButton>

        <GoogleSigninButton />
      </div>
    </UForm>
  </div>
</template>
