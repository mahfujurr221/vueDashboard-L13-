<template>
    <div class="overflow-x-auto rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 transition-colors">
        <table class="w-full text-sm text-left data-table">
            <thead class="text-xs text-slate-500 dark:text-slate-400 uppercase bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 font-bold transition-colors">
                <slot name="header" />
            </thead>
            <tbody>
                <slot />
            </tbody>
        </table>
    </div>
</template>

<style scoped>
:deep(th) {
    @apply px-3 py-2;
}
:deep(td) {
    @apply px-3 py-1.5 align-middle;
}
:deep(tr) {
    @apply border-b border-slate-50 dark:border-slate-800/50 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors;
}
:deep(tr:last-child) {
    @apply border-b-0;
}
</style>
