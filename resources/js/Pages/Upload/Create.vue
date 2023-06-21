<script setup>
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputError from '@/Components/InputError.vue';
    import ListBox from '@/Components/ListBox.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm, Link } from '@inertiajs/vue3';
    import { PhotoIcon, UserCircleIcon } from '@heroicons/vue/24/solid';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';


    const props = defineProps({
        categories: {
            type: Object,
            default: [],
        },
    });

    let form = useForm('CreateTeam', {
        name: '',
        category_id: '',
        path: '',
    });

    const handleFileInput = (event) => {
        form.path = event.target.files[0];
    };

    const submit = () => {
        form.category_id = form.category_id.id;
        form.post(route('images.store'), {
            // onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Image</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="space-y-12">
                                <div class="pb-12">
                                    <h2 class="text-base font-semibold leading-7 text-gray-900">Upload Image</h2>
                                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8">
                                        <div class="sm:col-span-3">
                                            <InputLabel for="uploadImage" value="Image Name"/>

                                            <div class="mt-2">
                                                <TextInput v-model="form.name" id="uploadImage" type="text" class="mt-1 block w-full" required autofocus autocomplete="name"/>
                                                <InputError class="mt-2" :message="form.errors.name"/>
                                            </div>
                                        </div>
                                        <div class="sm:col-span-3">
                                            <InputLabel for="name" value="Image"/>
                                            <div class="relative flex items-center">
                                                <input class="relative  block min-w-full rounded border bg-clip-padding py-[0.32rem] px-3 text-sm file:rounded-none file:border-0 file:border-solid file:px-3 file:py-[0.32rem] file:text-neutral-700
                                                                file:[margin-inline-end:0.75rem]" type="file" id="tool_csv" @input="handleFileInput"/>
                                            </div>
                                            <InputError class="mt-2" :message="form.errors.path"/>

                                        </div>
                                        <div class="sm:col-span-3">
                                            <ListBox :options="categories.data" v-model="form.category_id"></ListBox>
                                            <InputError class="mt-2" :message="form.errors.category_id"/>
                                        </div>
                                        <div class="sm:col-span-3">
                                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save
                                            </PrimaryButton>
                                            <SecondaryButton  class="mx-3" 
                                                              @click="form.reset('name', 'category_id')">Cancel
                                            </SecondaryButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
