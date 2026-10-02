<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import Toast from '@/Components/Toast.vue';
import HeaderSearch from '@/Components/HeaderSearch.vue';
import { useDarkMode } from '@/Composables/useDarkMode';

const showingNavigationDropdown = ref(false);
const { isDark, toggleDarkMode } = useDarkMode();
</script>
<template>
    <header class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shrink-0 z-10 sticky top-0 shadow-sm relative transition-colors duration-200">
        <Toast />
        <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
            <!-- Left Side: Hamburger & Search -->
            <div class="flex items-center flex-1">
                <!-- Hamburger / Mobile menu toggle -->
                <div class="flex items-center md:hidden mr-4">
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="inline-flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-800 focus:outline-none transition-colors"
                    >
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- Search Bar -->
                <HeaderSearch />
            </div>

            <!-- Right Side: Interactions & User Dropdown -->
            <div class="flex items-center space-x-1 md:space-x-3">
                
                <!-- Theme Toggle Button -->
                <button @click="toggleDarkMode" class="p-2 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:text-slate-400 dark:hover:text-indigo-400 dark:hover:bg-slate-800 transition-colors focus:outline-none focus:ring-0">
                    <!-- Moon Icon (Switch to Dark) -->
                    <svg v-if="!isDark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <!-- Sun Icon (Switch to Light) -->
                    <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                <!-- Notifications Button -->
                <button class="relative p-2 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:text-slate-400 dark:hover:text-indigo-400 dark:hover:bg-slate-800 transition-colors focus:outline-none focus:ring-0">
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>

                <!-- User Dropdown -->
                <div class="relative ml-1">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center pl-2 pr-3 py-1.5 text-sm font-medium rounded-full text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-0 transition-all duration-200">
                                    <img :src="$page.props.auth.user.image ? '/storage/' + $page.props.auth.user.image : `https://ui-avatars.com/api/?name=${encodeURIComponent($page.props.auth.user.name)}&color=4F46E5&background=EEF2FF`" alt="Profile" class="h-6 w-6 rounded-full mr-2 object-cover shadow-sm" />
                                    <span class="hidden md:inline-block">{{ $page.props.auth.user.name }}</span>
                                    <svg class="ml-2 -mr-0.5 h-4 w-4 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <div class="px-4 py-2 border-b border-slate-100">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ $page.props.auth.user.name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ $page.props.auth.user.email }}</p>
                            </div>
                            <DropdownLink :href="route('profile.edit')">
                                Profile Settings
                            </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </div>
        
        <!-- Mobile Navigation Menu Dropdown -->
        <div :class="{'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown}" class="md:hidden border-t border-slate-200 bg-white absolute w-full left-0 shadow-xl z-50 rounded-b-xl">
            <div class="pt-2 pb-3 space-y-1 px-3">
                <Link :href="route('dashboard')" class="flex items-center px-3 py-2.5 rounded-lg text-base font-medium transition-colors" :class="route().current('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-50'">
                    Dashboard
                </Link>
                <Link :href="route('profile.edit')" class="flex items-center px-3 py-2.5 rounded-lg text-base font-medium transition-colors" :class="route().current('profile.edit') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-50'">
                    Profile
                </Link>
                <Link :href="route('logout')" method="post" as="button" class="w-full text-left flex items-center px-3 py-2.5 rounded-lg text-base font-medium text-red-600 hover:bg-red-50 transition-colors mt-2">
                    Log Out
                </Link>
            </div>
        </div>
    </header>
</template>
