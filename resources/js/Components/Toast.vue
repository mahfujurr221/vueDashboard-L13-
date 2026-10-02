<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(false);
const message = ref('');
const type = ref('success'); // 'success' or 'error'
let timeout = null;

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
        <div v-if="show" class="fixed top-6 right-6 z-50 flex items-center w-full max-w-xs p-4 space-x-3 text-slate-800 bg-white rounded-xl shadow-2xl border border-slate-100" role="alert">
            
            <!-- Success Icon -->
            <div v-if="type === 'success'" class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
            </div>
            
            <!-- Error Icon -->
            <div v-if="type === 'error'" class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                </svg>
            </div>

            <div class="ml-3 text-sm font-semibold tracking-wide">{{ message }}</div>
            
            <button @click="show = false" type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-slate-400 hover:text-slate-900 rounded-lg focus:ring-2 focus:ring-slate-300 p-1.5 hover:bg-slate-100 inline-flex items-center justify-center h-8 w-8 transition-colors">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    </Transition>
</template>
