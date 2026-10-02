<script setup>
import { ref } from 'vue';
import Master from '@/Layouts/Master.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';

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
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 mb-1">User Management</h2>
                <p class="text-slate-500 text-sm">Manage system users and their roles</p>
            </div>
            <button v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('users-create')" @click="openAddModal" class="mt-4 md:mt-0 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-semibold rounded-full shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:-translate-y-0.5 transition-all text-sm flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New User
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100 font-bold">
                        <tr>
                            <th scope="col" class="px-6 py-4">User Details</th>
                            <th scope="col" class="px-6 py-4">Role</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                            <th scope="col" class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id" class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 shrink-0">
                                        <img class="h-10 w-10 rounded-full object-cover" :src="user.image ? '/storage/' + user.image : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&color=047857&background=D1FAE5`" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-bold text-slate-800">{{ user.name }}</div>
                                        <div class="text-xs text-slate-500">{{ user.email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span v-for="role in user.roles" :key="role.id" class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700 mr-1">
                                    {{ role.name.replace(/[-_]/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                                </span>
                                <span v-if="!user.roles || user.roles.length === 0" class="text-slate-400 text-xs italic">No Role</span>
                            </td>
                            <td class="px-6 py-4">
                                <span v-if="user.is_active" class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                                    Active
                                </span>
                                <span v-else class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                    Inactive
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <button v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('users-update')" @click="openEditModal(user)" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 border border-blue-100 rounded-lg hover:bg-blue-100 hover:text-blue-800 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    
                                    <button v-if="$page.props.auth.roles.includes('super-admin') || $page.props.auth.permissions.includes('users-delete')" @click="deleteUser(user)" :disabled="user.id === $page.props.auth.user.id" :class="[user.id === $page.props.auth.user.id ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-100 hover:text-red-800', 'inline-flex items-center justify-center w-8 h-8 text-red-600 bg-red-50 border border-red-100 rounded-lg transition-colors']">
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

        <!-- Add Modal -->
        <Modal :show="showAddModal" @close="showAddModal = false" maxWidth="lg">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Add New User</h3>
                <form @submit.prevent="submitAdd">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Name</label>
                            <TextInput v-model="form.name" type="text" class="w-full" required />
                            <InputError :message="form.errors.name" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                            <TextInput v-model="form.email" type="email" class="w-full" required />
                            <InputError :message="form.errors.email" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                            <TextInput v-model="form.password" type="password" class="w-full" required />
                            <InputError :message="form.errors.password" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Phone</label>
                            <TextInput v-model="form.phone" type="text" class="w-full" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Assign Role</label>
                            <SelectInput v-model="form.role" class="w-full" required>
                                <option value="" disabled>Select a Role</option>
                                <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.name }}</option>
                            </SelectInput>
                            <InputError :message="form.errors.role" class="mt-1" />
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end space-x-3 mt-6">
                        <button type="button" @click="showAddModal = false" class="px-4 py-2 text-sm font-semibold text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">Cancel</button>
                        <button type="submit" :disabled="form.processing" class="px-4 py-2 text-sm font-semibold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-500/20 transition-all disabled:opacity-50">
                            {{ form.processing ? 'Saving...' : 'Save User' }}
                        </button>
                    </div>
                </form>
            </div>
        </Modal>

        <!-- Edit Modal -->
        <Modal :show="showEditModal" @close="showEditModal = false" maxWidth="lg">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Edit User</h3>
                <form @submit.prevent="submitEdit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Name</label>
                            <TextInput v-model="editForm.name" type="text" class="w-full" required />
                            <InputError :message="editForm.errors.name" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                            <TextInput v-model="editForm.email" type="email" class="w-full" required />
                            <InputError :message="editForm.errors.email" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password (Leave blank to keep)</label>
                            <TextInput v-model="editForm.password" type="password" class="w-full" />
                            <InputError :message="editForm.errors.password" class="mt-1" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Phone</label>
                            <TextInput v-model="editForm.phone" type="text" class="w-full" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Assign Role</label>
                            <SelectInput v-model="editForm.role" class="w-full" required>
                                <option value="" disabled>Select a Role</option>
                                <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.name }}</option>
                            </SelectInput>
                            <InputError :message="editForm.errors.role" class="mt-1" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="flex items-center mt-2 cursor-pointer">
                                <input type="checkbox" v-model="editForm.is_active" :true-value="1" :false-value="0" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-slate-600">Active Account</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end space-x-3 mt-6">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm font-semibold text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">Cancel</button>
                        <button type="submit" :disabled="editForm.processing" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500/20 transition-all disabled:opacity-50">
                            {{ editForm.processing ? 'Updating...' : 'Update User' }}
                        </button>
                    </div>
                </form>
            </div>
        </Modal>

    </Master>
</template>
