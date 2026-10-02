<script setup>
import { ref } from 'vue';
import Master from '@/Layouts/Master.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import DataTable from '@/Components/DataTable.vue';
import AddNewButton from '@/Components/AddNewButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    users: Array,
    roles: Array
});

// Add User
const showAddModal = ref(false);
const form = useForm({
    name: '',
    email: '',
    password: '',
    phone: '',
    role: '',
    is_active: 1
});

const openAddModal = () => {
    form.reset();
    showAddModal.value = true;
};

const submitAdd = () => {
    form.post(route('users.store'), {
        preserveScroll: true,
        onSuccess: () => {
            showAddModal.value = false;
            form.reset();
        }
    });
};

// Edit User
const showEditModal = ref(false);
const editForm = useForm({
    id: null,
    name: '',
    email: '',
    password: '',
    phone: '',
    role: '',
    is_active: 1
});

const openEditModal = (user) => {
    editForm.id = user.id;
    editForm.name = user.name;
    editForm.email = user.email;
    editForm.phone = user.phone || '';
    editForm.role = user.roles && user.roles.length > 0 ? user.roles[0].name : '';
    editForm.is_active = user.is_active;
    editForm.password = ''; // empty by default
    showEditModal.value = true;
};

const submitEdit = () => {
    editForm.put(route('users.update', editForm.id), {
        preserveScroll: true,
        onSuccess: () => {
            showEditModal.value = false;
        }
    });
};

// Delete User
const deleteForm = useForm({});
const deleteUser = (user) => {
    if (confirm('Are you sure you want to delete this user?')) {
        deleteForm.delete(route('users.destroy', user.id), {
            preserveScroll: true
        });
    }
};
</script>

<template>
    <Head title="Manage Users" />

    <Master>
        <template #header>
            <Breadcrumb :items="[{ label: 'User Management' }]" />
        </template>

        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 leading-tight">User Management</h2>
            </div>
            <AddNewButton v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('users-create')" @click="openAddModal" label="Add User" />
        </div>

        <DataTable>
            <template #header>
                <tr>
                    <th scope="col">User Details</th>
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-right">Actions</th>
                </tr>
            </template>
            
            <tr v-for="user in users" :key="user.id">
                <td>
                    <div class="flex items-center py-0.5">
                        <div class="h-8 w-8 shrink-0">
                            <img class="h-8 w-8 rounded-full object-cover" :src="user.image ? '/storage/' + user.image : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&color=047857&background=D1FAE5`" alt="">
                        </div>
                        <div class="ml-3">
                            <div class="font-bold text-slate-800 dark:text-slate-100 leading-tight">{{ user.name }}</div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400 leading-tight">{{ user.email }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <span v-for="role in user.roles" :key="role.id" class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 mr-1">
                        {{ role.name.replace(/[-_]/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                    </span>
                    <span v-if="!user.roles || user.roles.length === 0" class="text-slate-400 dark:text-slate-500 text-xs italic">No Role</span>
                </td>
                <td>
                    <span v-if="user.is_active" class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 dark:bg-green-500/10 text-green-800 dark:text-green-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                        Active
                    </span>
                    <span v-else class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 dark:bg-red-500/10 text-red-800 dark:text-red-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                        Inactive
                    </span>
                </td>
                <td class="text-right">
                    <div class="flex items-center justify-end space-x-2">
                        <button v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('users-update')" @click="openEditModal(user)" class="inline-flex items-center justify-center w-7 h-7 text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-800 rounded hover:bg-blue-100 dark:hover:bg-blue-500/20 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                        
                        <button v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('users-delete')" @click="deleteUser(user)" :disabled="user.id === $page.props.auth.user.id" :class="[user.id === $page.props.auth.user.id ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-100 dark:hover:bg-red-500/20 hover:text-red-800 dark:hover:text-red-300', 'inline-flex items-center justify-center w-7 h-7 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-500/10 border border-red-100 dark:border-red-800 rounded transition-colors']">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
        </DataTable>

        <!-- Add Modal -->
        <Modal :show="showAddModal" @close="showAddModal = false" maxWidth="lg" title="Add New User">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Name</label>
                    <TextInput v-model="form.name" type="text" class="w-full" required />
                    <InputError :message="form.errors.name" class="mt-1" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Email Address</label>
                    <TextInput v-model="form.email" type="email" class="w-full" required />
                    <InputError :message="form.errors.email" class="mt-1" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Password</label>
                    <TextInput v-model="form.password" type="password" class="w-full" required />
                    <InputError :message="form.errors.password" class="mt-1" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Phone</label>
                    <TextInput v-model="form.phone" type="text" class="w-full" />
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Assign Role</label>
                    <SelectInput v-model="form.role" class="w-full" required>
                        <option value="" disabled>Select a Role</option>
                        <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.name }}</option>
                    </SelectInput>
                    <InputError :message="form.errors.role" class="mt-1" />
                </div>
            </div>
            
            <template #footer>
                <SecondaryButton @click="showAddModal = false">Cancel</SecondaryButton>
                <PrimaryButton type="button" @click="submitAdd" :disabled="form.processing">
                    {{ form.processing ? 'Saving...' : 'Save User' }}
                </PrimaryButton>
            </template>
        </Modal>

        <!-- Edit Modal -->
        <Modal :show="showEditModal" @close="showEditModal = false" maxWidth="lg" title="Edit User">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Name</label>
                    <TextInput v-model="editForm.name" type="text" class="w-full" required />
                    <InputError :message="editForm.errors.name" class="mt-1" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Email Address</label>
                    <TextInput v-model="editForm.email" type="email" class="w-full" required />
                    <InputError :message="editForm.errors.email" class="mt-1" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Password (Leave blank to keep)</label>
                    <TextInput v-model="editForm.password" type="password" class="w-full" />
                    <InputError :message="editForm.errors.password" class="mt-1" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Phone</label>
                    <TextInput v-model="editForm.phone" type="text" class="w-full" />
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Assign Role</label>
                    <SelectInput v-model="editForm.role" class="w-full" required>
                        <option value="" disabled>Select a Role</option>
                        <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.name }}</option>
                    </SelectInput>
                    <InputError :message="editForm.errors.role" class="mt-1" />
                </div>
                <div class="md:col-span-2">
                    <label class="flex items-center mt-2 cursor-pointer">
                        <input type="checkbox" v-model="editForm.is_active" :true-value="1" :false-value="0" class="rounded border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-500 dark:focus:ring-offset-slate-900">
                        <span class="ml-2 text-sm text-slate-600 dark:text-slate-300">Active Account</span>
                    </label>
                </div>
            </div>
            
            <template #footer>
                <SecondaryButton @click="showEditModal = false">Cancel</SecondaryButton>
                <PrimaryButton type="button" @click="submitEdit" :disabled="editForm.processing">
                    {{ editForm.processing ? 'Updating...' : 'Update User' }}
                </PrimaryButton>
            </template>
        </Modal>

    </Master>
</template>
