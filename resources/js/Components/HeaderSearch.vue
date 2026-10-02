<script setup>
import { ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';

const searchQuery = ref('');
</script>

<template>
    <div class="hidden sm:flex max-w-md w-full relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
        </div>
        <TextInput 
            v-model="searchQuery" 
            type="search" 
            class="pl-10 w-full bg-slate-100/50 dark:bg-slate-800/50 border-transparent shadow-none hover:bg-slate-50 dark:hover:bg-slate-800 focus:bg-white dark:focus:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-colors" 
            placeholder="Search anywhere..."
        />
    </div>
</template>
