<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: [String, Number],
});

const select = ref(null);

onMounted(() => {
    if (select.value.hasAttribute('autofocus')) {
        select.value.focus();
    }
});

defineExpose({ focus: () => select.value.focus() });
</script>

<template>
    <select
        class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:bg-white focus:border-indigo-600 focus:ring-0 transition-colors duration-200 shadow-sm"
        v-model="model"
        ref="select"
    >
        <slot />
    </select>
</template>
