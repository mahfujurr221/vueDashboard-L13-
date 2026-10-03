<script setup>
import { ref } from 'vue';
import Master from '@/Layouts/Master.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    setting: {
        type: Object,
        required: true
    }
});

const currentTab = ref('general');

const form = useForm({
    site_name: props.setting.site_name || '',
    site_title: props.setting.site_title || '',
    phone: props.setting.phone || '',
    email: props.setting.email || '',
    address: props.setting.address || '',
    logo: null,
    favicon: null,
    currency_symbol: props.setting.currency_symbol || '',
    currency_name: props.setting.currency_name || '',
    currency_code: props.setting.currency_code || '',
    currency_position: props.setting.currency_position || 'prefix',
    invoice_view_type: props.setting.invoice_view_type || 'both',
    pos_receipt_type: props.setting.pos_receipt_type || 'pos',
    purchase_receipt_type: props.setting.purchase_receipt_type || 'a5',
    payment_receipt_type: props.setting.payment_receipt_type || 'a4',
    low_stock_limit: props.setting.low_stock_limit || 10,
    dark_mode: props.setting.dark_mode == 1 ? true : false,
});

const logoPreview = ref(props.setting.logo ? '/storage/' + props.setting.logo : null);
const faviconPreview = ref(props.setting.favicon ? '/storage/' + props.setting.favicon : null);

const handleLogoChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.logo = file;
        logoPreview.value = URL.createObjectURL(file);
    }
};

const handleFaviconChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.favicon = file;
        faviconPreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    form.post(route('settings.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.logo = null;
            form.favicon = null;
        }
    });
};
</script>

<template>
    <Head title="System Settings" />

    <Master>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                System Settings
            </h2>
        </template>

        <div>
            <div>
                
                <form @submit.prevent="submit">
                    <!-- Header Area -->
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 leading-tight">Settings</h2>
                        </div>
                        <PrimaryButton type="submit" :disabled="form.processing">
                            <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                            Save Settings
                        </PrimaryButton>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Navigation Sidebar -->
                        <div class="w-full lg:w-1/4">
                            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-2 lg:p-3 sticky top-20 z-10 transition-colors">
                                <nav class="flex flex-row overflow-x-auto lg:flex-col gap-2 lg:gap-1.5 scrollbar-hide">
                                    <button @click="currentTab = 'general'" type="button" :class="[currentTab === 'general' ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-md shadow-indigo-200 dark:shadow-none' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50', 'flex items-center whitespace-nowrap shrink-0 px-4 py-2.5 text-xs font-bold rounded-full transition-all duration-200 uppercase tracking-wide']">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        General Info
                                    </button>
                                    
                                    <button @click="currentTab = 'branding'" type="button" :class="[currentTab === 'branding' ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-md shadow-indigo-200 dark:shadow-none' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50', 'flex items-center whitespace-nowrap shrink-0 px-4 py-2.5 text-xs font-bold rounded-full transition-all duration-200 uppercase tracking-wide']">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        Branding & Logos
                                    </button>
                                    
                                    <button @click="currentTab = 'pos'" type="button" :class="[currentTab === 'pos' ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-md shadow-indigo-200 dark:shadow-none' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50', 'flex items-center whitespace-nowrap shrink-0 px-4 py-2.5 text-xs font-bold rounded-full transition-all duration-200 uppercase tracking-wide']">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        POS & Currency
                                    </button>

                                    <button @click="currentTab = 'advanced'" type="button" :class="[currentTab === 'advanced' ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-md shadow-indigo-200 dark:shadow-none' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50', 'flex items-center whitespace-nowrap shrink-0 px-4 py-2.5 text-xs font-bold rounded-full transition-all duration-200 uppercase tracking-wide']">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                        Advanced Controls
                                    </button>
                                </nav>
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="w-full lg:w-3/4">
                            
                            <!-- General Info Section -->
                            <div v-show="currentTab === 'general'" class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-5 md:p-6 transition-colors">
                                <h4 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-4">Business Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Business Name</label>
                                        <TextInput type="text" v-model="form.site_name" required maxlength="100" />
                                        <InputError :message="form.errors.site_name" class="mt-2" />
                                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Displayed on receipts and browser title</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Site Slogan / Title</label>
                                        <TextInput type="text" v-model="form.site_title" maxlength="150" />
                                        <InputError :message="form.errors.site_title" class="mt-2" />
                                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Catchy phrase for your business</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Contact Phone</label>
                                        <TextInput type="tel" v-model="form.phone" @input="form.phone = form.phone.replace(/[^0-9]/g, '').slice(0, 15)" maxlength="15" />
                                        <InputError :message="form.errors.phone" class="mt-2" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Email Address</label>
                                        <TextInput type="email" v-model="form.email" maxlength="255" />
                                        <InputError :message="form.errors.email" class="mt-2" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Full Address</label>
                                        <textarea v-model="form.address" rows="3" maxlength="500" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-900 dark:text-slate-100 focus:bg-white dark:focus:bg-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all"></textarea>
                                        <InputError :message="form.errors.address" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Branding Section -->
                            <div v-show="currentTab === 'branding'" class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-5 md:p-6 transition-colors">
                                <h4 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-4">Branding Assets</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="bg-slate-50 dark:bg-slate-800/30 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-6 text-center">
                                        <h6 class="font-bold text-slate-800 dark:text-slate-200 mb-4">Main Business Logo</h6>
                                        <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-100 dark:border-slate-800 inline-block mb-4 shadow-sm min-h-[100px] min-w-[150px] flex items-center justify-center">
                                            <img v-if="logoPreview" :src="logoPreview" class="max-h-20 max-w-full object-contain">
                                            <span v-else class="text-slate-400 dark:text-slate-500 text-sm">No logo</span>
                                        </div>
                                        <input type="file" @change="handleLogoChange" accept="image/*" class="block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-500/10 file:text-indigo-700 dark:file:text-indigo-400 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-500/20 cursor-pointer">
                                        <InputError :message="form.errors.logo" class="mt-2" />
                                        <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">Recommended: PNG with transparent background</p>
                                    </div>
                                    
                                    <div class="bg-slate-50 dark:bg-slate-800/30 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-6 text-center">
                                        <h6 class="font-bold text-slate-800 dark:text-slate-200 mb-4">Site Favicon</h6>
                                        <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-100 dark:border-slate-800 inline-block mb-4 shadow-sm flex items-center justify-center">
                                            <img v-if="faviconPreview" :src="faviconPreview" class="h-12 w-12 object-contain">
                                            <span v-else class="text-slate-400 dark:text-slate-500 text-sm h-12 w-12 flex items-center justify-center">N/A</span>
                                        </div>
                                        <input type="file" @change="handleFaviconChange" accept="image/*" class="block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-500/10 file:text-indigo-700 dark:file:text-indigo-400 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-500/20 cursor-pointer">
                                        <InputError :message="form.errors.favicon" class="mt-2" />
                                        <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">Size: 32x32 or 64x64px</p>
                                    </div>
                                </div>
                            </div>

                            <!-- POS & Currency Section -->
                            <div v-show="currentTab === 'pos'" class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-5 md:p-6 transition-colors">
                                <h4 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-4">POS & Currency</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Currency Symbol</label>
                                        <TextInput type="text" v-model="form.currency_symbol" required maxlength="10" />
                                        <InputError :message="form.errors.currency_symbol" class="mt-2" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Currency Name</label>
                                        <TextInput type="text" v-model="form.currency_name" required maxlength="50" />
                                        <InputError :message="form.errors.currency_name" class="mt-2" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">ISO Code</label>
                                        <TextInput type="text" v-model="form.currency_code" required maxlength="3" @input="form.currency_code = form.currency_code.replace(/[^a-zA-Z]/g, '').toUpperCase().slice(0, 3)" placeholder="e.g. BDT" />
                                        <InputError :message="form.errors.currency_code" class="mt-2" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Position</label>
                                        <SelectInput v-model="form.currency_position">
                                            <option value="prefix">Prefix ($ 100)</option>
                                            <option value="suffix">Suffix (100 $)</option>
                                        </SelectInput>
                                        <InputError :message="form.errors.currency_position" class="mt-2" />
                                    </div>
                                </div>
                                
                                <div class="mb-5">
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Invoice Header Style</label>
                                    <SelectInput v-model="form.invoice_view_type">
                                        <option value="both">Logo & Text</option>
                                        <option value="logo_only">Logo Only</option>
                                        <option value="text_only">Text Only</option>
                                    </SelectInput>
                                    <InputError :message="form.errors.invoice_view_type" class="mt-2" />
                                </div>

                                <h5 class="text-base font-bold text-slate-800 dark:text-slate-100 border-t border-slate-100 dark:border-slate-800 pt-5 mb-4">Receipt Templates</h5>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">POS Sales Receipt</label>
                                        <SelectInput v-model="form.pos_receipt_type">
                                            <option value="pos">Thermal (80mm)</option>
                                            <option value="a4">Standard (A4)</option>
                                            <option value="a5">Standard (A5)</option>
                                        </SelectInput>
                                        <InputError :message="form.errors.pos_receipt_type" class="mt-2" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Purchase Orders</label>
                                        <SelectInput v-model="form.purchase_receipt_type">
                                            <option value="pos">Thermal (80mm)</option>
                                            <option value="a5">A5 Format</option>
                                        </SelectInput>
                                        <InputError :message="form.errors.purchase_receipt_type" class="mt-2" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Payment Vouchers</label>
                                        <SelectInput v-model="form.payment_receipt_type">
                                            <option value="pos">Thermal (80mm)</option>
                                            <option value="a4">Standard (A4)</option>
                                        </SelectInput>
                                        <InputError :message="form.errors.payment_receipt_type" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Advanced Controls Section -->
                            <div v-show="currentTab === 'advanced'" class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-5 md:p-6 transition-colors">
                                <h4 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-4">Advanced Controls</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-2xl">
                                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Low Stock Warning Threshold</label>
                                        <div class="flex">
                                            <span class="inline-flex items-center px-4 bg-white dark:bg-slate-900 border border-r-0 border-slate-200 dark:border-slate-700 rounded-l-xl text-yellow-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                            </span>
                                            <input type="number" v-model="form.low_stock_limit" min="0" max="100000" @input="form.low_stock_limit = Math.abs(parseInt(form.low_stock_limit)) || 0" class="w-full bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 border border-slate-200 dark:border-slate-700 rounded-r-xl px-4 py-2 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                                        </div>
                                        <InputError :message="form.errors.low_stock_limit" class="mt-2" />
                                        <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">Notify me when stock falls below this quantity</p>
                                    </div>
                                    
                                    <div class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-2xl flex justify-between items-center">
                                        <div>
                                            <h6 class="font-bold text-slate-800 dark:text-slate-200 mb-1">Dark Appearance</h6>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">Experimental UI theme</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" v-model="form.dark_mode" class="sr-only peer">
                                            <div class="w-14 h-7 bg-slate-300 dark:bg-slate-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-1 after:left-[4px] after:bg-white after:border-slate-300 dark:after:border-slate-500 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- Submit Button Area -->
                            <div class="sticky bottom-0 p-4 bg-white/95 dark:bg-slate-900/95 backdrop-blur-sm border-t border-slate-200 dark:border-slate-800 lg:static lg:p-0 lg:bg-transparent lg:border-none lg:mt-6 flex justify-end z-20 transition-colors">
                                <PrimaryButton type="submit" :disabled="form.processing" class="w-full justify-center lg:w-auto">
                                    <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                                    Save Settings
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </Master>
</template>
