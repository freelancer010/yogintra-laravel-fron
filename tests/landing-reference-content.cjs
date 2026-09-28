const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const path = require('node:path');
const script = fs.readFileSync(path.join(__dirname, '../public/assets/landing-reference/app.js'), 'utf8');

function render(saved, initial, missing = false) {
  const faq = { innerHTML: initial, children: initial ? [{}] : [] };
  const services = { innerHTML: initial, children: initial ? [{}] : [] };
  const navigation = { addEventListener() {}, querySelectorAll: () => [] };
  const document = {
    querySelector(selector) {
      if (selector === 'main[data-saved-classic-canvas]') return saved ? {} : null;
      if (selector === '#faqs') return missing ? null : faq;
      if (selector === '#services') return missing ? null : services;
      return navigation;
    },
    querySelectorAll: () => [],
  };
  vm.runInNewContext(script, { document });
  return { faq: faq.innerHTML, services: services.innerHTML };
}

const defaults = render(false, '');
assert.match(defaults.faq, /Can I join yoga classes/);
assert.match(defaults.services, /Online yoga/);
for (const saved of [true, false]) {
  const edited = render(saved, '<p>My edited content</p>');
  assert.equal(edited.faq, '<p>My edited content</p>');
  assert.equal(edited.services, '<p>My edited content</p>');
}
assert.deepEqual(render(true, ''), { faq: '', services: '' });
assert.doesNotThrow(() => render(true, '', true));
console.log('PASS: defaults, edited content, empty saved sections, and removed sections');
