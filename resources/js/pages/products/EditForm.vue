<script setup lang="ts">
import { emit, onBeforeUnmount, onMounted } from 'vue';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { router, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Label } from '@/components/ui/label';
import CorporationComboBox from '@/components/CorporationComboBox.vue';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Textarea } from '@/components/ui/textarea';
import { type FieldItem } from '@/types';
import { CircleX, Check, Search } from 'lucide-vue-next';
import SaveButton from './components/SaveButton.vue';
import { statuses } from './data/data';

const { product, cloned_product } = defineProps<{
    product?: object;
    corporations: array;
    cloned_product?: object;
}>();

const emit = defineEmits(['created', 'updated']);

let formParams = null;
const formStub = {
    name: '',
    description: '',
    corporation_id: null,
    certification_ids: [],
    packaging_ids: [],
    barcode: null,

    saturated_fat: null,
    trans_fat: null,
    cholesterol: null,
    dietary_fiber: null,
    sugars: null,
    added_sugars: null,
    sodium: null,
    vitamin_a: null,
    vitamin_c: null,
    vitamin_d: null,
    calcium: null,
    iron: null,
    potassium: null,
    glycemic_index: null,
    serving_size: null,
    servings_per_container: null,
    calories: null,
    protein: null,
    fat: null,
    carbohydrates: null,

    editors_note: '',
    status: 'draft',
    save_button_option: null,
};

if (product) {
    formParams = {
        ...product,
        editors_note: '',
    };
} else if (cloned_product) {
    formParams = {
        ...formStub,
        ...cloned_product,
        name: '',
        description: '',
        editors_note: '',
        barcode: null,
        status: 'draft',
    };
} else {
    formParams = formStub;
}

const form = useForm(formParams);

const beforeUnloadListener = (event) => {
    if (form.isDirty === true && (!event.detail || event.detail.visit.method === 'get')) {
        event.preventDefault();
        return confirm('Are you sure you want to navigate away? You may have unsaved changes.');
    }
};

router.on('before', (event) => {
    beforeUnloadListener(event);
});

onMounted(() => {
    window.addEventListener('beforeunload', beforeUnloadListener, { capture: true });
});

onBeforeUnmount(() => {
    window.removeEventListener('beforeunload', beforeUnloadListener, { capture: true });
});

const submit = () => {
    if (product) {
        form.put(route('dashboard.products.update', { product: product.id }), {
            onSuccess: () => {
                emit('updated');
            },
        });
    } else {
        form.post(route('dashboard.products.store'), {
            onSuccess: () => {
                emit('created');
            },
        });
    }
};

const savingActionChanged = (newVal) => {
    form.save_button_option = newVal;
};

const nutritionFields: FieldItem[] = [
    {
        name: 'serving_size',
        label: 'Serving Size (g)',
        type: 'number',
    },
    {
        name: 'servings_per_container',
        label: 'Servings Per Container',
        type: 'number',
    },
    {
        name: 'calories',
        label: 'Calories',
        type: 'number',
    },
    {
        name: 'protein',
        label: 'Protein (g)',
        type: 'number',
    },
    {
        name: 'fat',
        label: 'Fat (g)',
        type: 'number',
    },
    {
        name: 'saturated_fat',
        label: 'Saturated Fat (g)',
        type: 'number',
    },
    {
        name: 'trans_fat',
        label: 'Trans Fat (g)',
        type: 'number',
    },
    {
        name: 'cholesterol',
        label: 'Cholesterol (g)',
        type: 'number',
    },
    {
        name: 'carbohydrates',
        label: 'Carbohydrates (g)',
        type: 'number',
    },
    {
        name: 'dietary_fiber',
        label: 'Dietary Fiber (g)',
        type: 'number',
    },
    {
        name: 'sugars',
        label: 'Sugars (g)',
        type: 'number',
    },
    {
        name: 'added_sugars',
        label: 'Added Sugars (g)',
        type: 'number',
    },
    {
        name: 'sodium',
        label: 'Sodium (g)',
        type: 'number',
    },
    {
        name: 'vitamin_a',
        label: 'Vitamin A (g)',
        type: 'number',
    },
    {
        name: 'vitamin_c',
        label: 'Vitamin C (g)',
        type: 'number',
    },
    {
        name: 'vitamin_d',
        label: 'Vitamin D (g)',
        type: 'number',
    },
    {
        name: 'calcium',
        label: 'Calcium (g)',
        type: 'number',
    },
    {
        name: 'iron',
        label: 'Iron (g)',
        type: 'number',
    },
    {
        name: 'potassium',
        label: 'Potassium (g)',
        type: 'number',
    },
    {
        name: 'glycemic_index',
        label: 'Glycemic Index',
        type: 'select',
        options: [
            {
                name: null,
                label: 'None',
            },
            {
                name: 'low',
                label: 'Low (≤ 55)',
            },
            {
                name: 'medium',
                label: 'Medium (56–69)',
            },
            {
                name: 'high',
                label: 'High (≥ 70)',
            },
        ],
    },
];
</script>

<template>
    <form method="POST" action="" class="block w-full pb-20" @submit.prevent="submit">
        <div class="flex flex-row">
            <div class="ml-auto flex items-center gap-2">
                <Button v-if="product" variant="destructive" :disabled="form.processing" :class="{ 'opacity-50': form.processing, cursor: true }">
                    <CircleX class="h-4 w-4" />
                    Delete
                </Button>
                <SaveButton :disabled="form.processing" :class="{ 'opacity-50': form.processing }" v-on:changed="savingActionChanged" />
            </div>
        </div>

        <div class="" v-if="form.errors">
            {{ form.errors }}
        </div>

        <div class="w-full">
            <Tabs default-value="General">
                <TabsList class="w-full justify-start rounded-none border-b bg-transparent p-0">
                    <TabsTrigger
                        value="General"
                        class="relative h-9 rounded-none border-b-2 border-b-transparent bg-transparent px-4 pb-3 pt-2 text-base font-semibold text-muted-foreground shadow-none transition-none data-[state=active]:border-b-primary data-[state=active]:text-foreground data-[state=active]:shadow-none"
                    >
                        General
                    </TabsTrigger>
                    <TabsTrigger
                        value="Nutrition"
                        class="relative h-9 rounded-none border-b-2 border-b-transparent bg-transparent px-4 pb-3 pt-2 text-base font-semibold text-muted-foreground shadow-none transition-none data-[state=active]:border-b-primary data-[state=active]:text-foreground data-[state=active]:shadow-none"
                    >
                        Nutrition
                    </TabsTrigger>
                </TabsList>

                <div class="max-w-xl">
                    <TabsContent value="General">
                        <div class="flex flex-col gap-y-3">
                            <div class="space-y-1">
                                <Label for="name">Name</Label>
                                <Input id="name" v-model="form.name" required />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div class="space-y-1">
                                <Label for="description">Description</Label>
                                <Textarea id="description" v-model="form.description" rows="5" />
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <div class="space-y-1">
                                <Label for="corporation_id">Corporation</Label>
                                <CorporationComboBox
                                    :corporations="corporations"
                                    v-model="form.corporation_id"
                                />
                                <InputError class="mt-2" :message="form.errors.corporation_id" />
                            </div>

                            <div class="space-y-1">
                                <Label for="status">Status</Label>
                                <Select id="status" v-model="form.status">
                                    <SelectTrigger class="w-[180px]">
                                        <SelectValue placeholder="Select a status" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="status in statuses" :value="status.value" :key="status.value">
                                            {{ status.label }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                                <InputError class="mt-2" :message="form.errors.status" />
                            </div>
                        </div>
                    </TabsContent>

                    <TabsContent value="Nutrition">
                        <div class="flex flex-col gap-y-3">
                            <div class="space-y-1" v-for="field in nutritionFields" :key="field.name">
                                <Label for="field.name">{{ field.label }}</Label>

                                <Select v-if="field.type === 'select'" v-model="form[field.name]">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select an option" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="option in field.options" :value="option.name" :key="option.name">
                                            {{ option.label }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>

                                <Input v-else id="field.name" v-model="form[field.name]" :type="field.type" />

                                <InputError class="mt-2" :message="form.errors[field.name]" />
                            </div>
                        </div>
                    </TabsContent>
                </div>
            </Tabs>
        </div>
    </form>
</template>
