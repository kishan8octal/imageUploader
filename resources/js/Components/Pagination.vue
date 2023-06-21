<script setup>
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        data: {
            type: Object,
            default: () => ({}),
        },
    });

</script>

<template>
    <div v-if="data.links.length > 3" class="flex justify-end mt-4 mx-4">
        <Link
                v-for="(link, k) in data.links"
                :key="k"
                class="px-4 py-3 text-sm leading-4 bg-white rounded hover:bg-white hover:text-black focus:text-indigo-500 hover:shadow"
                :class="{'!bg-slate-400 text-white hover:text-black': link.active, 'inertia_disabled': !link.url}"
                :href=" link.url || '#'"
                v-html="link.label"
        />
    </div>
</template>
