<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

defineProps<{
    product: object;
    corporations: array;
}>();

</script>


<template>
    <div class="text-sm my-10">
        FORM - In Progress
    </div>
</template>
