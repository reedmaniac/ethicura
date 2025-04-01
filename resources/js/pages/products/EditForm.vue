<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
// import { Input } from '@/components/ui/input'
// import {
//   Select,
//   SelectContent,
//   SelectItem,
//   SelectTrigger,
//   SelectValue,
// } from '@/components/ui/select'
// import InputError from '@/components/InputError.vue';
// import { Label } from '@/components/ui/label'
// import { Textarea } from '@/components/ui/textarea'
import { CircleX, ScanBarcode } from 'lucide-vue-next';

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
    redirect: null,
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

</script>


<template>
    <form method="POST" action="" class="block w-full pb-20" @submit.prevent="submit">
        <div class="flex flex-row justify-between gap-8 pb-5">
            <div class="flex items-center ml-auto gap-2">
                <Button
                    v-if="product"
                    :product="product"
                    variant="destructive"
                    :disabled="form.processing"
                    :buttonClasses="{'opacity-50': form.processing}"
                >
                    <CircleX class="h-4 w-4" />
                    Delete
                </Button>
                <Button
                    type="submit"
                    variant="default"
                    :disabled="form.processing"
                    :buttonClasses="{'opacity-50': form.processing}"
                >
                    <ScanBarcode class="h-4 w-4" />
                    {{ product ? 'Update' : 'Save' }}
                </Button>
            </div>
        </div>
    </form>
</template>
