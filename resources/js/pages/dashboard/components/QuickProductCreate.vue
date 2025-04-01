<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import InputError from '@/components/InputError.vue';
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'

const { corporations } = defineProps({
    corporations: {
        type: Array,
        default: [],
        required: true,
    },
});

const form = useForm({
    name: 'My First Product',
    description: '',
    corporation_id: 7,
    status: 'draft',
});

const submit = () => {
  form.post(route('dashboard.quick-product'), {
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <Card>
    <CardHeader>
      <CardTitle>Create New Product</CardTitle>
      <CardDescription>
        Fill out initial fields and continue editing upon submit.
      </CardDescription>
    </CardHeader>
    <CardContent class="grid gap-6">

      <form class="space-y-4" @submit.prevent="submit">
        <div>
          <Label for="quick_product_name">Name</Label>
          <Input id="quick_product_name" type="text" placeholder="" v-model="form.name" required />
          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div>
          <Label for="quick_product_description">Description</Label>
          <Textarea
            id="quick_product_description"
            placeholder="Tell us a little bit about the product"
            v-model="form.description" />
          <InputError class="mt-2" :message="form.errors.description" />
        </div>

        <div>
          <Label>Corporation</Label>

          <Select v-model="form.corporation_id" required>
            <SelectTrigger>
              <SelectValue placeholder="Select a corporation" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem v-for="corporation in corporations" :value="corporation.id">
                {{ corporation.name }}
              </SelectItem>
            </SelectContent>
          </Select>
          <InputError class="mt-2" :message="form.errors.corporation_id" />
        </div>

        <div class="flex gap-2 justify-end">
          <Button type="submit">
            Submit
          </Button>
        </div>
      </form>

    </CardContent>
  </Card>
</template>
