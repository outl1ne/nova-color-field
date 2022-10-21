<template>
  <div class="o1-inline-flex o1-items-center">
    <div class="o1-rounded o1-mr-2" :style="{ backgroundColor: field.value, width: '20px', height: '20px' }" />
    <div>{{ field.value }}</div>
  </div>
</template>

<script>
export default {
  props: ['resourceName', 'field'],
};
</script>
