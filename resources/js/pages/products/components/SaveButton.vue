<template>
    <div class="align-center flex flex-row">
        <Button
            variation="secondary"
            type="submit"
            :disabled="disabled"
            id="save_option_menu"
            :aria-expanded="showMenu ? 'true' : 'false'"
            aria-haspopup="true"
            :class="cn(`min-w-[80px] rounded-l rounded-r-none`, props.class)"
        >
            <span class="inline">Save</span>
        </Button>

        <DropdownMenu>
            <DropdownMenuTrigger as-child>
                <Button
                    variation="secondary"
                    v-on:click.stop.prevent="showMenu = !showMenu"
                    :class="cn(`rounded-l-none rounded-r border-l border-l-accent dark:border-l-muted`, props.class)"
                >
                    <List v-if="action == 'listing'" />
                    <Repeat v-if="action == 'continue_editing'" />
                    <CirclePlus v-if="action == 'create_another'" />
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent class="w-56">
                <DropdownMenuLabel>After Saving</DropdownMenuLabel>
                <DropdownMenuItem :key="option_name" v-for="(display_name, option_name) in actionOptions" v-on:click="saveOptionUpdated(option_name)">
                    <Check class="h-4 w-4" v-if="option_name == action" />
                    <div class="h-4 w-4" v-else />
                    {{ display_name }}
                </DropdownMenuItem>
            </DropdownMenuContent>
        </DropdownMenu>
    </div>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { cn } from '@/lib/utils';
import { usePage } from '@inertiajs/vue3';
import { Check, CirclePlus, List, Repeat } from 'lucide-vue-next';
import type { HTMLAttributes } from 'vue';
import { ref } from 'vue';

const props = defineProps<{
    disabled?: boolean;
    class?: HTMLAttributes['class'];
}>();

const emit = defineEmits(['changed']);

const page = usePage();
const showMenu = ref(false);

const action = ref(page.props.product_save_button_option || 'listing');
const actionOptions = ref({
    listing: 'Go to Listing',
    continue_editing: 'Continue Editing',
    create_another: 'Create Another',
});

const saveOptionUpdated = (newValue) => {
    action.value = newValue;
    page.props.product_save_button_option = newValue;
    emit('changed', newValue);
};
</script>
