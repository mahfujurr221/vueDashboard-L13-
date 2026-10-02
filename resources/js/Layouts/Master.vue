<script setup>
import Sidebar from './Includes/Sidebar.vue';
import Header from './Includes/Header.vue';
import Footer from './Includes/Footer.vue';
</script>

<template>
    <div class="flex h-screen overflow-hidden bg-slate-50 font-sans text-slate-900">
        <!-- Sidebar -->
        <Sidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden relative">
            
            <!-- Top Navigation / Header -->
            <Header>
                <template #header v-if="$slots.header">
                    <slot name="header" />
                </template>
            </Header>

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto flex flex-col bg-slate-50">
                <!-- Main Page Content -->
                <main class="flex-1 p-4 sm:p-6 w-full mx-auto animate-fade-in">
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
