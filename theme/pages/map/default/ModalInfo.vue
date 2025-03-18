<script setup >
import axios from 'axios';
import { computedAsync } from '@vueuse/core'
const props = defineProps(['url'])
const content = computedAsync(
  async () => {
    if (!props.url) return null
    const { data } = await axios.get(props.url)
    return data
  },
  null
)


</script>
<template>
  <div class="modal fade" id="modalInfo" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content" v-html="content">

      </div>
    </div>
  </div>
</template>