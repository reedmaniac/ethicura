<script setup lang="ts">
import { ref, reactive, nextTick } from 'vue';
import InputError from './InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import axios from 'axios';

import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'

const emit = defineEmits(['confirmed']);

defineProps({
    title: {
        type: String,
        default: 'Confirm Password',
    },
    content: {
        type: String,
        default: 'For your security, please confirm your password to continue.',
    },
    button: {
        type: String,
        default: 'Confirm',
    },
});

const modalOpen = ref(false);
const confirmingPassword = ref(false);

const form = reactive({
    password: '',
    error: '',
    processing: false,
});

const startConfirmingPassword = () => {
    modalOpen.value = false;

    axios.get(route('password.confirmation')).then(response => {
        if (response.data.confirmed) {
            emit('confirmed');
        } else {
            modalOpen.value = true;
            confirmingPassword.value = true;

            setTimeout(() => document.getElementById('password_input').focus(), 250);
        }
    });
};

const confirmPassword = () => {
    form.processing = true;

    axios.post(route('password.confirm'), {
        password: form.password,
    }).then(() => {
        form.processing = false;

        closeModal();
        nextTick().then(() => emit('confirmed'));

    }).catch(error => {
        form.processing = false;
        form.error = error.response.data.errors.password[0];
        document.getElementById('password_input').focus();
    });
};

const closeModal = () => {
    confirmingPassword.value = false;
    form.password = '';
    form.error = '';
    modalOpen.value = false;
};

</script>


<template>
  <Dialog v-model:open="modalOpen">
    <DialogTrigger @click="startConfirmingPassword">
      <slot />
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>{{ title }}</DialogTitle>
        <DialogDescription>
            {{ content }}

            <div class="mt-4">
                <Input
                    id="password_input"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Password"
                    autocomplete="current-password"
                    @keyup.enter="confirmPassword"
                />

                <InputError :message="form.error" class="mt-2" />
            </div>
        </DialogDescription>
      </DialogHeader>

      <DialogFooter>
        <DialogClose>
          <Button type="button" variant="secondary">
            Cancel
          </Button>
        </DialogClose>

        <Button
            class="ms-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="confirmPassword"
        >
            {{ button }}
        </Button>
      </DialogFooter>
    </DialogContent>

  </Dialog>
</template>
