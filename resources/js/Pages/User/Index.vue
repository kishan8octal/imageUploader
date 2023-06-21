<script setup>
    import { ref, watch } from 'vue';

    import InputLabel from '@/Components/InputLabel.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, router } from '@inertiajs/vue3';
    import Pagination from '@/Components/Pagination.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import Modal from '@/Components/DialogModal.vue';
    import Checkbox from '@/Components/Checkbox.vue';
    import { UsersIcon, XMarkIcon } from '@heroicons/vue/24/outline';
    import { useSnackbar } from 'vue3-snackbar';

    const snackbar = useSnackbar();

    const NormalUser = 0;
    const Contributor = 1;
    const CurrentUser = User;

    const props = defineProps({
        images: {
            type: Object,
            required: true,
        },
        filters: {
            type: Object,
            required: true,
        },
        categories: {
            type: Object,
            required: true,
        },
    });

    const filterCategoryImages = ref([]);
    const isOpenModal = ref(false);
    const downloadImage = ref(null);

    watch(filterCategoryImages, (value) => {
        if (value) {
            getCategoryImage(value);
        }
    });

    const getCategoryImage = (filter) => {
        let params = {};

        if (filter) params.categoryIds = filter;

        router.get('/images', params, {
            preserveState: true,
            replace: true,
        });
    };

    const closeModal = () => {
        isOpenModal.value = false;
    };

    const openImage = (image) => {
        isOpenModal.value = true;
        downloadImage.value = image;
    };

    const handleDownloadImage = (imageId) => {
        axios.get(route('images.download', imageId)).then(res => {
            snackbar.add({
                type: 'success',
                text: 'Image Downloaded Successfully.',
            });
            isOpenModal.value = false;
        });
    };
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
                    <Link :href="route('images.index')" class="group flex gap-x-3 pb-3 p-2 text-sm leading-6 font-semibold border-b">
                        <UsersIcon class="h-6 w-6 shrink-0"/>
                        Categories
                    </Link>
                    <div class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold" v-for="category in categories.data">
                        <input :id="category.id" type="checkbox" :value="category.id" v-model="filterCategoryImages" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"/>
                        <InputLabel :value="category.name" :labelFor="category.id" class="text-white cursor-pointer"/>
                    </div>
                </ul>
            </li>
        </template>

        <Modal :show="isOpenModal" @close="closeModal">
            <template #title>
                <div class="flex justify-between">
                    <span>Download Image</span>
                    <XMarkIcon class="h-5 cursor-pointer" @click="closeModal"/>
                </div>
            </template>

            <template #content>
                <div class="mt-4 flex flex-col items-center gap-3">
                    <div>
                        <img class="max-w-[15rem]" :src="downloadImage.image_url"/>
                    </div>
                    <div>
                        <InputLabel class="inline text-gray-900" value="Contributor Name:"/>
                        {{downloadImage.user_name}}
                    </div>
                    <div>
                        <InputLabel class="inline text-gray-900" value="Image:"/>
                        {{downloadImage.name}}
                    </div>
                    <div>
                        <InputLabel class="inline text-gray-900" value="Total Downloads:"/>
                        {{downloadImage.total_downloads}}
                    </div>
                    <div>

                    </div>
                </div>
            </template>

            <template #footer>
                <a class="w-full text-center" :href="downloadImage.image_url" download @click="handleDownloadImage(downloadImage.id)">
                    <PrimaryButton class="ml-3">
                        Download
                    </PrimaryButton>
                </a>
            </template>
        </Modal>
        <div class="py-12">
            <div class="bg-white p-10">
                <div class="grid grid-cols-1 md:grid-cols-4 sm:grid-cols-2 gap-5">
                    <div v-for="image in images.data" class="shadow-lg p-4 flex flex-col gap-2 cursor-pointer" @click="openImage(image)">
                        <div>
                            <img class="h-[200px] w-full object-cover hover:scale-105 duration-200" :src="image.image_url"/>
                        </div>
                        <div>
                            <InputLabel class="inline text-gray-900" value="Contributor Name:"/>
                            {{image.user_name}}
                        </div>
                        <div>
                            <InputLabel class="inline text-gray-900" value="Image:"/>
                            {{image.name}}
                        </div>
                        <div>
                            <InputLabel class="inline text-gray-900" value="Total Downloads:"/>
                            {{image.total_downloads}}
                        </div>
                    </div>
                </div>
                <Pagination :data="images.meta"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
