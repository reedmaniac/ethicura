<script setup lang="ts">
import { Combobox, ComboboxAnchor, ComboboxEmpty, ComboboxGroup, ComboboxInput, ComboboxItem, ComboboxList } from '@/components/ui/combobox'
import { TagsInput, TagsInputInput, TagsInputItem, TagsInputItemDelete, TagsInputItemText } from '@/components/ui/tags-input'
import { useFilter } from 'reka-ui'
import { computed, ref, useTemplateRef } from 'vue'

interface Props {
    options: object[];
    placeholder: string;
    modelValue?: number[];
}

const props = defineProps<Props>()
const { placeholder = 'Choose tags' } = props;

// Take incoming modelValue, which is array of ID numbers and find matching options
const tagsValue = ref<typeof options[0]>(props.modelValue ? props.options.filter(d => props.modelValue.includes(d.id)) : []);

const open = ref(false);
const searchTerm = ref('');
const tagInput = useTemplateRef('taginput', true);

const { contains } = useFilter({ sensitivity: 'base' })

const filteredOptions = computed(() => {
  // Remove already selected options
  const theOptions = props.options.filter(item1 =>
    !tagsValue.value.some(item2 => item2.id === item1.id)
  );

  // Filter by search term
  return searchTerm.value
    ? theOptions.filter(option => contains(option.name, searchTerm.value))
    : theOptions
})

const emits = defineEmits<{
    (e: 'update:modelValue', payload: number): void;
}>();

const handleChange = (newVals) => {
  const newIds = newVals.map(v => v.id);
  emits('update:modelValue', newIds);
}

// On initial focusin, open the dropdown of options
document.addEventListener('focusin', (e) => {
  if (tagInput.value?.$el?.id && tagInput.value.$el === e.target && open.value === false) {
    open.value = true;
  }
})

</script>

<template>
  <Combobox
    v-model="tagsValue"
    v-model:open="open"
    :ignore-filter="true"
  >
    <ComboboxAnchor as-child>
      <TagsInput
        v-model="tagsValue"
        v-on:update:modelValue="handleChange"
        class="px-2 gap-2 w-80"
      >
        <div class="flex gap-2 flex-wrap items-center">
          <TagsInputItem
            v-for="item in tagsValue"
            :key="item.id"
            :value="item.name"
          >
            <TagsInputItemText />
            <TagsInputItemDelete />
          </TagsInputItem>
        </div>

        <ComboboxInput v-model="searchTerm" as-child>
          <TagsInputInput
            ref="taginput"
            id="tag-input"
            :placeholder="placeholder"
            class="min-w-[200px] w-full p-0 border-none focus-visible:ring-0 h-auto"
          />
        </ComboboxInput>
      </TagsInput>

      <ComboboxList class="w-[--reka-popper-anchor-width]">
        <ComboboxEmpty />
        <ComboboxGroup>
          <ComboboxItem
            v-for="filteredOption in filteredOptions"
            :key="filteredOption.id"
            :value="filteredOption"
            @select.prevent="(ev) => {

              if (typeof ev.detail.value === 'object') {
                searchTerm = ''
                tagsValue.push(ev.detail.value) // This is the filteredOption
              }

              if (filteredOptions.length === 0) {
                open = false
              }
            }"
          >
            {{ filteredOption.name }}
          </ComboboxItem>
        </ComboboxGroup>
      </ComboboxList>
    </ComboboxAnchor>
  </Combobox>
</template>
