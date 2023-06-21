<script setup>
    import Checkbox from '@/Components/Checkbox.vue';
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import RadioButton from '@/Components/RadioButton.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';

    defineProps({
        canResetPassword: {
            type: Boolean,
        },
        status: {
            type: String,
        },
    });

    const signInForm = useForm({
        email: '',
        password: '',
    });

    const signIn = () => {
        signInForm.post(route('login'), {
            onFinish: () => form.reset('password'),
        });
    };

    const signUpForm = useForm({
        name: '',
        email: '',
        password: '',
        type: '',
        password_confirmation: '',
    });

    const singUp = () => {
        signUpForm.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
</script>

<template>
    <GuestLayout>
        <Head title="Log in"/>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4  overflow-hidden">
            <h1 class="my-5 text-2xl bold">Sign Up</h1>
            <form @submit.prevent="singUp">
                <div>
                    <InputLabel for="name" value="Name"/>

                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="signUpForm.name" required autofocus autocomplete="name"/>

                    <InputError class="mt-2" :message="signUpForm.errors.name"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email"/>

                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="signUpForm.email" required autocomplete="username"/>

                    <InputError class="mt-2" :message="signUpForm.errors.email"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password"/>

                    <TextInput id="password" type="password" class="mt-1 block w-full" v-model="signUpForm.password" required autocomplete="new-password"/>

                    <InputError class="mt-2" :message="signUpForm.errors.password"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirm Password"/>

                    <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="signUpForm.password_confirmation" required autocomplete="new-password"/>

                    <InputError class="mt-2" :message="signUpForm.errors.password_confirmation"/>
                </div>
                <div class="mt-4 flex flex-col gap-3">
                    <RadioButton value="0" name="type" v-model="signUpForm.type" id="normalUser" label="Normal User" />
                    <RadioButton value="1" name="type" v-model="signUpForm.type" id="contributor" label="Contributor" />
                </div>
                <div class="mt-4">
                    <PrimaryButton :class="{ 'opacity-25': signUpForm.processing }" :disabled="signUpForm.processing">
                        Sign Up
                    </PrimaryButton>
                </div>
            </form>

        </div>
        <div class="border"></div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden">
            <h1 class="my-5 text-2xl bold">Sign In</h1>
            <form @submit.prevent="signIn">
                <div>
                    <InputLabel for="email" value="Username"/>

                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="signInForm.email" required autofocus autocomplete="username"/>

                    <InputError class="mt-2" :message="signInForm.errors.email"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password"/>

                    <TextInput id="password" type="password" class="mt-1 block w-full" v-model="signInForm.password" required autocomplete="current-password"/>

                    <InputError class="mt-2" :message="signInForm.errors.password"/>
                </div>

                <div class="mt-4">
                    <PrimaryButton :class="{ 'opacity-25': signInForm.processing }" :disabled="signInForm.processing">
                        Log in
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
