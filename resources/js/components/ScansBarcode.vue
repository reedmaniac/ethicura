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
} from '@/components/ui/dialog'
import { BrowserMultiFormatReader } from '@zxing/browser'

const emit = defineEmits(['confirmed']);

defineProps({
    button: {
        type: String,
        default: 'Confirm',
    },
});

const barcode = ref('');

const modalOpen = () => {
    const codeReader = new BrowserMultiFormatReader()
    codeReader.decodeFromVideoDevice(null, 'barcode-scan-video-id', (result, error) => {
      if (result) {
        console.log(result);
        barcode.value = result.getText();
      }
    })
};


const closeModal = () => {
    barcode.value = '';
    modalOpen.value = false;
};
</script>

<template>
    <Dialog v-on:update:open="modalOpen">
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>

        <DialogContent>
            <DialogHeader>
                <DialogTitle>Scan Barcode from Package</DialogTitle>
                <DialogDescription>

                    <div class="bg-black">
                        <video id="barcode-scan-video-id" class="h-30 w-30" />
                    </div>

                    <div class="space-y-1">
                        <Label for="name">Barcode</Label>
                        <Input id="name" v-model="barcode" />
                    </div>
                </DialogDescription>
            </DialogHeader>

            <DialogFooter>
                <DialogClose>
                    <Button type="button" variant="secondary"> Cancel </Button>
                </DialogClose>

                <Button class="ms-3" @click="saveCode">
                    Confirm
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
