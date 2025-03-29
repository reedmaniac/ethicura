<script setup lang="ts">
import { cn } from '@/lib/utils'
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form'
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
import { Label } from '@/components/ui/label'

import { Separator } from '@/components/ui/separator'
import { Textarea } from '@/components/ui/textarea'
import { toast } from 'vue-sonner'
import { toTypedSchema } from '@vee-validate/zod'
import { FieldArray, useForm } from 'vee-validate'
import { h, ref } from 'vue'
import * as z from 'zod'

const basicProductFormSchema = toTypedSchema(z.object({
  name: z
    .string()
    .min(2, {
      message: 'Name must be at least 2 characters.',
    })
    .max(50, {
      message: 'Name must not be longer than 50 characters.',
    }),
  description: z
    .string()
    .max(1000, { message: 'Description must not be longer than 1000 characters.' })
    .min(4, { message: 'Description must be at least 2 characters.' }),
  corporation: z.optional(),
}))

const { handleSubmit, resetForm } = useForm({
  validationSchema: basicProductFormSchema,
})

const onSubmit = handleSubmit((values) => {
  toast({
    title: 'You submitted the following values:',
    description: h(
      'pre', { class: 'mt-2 w-[340px] rounded-md bg-slate-950 p-4' },
      h('code', { class: 'text-white' },
        JSON.stringify(values, null, 2
      )
    )),
  })
})
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

      <form class="space-y-8" @submit="onSubmit">
        <FormField v-slot="{ componentField }" name="name">
          <FormItem>
            <Label>Name</Label>
            <FormControl>
              <Input type="text" placeholder="" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>


        <FormField v-slot="{ componentField }" name="description">
          <FormItem>
            <FormLabel>Description</FormLabel>
            <FormControl>
              <Textarea placeholder="Tell us a little bit about the product" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="corporation">
          <FormItem>
            <FormLabel>Corporation</FormLabel>

            <Select v-bind="componentField">
              <FormControl>
                <SelectTrigger>
                  <SelectValue placeholder="Select a corporation" />
                </SelectTrigger>
              </FormControl>
              <SelectContent>
                <SelectGroup>
                  <SelectItem value="1">
                    Evil
                  </SelectItem>
                  <SelectItem value="2">
                    Really Evil
                  </SelectItem>
                  <SelectItem value="3">
                    Super Evil
                  </SelectItem>
                </SelectGroup>
              </SelectContent>
            </Select>
            <FormMessage />
          </FormItem>
        </FormField>

        <div class="flex gap-2 justify-end">
          <Button
            type="button"
            variant="ghost"
            @click="resetForm"
          >
            Reset form
          </Button>
          <Button type="submit">
            Submit
          </Button>
        </div>
      </form>

    </CardContent>
  </Card>
</template>
