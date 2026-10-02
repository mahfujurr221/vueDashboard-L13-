<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    items: {
        type: Array,
        required: true,
        // Array of objects: { label: 'Label', url: '/url' }
    }
});
</script>

<template>
    <nav class="flex text-sm font-medium text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <Link :href="route('dashboard')" class="inline-flex items-center hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Dashboard
                </Link>
            </li>
            
            <li v-for="(item, index) in items" :key="index">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-slate-300 dark:text-slate-600 mx-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <Link v-if="item.url" :href="item.url" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors whitespace-nowrap">{{ item.label }}</Link>
                    <span v-else class="text-slate-800 dark:text-slate-200 font-bold whitespace-nowrap">{{ item.label }}</span>
                </div>
            </li>
        </ol>
    </nav>
</template>
