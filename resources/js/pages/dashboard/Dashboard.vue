<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import QuickProductCreate from './components/QuickProductCreate.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const { corporations } = defineProps({
    corporations: {
        type: Array,
    },
});

</script>

<template>
    <Head title="Admin Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="p-4 items-start justify-center gap-6 rounded-lg md:grids-col-2 grid md:gap-4 lg:grid-cols-10 xl:grid-cols-11 xl:gap-4"
        >
            <div class="space-y-4 lg:col-span-4 xl:col-span-6 xl:space-y-4">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                    <div class="space-y-4">
                        <QuickProductCreate :corporations="corporations" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
