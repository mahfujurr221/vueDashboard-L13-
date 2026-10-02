<template>
    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-sm text-left text-slate-600">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200 font-semibold tracking-wider">
                <slot name="header" />
            </thead>
            <tbody class="divide-y divide-slate-100">
                <slot />
            </tbody>
        </table>
    </div>
</template>
