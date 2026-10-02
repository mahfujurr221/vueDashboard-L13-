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
        class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:bg-white dark:focus:bg-slate-800 focus:border-indigo-600 dark:focus:border-indigo-500 focus:ring-0 transition-colors duration-200 shadow-sm"
        v-model="model"
        ref="select"
    >
        <slot />
    </select>
</template>
