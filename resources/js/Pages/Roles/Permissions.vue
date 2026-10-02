<script setup>
import { ref, computed } from 'vue';
import Master from '@/Layouts/Master.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DataTable from '@/Components/DataTable.vue';

const props = defineProps({
    role: Object,
    groupedPermissions: Object,
    rolePermissions: Array
});

const form = useForm({
    permissions: props.rolePermissions || []
});

const searchQuery = ref('');

// Filtered groups based on search
const filteredGroups = computed(() => {
    if (!searchQuery.value) return props.groupedPermissions;
    
    const query = searchQuery.value.toLowerCase();
    const filtered = {};
    
    for (const [group, permissions] of Object.entries(props.groupedPermissions)) {
        const matchingPerms = permissions.filter(p => p.name.toLowerCase().includes(query));
        if (matchingPerms.length > 0) {
            filtered[group] = matchingPerms;
        }
    }
    
    return filtered;
});

const submit = () => {
    form.put(route('roles.update_permissions', props.role.id), {
        preserveScroll: true
    });
};

const selectAll = () => {
    const allPerms = [];
    Object.values(props.groupedPermissions).forEach(group => {
        group.forEach(p => allPerms.push(p.name));
    });
    form.permissions = allPerms;
};

const unselectAll = () => {
    form.permissions = [];
};

const isGroupSelected = (groupName) => {
    const permsInGroup = props.groupedPermissions[groupName].map(p => p.name);
    return permsInGroup.every(p => form.permissions.includes(p));
};

const toggleGroup = (groupName, event) => {
    const permsInGroup = props.groupedPermissions[groupName].map(p => p.name);
    if (event.target.checked) {
        permsInGroup.forEach(p => {
            if (!form.permissions.includes(p)) form.permissions.push(p);
        });
    } else {
        form.permissions = form.permissions.filter(p => !permsInGroup.includes(p));
    }
};
</script>

<template>
    <Head :title="`Permissions for ${role.name}`" />

    <Master>
        <template #header>
            <Breadcrumb :items="[
                { label: 'Role Management', url: route('roles.index') },
                { label: `Permissions (${role.name})` }
            ]" />
        </template>

        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors">
            <div class="p-4 md:p-6 border-b border-slate-100 dark:border-slate-800 flex justify-end">
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <button @click="selectAll" type="button" class="px-4 py-2 text-sm font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-800/50 rounded-lg hover:bg-emerald-100 dark:hover:bg-emerald-500/20 transition-colors w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Select All
                    </button>
                    <button @click="unselectAll" type="button" class="px-4 py-2 text-sm font-semibold text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-800/50 rounded-lg hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        Unselect All
                    </button>
                </div>
            </div>

            <div class="p-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/30">
                <div class="relative max-w-md">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input v-model="searchQuery" type="text" class="block w-full p-2.5 pl-10 text-sm text-slate-900 dark:text-slate-100 border border-slate-200 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 focus:ring-indigo-500 dark:focus:ring-indigo-500 focus:border-indigo-500 dark:focus:border-indigo-500 shadow-sm" placeholder="Search permissions (e.g. 'user-create')...">
                </div>
            </div>

            <form @submit.prevent="submit">
                <DataTable>
                    <template #header>
                        <tr>
                            <th scope="col" class="w-1/4">Module Group</th>
                            <th scope="col" class="w-24 text-center">All</th>
                            <th scope="col">Specific Permissions</th>
                        </tr>
                    </template>
                    
                    <tr v-if="Object.keys(filteredGroups).length === 0">
                        <td colspan="3" class="!py-8 text-center text-slate-500 dark:text-slate-400">
                            No permissions match your search.
                        </td>
                    </tr>
                    <tr v-for="(permissions, group) in filteredGroups" :key="group">
                        <td class="align-top">
                            <span class="inline-block px-3 py-1 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 rounded-lg text-xs font-bold uppercase tracking-wider">
                                {{ group.replace(/_/g, ' ') }}
                            </span>
                        </td>
                        <td class="align-top text-center">
                            <div class="flex justify-center">
                                <input type="checkbox" :checked="isGroupSelected(group)" @change="toggleGroup(group, $event)" class="w-5 h-5 text-indigo-600 bg-white dark:bg-slate-900 border-slate-300 dark:border-slate-700 rounded focus:ring-indigo-500 dark:focus:ring-offset-slate-900 focus:ring-2 cursor-pointer transition-all">
                            </div>
                        </td>
                        <td>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-3 gap-x-4">
                                <div v-for="permission in permissions" :key="permission.id" class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input v-model="form.permissions" :value="permission.name" :id="`perm_${permission.id}`" type="checkbox" class="w-4 h-4 text-indigo-600 bg-white dark:bg-slate-900 border-slate-300 dark:border-slate-700 rounded focus:ring-indigo-500 dark:focus:ring-offset-slate-900 focus:ring-2 cursor-pointer transition-all">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label :for="`perm_${permission.id}`" class="font-medium text-slate-700 dark:text-slate-300 cursor-pointer select-none hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                            {{ permission.name.replace(/[-_]/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </DataTable>

                <div class="p-6 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-100 dark:border-slate-800 flex items-center justify-center gap-4 transition-colors">
                    <Link :href="route('roles.index')" class="px-6 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                        Cancel
                    </Link>
                    <button type="submit" :disabled="form.processing" class="px-8 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-700 text-white font-semibold rounded-full shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:-translate-y-0.5 transition-all text-sm flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        {{ form.processing ? 'Saving...' : 'Update Permissions' }}
                    </button>
                </div>
            </form>
        </div>
    </Master>
</template>
