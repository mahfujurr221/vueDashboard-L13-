<script setup>
defineProps({
    title: String,
});
</script>
<template>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div v-if="title || $slots.header" class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 v-if="title" class="font-bold text-slate-800">{{ title }}</h3>
            <slot name="header" />
        </div>
        <div class="p-5">
            <slot />
        </div>
        <div v-if="$slots.footer" class="px-5 py-3 border-t border-slate-100 bg-slate-50/50 rounded-b-xl">
            <slot name="footer" />
        </div>
    </div>
</template>
