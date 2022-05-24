Nova.booting((Vue, router) => {
  Vue.component('index-color-field', require('./components/IndexField').default);
  Vue.component('detail-color-field', require('./components/DetailField').default);
  Vue.component('form-color-field', require('./components/FormField').default);
});
