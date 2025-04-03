<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import ProductEditForm from './EditForm.vue';

defineProps<{
    product: object;
    corporations: array;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Products',
        href: '/products',
    },
];
</script>

<template>
    <Head title="Edit Product" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="hidden h-full flex-1 flex-col space-y-8 p-8 md:flex">
            <div class="flex items-center justify-between space-y-2">
                <h2 class="text-2xl font-bold tracking-tight">Editing: {{ product.name }}</h2>
            </div>

            <ProductEditForm :product="product" :corporations="corporations" />
        </div>
    </AppLayout>
</template>
