<template>
    <footer class="shrink-0 bg-white border-t border-slate-200 py-4 px-6 text-center text-sm text-slate-500 mt-auto w-full">
        <div class="flex items-center justify-between mx-auto flex-col sm:flex-row gap-2 max-w-7xl">
            <div>
                &copy; {{ new Date().getFullYear() }} <span class="font-semibold text-slate-700">VueDash</span>. All rights reserved.
            </div>
            <div class="flex items-center gap-4 text-xs font-medium">
                <a href="#" class="hover:text-indigo-600 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">Terms of Service</a>
            </div>
        </div>
    </footer>
</template>
