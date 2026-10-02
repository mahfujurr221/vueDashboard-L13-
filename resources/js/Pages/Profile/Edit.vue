<script setup>
import Master from '@/Layouts/Master.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const currentTab = ref('overview');
</script>

<template>
    <Head title="Profile" />

    <Master>
        <template #header>
            <h2 class="text-lg font-bold text-slate-800">
                My Profile
            </h2>
        </template>

        <div class="flex flex-col xl:flex-row gap-4 mb-0 h-[calc(100vh-140px)]">
            <!-- Left Profile Card -->
            <div class="w-full xl:w-1/3 h-full">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col items-center text-center">
                    <div class="relative">
                        <img 
                            :src="user.image ? '/storage/' + user.image : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&color=7F9CF5&background=EBF4FF`" 
                            alt="Profile" 
                            class="w-24 h-24 rounded-full object-cover shadow-sm border-4 border-white ring-1 ring-slate-100"
                        >
                    </div>
                    <h2 class="text-xl font-bold text-slate-800 mt-3">{{ user.name }}</h2>
                    <h3 class="text-xs font-semibold text-indigo-600 mt-1 uppercase tracking-wider">{{ user.type || 'Administrator' }}</h3>
                </div>
            </div>

            <!-- Right Tabs -->
            <div class="w-full xl:w-2/3 h-full flex flex-col">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col h-full">
                    <div class="flex flex-wrap border-b border-slate-100 bg-slate-50/50 flex-shrink-0">
                        <button 
                            @click="currentTab = 'overview'" 
                            :class="[currentTab === 'overview' ? 'text-indigo-600 border-b-2 border-indigo-600 font-bold bg-white' : 'text-slate-500 hover:text-slate-700 font-medium', 'px-5 py-3 text-sm transition-colors']"
                        >
                            Overview
                        </button>
                        <button 
                            @click="currentTab = 'edit'" 
                            :class="[currentTab === 'edit' ? 'text-indigo-600 border-b-2 border-indigo-600 font-bold bg-white' : 'text-slate-500 hover:text-slate-700 font-medium', 'px-5 py-3 text-sm transition-colors']"
                        >
                            Edit Profile
                        </button>
                        <button 
                            @click="currentTab = 'password'" 
                            :class="[currentTab === 'password' ? 'text-indigo-600 border-b-2 border-indigo-600 font-bold bg-white' : 'text-slate-500 hover:text-slate-700 font-medium', 'px-5 py-3 text-sm transition-colors']"
                        >
                            Change Password
                        </button>
                    </div>

                    <div class="p-5 flex-grow overflow-y-auto">
                        <div v-show="currentTab === 'overview'" class="animate-fade-in">
                            <h5 class="text-base font-bold text-slate-800 mb-4">Profile Details</h5>
                            
                            <div class="space-y-0.5">
                                <div class="flex flex-col md:flex-row py-3 border-b border-slate-100 hover:bg-slate-50 px-2 rounded-lg transition-colors">
                                    <div class="w-full md:w-1/3 text-sm font-bold text-slate-700">Full Name</div>
                                    <div class="w-full md:w-2/3 text-sm text-slate-600">{{ user.name }}</div>
                                </div>
                                <div class="flex flex-col md:flex-row py-3 border-b border-slate-100 hover:bg-slate-50 px-2 rounded-lg transition-colors">
                                    <div class="w-full md:w-1/3 text-sm font-bold text-slate-700">Email</div>
                                    <div class="w-full md:w-2/3 text-sm text-slate-600">{{ user.email }}</div>
                                </div>
                                <div class="flex flex-col md:flex-row py-3 border-b border-slate-100 hover:bg-slate-50 px-2 rounded-lg transition-colors">
                                    <div class="w-full md:w-1/3 text-sm font-bold text-slate-700">Phone</div>
                                    <div class="w-full md:w-2/3 text-sm text-slate-600">{{ user.phone || 'Not provided' }}</div>
                                </div>
                                <div class="flex flex-col md:flex-row py-3 hover:bg-slate-50 px-2 rounded-lg transition-colors">
                                    <div class="w-full md:w-1/3 text-sm font-bold text-slate-700">Account Status</div>
                                    <div class="w-full md:w-2/3 text-sm">
                                        <span v-if="user.is_active" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                        <span v-else class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-show="currentTab === 'edit'" class="animate-fade-in">
                            <h5 class="text-base font-bold text-slate-800 mb-4">Edit Profile</h5>
                            <UpdateProfileInformationForm
                                :must-verify-email="mustVerifyEmail"
                                :status="status"
                            />
                        </div>

                        <div v-show="currentTab === 'password'" class="animate-fade-in">
                            <h5 class="text-base font-bold text-slate-800 mb-4">Change Password</h5>
                            <UpdatePasswordForm />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Master>
</template>
