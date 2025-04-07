<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import QuickProductCreate from './components/QuickProductCreate.vue';
import QuickCorporationCreate from './components/QuickCorporationCreate.vue';


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
        <div class="grid items-start justify-center gap-6 rounded-lg p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div class=""><QuickProductCreate :corporations="corporations" class="bg-gray-50" /></div>
                <div class=""><QuickCorporationCreate class="bg-gray-50" /></div>
                <div class=""></div>
            </div>
        </div>
    </AppLayout>
</template>
