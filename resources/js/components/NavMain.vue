<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem, SidebarMenuAction } from '@/components/ui/sidebar';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuPortal,
  DropdownMenuSeparator,
  DropdownMenuShortcut,
  DropdownMenuSub,
  DropdownMenuSubContent,
  DropdownMenuSubTrigger,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';

defineProps<{
    items: NavItem[];
}>();

const page = usePage<SharedData>();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton as-child :is-active="item.href === page.url">
                    <Link :href="item.href">
                        <component :is="item.icon" />
                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
                <SidebarMenuAction as="a" v-if="item.actionMenu" :href="item.actionMenu.href" :title="item.actionMenu.title">
                  <component :is="item.actionMenu.icon" /><span class="sr-only">{{ item.actionMenu.title }}</span>
                </SidebarMenuAction>
                <DropdownMenu v-else-if="item.dropdownMenus && item.dropdownMenus.length > 0">
                    <DropdownMenuTrigger asChild>
                        <SidebarMenuAction>
                            <MoreHorizontal />
                        </SidebarMenuAction>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent side="right" align="start">
                        <DropdownMenuItem v-for="dropdownMenuItem in item.dropdownMenus" :key="dropdownMenuItem.title">
                            <span>{{ dropdownMenuItem.title }}</span>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
