<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { columns } from './components/columns';
import ProductDataTable from './components/ProductDataTable.vue';

defineProps<{
    products: object;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Products" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="hidden h-full flex-1 flex-col space-y-8 p-8 md:flex">
            <div class="flex items-center justify-between space-y-2">
                <h2 class="text-2xl font-bold tracking-tight">Products</h2>
            </div>
            <ProductDataTable :data="products" :columns="columns" />
        </div>
    </AppLayout>
</template>
