<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    label: {
        type: String,
        default: 'Add New',
    }
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center justify-center px-4 py-1.5 bg-gradient-to-r from-indigo-500 to-indigo-600 dark:from-indigo-600 dark:to-indigo-700 text-white text-xs font-bold rounded-full shadow-md shadow-indigo-500/30 hover:shadow-lg hover:shadow-indigo-500/50 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 active:translate-y-0 active:shadow-sm transition-all duration-200 uppercase tracking-wide"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
        <slot>{{ label }}</slot>
    </button>
</template>
