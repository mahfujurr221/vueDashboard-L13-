<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({ href: String, title: String });
</script>
<template>
    <Link :href="href" class="flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md hover:border-indigo-300 transition-all group">
        <div class="text-slate-400 group-hover:text-indigo-600 mr-3 transition-colors">
            <slot name="icon" />
        </div>
        <span class="text-sm font-semibold text-slate-700 group-hover:text-indigo-700 transition-colors">{{ title }}</span>
    </Link>
</template>
