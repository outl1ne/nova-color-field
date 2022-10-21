const handleDarkMode = () => {
  const cls = document.documentElement.classList;
  const isDarkMode = cls.contains('dark');

  if (isDarkMode && !cls.contains('o1-dark')) {
    cls.add('o1-dark');
  } else if (!isDarkMode && cls.contains('o1-dark')) {
    cls.remove('o1-dark');
  }
};

Nova.booting((Vue, store) => {
  handleDarkMode();
  new MutationObserver(handleDarkMode).observe(document.documentElement, {
    attributes: true,
    attributeOldValue: true,
    attributeFilter: ['class'],
  });

  Vue.component('index-color-field', require('./components/IndexField').default);
  Vue.component('detail-color-field', require('./components/DetailField').default);
  Vue.component('form-color-field', require('./components/FormField').default);
});
