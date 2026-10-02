<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import Toast from '@/Components/Toast.vue';

const showingNavigationDropdown = ref(false);
</script>
<template>
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200 shrink-0 z-10 sticky top-0 shadow-sm relative">
        <Toast />
        <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
            <!-- Hamburger / Mobile menu toggle -->
            <div class="flex items-center md:hidden">
                <button
                    @click="showingNavigationDropdown = !showingNavigationDropdown"
                    class="inline-flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none transition-colors"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Header Slot (Page Title) -->
            <div class="hidden md:flex items-center text-lg font-bold text-slate-800" v-if="$slots.header">
                <slot name="header" />
            </div>
            <!-- Centered title on mobile -->
            <div class="md:hidden flex-1 flex justify-center text-lg font-bold text-slate-800 truncate px-4" v-if="$slots.header">
                 <slot name="header" />
            </div>

            <!-- User Dropdown -->
            <div class="flex items-center">
                <div class="relative">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg text-slate-600 bg-transparent hover:text-slate-900 hover:bg-slate-100 focus:outline-none transition-all duration-200">
                                    {{ $page.props.auth.user.name }}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
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
