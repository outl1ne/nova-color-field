<template>
  <default-field :field="field">
    <template slot="field">
      <div class="inline-flex mb-2">
        <div
          class="color-input rounded-l-lg border-r-0 h-100 border border-60 color-input-value"
          v-bind:style="{ backgroundColor: value, width: '36px' }"
        />

        <input
          :id="field.name"
          type="text"
          class="w-25 form-control form-input form-input-bordered color-input rounded-l-none"
          :class="errorClasses"
          :placeholder="placeholder"
          v-model="value"
        />
      </div>

      <component
        :is="component"
        :id="field.name"
        :class="errorClasses"
        :palette="palette"
        :value="value"
        @input="handleChange"
      />

      <p v-if="hasError" class="my-2 text-danger">
        {{ firstError }}
      </p>
    </template>
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';
import { Chrome, Compact, Grayscale, Material, Photoshop, Sketch, Slider, Swatches } from 'vue-color';

export default {
  mixins: [FormField, HandlesValidationErrors],

  components: {
    'chrome-picker': Chrome,
    'compact-picker': Compact,
    'grayscale-picker': Grayscale,
    'material-picker': Material,
    'photoshop-picker': Photoshop,
    'sketch-picker': Sketch,
    'slider-picker': Slider,
    'swatches-picker': Swatches,
  },

  props: ['resourceName', 'resourceId', 'field'],

  methods: {
    setInitialValue() {
      this.value = this.field.value || '';
    },
    fill(formData) {
      formData.append(this.field.attribute, this.value || '');
    },
    handleChange(value) {
      this.value = value.hex;
    },
  },

  computed: {
    component() {
      return this.field.pickerType + '-picker';
    },
    palette() {
      return this.field.palette || undefined;
    },
    placeholder() {
      if (this.field.extraAttributes === undefined) {
        return this.field.name;
      }
      return this.field.extraAttributes.placeholder || this.field.name;
    },
  },
};
</script>
