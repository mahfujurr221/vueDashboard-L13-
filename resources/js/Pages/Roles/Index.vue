<script setup>
import { ref } from 'vue';
import Master from '@/Layouts/Master.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DataTable from '@/Components/DataTable.vue';
import AddNewButton from '@/Components/AddNewButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

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
        <template #header>
            <Breadcrumb :items="[{ label: 'Role Management' }]" />
        </template>

        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 leading-tight">Role Management</h2>
            </div>
            <AddNewButton v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('roles-create')" @click="openAddModal" label="Add Role" />
        </div>

        <DataTable>
            <template #header>
                <tr>
                    <th scope="col" class="w-20">#</th>
                    <th scope="col">Role Name</th>
                    <th scope="col" class="text-right">Actions</th>
                </tr>
            </template>
            
            <tr v-if="roles.length === 0">
                <td colspan="3" class="!py-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 dark:text-slate-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <h5 class="text-slate-500 dark:text-slate-400 font-bold text-base">No Roles Found</h5>
                    <p class="text-slate-400 dark:text-slate-500 text-xs mt-1">Start by adding your first role.</p>
                </td>
            </tr>
            <tr v-for="(role, index) in roles" :key="role.id">
                <td class="text-slate-500 dark:text-slate-400 font-medium">{{ index + 1 }}</td>
                <td>
                    <span class="font-bold text-slate-700 dark:text-slate-200">{{ role.name }}</span>
                    <span v-if="role.name === 'super-admin'" class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-100 dark:bg-red-500/10 text-red-800 dark:text-red-400">Protected</span>
                </td>
                <td class="text-right">
                    <div class="flex items-center justify-end space-x-2">
                        <Link :href="route('roles.permissions', role.id)" class="inline-flex items-center justify-center px-2 py-1 text-[11px] font-bold text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-800/50 rounded hover:bg-indigo-100 dark:hover:bg-indigo-500/20 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors uppercase tracking-wider">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            Permissions
                        </Link>
                        
                        <button v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('roles-update')" @click="openEditModal(role)" class="inline-flex items-center justify-center w-7 h-7 text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-800 rounded hover:bg-blue-100 dark:hover:bg-blue-500/20 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                        
                        <button v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('roles-delete')" @click="deleteRole(role)" :disabled="role.name === 'super-admin'" :class="[role.name === 'super-admin' ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-100 dark:hover:bg-red-500/20 hover:text-red-800 dark:hover:text-red-300', 'inline-flex items-center justify-center w-7 h-7 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-500/10 border border-red-100 dark:border-red-800 rounded transition-colors']">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
        </DataTable>

        <!-- Add Role Modal -->
        <Modal :show="showAddModal" @close="showAddModal = false" maxWidth="md" title="Add New Role">
            <div class="mb-5">
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Role Name</label>
                <TextInput v-model="form.name" type="text" class="w-full" placeholder="e.g. Manager" required />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            
            <template #footer>
                <SecondaryButton @click="showAddModal = false">Cancel</SecondaryButton>
                <PrimaryButton type="button" @click="submitAdd" :disabled="form.processing">
                    {{ form.processing ? 'Saving...' : 'Save Role' }}
                </PrimaryButton>
            </template>
        </Modal>

        <!-- Edit Role Modal -->
        <Modal :show="showEditModal" @close="showEditModal = false" maxWidth="md" title="Update Role">
            <div class="mb-5">
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Role Name</label>
                <TextInput v-model="editForm.name" type="text" class="w-full" required />
                <InputError :message="editForm.errors.name" class="mt-2" />
            </div>
            
            <template #footer>
                <SecondaryButton @click="showEditModal = false">Cancel</SecondaryButton>
                <PrimaryButton type="button" @click="submitEdit" :disabled="editForm.processing">
                    {{ editForm.processing ? 'Updating...' : 'Update Role' }}
                </PrimaryButton>
            </template>
        </Modal>

    </Master>
</template>
