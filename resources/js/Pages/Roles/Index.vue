<script setup>
import { ref } from 'vue';
import Master from '@/Layouts/Master.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    roles: Array
});

// Add Role
const showAddModal = ref(false);
const form = useForm({
    name: ''
});

const openAddModal = () => {
    form.reset();
    showAddModal.value = true;
};

const submitAdd = () => {
    form.post(route('roles.store'), {
        preserveScroll: true,
        onSuccess: () => {
            showAddModal.value = false;
            form.reset();
        }
    });
};

// Edit Role
const showEditModal = ref(false);
const editForm = useForm({
    id: null,
    name: ''
});

const openEditModal = (role) => {
    editForm.id = role.id;
    editForm.name = role.name;
    showEditModal.value = true;
};

const submitEdit = () => {
    editForm.put(route('roles.update', editForm.id), {
        preserveScroll: true,
        onSuccess: () => {
            showEditModal.value = false;
        }
    });
};

// Delete Role
const deleteForm = useForm({});
const deleteRole = (role) => {
    if (confirm('Are you sure you want to delete this role?')) {
        deleteForm.delete(route('roles.destroy', role.id), {
            preserveScroll: true
        });
    }
};
</script>

<template>
    <Head title="Manage Roles" />

    <Master>
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 mb-1">Role Management</h2>
                <p class="text-slate-500 text-sm">Define user roles and access levels</p>
            </div>
            <button v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('roles-create')" @click="openAddModal" class="mt-4 md:mt-0 px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-700 text-white font-semibold rounded-full shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:-translate-y-0.5 transition-all text-sm flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Role
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100 font-bold">
                        <tr>
                            <th scope="col" class="px-6 py-4 w-20">#</th>
                            <th scope="col" class="px-6 py-4">Role Name</th>
                            <th scope="col" class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="roles.length === 0">
                            <td colspan="3" class="px-6 py-12 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <h5 class="text-slate-500 font-bold text-base">No Roles Found</h5>
                                <p class="text-slate-400 text-xs mt-1">Start by adding your first role.</p>
                            </td>
                        </tr>
                        <tr v-for="(role, index) in roles" :key="role.id" class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4 text-slate-500 font-medium">{{ index + 1 }}</td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-700">{{ role.name }}</span>
                                <span v-if="role.name === 'super-admin'" class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-100 text-red-800">Protected</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <Link :href="route('roles.permissions', role.id)" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-lg hover:bg-indigo-100 hover:text-indigo-800 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                        </svg>
                                        Permissions
                                    </Link>
                                    
                                    <button v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('roles-update')" @click="openEditModal(role)" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 border border-blue-100 rounded-lg hover:bg-blue-100 hover:text-blue-800 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    
                                    <button v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('roles-delete')" @click="deleteRole(role)" :disabled="role.name === 'super-admin'" :class="[role.name === 'super-admin' ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-100 hover:text-red-800', 'inline-flex items-center justify-center w-8 h-8 text-red-600 bg-red-50 border border-red-100 rounded-lg transition-colors']">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Role Modal -->
        <Modal :show="showAddModal" @close="showAddModal = false" maxWidth="md">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Add New Role</h3>
                <form @submit.prevent="submitAdd">
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Role Name</label>
                        <TextInput v-model="form.name" type="text" class="w-full" placeholder="e.g. Manager" required />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-end space-x-3 mt-6">
                        <button type="button" @click="showAddModal = false" class="px-4 py-2 text-sm font-semibold text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">Cancel</button>
                        <button type="submit" :disabled="form.processing" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500/20 transition-all disabled:opacity-50">
                            {{ form.processing ? 'Saving...' : 'Save Role' }}
                        </button>
                    </div>
                </form>
            </div>
        </Modal>

        <!-- Edit Role Modal -->
        <Modal :show="showEditModal" @close="showEditModal = false" maxWidth="md">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Update Role</h3>
                <form @submit.prevent="submitEdit">
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Role Name</label>
                        <TextInput v-model="editForm.name" type="text" class="w-full" required />
                        <InputError :message="editForm.errors.name" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-end space-x-3 mt-6">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm font-semibold text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">Cancel</button>
                        <button type="submit" :disabled="editForm.processing" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500/20 transition-all disabled:opacity-50">
                            {{ editForm.processing ? 'Updating...' : 'Update Role' }}
                        </button>
                    </div>
                </form>
            </div>
        </Modal>

    </Master>
</template>
