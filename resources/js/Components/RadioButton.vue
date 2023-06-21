<script setup>
const props = defineProps({
    type: {
        type: String,
        required: true,
    },
    label:String,
    id:String,
    name:String,
    value:String,
});

defineEmits(['update:modelValue']);

</script>
<template>
    <div class="flex flex-wrap gap-1">
        <div class="flex items-center mr-4" >
            <div>
                <input  @input="$emit('update:modelValue', $event.target.value)" :value="value" v-model="modelValue" :id="id" type="radio" :name="name"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label :for="id"
                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer">{{label || 'Add Label'}}</label>
            </div>

        </div>
    </div>
</template>
