<script setup>
import Sidebar from './Includes/Sidebar.vue';
import Header from './Includes/Header.vue';
import Footer from './Includes/Footer.vue';
import Toast from '@/Components/Toast.vue';
</script>

<template>
    <div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-slate-900 font-sans text-slate-900 dark:text-slate-100 transition-colors duration-200">
        <Toast />
        <!-- Sidebar -->
        <Sidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden relative">
            
            <!-- Top Navigation / Header -->
            <Header />

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto flex flex-col bg-slate-50 dark:bg-slate-900 transition-colors duration-200">
                <!-- Main Page Content -->
                <main class="flex-1 p-4 sm:p-6 w-full mx-auto animate-fade-in">
                    <!-- Page Breadcrumb / Header -->
                    <!-- <div v-if="$slots.header" class="mb-2">
                        <slot name="header" />
                    </div> -->
                    <slot />
                </main>

                <!-- Footer -->
                <Footer />
            </div>
        </div>
    </div>
</template>

<style>
/* Custom animations and scrollbar hiding */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fadeIn 0.4s ease-out forwards;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
