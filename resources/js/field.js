import IndexField from './components/IndexField';
import DetailField from './components/DetailField';
import FormField from './components/FormField';

Nova.booting((Vue, router) => {
  Vue.component('index-color', IndexField);
  Vue.component('detail-color', DetailField);
  Vue.component('form-color', FormField);
});
