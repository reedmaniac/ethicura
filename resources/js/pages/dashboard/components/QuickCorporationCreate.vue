<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { useForm } from '@inertiajs/vue3';
import { BriefcaseBusiness } from 'lucide-vue-next';


const form = useForm({
    name: '',
    description: '',
    slug: '',
});

const submit = () => {
    form.post(route('dashboard.quick-corporation'), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Card>
        <CardHeader class="pb-3">
            <CardTitle>
                <div class="flex flex-row gap-x-2">
                    <BriefcaseBusiness />
                    Create New Corporation
                </div>
            </CardTitle>
            <CardDescription> Fill out initial fields and continue editing upon submit.</CardDescription>
        </CardHeader>
        <CardContent class="grid gap-6">
            <form class="space-y-4" @submit.prevent="submit">
                <div>
                    <Label for="quick_corporation_name">Name</Label>
                    <Input id="quick_corporation_name" type="text" placeholder="" v-model="form.name" required />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <Label for="quick_corporation_slug">URL Slug</Label>
                    <Input id="quick_corporation_slug" type="text" placeholder="" v-model="form.slug" required />
                    <InputError class="mt-2" :message="form.errors.slug" />
                </div>

                <div>
                    <Label for="quick_corporation_description">Description</Label>
                    <Textarea id="quick_corporation_description" placeholder="Tell us a little bit about the corporation" v-model="form.description" />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div class="flex justify-end gap-2">
                    <Button type="submit">Create</Button>
                </div>
            </form>
        </CardContent>
    </Card>
</template>
