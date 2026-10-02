<script setup>
defineProps({
    placeholder: {
        type: String,
        default: 'Search...'
    }
});
const model = defineModel({ type: String });
</script>
<template>
    <div class="flex items-center space-x-3 w-full max-w-sm">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input type="text" v-model="model" :placeholder="placeholder" class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-9 pr-3 py-1.5 text-sm focus:outline-none focus:bg-white focus:border-indigo-600 focus:ring-0 transition-colors duration-200 shadow-sm">
        </div>
        <slot />
    </div>
</template>
