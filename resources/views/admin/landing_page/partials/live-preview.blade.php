<script>
(() => {
  const sections = document.getElementById('sections');
  const canvas = document.querySelector('.builder-canvas');
  const inspector = document.querySelector('.builder-inspector');
  if (!sections || !canvas || !inspector) return;

  const preview = document.createElement('div');
  preview.className = 'live-preview';
  preview.innerHTML = '<div class="live-preview-toolbar"><span><i class="preview-dot"></i>Live page preview</span><span>Desktop canvas</span></div><div class="live-preview-content"></div>';
  canvas.appendChild(preview);

  const layers = document.createElement('div');
  layers.className = 'section-layers';
  layers.innerHTML = '<div class="builder-inspector-title"><span>Page structure</span><span id="layer-count">0</span></div><div id="section-layers-list"></div>';
  inspector.appendChild(layers);

  const getValue = (card, suffix) => {
    const field = [...card.querySelectorAll('input, textarea, select')].find(item => item.name && item.name.endsWith('[' + suffix + ']'));
    return field ? field.value.trim() : '';
  };
  const escape = (value) => String(value || '').replace(/[&<>'"]/g, character => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;', "'":'&#039;', '"':'&quot;' })[character]);
  const plainText = (value) => { const element = document.createElement('div'); element.innerHTML = value || ''; return element.textContent || element.innerText || ''; };
  const focusCard = (card) => {
    document.querySelectorAll('.page-builder-section, .preview-section, .section-layer').forEach(element => element.classList.remove('is-selected'));
    card.classList.add('is-selected');
    document.querySelectorAll('[data-builder-id="' + card.dataset.builderId + '"]').forEach(element => element.classList.add('is-selected'));
    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
  };

  function render() {
    const cards = [...sections.querySelectorAll('.page-builder-section')];
    const content = preview.querySelector('.live-preview-content');
    const list = layers.querySelector('#section-layers-list');
    layers.querySelector('#layer-count').textContent = cards.length + ' sections';
    if (!cards.length) {
      content.innerHTML = '<div class="section-empty">Your page preview will appear here. Add a section to begin.</div>';
      list.innerHTML = '<div class="section-empty">No sections yet</div>';
      return;
    }
    content.innerHTML = '';
    list.innerHTML = '';
    cards.forEach((card, index) => {
      card.dataset.builderId ||= 'section-' + Date.now() + '-' + index;
      const type = getValue(card, 'section_type') || 'text';
      const heading = getValue(card, 'heading') || 'Section heading';
      const text = plainText(getValue(card, 'content')) || 'Add text to describe this section.';
      const button = getValue(card, 'button_text');
      const background = getValue(card, 'background_color') || '#ffffff';
      const position = getValue(card, 'image_position') || 'left';
      const imageInput = card.querySelector('input[type=file]');
      const existingImage = getValue(card, 'existing_image');
      const image = card.dataset.previewImage || (existingImage ? '/' + existingImage.replace(/^\//, '') : '');
      const previewSection = document.createElement('article');
      previewSection.className = 'preview-section';
      previewSection.dataset.builderId = card.dataset.builderId;
      previewSection.style.backgroundColor = background;
      const imageMarkup = image ? '<img class="preview-section-image" src="' + escape(image) + '" alt="">' : '<div class="preview-image-empty">Image area</div>';
      previewSection.innerHTML = '<div class="preview-section-row ' + (position === 'right' ? 'is-right' : '') + '">' + (type === 'image_text' ? imageMarkup : '') + '<div class="preview-section-copy"><small>' + escape(type.replace('_', ' + ')) + '</small><h3 contenteditable="true" data-preview-field="heading">' + escape(heading) + '</h3><p contenteditable="true" data-preview-field="content">' + escape(text) + '</p>' + (button ? '<span class="preview-cta">' + escape(button) + '</span>' : '') + '</div></div>';
      previewSection.addEventListener('click', () => focusCard(card));
      content.appendChild(previewSection);
      const layer = document.createElement('button');
      layer.type = 'button'; layer.className = 'section-layer'; layer.dataset.builderId = card.dataset.builderId;
      layer.innerHTML = '<span>☷ ' + escape(heading) + '</span><small>' + escape(type.replace('_', ' + ')) + '</small>';
      layer.addEventListener('click', () => focusCard(card));
      list.appendChild(layer);
      if (imageInput && imageInput.files && imageInput.files[0] && !card.dataset.previewImage) {
        const reader = new FileReader();
        reader.onload = event => { card.dataset.previewImage = event.target.result; render(); };
        reader.readAsDataURL(imageInput.files[0]);
      }
    });
  }

  sections.addEventListener('input', render);
  preview.querySelector('.live-preview-content').addEventListener('input', (event) => {
    const fieldName = event.target.dataset.previewField;
    if (!fieldName) return;
    const previewSection = event.target.closest('.preview-section');
    const card = [...sections.querySelectorAll('.page-builder-section')].find(item => item.dataset.builderId === previewSection.dataset.builderId);
    const field = card && [...card.querySelectorAll('input, textarea, select')].find(item => item.name && item.name.endsWith('[' + fieldName + ']'));
    if (field) field.value = event.target.innerText;
  });
  preview.querySelector('.live-preview-content').addEventListener('blur', (event) => {
    if (event.target.dataset.previewField) render();
  }, true);
  sections.addEventListener('change', (event) => {
    if (event.target.matches('input[type=file]')) {
      delete event.target.closest('.page-builder-section').dataset.previewImage;
    }
    render();
  });
  new MutationObserver(render).observe(sections, { childList: true, subtree: false });
  render();
})();
</script>
