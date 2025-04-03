<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import type { Row } from '@tanstack/vue-table';
import { computed } from 'vue';
import type { Product } from '../data/schema';

import { Link } from '@inertiajs/vue3';
import { Ellipsis } from 'lucide-vue-next';
import { productSchema } from '../data/schema';

interface DataTableRowActionsProps {
    row: Row<Product>;
}
const props = defineProps<DataTableRowActionsProps>();

const product = computed(() => productSchema.parse(props.row.original));

const productEditLink = route('dashboard.products.edit', { product: product.value.id });
const productCloneLink = route('dashboard.products.create', { clone_id: product.value.id });

const deleteFlow = () => {
    alert('@todo');
};
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="flex h-8 w-8 p-0 data-[state=open]:bg-muted">
                <Ellipsis class="h-4 w-4" />
                <span class="sr-only">Open menu</span>
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end" class="w-[160px]">
            <DropdownMenuItem><Link :aria-label="`Edit ${product.name}`" :href="productEditLink">Edit</Link></DropdownMenuItem>
            <DropdownMenuItem><Link :aria-label="`Clone ${product.name}`" :href="productCloneLink">Make a copy</Link></DropdownMenuItem>
            <DropdownMenuItem v-on:click.prevent="deleteFlow"> Delete </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
