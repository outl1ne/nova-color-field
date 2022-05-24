<template>
  <DefaultField :field="currentField" :errors="errors" :show-help-text="showHelpText">
    <template #field>
      <div
        class="nc-inline-flex nc-mb-2 color-picker nc-overflow-hidden nc-rounded-lg form-input-bordered"
        ref="inputArea"
      >
        <div
          class="color-button border-r h-100 color-input-value"
          v-bind:style="{ backgroundColor: hexValue, width: '36px' }"
          @click="togglePicker"
        />

        <input
          :id="field.name"
          type="text"
          class="nc-w-25 nc-border-0 form-control form-input color-input nc-rounded-l-none"
          :class="errorClasses"
          :placeholder="placeholder"
          :value="displayValue"
          v-on:keydown.enter.prevent="handleEnter"
          @blur="handleRawInput"
          @click="showPicker"
        />
      </div>

      <component
        v-if="shouldShowPicker"
        ref="pickerArea"
        :is="component"
        :id="field.name"
        :class="['nc-picker', errorClasses, { absolute: field.autoHidePicker && field.pickerType !== 'slider', 'nc-z-10': true }]"
        :palette="palette"
        v-model="value"
      />

      <p v-if="hasError" class="nc-my-2 text-danger">
        {{ firstError }}
      </p>
    </template>
  </DefaultField>
</template>

<script>
import { DependentFormField, HandlesValidationErrors } from 'laravel-nova';
import { Chrome, Compact, Grayscale, Material, Photoshop, Sketch, Slider, Swatches, Twitter } from '@ckpack/vue-color';
import tinycolor from 'tinycolor2';

export default {
  name: 'NovaColorField',
  mixins: [HandlesValidationErrors, DependentFormField],

  components: {
    'chrome-picker': Chrome,
    'compact-picker': Compact,
    'grayscale-picker': Grayscale,
    'material-picker': Material,
    'photoshop-picker': Photoshop,
    'sketch-picker': Sketch,
    'slider-picker': Slider,
    'swatches-picker': Swatches,
    'twitter-picker': Twitter,
  },

  props: ['resourceName', 'resourceId', 'field'],

  data() {
    return {
      shouldShowPicker: !this.field.autoHidePicker,
    };
  },

  beforeDestroy() {
    if (this.shouldShowPicker) {
      document.removeEventListener('click', this.documentClick);
    }
  },

  methods: {
    setInitialValue() {
      this.value = this.field.value || '';
    },

    fill(formData) {
      if (!this.value) {
        formData.append(this.field.attribute, null);
        return;
      }
      formData.append(this.field.attribute, this.saveValue);
    },

    valueUpdated() {
      if (this.field) {
        this.emitFieldValueChange(this.field.attribute, this.saveValue);
      }
    },

    handleRawInput(event) {
      const value = event.target.value;
      const color = tinycolor(value);
      if (color._format) {
        this.value = color.toHex8String();
        this.valueUpdated();
      }
    },

    handleEnter(event) {
      event.target.blur(); 
      this.hidePicker()
    },

    documentClick(event) {
      const inputArea = this.$refs.inputArea;
      const pickerArea = this.$refs.pickerArea.$el;
      const target = event.target;

      if (target === inputArea || target === pickerArea) return;
      if (inputArea.contains(target) || pickerArea.contains(target)) return;
      this.hidePicker();
    },

    showPicker() {
      if (this.pickerType === 'none') return;
      if (this.field.autoHidePicker) {
        if (!this.shouldShowPicker) {
          document.addEventListener('click', this.documentClick);
        }
        this.shouldShowPicker = true;
      }
    },
    togglePicker() {
      if (this.shouldShowPicker) {
        this.hidePicker();
      } else {
        this.showPicker();
      }
    },
    hidePicker() {
      document.removeEventListener('click', this.documentClick);
      if (this.shouldShowPicker === true) this.valueUpdated();
      this.shouldShowPicker = false;
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
    displayValue() {
      if (!this.value) return '';
      const displayAs = this.field.displayAs ?? 'hex8';
      const value = typeof this.value === 'object' && this.value.hex8 ? this.value.hex8 : this.value;
      const color = tinycolor(value);
      return ['hex', 'hex8', 'rgb', 'hsl'].includes(displayAs) ? color.toString(displayAs) : color.toHex8String();
    },
    saveValue() {
      if (!this.value) return '';
      const saveAs = this.field.saveAs ?? 'hex8';
      const value = typeof this.value === 'object' && this.value.hex8 ? this.value.hex8 : this.value;
      const color = tinycolor(value);
      return ['hex', 'hex8', 'rgb', 'hsl'].includes(saveAs) ? color.toString(saveAs) : color.toHex8String();
    },
    hexValue() {
      if (!this.value) return '#ffffff';
      try {
        return tinycolor(this.saveValue).toHex8String();
      } catch (e) {
        return '#ffffff';
      }
    },
  },
};
</script>

<style scoped>
.color-picker .color-button {
  cursor: pointer;
}

.nc-picker.absolute {
  position: absolute !important;
}

.color-picker.form-input-bordered:focus-within {
  border-color: rgba(var(--colors-primary-300));
  outline: 2px solid transparent;
  outline-offset: 2px;
  --tw-ring-color: rgba(var(--colors-primary-100));
  --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
  --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color);
  box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
}
</style>
