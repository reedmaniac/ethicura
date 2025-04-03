<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, BriefcaseBusiness, FileSpreadsheet, Folder, FolderInput, House, Plus, ScanBarcode, Users } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: House,
    },
    {
        title: 'Products',
        href: '/dashboard/products',
        icon: ScanBarcode,
        actionMenu: {
            icon: Plus,
            title: 'Create Product',
            href: '/dashboard/products/create',
        },
    },
    {
        title: 'Categories',
        href: '/dashboard/categories',
        icon: FolderInput,
        actionMenu: {
            icon: Plus,
            title: 'Create Category',
            href: '/dashboard/categories/create',
        },
    },
    {
        title: 'Corporations',
        href: '/dashboard/corporations',
        icon: BriefcaseBusiness,
        actionMenu: {
            icon: Plus,
            title: 'Create Corporation',
            href: '/dashboard/corporations/create',
        },
    },
    {
        title: 'Exports',
        href: '/dashboard/exports',
        icon: FileSpreadsheet,
        actionMenu: {
            icon: Plus,
            title: 'Create Export',
            href: '/dashboard/exports/create',
        },
    },
    {
        title: 'Users',
        href: '/dashboard/users',
        icon: Users,
        actionMenu: {
            icon: Plus,
            title: 'Create User',
            href: '/dashboard/users/create',
        },
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Vue Start Kit',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Starter Kits',
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset" side="left">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard.index')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
