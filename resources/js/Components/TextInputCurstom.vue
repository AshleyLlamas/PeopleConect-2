<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: [String, Number],
    type: {
        type: String,
        default: 'text',
    },
    placeholder: String,
    id: String,
    name: String,
    disabled: Boolean,
    readonly: Boolean,
    icon: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <div class="relative">
        <input
            ref="input"
            class="peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
            :type="type"
            :placeholder="placeholder"
            :id="id"
            :name="name"
            :disabled="disabled"
            :readonly="readonly"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        />

        <!-- Icon container -->
        <div v-if="icon" class="absolute inset-y-0 start-0 flex items-center ps-4">
            <font-awesome-icon :icon="icon" class="text-gray-500" />
        </div>
    </div>
</template>
