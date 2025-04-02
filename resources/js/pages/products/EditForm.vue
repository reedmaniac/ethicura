<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import InputError from '@/components/InputError.vue';
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import { CircleX } from 'lucide-vue-next';
import SaveButton from './components/SaveButton.vue';
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from '@/components/ui/tabs'

const {product} = defineProps<{
    product?: object;
    corporations: array;
    cloned_bulletin?: object;
}>();

defineEmits(['created', 'updated']);

let formParams = null;
const formStub = {
    name: '',
    description: '',
    corporation_id: null,
    certification_ids: [],
    packaging_ids: [],
    editors_note: '',
    status: 'draft',
    save_button_option: null,
};

if (product) {
    formParams = {
        ...product,
        editors_note: '',
    }
} else if (cloned_bulletin) {
    formParams = {
        ...formStub,
        name: '',
        description: '',
        editors_note: '',
        status: 'draft',
    }
} else {
    formParams = formStub;
}

const form = useForm(formParams);

router.on('before', (event) => {
    if (form.form.isDirty === true) {
        event.preventDefault();
        return confirm('Are you sure you want to navigate away? You may have unsaved changes.')
    }
})


const submit = () => {
    if (product) {
        form.post(route('product.store'), {
            onSuccess: () => {
                emit('updated');
            },
        });
    } else {
        form.post(route('product.store'), {
            onSuccess: () => {
                emit('created');
            },
        });
    }
};

const savingActionChanged = (newVal) => {
    form.save_button_option = newVal;
};

</script>


<template>
    <form method="POST" action="" class="block w-full pb-20" @submit.prevent="submit">
        <div class="flex flex-row">
            <div class="flex items-center ml-auto gap-2">
                <Button
                    v-if="product"
                    :product="product"
                    variant="destructive"
                    :disabled="form.processing"
                    :classes="{'opacity-50': form.processing}"
                >
                    <CircleX class="h-4 w-4" />
                    Delete
                </Button>
                <SaveButton
                    :disabled="form.processing"
                    :classes="{'opacity-50': form.processing}"
                    v-on:changed="savingActionChanged"
                />
            </div>
        </div>

        <div class="w-full mt-[-1.8em]">
            <Tabs default-value="General">
                <TabsList class="w-full justify-start rounded-none border-b bg-transparent p-0">
                  <TabsTrigger value="General" class="text-base relative h-9 rounded-none border-b-2 border-b-transparent bg-transparent px-4 pb-3 pt-2 font-semibold text-muted-foreground shadow-none transition-none data-[state=active]:border-b-primary data-[state=active]:text-foreground data-[state=active]:shadow-none">
                    General
                  </TabsTrigger>
                  <TabsTrigger value="Nutrition" class="text-base relative h-9 rounded-none border-b-2 border-b-transparent bg-transparent px-4 pb-3 pt-2 font-semibold text-muted-foreground shadow-none transition-none data-[state=active]:border-b-primary data-[state=active]:text-foreground data-[state=active]:shadow-none">
                    Nutrition
                  </TabsTrigger>
                </TabsList>

                <div class="max-w-xl">
                    <TabsContent value="General">
                        <div class="flex flex-col gap-y-3">
                            <div class="space-y-1">
                                <Label for="name">Name</Label>
                                <Input id="name" default-value="Pedro Duarte" />
                            </div>
                            <div class="space-y-1">
                                <Label for="description">Description</Label>
                                <Textarea id="description" rows="5" />
                            </div>
                        </div>
                    </TabsContent>

                    <TabsContent value="Nutrition">
                        <div class="flex flex-col gap-y-3">
                            <div class="space-y-1">
                                <Label for="saturated_fat">Saturated Fat (g)</Label>
                                <Input id="saturated_fat" type="number" />
                            </div>
                            <div class="space-y-1">
                                <Label for="trans_fat">Trans Fat (g)</Label>
                                <Input id="trans_fat" type="number" />
                            </div>
                        </div>
                    </TabsContent>
                </div>
              </Tabs>
        </div>
    </form>
</template>
