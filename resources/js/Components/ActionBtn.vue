<script setup>
defineProps({
    title: String,
    type: { type: String, default: 'button' },
    color: { type: String, default: 'primary' }
});
</script>
<template>
    <button :type="type" :title="title" class="inline-flex items-center justify-center p-1.5 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-1"
    :class="{
        'text-indigo-500 hover:text-white hover:bg-indigo-500 focus:ring-indigo-500': color === 'primary',
        'text-red-500 hover:text-white hover:bg-red-500 focus:ring-red-500': color === 'danger',
        'text-green-500 hover:text-white hover:bg-green-500 focus:ring-green-500': color === 'success',
        'text-slate-500 hover:text-white hover:bg-slate-500 focus:ring-slate-500': color === 'default'
    }">
        <slot />
    </button>
</template>
