<script setup>
import { ref, watch, onMounted, onUnmounted, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(false);
const message = ref('');
const type = ref('success'); // 'success', 'error', 'warning'
let timeout = null;

const toastClasses = computed(() => {
    switch (type.value) {
        case 'success': return 'bg-green-600 text-white shadow-green-500/20';
        case 'error': return 'bg-red-600 text-white shadow-red-500/20';
        case 'warning': return 'bg-amber-500 text-white shadow-amber-500/20';
        default: return 'bg-slate-800 text-white shadow-slate-500/20';
    }
});

const iconClasses = computed(() => {
    switch (type.value) {
        case 'success': return 'text-green-50 bg-green-700/40';
        case 'error': return 'text-red-50 bg-red-700/40';
        case 'warning': return 'text-amber-50 bg-amber-700/40';
        default: return 'text-slate-50 bg-slate-700/40';
    }
});

const btnClasses = computed(() => {
    switch (type.value) {
        case 'success': return 'text-green-200 hover:text-white hover:bg-green-700/50 focus:ring-green-400';
        case 'error': return 'text-red-200 hover:text-white hover:bg-red-700/50 focus:ring-red-400';
        case 'warning': return 'text-amber-100 hover:text-white hover:bg-amber-600/50 focus:ring-amber-400';
        default: return 'text-slate-400 hover:text-white hover:bg-slate-700 focus:ring-slate-400';
    }
});

const showToast = (msg, msgType = 'success') => {
    message.value = msg;
    type.value = msgType;
    show.value = true;
    
    if (timeout) clearTimeout(timeout);
    timeout = setTimeout(() => {
        show.value = false;
    }, 4000);
};

// Watch for flash messages coming from Inertia page props
watch(() => page.props.flash, (flash) => {
    if (flash.success) {
        showToast(flash.success, 'success');
        // Clear the flash so it doesn't reappear on back/forward navigation
        page.props.flash.success = null;
    } else if (flash.error) {
        showToast(flash.error, 'error');
        page.props.flash.error = null;
    }
}, { deep: true });

onUnmounted(() => {
    if (timeout) clearTimeout(timeout);
});
</script>

<template>
    <Transition
        enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="-translate-y-4 opacity-0 sm:-translate-y-0 sm:translate-x-4"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="show" :class="['fixed top-6 right-6 z-50 flex items-center w-full max-w-xs py-2.5 px-4 space-x-3 rounded-lg shadow-xl backdrop-blur-sm border border-white/10', toastClasses]" role="alert">
            
            <!-- Success Icon -->
            <div v-if="type === 'success'" :class="['inline-flex items-center justify-center flex-shrink-0 w-6 h-6 rounded-md', iconClasses]">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
            </div>
            
            <!-- Error Icon -->
            <div v-if="type === 'error'" :class="['inline-flex items-center justify-center flex-shrink-0 w-6 h-6 rounded-md', iconClasses]">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                </svg>
            </div>

            <!-- Warning Icon -->
            <div v-if="type === 'warning'" :class="['inline-flex items-center justify-center flex-shrink-0 w-6 h-6 rounded-md', iconClasses]">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                </svg>
            </div>

            <div class="ml-3 text-xs font-semibold tracking-wide flex-1">{{ message }}</div>
            
            <button @click="show = false" type="button" :class="['ml-auto -mx-1.5 -my-1.5 rounded-md focus:ring-2 p-1 inline-flex items-center justify-center h-6 w-6 transition-colors bg-transparent', btnClasses]">
                <span class="sr-only">Close</span>
                <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    </Transition>
</template>
