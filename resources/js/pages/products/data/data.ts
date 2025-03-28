import { h } from 'vue'

import { CircleCheck, Circle } from 'lucide-vue-next';

export const statuses = [
  {
    value: 'draft',
    label: 'Draft',
    icon: h(Circle),
  },
  {
    value: 'published',
    label: 'Published',
    icon: h(CircleCheck),
  },
]
