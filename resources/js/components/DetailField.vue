<template>
  <PanelItem :index="index" :field="field">
    <template #value>
      <div class="nc-inline-flex nc-items-center">
        <div
          class="nc-rounded nc-mr-2"
          v-bind:style="{ backgroundColor: field.value, width: '20px', height: '20px' }"
        />
        <div>{{ field.value || '—' }}</div>
      </div>
    </template>
  </PanelItem>
</template>

<script>
export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
};
</script>
