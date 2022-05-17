import IndexField from './components/IndexField';
import DetailField from './components/DetailField';
import FormField from './components/FormField';

Nova.booting((Vue, router) => {
  Vue.component('index-color-field', IndexField.default);
  Vue.component('detail-color-field', DetailField.default);
  Vue.component('form-color-field', FormField.default);
});
