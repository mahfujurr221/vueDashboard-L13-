<script setup>
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const showBackupModal = ref(false);
const backupPassword = ref('');
const passwordError = ref('');

const submitBackup = () => {
    if (backupPassword.value !== 'tiger') {
        passwordError.value = 'Incorrect backup password.';
        return;
    }
    
    passwordError.value = '';
    showBackupModal.value = false;
    backupPassword.value = '';
    
    // Trigger download
    window.location.href = route('backup.download') + '?password=tiger';
};
</script>

<template>
    <aside class="w-64 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 flex flex-col transition-all duration-300 hidden md:flex shadow-lg z-20 shrink-0 border-r border-slate-200 dark:border-slate-800">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 shrink-0">
            <Link :href="route('dashboard')" class="flex items-center space-x-3 group">
                <div class="p-1.5 bg-indigo-50 dark:bg-indigo-500/10 rounded-lg group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition">
                    <ApplicationLogo class="block h-7 w-auto fill-current text-indigo-600 dark:text-indigo-400" />
                </div>
                <span class="text-lg font-bold tracking-wide text-slate-800 dark:text-slate-100">VueDash</span>
            </Link>
        </div>

        <!-- Menus -->
        <nav class="flex-1 overflow-y-auto py-5 px-3 space-y-1 scrollbar-hide">
            <div class="px-3 pt-2 pb-3 flex items-center w-full opacity-80">
                <span class="text-[10px] font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-widest mr-3">Menu</span>
                <div class="flex-1 border-t border-dashed border-indigo-200 dark:border-indigo-800/60"></div>
            </div>
            <Link
                prefetch
                :href="route('dashboard')"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group"
                :class="{ 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400': route().current('dashboard'), 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100': !route().current('dashboard') }"
            >
                <svg class="mr-3 h-5 w-5 transition-colors" :class="route().current('dashboard') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </Link>

            <Link
                v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('roles-view')"
                prefetch
                :href="route('roles.index')"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group"
                :class="{ 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400': route().current('roles.*'), 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100': !route().current('roles.*') }"
            >
                <svg class="mr-3 h-5 w-5 transition-colors" :class="route().current('roles.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Role Management
            </Link>

            <Link
                v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('users-view')"
                prefetch
                :href="route('users.index')"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group"
                :class="{ 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400': route().current('users.*'), 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100': !route().current('users.*') }"
            >
                <svg class="mr-3 h-5 w-5 transition-colors" :class="route().current('users.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Users
            </Link>

            <div class="px-3 pt-6 pb-3 flex items-center w-full opacity-80">
                <span class="text-[10px] font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-widest mr-3">Settings</span>
                <div class="flex-1 border-t border-dashed border-indigo-200 dark:border-indigo-800/60"></div>
            </div>

            <Link
                v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('settings-view')"
                prefetch
                :href="route('settings.index')"
                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group"
                :class="{ 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400': route().current('settings.*'), 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100': !route().current('settings.*') }"
            >
                <svg class="mr-3 h-5 w-5 transition-colors" :class="route().current('settings.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                System Settings
            </Link>
        </nav>
        
        <!-- Backup Button -->
        <div v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('backup-database')" class="h-[32px] px-3 flex items-center justify-center border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shrink-0 transition-colors duration-200">
            <button @click="showBackupModal = true" type="button" class="flex items-center justify-center w-full h-[24px] bg-[#293241] dark:bg-slate-700 text-white text-[9px] font-bold rounded hover:bg-slate-800 transition-colors duration-200 uppercase tracking-widest">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Backup Database
            </button>
        </div>

        <!-- Backup Password Modal -->
        <Modal :show="showBackupModal" @close="showBackupModal = false" maxWidth="sm" title="Backup Verification">
            <div class="mb-5">
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    Downloading the database is a highly sensitive action. Please enter the backup password to proceed.
                </p>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Password</label>
                <TextInput 
                    v-model="backupPassword" 
                    type="password" 
                    class="w-full" 
                    placeholder="Enter password..." 
                    @keyup.enter="submitBackup"
                    required 
                />
                <InputError :message="passwordError" class="mt-2" />
            </div>
            
            <template #footer>
                <SecondaryButton @click="showBackupModal = false">Cancel</SecondaryButton>
                <PrimaryButton type="button" @click="submitBackup">Download Backup</PrimaryButton>
            </template>
        </Modal>
    </aside>
</template>
