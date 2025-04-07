<script setup lang="ts">
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import StreamBarcodeReader from '@/components/StreamBarcodeReader.vue';

const emit = defineEmits(['confirmed']);

defineProps({
    button: {
        type: String,
        default: 'Confirm',
    },
});

const isModalOpen = ref(false);
const barcode = ref('');

const onDecode = (result) => {
    console.log(result);
    barcode.value = result;
};

const closeModal = () => {
    barcode.value = '';
    isModalOpen.value = false;
};

const saveCode = () => {
    emit('confirmed', barcode.value);
    closeModal();
};

</script>

<template>
    <Dialog v-on:update:open="modalOpen" v-model:open="isModalOpen">
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>

        <DialogContent>
            <DialogHeader>
                <DialogTitle>Scan Barcode from Package</DialogTitle>
                <DialogDescription>

                    <div class="bg-black h-30 w-30">
                        <StreamBarcodeReader @decode="onDecode" @loaded="onLoaded"></StreamBarcodeReader>
                    </div>

                    <div class="space-y-1 mt-2">
                        <Label for="scanned_barcode" class="text-base ">Detected Barcode</Label>
                        <Input id="scanned_barcode" v-model="barcode" />
                    </div>
                </DialogDescription>
            </DialogHeader>

            <DialogFooter>
                <Button type="button" variant="secondary" v-on:click="closeModal"> Cancel </Button>
                <Button class="ms-3" @click="saveCode">
                    Accept
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
