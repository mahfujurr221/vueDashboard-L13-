<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 text-slate-700 text-sm font-semibold rounded-lg shadow-sm hover:bg-slate-50 hover:text-slate-900 hover:border-slate-400 focus:outline-none focus:ring-4 focus:ring-slate-500/10 active:bg-slate-100 transition-all disabled:opacity-50"
    >
        <slot />
    </button>
</template>
