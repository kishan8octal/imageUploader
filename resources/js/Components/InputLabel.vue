<script setup>
defineProps({
    value: {
        type: String,
    },
    labelFor:{
        type: [String, Number],
        default: null
    }
});
</script>

<template>
    <label :for="labelFor" class="block font-medium text-sm text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
