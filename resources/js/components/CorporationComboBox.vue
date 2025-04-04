<script setup lang="ts">
import { cn } from '@/lib/utils';
import { Button } from '@/components/ui/button'
import { Combobox, ComboboxAnchor, ComboboxEmpty, ComboboxGroup, ComboboxInput, ComboboxItem, ComboboxItemIndicator, ComboboxList, ComboboxTrigger } from '@/components/ui/combobox'
import { Check, ChevronsUpDown, Search } from 'lucide-vue-next'
import { ref } from 'vue'
import { useVModel } from '@vueuse/core';
import type { Corporation } from '@/types';

interface Props {
    corporations: Corporation[];
    modelValue?: number;
}

const props = defineProps<Props>();

const value = ref<typeof corporations[0]>(props.modelValue ? props.corporations.find(d => d.id === props.modelValue) : null);

const emits = defineEmits<{
    (e: 'update:modelValue', payload: number): void;
}>();

function handleChange(newVal) {
  emits('update:modelValue', newVal.id);
}

</script>

<template>
  <Combobox v-model="value" by="name" v-on:update:modelValue="handleChange">
    <ComboboxAnchor as-child>
      <ComboboxTrigger as-child>
        <Button variant="outline" class="justify-between font-normal">
          {{ value?.name ?? 'Select corporation' }}
          <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
        </Button>
      </ComboboxTrigger>
    </ComboboxAnchor>

    <ComboboxList>
      <div class="relative w-full max-w-sm items-center">
        <ComboboxInput class="pl-9 focus-visible:ring-0 border-0 border-b rounded-none h-10" placeholder="Select corporation..." />
        <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
          <Search class="size-4 text-muted-foreground" />
        </span>
      </div>

      <ComboboxEmpty>
        No corporation found.
      </ComboboxEmpty>

      <ComboboxGroup>
        <ComboboxItem
          v-for="corporation in corporations"
          :key="corporation.id"
          :value="corporation"
        >
          {{ corporation.name }}

          <ComboboxItemIndicator>
            <Check :class="cn('ml-auto h-4 w-4')" />
          </ComboboxItemIndicator>
        </ComboboxItem>
      </ComboboxGroup>
    </ComboboxList>
  </Combobox>
</template>
