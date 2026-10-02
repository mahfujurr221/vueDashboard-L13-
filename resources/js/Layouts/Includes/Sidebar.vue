<script setup>
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>
<template>
    <aside class="w-64 bg-white text-slate-800 flex flex-col transition-all duration-300 hidden md:flex shadow-lg z-20 shrink-0 border-r border-slate-200">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 bg-white border-b border-slate-100 shrink-0">
            <Link :href="route('dashboard')" class="flex items-center space-x-3 group">
                <div class="p-1.5 bg-indigo-50 rounded-lg group-hover:bg-indigo-100 transition">
                    <ApplicationLogo class="block h-7 w-auto fill-current text-indigo-600" />
                </div>
                <span class="text-lg font-bold tracking-wide text-slate-800">VueDash</span>
            </Link>
        </div>

        <!-- Menus -->
        <nav class="flex-1 overflow-y-auto py-5 px-3 space-y-1 scrollbar-hide">
            <div class="px-3 pb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                Menu
            </div>
            <Link
                prefetch
                :href="route('dashboard')"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group"
                :class="{ 'bg-indigo-50 text-indigo-700': route().current('dashboard'), 'text-slate-600 hover:bg-slate-50 hover:text-slate-900': !route().current('dashboard') }"
            >
                <svg class="mr-3 h-5 w-5 transition-colors" :class="route().current('dashboard') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </Link>

            <div class="px-3 pt-5 pb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                Settings
            </div>
            <Link
                prefetch
                :href="route('profile.edit')"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group"
                :class="{ 'bg-indigo-50 text-indigo-700': route().current('profile.edit'), 'text-slate-600 hover:bg-slate-50 hover:text-slate-900': !route().current('profile.edit') }"
            >
                <svg class="mr-3 h-5 w-5 transition-colors" :class="route().current('profile.edit') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profile
            </Link>

            <Link
                prefetch
                :href="route('settings.index')"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group"
                :class="{ 'bg-indigo-50 text-indigo-700': route().current('settings.*'), 'text-slate-600 hover:bg-slate-50 hover:text-slate-900': !route().current('settings.*') }"
            >
                <svg class="mr-3 h-5 w-5 transition-colors" :class="route().current('settings.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                System Settings
            </Link>
        </nav>
        
        <!-- User Info -->
        <div class="p-4 border-t border-slate-100 bg-white shrink-0">
            <div class="flex items-center px-2">
                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm shrink-0">
                    {{ $page.props.auth.user.name.charAt(0) }}
                </div>
                <div class="ml-3 overflow-hidden">
                    <p class="text-sm font-medium text-slate-800 truncate">{{ $page.props.auth.user.name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ $page.props.auth.user.email }}</p>
                </div>
            </div>
        </div>
    </aside>
</template>
