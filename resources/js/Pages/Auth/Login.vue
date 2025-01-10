<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInputCurstom from '@/Components/TextInputCurstom.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <Head title="Iniciar sesión" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-6 p-4">
            <div>
                <InputLabel for="email" value="Correo Electrónico" />
                <TextInputCurstom
                    id="email"
                    v-model="form.email"
                    type="email"
                    placeholder="Ingresa tu correo electrónico"
                    icon="envelope"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Contraseña" />
                <TextInputCurstom
                    id="password"
                    v-model="form.password"
                    type="password"
                    placeholder="Ingresa tu contraseña"
                    icon="lock"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center">
                <Checkbox v-model:checked="form.remember" name="remember" />
                <span class="ms-2 text-sm text-gray-600">Recordarme</span>
            </div>

            <div class="flex items-center justify-between">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-blue-600 hover:underline focus:outline-none">
                    ¿Olvidaste tu contraseña?
                </Link>

                <PrimaryButton
                    class="ms-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2"
                    :class="{ 'opacity-50': form.processing }"
                    :disabled="form.processing">
                    Iniciar Sesión
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
