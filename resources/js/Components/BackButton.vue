<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({ href: String });
</script>
<template>
    <Link :href="href" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        <slot>Back</slot>
    </Link>
</template>
