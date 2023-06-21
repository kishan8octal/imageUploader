<script setup>
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputError from '@/Components/InputError.vue';
    import ListBox from '@/Components/ListBox.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm, Link } from '@inertiajs/vue3';
    import { PhotoIcon, UserCircleIcon } from '@heroicons/vue/24/solid';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import Pagination from "@/Components/Pagination.vue";
    import {
        UsersIcon,
    } from '@heroicons/vue/24/outline'
    const props = defineProps({
        images: {
            type: Object,
            required: true,
        }, 
    });

    const NormalUser = 0;
    const Contributor = 1;
    const CurrentUser = User;
    
</script>
<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Upload Image</h2>
        </template>
        
        <template #sidebar v-if="CurrentUser.type === NormalUser">
            <li>
                <ul role="list" class="-mx-2 space-y-1 text-white">
                    <Link :href="route('images.index')"  class="'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold'">
                        <UsersIcon class="h-6 w-6 shrink-0"/>
                        Categories
                    </Link>
                </ul>
            </li>
        </template>
        
        <div class="py-12">
            <div class="bg-white py-10">
                <h2 class="text-base font-semibold leading-7 sm:px-6 lg:px-8">Download Report</h2>
                <table class="mt-6 w-full whitespace-nowrap text-left">
                    <thead class="border-b border-white/10 text-sm leading-6">
                    <tr>
                        <th scope="col" class="py-2 pl-4 pr-8 font-semibold sm:pl-6 lg:pl-8">Image Name</th>
                        <th scope="col" class="hidden py-2 pl-0 pr-8 font-semibold sm:table-cell">Category</th>
                        <th scope="col" class="hidden py-2 pl-0 pr-8 font-semibold md:table-cell lg:pr-20">Total Downloads</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                    <tr v-for="image in images.data" :key="image.id">
                        <td class="py-4 pl-4 pr-8 sm:pl-6 lg:pl-8">
                            <div class="flex items-center gap-x-4">
                                <img :src="image.image_url" alt="" class="h-8 w-8 rounded-full bg-gray-800 object-cover" />
                                <div class="truncate text-sm font-medium leading-6">{{ image.name }}</div>
                            </div>
                        </td>
                        <td class="py-4 pl-0 pr-8 text-sm leading-6 text-gray-400 md:table-cell lg:pr-20">{{ image.category_name }}</td>
                        <td class="py-4 pl-0 pr-8 text-sm leading-6 text-gray-400 md:table-cell lg:pr-20">{{ image.total_downloads }}</td>
                    </tr>
                    </tbody>
                </table>
                <Pagination :data="images.meta" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
