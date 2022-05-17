<template>
  <DefaultField
    :field="currentField"
    :errors="errors"
    :show-help-text="showHelpText"
  >
    <template #field>
      <div class="inline-flex mb-2 color-picker" @click="showPicker" ref="inputArea">
        <div
          class="color-button rounded-l-lg border-r-0 h-100 border border-60 color-input-value"
          v-bind:style="{ backgroundColor: hexValue, width: '36px' }"
        />

        <input
          :id="field.name"
          type="text"
          class="w-25 form-control form-input form-input-bordered color-input rounded-l-none"
          :class="errorClasses"
          :placeholder="placeholder"
          :value="displayValue"
          @blur="handleRawInput"
        />
      </div>

      <component
        v-if="shouldShowPicker"
        ref="pickerArea"
        :is="component"
        :id="field.name"
        :class="[errorClasses, { absolute: field.autoHidePicker && field.pickerType !== 'slider', 'z-10': true }]"
        :palette="palette"
        :value="hexValue"
        @input="handleChange"
      />

      <p v-if="hasError" class="my-2 text-danger">
        {{ firstError }}
      </p>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';
import { Chrome, Compact, Grayscale, Material, Photoshop, Sketch, Slider, Swatches, Twitter } from '@ckpack/vue-color';
import tinycolor from 'tinycolor2';

export default {
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

  mounted() {
    console.log(this);
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

      const saveAs = this.field.saveAs;
      const color = tinycolor(this.value);

      let value = null;
      if (saveAs === 'hex') value = color.toHexString();
      if (saveAs === 'hex8') value = color.toHex8String();
      if (saveAs === 'rgb' || saveAs === 'rgba') value = JSON.stringify(color.toRgb());
      if (saveAs === 'hsl') value = JSON.stringify(color.toHsl());

      formData.append(this.field.attribute, value);
    },

    handleChange(value) {
      if (!value) {
        this.value = void 0;
        return;
      }

      if (typeof value === 'string') {
        const color = tinycolor(value);
        if (color._format) this.value = color.toHex8String();
        return;
      }

      if (typeof value === 'object' && value.hex8) {
        this.value = value.hex8;
        return;
      }

      if (typeof value === 'object' && value._format) {
        this.value = value.toHex8String();
        return;
      }
    },

    handleRawInput(event) {
      const value = event.target.value;
      const color = tinycolor(value);
      if (color._format) this.handleChange(color);
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

    hidePicker() {
      document.removeEventListener('click', this.documentClick);
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

      const displayAs = this.field.displayAs;
      const color = tinycolor(this.value);
      if (displayAs === 'hex') return color.toHexString();
      if (displayAs === 'hex8') return color.toHex8String();
      if (displayAs === 'rgb' || displayAs === 'rgba') return color.toRgbString();
      if (displayAs === 'hsl') return color.toHslString();
      return color.toHexString();
    },
    hexValue() {
      if (!this.value) return '#ffffff';
      try {
        return tinycolor(this.value).toHexString();
      } catch (e) {
        return '#ffffff';
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.color-picker-field {
  .absolute {
    position: absolute !important;
  }

  .color-button {
    cursor: pointer;
  }
}
</style>
