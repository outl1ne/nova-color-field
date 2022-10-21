<template>
  <PanelItem :index="index" :field="field">
    <template #value>
      <div class="o1-inline-flex o1-items-center">
        <div
          class="o1-bg-checkered o1-mr-2 o1-rounded o1-overflow-hidden"
          style="width: 22px; height: 22px"
          v-if="field.value"
        >
          <div class="o1-mr-2 o1-w-full o1-h-full" :style="{ backgroundColor: field.value }" />
        </div>
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
