<script>
(() => {
  const sections = document.getElementById('sections');
  const canvas = document.querySelector('.builder-canvas');
  const inspector = document.querySelector('.builder-inspector');
  if (!sections || !canvas || !inspector) return;
  // Settings are kept in a modal; Laravel remains the source of validation so a
  // hidden browser-required field can never block the Publish action.
  document.getElementById('landing-page-form').noValidate = true;

  // Form cards remain the persistence layer; visual controls below are the editor UI.
  const panelColumn = sections.closest('.col-md-12');
  panelColumn.style.display = 'none';

  const preview = document.createElement('div');
  preview.className = 'live-preview';
  preview.innerHTML = '<div class="live-preview-toolbar"><span><i class="preview-dot"></i><span class="builder-save-state">Saved</span></span><span class="builder-device-controls"><button type="button" data-device="desktop" class="is-active">Desktop</button><button type="button" data-device="tablet">Tablet</button><button type="button" data-device="mobile">Mobile</button></span></div><div class="live-preview-content"></div>';
  canvas.appendChild(preview);
  const saveState = preview.querySelector('.builder-save-state');
  const setSaveState = value => { saveState.textContent = value; saveState.parentElement.classList.toggle('is-dirty', value !== 'Saved'); };
  preview.querySelectorAll('[data-device]').forEach(control => control.addEventListener('click', () => {
    preview.dataset.device = control.dataset.device;
    preview.querySelectorAll('[data-device]').forEach(button => button.classList.toggle('is-active', button === control));
  }));
  const elementToolbar = document.createElement('div');
  elementToolbar.className = 'builder-element-toolbar';
  elementToolbar.innerHTML = '<button type="button" data-toolbar-action="edit">Edit</button><button type="button" data-toolbar-action="link">Link</button><button type="button" data-toolbar-action="align">Align</button><button type="button" data-toolbar-action="duplicate">Duplicate</button>';
  document.body.appendChild(elementToolbar);

  const addBar = document.createElement('div');
  addBar.className = 'canvas-add-bar';
  addBar.innerHTML = '<button type="button" class="add-section-primary">＋ Add section</button>';
  canvas.appendChild(addBar);
  const picker = document.createElement('div');
  picker.className = 'template-picker';
  picker.innerHTML = '<div class="template-picker-backdrop"></div><div class="template-picker-dialog" role="dialog" aria-modal="true"><button type="button" class="template-picker-close" aria-label="Close">×</button><h3>Add a section</h3><p>Choose a ready-to-edit starting layout.</p><div class="template-picker-grid"><button data-template="text"><b>¶</b><strong>Text</strong><small>Heading and description</small></button><button data-template="custom_columns"><b>▥</b><strong>Empty section</strong><small>Build a 1-, 2-, or 3-column layout</small></button><button data-template="image_text"><b>▣</b><strong>Image + text</strong><small>Two-column story</small></button><button data-template="feature_grid"><b>▦</b><strong>Cards / features</strong><small>Repeatable benefit cards</small></button><button data-template="testimonial"><b>★</b><strong>Testimonials</strong><small>Use existing client reviews</small></button><button data-template="faq"><b>?</b><strong>Homepage FAQ</strong><small>Common questions and answers</small></button><button data-template="image"><b>▤</b><strong>Full image</strong><small>Image or visual break</small></button><button data-template="cta"><b>↗</b><strong>Button / CTA</strong><small>Prompt people to act</small></button></div></div>';
  document.body.appendChild(picker);
  const openPicker = () => picker.classList.add('is-open');
  const closePicker = () => picker.classList.remove('is-open');
  addBar.querySelector('.add-section-primary').addEventListener('click', openPicker);
  picker.addEventListener('click', event => {
    if (event.target.classList.contains('template-picker-backdrop') || event.target.closest('.template-picker-close')) { closePicker(); return; }
    const template = event.target.closest('[data-template]');
    if (!template) return;
    const type = template.dataset.template;
    const sourceType = ['image', 'feature_grid', 'custom_columns', 'testimonial', 'faq'].includes(type) ? 'image_text' : type;
    document.querySelector('.add-section[data-section-type="' + sourceType + '"]')?.click();
    setTimeout(() => {
      const card = [...sections.querySelectorAll('.page-builder-section')].at(-1);
      const field = card?.querySelector('select[name$="[section_type]"]');
      if (field && ['image', 'feature_grid', 'custom_columns', 'testimonial', 'faq'].includes(type)) {
        if (!field.querySelector('option[value="' + type + '"]')) field.add(new Option(({ image: 'Image / Hero', feature_grid: 'Feature grid', custom_columns: 'Empty columns', testimonial: 'Testimonials', faq: 'Homepage FAQ' })[type], type));
        field.value = type;
        if (type === 'image') ensureField(card, 'image_size', '100').value = '100';
        if (type === 'feature_grid') {
          const blocks = ensureField(card, 'blocks', '');
          blocks.value = JSON.stringify([{ icon: '✚', title: 'Traditional Healing', text: '' }, { icon: '♨', title: 'Improve Health', text: '' }, { icon: '☯', title: 'Holistic Wellness', text: '' }]);
          ensureField(card, 'grid_columns', '3').value = '3';
        }
        if (type === 'custom_columns') {
          ensureField(card, 'heading', '').value = '';
          ensureField(card, 'content', '').value = '';
          ensureField(card, 'blocks', '[]').value = JSON.stringify([{ type: 'text', title: '', text: '' }, { type: 'text', title: '', text: '' }, { type: 'text', title: '', text: '' }]);
          ensureField(card, 'grid_columns', '1').value = '1';
        }
        if (type === 'testimonial') {
          ensureField(card, 'heading', 'What our clients say').value = 'What our clients say';
          ensureField(card, 'content', 'Real feedback from YogIntra students and practitioners.').value = 'Real feedback from YogIntra students and practitioners.';
          ensureField(card, 'text_align', 'center').value = 'center';
        }
        if (type === 'faq') {
          ensureField(card, 'heading', 'Frequently asked questions').value = 'Frequently asked questions';
          ensureField(card, 'content', 'Answers to common questions about YogIntra services and programmes.').value = 'Answers to common questions about YogIntra services and programmes.';
          ensureField(card, 'blocks', '[]').value = JSON.stringify([{ title: 'What is YogIntra?', text: 'YogIntra is a wellness platform offering yoga classes, holistic programmes and community events.' }, { title: 'What services does YogIntra provide?', text: 'We offer group, online, home-visit and private yoga classes, meditation, breathwork and corporate wellness programmes.' }, { title: 'Do YogIntra trainers offer personalised programmes?', text: 'Yes. Trainers can tailor sessions around flexibility, strength, stress-reduction and mindfulness goals.' }, { title: 'How can I contact YogIntra?', text: 'Contact us using the website enquiry form, email, phone or social media.' }]);
          ensureField(card, 'text_align', 'left').value = 'left';
        }
        field.dispatchEvent(new Event('change', { bubbles: true }));
      }
      if (card) { render(); focusCard(card); }
    }, 0);
    closePicker();
  });

  const stylePanel = document.createElement('div');
  stylePanel.className = 'visual-style-panel';
  stylePanel.innerHTML = '<div class="builder-inspector-title"><span>Design</span><span>◐</span></div><div class="section-empty">Select a section on the canvas</div>';
  inspector.appendChild(stylePanel);

  const layers = document.createElement('div');
  layers.className = 'section-layers';
  layers.innerHTML = '<div class="builder-inspector-title"><span>Page structure</span><span id="layer-count">0</span></div><div id="section-layers-list"></div>';
  inspector.appendChild(layers);

  const linkPopup = document.createElement('form');
  linkPopup.className = 'builder-link-popup';
  linkPopup.innerHTML = '<label>Link URL<input type="url" name="url" placeholder="https://example.com or /contact" required></label><label class="builder-link-new-tab"><input type="checkbox" name="new_tab"> Open in new tab</label><button type="submit">Add link</button><button type="button" class="builder-link-cancel">Cancel</button>';
  document.body.appendChild(linkPopup);
  const linkActions = document.createElement('div');
  linkActions.className = 'builder-link-actions';
  linkActions.innerHTML = '<button type="button" title="Remove hyperlink">↗ <span>Remove link</span></button>';
  document.body.appendChild(linkActions);
  let selectedLinkRange = null;
  let selectionHighlight = null;
  let activePreviewLink = null;
  let linkActionsTimer = null;
  const showSelectedLinkRange = range => {
    if (!window.Highlight || !window.CSS?.highlights) return;
    selectionHighlight = new window.Highlight(range);
    window.CSS.highlights.set('builder-link-selection', selectionHighlight);
  };
  const clearSelectedLinkRange = () => {
    if (window.CSS?.highlights) window.CSS.highlights.delete('builder-link-selection');
    selectionHighlight = null;
  };
  const saveEditableMarkup = editable => {
    const previewSection = editable?.closest('.preview-section');
    const card = previewSection && [...sections.querySelectorAll('.page-builder-section')].find(item => item.dataset.builderId === previewSection.dataset.builderId);
    if (!card || !editable) return;
    if (editable.dataset.previewField) { const field = getField(card, editable.dataset.previewField); if (field) field.value = editable.innerHTML; }
    if (editable.dataset.previewColumn !== undefined) { const blocksField = getField(card, 'blocks'); let blocks = []; try { blocks = JSON.parse(blocksField.value || '[]'); } catch (_) {} if (blocks[Number(editable.dataset.previewColumn)]) { blocks[Number(editable.dataset.previewColumn)][editable.dataset.previewColumnKey] = editable.innerHTML; blocksField.value = JSON.stringify(blocks); } }
    if (editable.dataset.previewExtra !== undefined) { const elementsField = getField(card, 'elements'); let elements = []; try { elements = JSON.parse(elementsField.value || '[]'); } catch (_) {} if (elements[Number(editable.dataset.previewExtra)]) { elements[Number(editable.dataset.previewExtra)].text = editable.innerHTML; elementsField.value = JSON.stringify(elements); } }
  };
  const hideLinkActions = () => { linkActions.classList.remove('is-open'); activePreviewLink = null; };
  const showLinkActions = anchor => {
    if (!anchor?.closest('.live-preview-content [contenteditable]')) return;
    window.clearTimeout(linkActionsTimer);
    activePreviewLink = anchor;
    const rect = anchor.getBoundingClientRect();
    linkActions.style.left = Math.min(window.innerWidth - 150, Math.max(8, rect.left)) + 'px';
    linkActions.style.top = Math.max(8, rect.top - 38) + 'px';
    linkActions.classList.add('is-open');
  };

  const getValue = (card, suffix) => {
    const field = [...card.querySelectorAll('input, textarea, select')].find(item => item.name && item.name.endsWith('[' + suffix + ']'));
    return field ? field.value.trim() : '';
  };
  const getField = (card, suffix) => [...card.querySelectorAll('input, textarea, select')].find(item => item.name && item.name.endsWith('[' + suffix + ']'));
  const normalizeSectionIndexes = () => {
    [...sections.querySelectorAll('.page-builder-section')].forEach((sectionCard, index) => {
      sectionCard.querySelectorAll('[name^="sections["]').forEach(field => {
        field.name = field.name.replace(/^sections\[\d+\]/, 'sections[' + index + ']');
      });
    });
  };
  const history = []; let historyIndex = -1; let restoringHistory = false; let historyTimer = null;
  const snapshot = () => {
    if (restoringHistory) return;
    const markup = sections.innerHTML;
    if (history[historyIndex] === markup) return;
    history.splice(historyIndex + 1); history.push(markup);
    if (history.length > 40) history.shift();
    historyIndex = history.length - 1;
  };
  const restoreHistory = nextIndex => {
    if (nextIndex < 0 || nextIndex >= history.length) return;
    restoringHistory = true; sections.innerHTML = history[nextIndex]; historyIndex = nextIndex; normalizeSectionIndexes(); render(); restoringHistory = false; setSaveState('Unsaved changes');
  };
  const queueSnapshot = () => { window.clearTimeout(historyTimer); historyTimer = window.setTimeout(snapshot, 350); setSaveState('Unsaved changes'); };
  const ensureField = (card, suffix, value) => {
    let field = getField(card, suffix);
    if (!field) { field = document.createElement('input'); field.type = 'hidden'; const source = getField(card, 'heading') || getField(card, 'section_type'); field.name = source.name.replace(/\[[^\]]+\]$/, '[' + suffix + ']'); field.value = value; card.appendChild(field); }
    return field;
  };
  const elementStyles = (card) => {
    const field = ensureField(card, 'element_styles', '{}');
    let styles = {}; try { styles = JSON.parse(field.value || '{}'); } catch (_) {}
    styles.heading ||= {}; styles.content ||= {};
    ['heading', 'content'].forEach(key => { ['padding_x', 'padding_y', 'margin_x', 'margin_y'].forEach(property => styles[key][property] ??= 0); styles[key].font_weight ??= key === 'heading' ? 'bold' : 'normal'; styles[key].font_style ??= 'normal'; styles[key].text_decoration ??= 'none'; });
    return { field, styles };
  };
  const escape = (value) => String(value || '').replace(/[&<>'"]/g, character => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;', "'":'&#039;', '"':'&quot;' })[character]);
  const richPreview = value => {
    const holder = document.createElement('div'); holder.innerHTML = value || '';
    holder.querySelectorAll('*').forEach(node => {
      if (node.tagName === 'A') { const href = node.getAttribute('href') || ''; if (!/^(https?:\/\/|\/|#|mailto:|tel:)/i.test(href)) node.removeAttribute('href'); node.removeAttribute('style'); }
      else if (node.tagName !== 'BR') node.replaceWith(...node.childNodes);
    });
    return holder.innerHTML;
  };
  const plainText = (value) => { const element = document.createElement('div'); element.innerHTML = value || ''; return element.textContent || element.innerText || ''; };
  const listItems = element => String(element.items || '').split(/\r?\n/).map(item => item.trim()).filter(Boolean);
  const previewExtraElement = (element, index, textColor, headingSize, descriptionColor, descriptionSize) => {
    const color = escape(element.color || (element.type === 'heading' ? textColor : descriptionColor));
    const size = escape(element.size || (element.type === 'heading' ? headingSize : descriptionSize));
    const spacing = 'padding:' + escape(element.padding || 0) + 'px;margin:' + escape(element.margin || 0) + 'px';
    if (element.type === 'bullet_list' || element.type === 'numbered_list') {
      const tag = element.type === 'numbered_list' ? 'ol' : 'ul';
      const items = listItems(element);
      return '<' + tag + ' class="preview-builder-list" data-preview-extra-list="' + index + '" style="color:' + color + ';font-size:' + size + 'px;' + spacing + ';--list-item-gap:' + escape(element.item_gap ?? 8) + 'px">' + (items.length ? items.map(item => '<li>' + escape(item) + '</li>').join('') : '<li>Add list items in the editor</li>') + '</' + tag + '>';
    }
    return element.type === 'heading'
      ? '<h3 contenteditable="true" data-preview-extra="' + index + '" style="color:' + color + ';font-size:' + size + 'px;' + spacing + '">' + escape(element.text) + '</h3>'
      : '<p contenteditable="true" data-preview-extra="' + index + '" style="color:' + color + ';font-size:' + size + 'px;' + spacing + '">' + escape(element.text) + '</p>';
  };
  const focusCard = (card, target = 'section') => {
    document.querySelectorAll('.page-builder-section, .preview-section, .section-layer, .section-tree-child, .preview-image-frame, .preview-section [data-preview-field], .preview-section [data-preview-column-target]').forEach(element => element.classList.remove('is-selected', 'is-selected-target'));
    card.classList.add('is-selected');
    card.dataset.selectedTarget = target;
    document.querySelectorAll('[data-builder-id="' + card.dataset.builderId + '"]').forEach(element => element.classList.add('is-selected'));
    const previewSection = document.querySelector('.preview-section[data-builder-id="' + card.dataset.builderId + '"]');
    const tree = document.querySelector('.section-tree[data-builder-id="' + card.dataset.builderId + '"]');
    if (target === 'image') previewSection?.querySelector('.preview-image-frame')?.classList.add('is-selected-target');
    if (target !== 'section' && target !== 'image') {
      const previewTarget = previewSection?.querySelector('[data-preview-column-target="' + target + '"], [data-preview-field="' + target + '"]');
      previewTarget?.classList.add('is-selected-target');
    }
    const treeTarget = tree?.querySelector('[data-tree-target="' + target + '"]');
    (treeTarget || tree?.querySelector('.section-layer'))?.classList.add('is-selected');
    inspector.scrollTo({ top: 0, behavior: 'smooth' });
    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    renderStyles(card, target);
    const selected = previewSection?.querySelector('[data-preview-column-target="' + target + '"], [data-preview-field="' + target + '"], .preview-image-frame.is-selected-target') || previewSection;
    if (selected) { const rect = selected.getBoundingClientRect(); elementToolbar.style.left = Math.max(8, rect.left) + 'px'; elementToolbar.style.top = Math.max(8, rect.top - 38) + 'px'; elementToolbar.dataset.builderId = card.dataset.builderId; elementToolbar.dataset.target = target; elementToolbar.classList.add('is-open'); }
  };
  elementToolbar.addEventListener('click', event => {
    const action = event.target.dataset.toolbarAction; if (!action) return;
    const card = [...sections.querySelectorAll('.page-builder-section')].find(item => item.dataset.builderId === elementToolbar.dataset.builderId); if (!card) return;
    const target = elementToolbar.dataset.target || 'section';
    if (action === 'edit') { document.querySelector('.preview-section[data-builder-id="' + card.dataset.builderId + '"] [data-preview-field="' + target + '"], .preview-section[data-builder-id="' + card.dataset.builderId + '"] [data-preview-column-target="' + target + '"]')?.focus(); return; }
    if (action === 'link') { if (selectedLinkRange) { linkPopup.classList.add('is-open'); linkPopup.elements.url.focus(); } else { alert('Select the text you want to link first, then choose Link.'); } return; }
    if (action === 'align') {
      const columnTarget = /^column-(\d+)-(title|text|small_text|bullets)$/.exec(target);
      if (columnTarget) {
        const blocksField = getField(card, 'blocks'); let blocks = []; try { blocks = JSON.parse(blocksField.value || '[]'); } catch (_) {}
        const block = blocks[Number(columnTarget[1])] || {}; block.styles ||= {}; block.styles[columnTarget[2]] ||= {};
        const current = block.styles[columnTarget[2]].align || getValue(card, 'text_align') || 'left';
        block.styles[columnTarget[2]].align = current === 'left' ? 'center' : current === 'center' ? 'right' : 'left';
        blocks[Number(columnTarget[1])] = block; blocksField.value = JSON.stringify(blocks);
      } else { const field = ensureField(card, 'text_align', 'left'); field.value = field.value === 'left' ? 'center' : field.value === 'center' ? 'right' : 'left'; }
      render(); queueSnapshot(); return;
    }
    if (action === 'duplicate') { const copy = card.cloneNode(true); copy.dataset.builderId = ''; sections.insertBefore(copy, card.nextSibling); normalizeSectionIndexes(); render(); queueSnapshot(); return; }
  });

  function renderStyles(card, target = card.dataset.selectedTarget || 'section') {
    const type = getValue(card, 'section_type');
    const background = ensureField(card, 'background_color', '#ffffff');
    const textColor = ensureField(card, 'text_color', '#183c45');
    const headingSize = ensureField(card, 'heading_size', '32');
    const descriptionColor = ensureField(card, 'description_color', '#647b82');
    const descriptionSize = ensureField(card, 'description_size', '16');
    const textAlign = ensureField(card, 'text_align', 'left');
    const blocksField = ensureField(card, 'blocks', '');
    const elementsField = ensureField(card, 'elements', '');
    const gridColumns = ensureField(card, 'grid_columns', '3');
    const cardLayout = ensureField(card, 'card_layout', 'stacked');
    const cardAlignment = ensureField(card, 'card_alignment', 'center');
    const gridGap = ensureField(card, 'grid_gap', '24');
    const imageSize = ensureField(card, 'image_size', type === 'image' ? '100' : '42');
    const elementData = elementStyles(card);
    const paddingX = ensureField(card, 'padding_x', '0');
    const padding = ensureField(card, 'padding_y', '48');
    const marginX = ensureField(card, 'margin_x', '0');
    const margin = ensureField(card, 'margin_y', '0');
    const imageControl = type === 'image_text' ? '<label>Image placement</label><select data-style="image_position"><option value="left" ' + (getValue(card, 'image_position') !== 'right' ? 'selected' : '') + '>Image left / text right</option><option value="right" ' + (getValue(card, 'image_position') === 'right' ? 'selected' : '') + '>Image right / text left</option></select>' : '';
    let blocks = []; try { blocks = JSON.parse(blocksField.value || '[]'); } catch (_) {};
    let extraElements = []; try { extraElements = JSON.parse(elementsField.value || '[]'); } catch (_) {};
    let blockPreviews = {}; try { blockPreviews = JSON.parse(card.dataset.blockPreviews || '{}'); } catch (_) {};
    blocks.forEach((block, index) => { if (blockPreviews[index]) block.previewImage = blockPreviews[index]; });
    const columnTarget = type === 'custom_columns' && /^column-(\d+)-(title|text|small_text|bullets|image|button|container)$/.exec(target);
    if (columnTarget) {
      const columnIndex = Number(columnTarget[1]);
      const elementKey = columnTarget[2];
      const block = blocks[columnIndex] || {};
      if (elementKey === 'container') {
        const spacing = (label, key, value) => '<label>' + label + ' <span>' + value + 'px</span></label><div class="builder-range-number"><input data-column-container="' + key + '" type="range" min="0" max="160" value="' + value + '"><input data-column-container="' + key + '" type="number" min="0" max="160" value="' + value + '"></div>';
        stylePanel.innerHTML = '<div class="builder-inspector-title"><span>Column layout</span><span>◐</span></div><button type="button" class="back-to-column">← Back to section</button><label>Vertical alignment</label><select data-column-container="vertical_align"><option value="start" ' + ((block.vertical_align || 'start') === 'start' ? 'selected' : '') + '>Top</option><option value="center" ' + (block.vertical_align === 'center' ? 'selected' : '') + '>Center</option><option value="end" ' + (block.vertical_align === 'end' ? 'selected' : '') + '>Bottom</option></select><div class="column-spacing-controls"><strong>Column spacing</strong>' + spacing('Padding horizontal', 'padding_x', Number(block.padding_x || 0)) + spacing('Padding vertical', 'padding_y', Number(block.padding_y || 0)) + spacing('Margin horizontal', 'margin_x', Number(block.margin_x || 0)) + spacing('Margin vertical', 'margin_y', Number(block.margin_y || 0)) + '</div>';
        stylePanel.querySelectorAll('[data-column-container]').forEach(control => { const update = () => { block[control.dataset.columnContainer] = control.dataset.columnContainer === 'vertical_align' ? control.value : Number(control.value); const paired = control.closest('.builder-range-number')?.querySelector('input[type="' + (control.type === 'range' ? 'number' : 'range') + '"]'); if (paired) paired.value = control.value; const label = control.closest('.builder-range-number')?.previousElementSibling?.querySelector('span'); if (label) label.textContent = control.value + 'px'; blocks[columnIndex] = block; blocksField.value = JSON.stringify(blocks); render(); }; control.addEventListener('input', update); control.addEventListener('change', update); });
        stylePanel.querySelector('.back-to-column')?.addEventListener('click', () => focusCard(card, 'section'));
        return;
      }
      block.styles ||= {}; block.styles[elementKey] ||= {};
      const style = block.styles[elementKey];
      const isImage = elementKey === 'image'; const isButton = elementKey === 'button';
      const label = ({ title:'Heading', text:'Paragraph', small_text:'Supporting text', bullets:'Bullet list', image:'Image', button:'Button' })[elementKey];
      style.color ??= elementKey === 'title' ? textColor.value : descriptionColor.value;
      style.size ??= elementKey === 'title' ? 24 : 16;
      style.padding ??= 0; style.margin ??= 0; style.align ??= textAlign.value;
      blocks[columnIndex] = block; blocksField.value = JSON.stringify(blocks);
      stylePanel.innerHTML = '<div class="builder-inspector-title"><span>' + label + ' design</span><span>◐</span></div><button type="button" class="back-to-column">← Back to section</button>' + (isButton ? '<label>Button label</label><input data-column-button="button_text" value="' + escape(block.button_text || '') + '"><label>Button URL</label><input data-column-button="button_url" value="' + escape(block.button_url || '') + '" placeholder="/contact or https://..."><small>Both label and URL are required for the live button.</small>' : (isImage ? '<label>Image width <span>' + escape(block.image_size ?? 100) + '%</span></label><input data-column-image-width type="range" min="20" max="100" value="' + escape(block.image_size ?? 100) + '">' : '<label>Text alignment</label><select data-column-style="align"><option value="left" ' + (style.align === 'left' ? 'selected' : '') + '>Left</option><option value="center" ' + (style.align === 'center' ? 'selected' : '') + '>Center</option><option value="right" ' + (style.align === 'right' ? 'selected' : '') + '>Right</option></select><label>Colour</label><input data-column-style="color" type="color" value="' + escape(style.color) + '"><label>Font size <span>' + escape(style.size) + 'px</span></label><input data-column-style="size" type="range" min="12" max="56" value="' + escape(style.size) + '">')) + '<label>Padding <span>' + escape(style.padding) + 'px</span></label><input data-column-style="padding" type="range" min="0" max="100" value="' + escape(style.padding) + '"><label>Margin <span>' + escape(style.margin) + 'px</span></label><input data-column-style="margin" type="range" min="0" max="100" value="' + escape(style.margin) + '">';
      const updateColumnStyle = control => { if (control.dataset.columnImageWidth !== undefined) block.image_size = Number(control.value); else block.styles[elementKey][control.dataset.columnStyle] = control.dataset.columnStyle === 'align' || control.dataset.columnStyle === 'color' ? control.value : Number(control.value); blocksField.value = JSON.stringify(blocks); control.previousElementSibling?.querySelector('span') && (control.previousElementSibling.querySelector('span').textContent = control.value + (control.dataset.columnImageWidth !== undefined ? '%' : 'px')); render(); };
      stylePanel.querySelectorAll('[data-column-style], [data-column-image-width]').forEach(control => { control.addEventListener('input', () => updateColumnStyle(control)); control.addEventListener('change', () => updateColumnStyle(control)); });
      stylePanel.querySelectorAll('[data-column-button]').forEach(control => control.addEventListener('input', () => { block[control.dataset.columnButton] = control.value; blocks[columnIndex] = block; blocksField.value = JSON.stringify(blocks); render(); }));
      stylePanel.querySelector('.back-to-column')?.addEventListener('click', () => focusCard(card, 'section'));
      return;
    }
    if (type === 'feature_grid' && !blocks.length) { blocks = [{ icon: '✚', title: 'Traditional Healing', text: '' }, { icon: '♨', title: 'Improve Health', text: '' }, { icon: '☯', title: 'Holistic Wellness', text: '' }]; blocksField.value = JSON.stringify(blocks); }
    const blockControls = type === 'feature_grid' ? '<div class="block-editor"><label>Feature layout</label><select data-style="grid_columns"><option value="2" ' + (gridColumns.value === '2' ? 'selected' : '') + '>2 columns</option><option value="3" ' + (gridColumns.value === '3' ? 'selected' : '') + '>3 columns</option><option value="4" ' + (gridColumns.value === '4' ? 'selected' : '') + '>4 columns</option></select><label>Card style</label><select data-style="card_layout"><option value="stacked" ' + (cardLayout.value === 'stacked' ? 'selected' : '') + '>Centered (icon above)</option><option value="icon_left" ' + (cardLayout.value === 'icon_left' ? 'selected' : '') + '>Icon left</option></select><label>Card alignment</label><select data-style="card_alignment"><option value="left" ' + (cardAlignment.value === 'left' ? 'selected' : '') + '>Left</option><option value="center" ' + (cardAlignment.value === 'center' ? 'selected' : '') + '>Center</option><option value="right" ' + (cardAlignment.value === 'right' ? 'selected' : '') + '>Right</option></select><label>Card gap <span>' + gridGap.value + 'px</span></label><input data-style="grid_gap" type="range" min="0" max="100" value="' + gridGap.value + '"><label>Feature cards</label>' + blocks.map((block, index) => '<div class="feature-block-control"><div class="feature-block-image">' + (block.previewImage || block.image ? '<img src="' + escape(block.previewImage || ('/' + String(block.image).replace(/^\//, ''))) + '" alt="">' : '<b>' + escape(block.icon || '✦') + '</b>') + '<button type="button" data-block-image="' + index + '">' + (block.image ? 'Replace image' : 'Add image') + '</button></div><input data-block="' + index + '" data-block-key="icon" value="' + escape(block.icon || '') + '" maxlength="4" aria-label="Icon"><input data-block="' + index + '" data-block-key="title" value="' + escape(block.title || '') + '" aria-label="Title"><textarea data-block="' + index + '" data-block-key="text" aria-label="Description">' + escape(block.text || '') + '</textarea><button type="button" data-remove-block="' + index + '">Remove</button></div>').join('') + '<button type="button" class="add-feature-block">+ Add card</button></div>' : '';
    if (type === 'custom_columns' && !blocks.length) { blocks = [{ type: 'text', title: '', text: '' }, { type: 'text', title: '', text: '' }, { type: 'text', title: '', text: '' }]; blocksField.value = JSON.stringify(blocks); }
    const columnControls = type === 'custom_columns' ? '<div class="block-editor"><label>Section division</label><select data-column-count><option value="1" ' + (gridColumns.value === '1' ? 'selected' : '') + '>1 column — 100% width</option><option value="2" ' + (gridColumns.value === '2' ? 'selected' : '') + '>2 columns — 50% each</option><option value="3" ' + (gridColumns.value === '3' ? 'selected' : '') + '>3 columns — 33.33% each</option></select><small>Choose what each visible column should contain.</small>' + blocks.slice(0, Number(gridColumns.value || 1)).map((block, index) => '<div class="feature-block-control column-control"><label>Column ' + (index + 1) + '</label><select data-block="' + index + '" data-block-key="type"><option value="text" ' + ((block.type || 'text') === 'text' ? 'selected' : '') + '>Text</option><option value="image" ' + (block.type === 'image' ? 'selected' : '') + '>Image</option><option value="button" ' + (block.type === 'button' ? 'selected' : '') + '>Button / CTA</option></select>' + ((block.type || 'text') === 'image' ? '<div class="feature-block-image">' + (block.previewImage || block.image ? '<img src="' + escape(block.previewImage || ('/' + String(block.image).replace(/^\//, ''))) + '" alt="">' : '<b>▧</b>') + '<button type="button" data-block-image="' + index + '">' + (block.image ? 'Replace image' : 'Add image') + '</button></div><label>Image width <span>' + escape(block.image_size ?? 100) + '%</span></label><input data-block="' + index + '" data-block-key="image_size" type="range" min="20" max="100" value="' + escape(block.image_size ?? 100) + '">' : ((block.type || 'text') === 'button' ? '<input data-block="' + index + '" data-block-key="button_text" value="' + escape(block.button_text || '') + '" placeholder="Button label"><input data-block="' + index + '" data-block-key="button_url" value="' + escape(block.button_url || '') + '" placeholder="https://...">' : '<input data-block="' + index + '" data-block-key="title" value="' + escape(block.title || '') + '" placeholder="Heading"><textarea data-block="' + index + '" data-block-key="text" placeholder="Text">' + escape(block.text || '') + '</textarea>')) + '</div>').join('') + '</div>' : '';
    const extraElementControls = !['image', 'testimonial', 'faq', 'custom_columns'].includes(type) ? '<div class="block-editor"><label>Extra section elements</label>' + extraElements.map((element, index) => {
      const isList = element.type === 'bullet_list' || element.type === 'numbered_list';
      const defaultColor = element.type === 'heading' ? textColor.value : descriptionColor.value;
      const defaultSize = element.type === 'heading' ? headingSize.value : descriptionSize.value;
      return '<div class="feature-block-control extra-element-control"><select data-extra="' + index + '" data-extra-key="type"><option value="heading" ' + (element.type === 'heading' ? 'selected' : '') + '>Heading</option><option value="subheading" ' + (element.type === 'subheading' ? 'selected' : '') + '>Sub heading</option><option value="bullet_list" ' + (element.type === 'bullet_list' ? 'selected' : '') + '>• Bulleted list</option><option value="numbered_list" ' + (element.type === 'numbered_list' ? 'selected' : '') + '>1. Numbered list</option></select>' + (isList ? '<label>List items <small>One item per line</small></label><textarea data-extra="' + index + '" data-extra-key="items" rows="4" placeholder="First item&#10;Second item">' + escape(element.items || '') + '</textarea><label>Item gap <span>' + escape(element.item_gap ?? 8) + 'px</span></label><input data-extra="' + index + '" data-extra-key="item_gap" type="range" min="0" max="48" value="' + escape(element.item_gap ?? 8) + '">' : '<input data-extra="' + index + '" data-extra-key="text" value="' + escape(element.text || '') + '">') + '<label>Colour</label><input data-extra="' + index + '" data-extra-key="color" type="color" value="' + escape(element.color || defaultColor) + '"><label>Font size <span>' + escape(element.size || defaultSize) + 'px</span></label><input data-extra="' + index + '" data-extra-key="size" type="range" min="12" max="56" value="' + escape(element.size || defaultSize) + '"><label>Element padding</label><input data-extra="' + index + '" data-extra-key="padding" type="range" min="0" max="100" value="' + escape(element.padding || 0) + '"><label>Element margin</label><input data-extra="' + index + '" data-extra-key="margin" type="range" min="0" max="100" value="' + escape(element.margin || 0) + '"><button type="button" data-remove-extra="' + index + '">Remove</button></div>';
    }).join('') + '<div class="extra-element-actions"><button type="button" class="add-extra-heading">+ Add heading</button><button type="button" class="add-extra-subheading">+ Add sub heading</button><button type="button" class="add-extra-bullet-list">+ Bulleted list</button><button type="button" class="add-extra-numbered-list">+ Numbered list</button></div></div>' : '';
    const targetLabel = target === 'section' ? 'Section' : (target === 'image' ? 'Image' : (target === 'heading' ? 'Heading text' : 'Subtext'));
    const backgroundImage = getValue(card, 'existing_background_image');
    const backgroundMode = ensureField(card, 'background_mode', backgroundImage ? 'image' : 'color');
    const backgroundPosition = ensureField(card, 'background_position', 'center');
    const backgroundParallax = ensureField(card, 'background_parallax', '0');
    const overlayColor = ensureField(card, 'background_overlay_color', '#000000');
    const overlayOpacity = ensureField(card, 'background_overlay_opacity', '0');
    const backgroundControls = '<div class="section-background-media"><div class="background-mode-toggle"><button type="button" data-background-mode="color" class="' + (backgroundMode.value === 'color' ? 'is-active' : '') + '">Colour</button><button type="button" data-background-mode="image" class="' + (backgroundMode.value === 'image' ? 'is-active' : '') + '">Image</button></div><div class="background-image-options ' + (backgroundMode.value === 'image' ? '' : 'is-hidden') + '"><label>Background image</label><input data-background-image type="file" accept="image/*"><small>' + (backgroundImage ? 'Current image selected' : 'Upload an image for this section') + '</small><label>Image position</label><select data-style="background_position"><option value="left" ' + (backgroundPosition.value === 'left' ? 'selected' : '') + '>Left</option><option value="center" ' + (backgroundPosition.value === 'center' ? 'selected' : '') + '>Center</option><option value="right" ' + (backgroundPosition.value === 'right' ? 'selected' : '') + '>Right</option><option value="top" ' + (backgroundPosition.value === 'top' ? 'selected' : '') + '>Top</option><option value="bottom" ' + (backgroundPosition.value === 'bottom' ? 'selected' : '') + '>Bottom</option></select><label>Overlay colour</label><input data-style="background_overlay_color" type="color" value="' + overlayColor.value + '"><label>Overlay opacity <span>' + overlayOpacity.value + '%</span></label><input data-style="background_overlay_opacity" type="range" min="0" max="90" value="' + overlayOpacity.value + '"><label class="builder-switch"><input data-style="background_parallax" type="checkbox" value="1" ' + (backgroundParallax.value === '1' ? 'checked' : '') + '><span class="builder-switch-track"></span><span>Desktop parallax</span></label><small>Moves the background at a different speed while visitors scroll. Disabled on mobile.</small></div></div>';
    const elementControls = target === 'section' ? '<label>Background</label><input data-style="background_color" type="color" value="' + background.value + '"><label>Padding horizontal <span>' + paddingX.value + 'px</span></label><input data-style="padding_x" type="range" min="0" max="160" value="' + paddingX.value + '"><label>Padding vertical <span>' + padding.value + 'px</span></label><input data-style="padding_y" type="range" min="0" max="160" value="' + padding.value + '"><label>Margin horizontal <span>' + marginX.value + 'px</span></label><input data-style="margin_x" type="range" min="0" max="120" value="' + marginX.value + '"><label>Margin vertical <span>' + margin.value + 'px</span></label><input data-style="margin_y" type="range" min="0" max="120" value="' + margin.value + '">' : (target === 'image' ? '<label>Image width <span>' + imageSize.value + '%</span></label><input data-style="image_size" type="range" min="20" max="' + (type === 'image' ? '100' : '75') + '" value="' + imageSize.value + '"><div class="image-size-progress" aria-hidden="true"><span style="width:' + imageSize.value + '%"></span></div><small class="image-help">Hover the image to add or replace it.</small>' : '<label>Text alignment</label><select data-style="text_align"><option value="left" ' + (textAlign.value === 'left' ? 'selected' : '') + '>Left</option><option value="center" ' + (textAlign.value === 'center' ? 'selected' : '') + '>Center</option><option value="right" ' + (textAlign.value === 'right' ? 'selected' : '') + '>Right</option></select>' + (target === 'heading' ? '<label>Heading colour</label><input data-style="text_color" type="color" value="' + textColor.value + '"><label>Heading size <span>' + headingSize.value + 'px</span></label><input data-style="heading_size" type="range" min="16" max="72" value="' + headingSize.value + '">' : '<label>Description colour</label><input data-style="description_color" type="color" value="' + descriptionColor.value + '"><label>Description size <span>' + descriptionSize.value + 'px</span></label><input data-style="description_size" type="range" min="12" max="36" value="' + descriptionSize.value + '">') + '<label>Element padding <span>' + elementData.styles[target].padding_y + 'px</span></label><input data-element-style="padding_y" type="range" min="0" max="120" value="' + elementData.styles[target].padding_y + '"><label>Element margin <span>' + elementData.styles[target].margin_y + 'px</span></label><input data-element-style="margin_y" type="range" min="0" max="120" value="' + elementData.styles[target].margin_y + '">');
    const formatControls = (target === 'heading' || target === 'content') ? '<div class="text-format-controls" aria-label="Text formatting"><span>Text style</span><button type="button" data-format="font_weight" data-format-value="bold" class="' + (elementData.styles[target].font_weight === 'bold' ? 'is-active' : '') + '"><b>B</b></button><button type="button" data-format="font_style" data-format-value="italic" class="' + (elementData.styles[target].font_style === 'italic' ? 'is-active' : '') + '"><i>I</i></button><button type="button" data-format="text_decoration" data-format-value="underline" class="' + (elementData.styles[target].text_decoration === 'underline' ? 'is-active' : '') + '"><u>U</u></button></div>' : '';
    stylePanel.innerHTML = '<div class="builder-inspector-title"><span>' + targetLabel + ' design</span><span>◐</span></div><button type="button" class="delete-selected-section">Delete section</button>' + (target === 'section' ? imageControl + blockControls + columnControls + extraElementControls + backgroundControls : '') + elementControls + formatControls + (target === 'section' ? '<button type="button" class="apply-section-spacing">Apply this spacing to all sections</button>' : '');
    stylePanel.querySelectorAll('.column-control').forEach((columnControl, index) => {
      const block = blocks[index] || {};
      const extras = document.createElement('div');
      extras.className = 'column-support-controls';
      const spacing = (label, key, value) => '<label>' + label + ' <span>' + value + 'px</span></label><div class="builder-range-number"><input data-block="' + index + '" data-block-key="' + key + '" type="range" min="0" max="160" value="' + value + '"><input data-block="' + index + '" data-block-key="' + key + '" type="number" min="0" max="160" value="' + value + '" aria-label="' + label + ' pixels"></div>';
      extras.innerHTML = '<label>Supporting text <small>Optional</small></label><textarea data-block="' + index + '" data-block-key="small_text" placeholder="Small text below this column">' + escape(block.small_text || '') + '</textarea><label>Bullet points <small>One item per line</small></label><textarea data-block="' + index + '" data-block-key="bullets" placeholder="First point&#10;Second point">' + escape(block.bullets || '') + '</textarea><div class="column-spacing-controls"><strong>Column spacing</strong>' + spacing('Padding horizontal', 'padding_x', Number(block.padding_x || 0)) + spacing('Padding vertical', 'padding_y', Number(block.padding_y || 0)) + spacing('Margin horizontal', 'margin_x', Number(block.margin_x || 0)) + spacing('Margin vertical', 'margin_y', Number(block.margin_y || 0)) + '</div>';
      columnControl.appendChild(extras);
    });
    stylePanel.querySelectorAll('[data-style]').forEach(control => {
      const update = () => {
        ensureField(card, control.dataset.style, '').value = control.type === 'checkbox' ? (control.checked ? '1' : '0') : control.value;
        control.previousElementSibling?.querySelector('span') && (control.previousElementSibling.querySelector('span').textContent = control.value + (['image_size', 'background_overlay_opacity'].includes(control.dataset.style) ? '%' : 'px'));
        if (control.dataset.style === 'image_size') {
          stylePanel.querySelector('.image-size-progress span').style.width = control.value + '%';
          document.querySelectorAll('.preview-section[data-builder-id="' + card.dataset.builderId + '"] .preview-image-frame').forEach(frame => frame.style.width = control.value + '%');
          return;
        }
        render();
      };
      control.addEventListener('input', update); control.addEventListener('change', update);
    });
    stylePanel.querySelectorAll('[data-element-style]').forEach(control => { const update = () => { elementData.styles[target][control.dataset.elementStyle] = Number(control.value); elementData.field.value = JSON.stringify(elementData.styles); control.previousElementSibling.querySelector('span').textContent = control.value + 'px'; render(); }; control.addEventListener('input', update); });
    stylePanel.querySelectorAll('[data-format]').forEach(button => button.addEventListener('click', () => { const property = button.dataset.format; const value = button.dataset.formatValue; const inactiveValue = property === 'font_weight' ? 'normal' : (property === 'font_style' ? 'normal' : 'none'); elementData.styles[target][property] = elementData.styles[target][property] === value ? inactiveValue : value; elementData.field.value = JSON.stringify(elementData.styles); renderStyles(card, target); render(); }));
    stylePanel.querySelector('.apply-section-spacing')?.addEventListener('click', () => {
      const spacing = ['padding_x', 'padding_y', 'margin_x', 'margin_y'];
      [...sections.querySelectorAll('.page-builder-section')].forEach(otherCard => spacing.forEach(property => ensureField(otherCard, property, '0').value = ensureField(card, property, '0').value));
      render();
    });
    stylePanel.querySelector('[data-section-image]')?.addEventListener('change', event => { const target = card.querySelector('input[type=file]'); if (!target || !event.target.files.length) return; target.files = event.target.files; delete card.dataset.previewImage; target.dispatchEvent(new Event('change', { bubbles: true })); });
    stylePanel.querySelectorAll('[data-background-mode]').forEach(button => button.addEventListener('click', () => { backgroundMode.value = button.dataset.backgroundMode; renderStyles(card, target); render(); }));
    stylePanel.querySelector('[data-background-image]')?.addEventListener('change', event => {
      const file = event.target.files?.[0]; if (!file) return;
      const uploadError = event.target.parentElement.querySelector('.background-upload-error') || document.createElement('small');
      uploadError.className = 'background-upload-error';
      if (file.size > 5 * 1024 * 1024) { uploadError.textContent = 'Size limit exceeded: choose an image smaller than 5 MB.'; event.target.insertAdjacentElement('afterend', uploadError); event.target.value = ''; return; }
      uploadError.remove();
      let input = getField(card, 'background_image');
      if (!input) { input = document.createElement('input'); input.type = 'file'; input.hidden = true; input.name = getField(card, 'heading').name.replace('[heading]', '[background_image]'); card.appendChild(input); }
      input.files = event.target.files; backgroundMode.value = 'image';
      const reader = new FileReader(); reader.onload = loaded => { card.dataset.previewBackgroundImage = loaded.target.result; render(); }; reader.readAsDataURL(file);
    });
    stylePanel.querySelectorAll('[data-block]').forEach(control => {
      const updateBlock = () => {
        blocks[control.dataset.block][control.dataset.blockKey] = control.value;
        blocksField.value = JSON.stringify(blocks);
        const pairedControl = control.closest('.builder-range-number')?.querySelector('input[type="' + (control.type === 'range' ? 'number' : 'range') + '"]');
        if (pairedControl) pairedControl.value = control.value;
        const spacingLabel = control.closest('.builder-range-number')?.previousElementSibling?.querySelector('span');
        if (spacingLabel) spacingLabel.textContent = control.value + 'px';
        if (control.tagName === 'SELECT') { renderStyles(card, target); render(); return; }
        if (control.type === 'range') { control.previousElementSibling?.querySelector('span') && (control.previousElementSibling.querySelector('span').textContent = control.value + '%'); document.querySelectorAll('[data-preview-column-image="' + control.dataset.block + '"]').forEach(image => image.style.width = control.value + '%'); }
        if (control.type === 'range' && ['padding_x', 'padding_y', 'margin_x', 'margin_y'].includes(control.dataset.blockKey)) render();
      };
      control.addEventListener('input', updateBlock);
      control.addEventListener('change', updateBlock);
      control.addEventListener('blur', () => { if (control.tagName !== 'SELECT' && control.type !== 'range') render(); });
    });
    stylePanel.querySelector('[data-column-count]')?.addEventListener('change', event => { gridColumns.value = event.target.value; renderStyles(card, target); render(); });
    stylePanel.querySelectorAll('[data-extra]').forEach(control => {
      const updateExtra = () => {
        extraElements[control.dataset.extra][control.dataset.extraKey] = control.value;
        elementsField.value = JSON.stringify(extraElements);
        renderStyles(card, target); render();
      };
      control.addEventListener('input', updateExtra); control.addEventListener('change', updateExtra);
    });
    const addExtra = type => {
      const isList = type === 'bullet_list' || type === 'numbered_list';
      extraElements.push({ type, text: type === 'heading' ? 'New heading' : 'New sub heading', items: isList ? 'First item\nSecond item\nThird item' : '', item_gap: 8, color: type === 'heading' ? textColor.value : descriptionColor.value, size: type === 'heading' ? headingSize.value : descriptionSize.value, padding: 0, margin: 0 });
      elementsField.value = JSON.stringify(extraElements); renderStyles(card, target); render();
    };
    stylePanel.querySelector('.add-extra-heading')?.addEventListener('click', () => addExtra('heading'));
    stylePanel.querySelector('.add-extra-subheading')?.addEventListener('click', () => addExtra('subheading'));
    stylePanel.querySelector('.add-extra-bullet-list')?.addEventListener('click', () => addExtra('bullet_list'));
    stylePanel.querySelector('.add-extra-numbered-list')?.addEventListener('click', () => addExtra('numbered_list'));
    stylePanel.querySelectorAll('[data-remove-extra]').forEach(button => button.addEventListener('click', () => { extraElements.splice(button.dataset.removeExtra, 1); elementsField.value = JSON.stringify(extraElements); renderStyles(card, target); render(); }));
    stylePanel.querySelectorAll('[data-block-image]').forEach(button => button.addEventListener('click', () => { const index = button.dataset.blockImage; let input = card.querySelector('[data-block-upload="' + index + '"]'); if (!input) { input = document.createElement('input'); input.type = 'file'; input.accept = 'image/*'; input.hidden = true; input.dataset.blockUpload = index; input.name = blocksField.name.replace('[blocks]', '[block_images][' + index + ']'); card.appendChild(input); input.addEventListener('change', () => { const file = input.files?.[0]; if (!file) return; const reader = new FileReader(); reader.onload = event => { let previews = {}; try { previews = JSON.parse(card.dataset.blockPreviews || '{}'); } catch (_) {} previews[index] = event.target.result; card.dataset.blockPreviews = JSON.stringify(previews); render(); renderStyles(card, target); }; reader.readAsDataURL(file); }); } input.click(); }));
    stylePanel.querySelector('.add-feature-block')?.addEventListener('click', () => { blocks.push({ icon: '✦', title: 'New feature', text: 'Describe the benefit.' }); blocksField.value = JSON.stringify(blocks); renderStyles(card); render(); });
    stylePanel.querySelectorAll('[data-remove-block]').forEach(button => button.addEventListener('click', () => { blocks.splice(button.dataset.removeBlock, 1); blocksField.value = JSON.stringify(blocks); renderStyles(card); render(); }));
    stylePanel.querySelector('.delete-selected-section')?.addEventListener('click', () => { card.remove(); stylePanel.innerHTML = '<div class="builder-inspector-title"><span>Design</span><span>◐</span></div><div class="section-empty">Select a section on the canvas</div>'; render(); });
  }

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
      const existingBackgroundImage = getValue(card, 'existing_background_image');
      const backgroundImage = card.dataset.previewBackgroundImage || (existingBackgroundImage ? '/' + existingBackgroundImage.replace(/^\//, '') : '');
      const backgroundMode = getValue(card, 'background_mode') || 'color';
      const overlayColor = getValue(card, 'background_overlay_color') || '#000000';
      const overlayOpacity = Math.max(0, Math.min(90, Number(getValue(card, 'background_overlay_opacity') || 0))) / 100;
      const textColor = getValue(card, 'text_color') || '#183c45';
      const headingSize = getValue(card, 'heading_size') || '32';
      const descriptionColor = getValue(card, 'description_color') || '#647b82';
      const descriptionSize = getValue(card, 'description_size') || '16';
      const textAlign = getValue(card, 'text_align') || 'left';
      const selectedStyles = elementStyles(card).styles;
      let blocks = []; try { blocks = JSON.parse(getValue(card, 'blocks') || '[]'); } catch (_) {}
      let extraElements = []; try { extraElements = JSON.parse(getValue(card, 'elements') || '[]'); } catch (_) {}
      let blockPreviews = {}; try { blockPreviews = JSON.parse(card.dataset.blockPreviews || '{}'); } catch (_) {}
      blocks.forEach((block, blockIndex) => { if (blockPreviews[blockIndex]) block.previewImage = blockPreviews[blockIndex]; });
      const position = getValue(card, 'image_position') || 'left';
      const paddingX = getValue(card, 'padding_x') || '0';
      const paddingY = getValue(card, 'padding_y') || '48';
      const marginX = getValue(card, 'margin_x') || '0';
      const marginY = getValue(card, 'margin_y') || '0';
      const imageInput = card.querySelector('input[type=file]');
      const existingImage = getValue(card, 'existing_image');
      const image = card.dataset.previewImage || (existingImage ? '/' + existingImage.replace(/^\//, '') : '');
      const previewSection = document.createElement('article');
      previewSection.className = 'preview-section';
      previewSection.dataset.builderId = card.dataset.builderId;
      previewSection.style.backgroundColor = background;
      if (backgroundMode === 'image' && backgroundImage) { const rgb = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(overlayColor); const overlay = rgb ? 'rgba(' + parseInt(rgb[1], 16) + ',' + parseInt(rgb[2], 16) + ',' + parseInt(rgb[3], 16) + ',' + overlayOpacity + ')' : 'rgba(0,0,0,0)'; const backgroundUrl = /^(https?:)?\/\//i.test(backgroundImage) || backgroundImage.startsWith('/') ? backgroundImage : '/' + backgroundImage; previewSection.style.backgroundImage = 'linear-gradient(' + overlay + ',' + overlay + '), url("' + backgroundUrl.replace(/"/g, '%22') + '")'; previewSection.style.backgroundSize = 'cover'; previewSection.style.backgroundRepeat = 'no-repeat'; previewSection.style.backgroundPosition = (getValue(card, 'background_position') || 'center') + ' center'; }
      previewSection.style.backgroundAttachment = getValue(card, 'background_parallax') === '1' ? 'fixed' : 'scroll';
      previewSection.style.setProperty('padding', paddingY + 'px ' + paddingX + 'px', 'important');
      previewSection.style.setProperty('margin', marginY + 'px ' + marginX + 'px', 'important');
      previewSection.style.boxSizing = 'border-box';
      previewSection.style.setProperty('text-align', textAlign, 'important');
      const imageMarkup = '<div class="preview-image-frame">' + (image ? '<img class="preview-section-image" src="' + escape(image) + '" alt="">' : '<div class="preview-image-empty">Image area</div>') + '<button type="button" class="preview-image-action">' + (image ? 'Replace image' : 'Add image') + '</button></div>';
      const gridColumns = type === 'custom_columns' ? Math.max(1, Math.min(3, Number(getValue(card, 'grid_columns') || 1))) : Math.max(2, Math.min(4, Number(getValue(card, 'grid_columns') || 3)));
      const gridMarkup = '<div class="preview-grid-heading"><h3 contenteditable="true" data-preview-field="heading" style="color:' + escape(textColor) + ';font-size:' + escape(headingSize) + 'px">' + escape(heading) + '</h3>' + extraElements.map((element, extraIndex) => previewExtraElement(element, extraIndex, textColor, headingSize, descriptionColor, descriptionSize)).join('') + '<p contenteditable="true" data-preview-field="content" style="color:' + escape(descriptionColor) + ';font-size:' + escape(descriptionSize) + 'px">' + escape(text) + '</p></div><div class="preview-feature-grid" style="grid-template-columns:repeat(' + gridColumns + ', minmax(0,1fr));gap:' + escape(getValue(card, 'grid_gap') || '24') + 'px">' + blocks.map(block => '<div class="preview-feature ' + (getValue(card, 'card_layout') === 'icon_left' ? 'is-icon-left' : 'is-stacked') + '" style="text-align:' + escape(getValue(card, 'card_alignment') || 'center') + '">' + (block.previewImage || block.image ? '<img src="' + escape(block.previewImage || ('/' + String(block.image).replace(/^\//, ''))) + '" alt="">' : '<b>' + escape(block.icon || '✦') + '</b>') + '<div><h4>' + escape(block.title || 'Feature title') + '</h4>' + (block.text ? '<p>' + escape(block.text) + '</p>' : '') + '</div></div>').join('') + '</div>';
      const columnStyle = (block, key) => { const style = (block.styles || {})[key] || {}; return 'color:' + escape(style.color || (key === 'title' ? textColor : descriptionColor)) + ';font-size:' + escape(style.size || (key === 'title' ? 24 : 16)) + 'px;padding:' + escape(style.padding || 0) + 'px;margin:' + escape(style.margin || 0) + 'px;text-align:' + escape(style.align || textAlign) + ';'; };
      const columnExtraMarkup = (block, index) => (block.small_text ? '<small class="preview-column-support" contenteditable="true" data-preview-column="' + index + '" data-preview-column-key="small_text" data-preview-column-target="column-' + index + '-small_text" style="' + columnStyle(block, 'small_text') + '">' + escape(block.small_text) + '</small>' : '') + (block.bullets ? '<ul class="preview-builder-list" data-preview-column-target="column-' + index + '-bullets" style="' + columnStyle(block, 'bullets') + '">' + String(block.bullets).split(/\r?\n/).filter(Boolean).map(item => '<li>' + escape(item) + '</li>').join('') + '</ul>' : '');
      const columnMarkup = '<div class="preview-custom-columns-wrap"><div class="preview-feature-grid preview-custom-columns" style="grid-template-columns:repeat(' + gridColumns + ', minmax(0,1fr));gap:' + escape(getValue(card, 'grid_gap') || '24') + 'px">' + blocks.slice(0, gridColumns).map((block, index) => '<div class="preview-feature is-stacked preview-column-stack" style="text-align:' + escape(textAlign) + '">' + (block.type === 'image' ? (block.previewImage || block.image ? '<img data-preview-column-image="' + index + '" data-preview-column-target="column-' + index + '-image" style="width:' + escape(block.image_size ?? 100) + '%;max-width:100%;height:auto;margin:0 auto" src="' + escape(block.previewImage || ('/' + String(block.image).replace(/^\//, ''))) + '" alt="">' : '<button type="button" class="preview-image-empty" data-preview-empty-image="' + index + '">Add an image</button>') : (block.type === 'button' ? '<span class="preview-cta">' + escape(block.button_text || 'Button label') + '</span>' : '<div><h4 contenteditable="true" data-preview-column="' + index + '" data-preview-column-key="title" data-preview-column-target="column-' + index + '-title" style="' + columnStyle(block, 'title') + '">' + escape(block.title || 'Add a heading') + '</h4><p contenteditable="true" data-preview-column="' + index + '" data-preview-column-key="text" data-preview-column-target="column-' + index + '-text" style="white-space:pre-wrap;' + columnStyle(block, 'text') + '">' + escape(block.text || 'Add text for this column.') + '</p></div>')) + columnExtraMarkup(block, index) + '<button type="button" class="preview-column-add" data-column-extra="' + index + '">＋ Add text or list</button>' + (gridColumns > 1 ? '<button type="button" class="preview-column-remove" data-column-remove="' + index + '" title="Remove column" aria-label="Remove column">×</button>' : '') + '</div>').join('') + '</div>' + (gridColumns < 3 ? '<button type="button" class="preview-column-divider" title="Split into ' + (gridColumns + 1) + ' columns" aria-label="Add a column">+</button>' : '') + '</div>';
      const textExtraMarkup = !['image', 'feature_grid', 'testimonial', 'faq'].includes(type) ? extraElements.map((element, extraIndex) => previewExtraElement(element, extraIndex, textColor, headingSize, descriptionColor, descriptionSize)).join('') : '';
      previewSection.innerHTML = type === 'feature_grid' ? gridMarkup : (type === 'custom_columns' ? columnMarkup : (type === 'image' ? '<div class="preview-image-hero">' + imageMarkup + '</div>' : '<div class="preview-section-row ' + (position === 'right' ? 'is-right' : '') + '">' + (type === 'image_text' ? imageMarkup : '') + '<div class="preview-section-copy"><small>' + escape(type.replace('_', ' + ')) + '</small><h3 contenteditable="true" data-preview-field="heading" style="color:' + escape(textColor) + ';font-size:' + escape(headingSize) + 'px">' + escape(heading) + '</h3>' + textExtraMarkup + '<p contenteditable="true" data-preview-field="content" style="color:' + escape(descriptionColor) + ';font-size:' + escape(descriptionSize) + 'px">' + escape(text) + '</p>' + (button ? '<span class="preview-cta">' + escape(button) + '</span>' : '') + '</div></div>'));
      if (type === 'custom_columns') blocks.slice(0, gridColumns).forEach((block, index) => { if (block.type === 'empty') { const column = previewSection.querySelectorAll('.preview-column-stack')[index]; const primary = column?.firstElementChild; if (primary) primary.outerHTML = '<div class="preview-empty-column-wrap"><button type="button" class="preview-empty-column" data-empty-column="' + index + '">＋ Add element</button><div class="preview-empty-column-menu"><button type="button" data-empty-column-choice="text" data-empty-column-index="' + index + '">Text</button><button type="button" data-empty-column-choice="image" data-empty-column-index="' + index + '">Image</button><button type="button" data-empty-column-choice="button" data-empty-column-index="' + index + '">Button</button></div></div>'; } });
      if (type === 'custom_columns') blocks.slice(0, gridColumns).forEach((block, index) => { if (block.type === 'button') { const button = previewSection.querySelectorAll('.preview-column-stack')[index]?.querySelector('.preview-cta'); const style = (block.styles || {}).button || {}; if (button) { button.setAttribute('data-preview-column-target', 'column-' + index + '-button'); if (Number(style.padding || 0) > 0) button.style.padding = Number(style.padding) + 'px'; if (Number(style.margin || 0) > 0) button.style.margin = Number(style.margin) + 'px'; } } });
      previewSection.querySelectorAll('.preview-column-stack').forEach((column, index) => { const block = blocks[index] || {}; column.style.padding = Number(block.padding_y || 0) + 'px ' + Number(block.padding_x || 0) + 'px'; column.style.margin = Number(block.margin_y || 0) + 'px ' + Number(block.margin_x || 0) + 'px'; });
      previewSection.querySelectorAll('.preview-column-stack').forEach((column, index) => { const block = blocks[index] || {}; column.dataset.previewColumnTarget = 'column-' + index + '-container'; column.style.justifyContent = ({ start:'flex-start', center:'center', end:'flex-end' })[block.vertical_align || 'start']; });
      previewSection.querySelectorAll('[data-preview-field]').forEach(element => { const field = getField(card, element.dataset.previewField); if (field && /<a\b/i.test(field.value)) element.innerHTML = richPreview(field.value); });
      previewSection.querySelectorAll('[data-preview-column]').forEach(element => { const block = blocks[Number(element.dataset.previewColumn)]; const value = block?.[element.dataset.previewColumnKey]; if (value && /<a\b/i.test(value)) element.innerHTML = richPreview(value); });
      previewSection.querySelectorAll('[data-preview-extra]').forEach(element => { const extra = extraElements[Number(element.dataset.previewExtra)]; if (extra?.text && /<a\b/i.test(extra.text)) element.innerHTML = richPreview(extra.text); });
      const sectionActions = document.createElement('div');
      sectionActions.className = 'preview-section-actions';
      if (type === 'feature_grid') {
        sectionActions.innerHTML = '<button type="button" class="preview-section-add" data-quick-add-feature>＋ Add feature card</button>';
      } else if (type === 'custom_columns' && gridColumns < 3) {
        sectionActions.innerHTML = '<button type="button" class="preview-section-add" data-quick-add-trigger>＋ Add column</button><div class="preview-section-add-menu"><small>Add a new column</small><button type="button" data-quick-add-column="text">Text</button><button type="button" data-quick-add-column="image">Image</button><button type="button" data-quick-add-column="button">Button</button></div>';
      } else if (!['image', 'testimonial', 'faq'].includes(type)) {
        sectionActions.innerHTML = '<button type="button" class="preview-section-add" data-quick-add-trigger>＋ Add element</button><div class="preview-section-add-menu"><button type="button" data-quick-add-extra="heading">Heading</button><button type="button" data-quick-add-extra="subheading">Subheading</button><button type="button" data-quick-add-extra="bullet_list">Bulleted list</button><button type="button" data-quick-add-extra="numbered_list">Numbered list</button></div>';
      }
      if (sectionActions.innerHTML) {
        sectionActions.addEventListener('click', event => {
          event.stopPropagation();
          if (event.target.closest('[data-quick-add-trigger]')) { sectionActions.classList.toggle('is-open'); return; }
          if (event.target.closest('[data-quick-add-feature]')) {
            blocks.push({ icon: '✦', title: 'New feature', text: 'Describe the benefit.' });
            getField(card, 'blocks').value = JSON.stringify(blocks); focusCard(card, 'section'); render(); return;
          }
          const columnChoice = event.target.closest('[data-quick-add-column]');
          if (columnChoice) {
            const nextCount = Math.min(3, gridColumns + 1);
            while (blocks.length < nextCount) blocks.push({ type: 'empty', title: '', text: '' });
            blocks[nextCount - 1] = { ...blocks[nextCount - 1], type: columnChoice.dataset.quickAddColumn };
            getField(card, 'blocks').value = JSON.stringify(blocks);
            getField(card, 'grid_columns').value = String(nextCount); focusCard(card, 'section'); render(); return;
          }
          const extraChoice = event.target.closest('[data-quick-add-extra]');
          if (extraChoice) {
            const extraType = extraChoice.dataset.quickAddExtra;
            const isList = extraType === 'bullet_list' || extraType === 'numbered_list';
            extraElements.push({ type: extraType, text: extraType === 'heading' ? 'New heading' : 'New sub heading', items: isList ? 'First item\nSecond item\nThird item' : '', item_gap: 8, color: extraType === 'heading' ? textColor : descriptionColor, size: extraType === 'heading' ? headingSize : descriptionSize, padding: 0, margin: 0 });
            getField(card, 'elements').value = JSON.stringify(extraElements); focusCard(card, 'section'); render();
          }
        });
        previewSection.appendChild(sectionActions);
      }
      const deleteSectionButton = document.createElement('button');
      deleteSectionButton.type = 'button'; deleteSectionButton.className = 'preview-section-delete'; deleteSectionButton.title = 'Delete section'; deleteSectionButton.setAttribute('aria-label', 'Delete section'); deleteSectionButton.textContent = '×';
      const deleteSection = event => { event.preventDefault(); event.stopImmediatePropagation(); if (!card.isConnected) return; card.remove(); normalizeSectionIndexes(); render(); queueSnapshot(); };
      deleteSectionButton.addEventListener('pointerdown', deleteSection, true);
      deleteSectionButton.addEventListener('click', deleteSection, true);
      previewSection.appendChild(deleteSectionButton);
      previewSection.querySelectorAll('[data-column-extra]').forEach(button => button.addEventListener('click', event => {
        event.stopPropagation();
        const column = blocks[Number(button.dataset.columnExtra)];
        if (!column) return;
        if (!column.small_text) column.small_text = 'Add supporting text';
        else if (!column.bullets) column.bullets = 'First item\nSecond item\nThird item';
        else column.small_text += '\nAdditional text';
        getField(card, 'blocks').value = JSON.stringify(blocks); focusCard(card, 'section'); render();
      }));
      previewSection.querySelectorAll('[data-column-remove]').forEach(button => button.addEventListener('click', event => {
        event.stopPropagation(); blocks.splice(Number(button.dataset.columnRemove), 1);
        getField(card, 'blocks').value = JSON.stringify(blocks); getField(card, 'grid_columns').value = String(Math.max(1, gridColumns - 1)); focusCard(card, 'section'); render(); queueSnapshot();
      }));
      previewSection.querySelectorAll('[data-preview-empty-image]').forEach(button => button.addEventListener('click', event => {
        event.stopPropagation(); const index = button.dataset.previewEmptyImage;
        let input = card.querySelector('[data-block-upload="' + index + '"]');
        if (!input) { input = document.createElement('input'); input.type = 'file'; input.accept = 'image/*'; input.hidden = true; input.dataset.blockUpload = index; input.name = getField(card, 'blocks').name.replace('[blocks]', '[block_images][' + index + ']'); card.appendChild(input); input.addEventListener('change', () => { const file = input.files?.[0]; if (!file) return; const reader = new FileReader(); reader.onload = loaded => { let previews = {}; try { previews = JSON.parse(card.dataset.blockPreviews || '{}'); } catch (_) {} previews[index] = loaded.target.result; card.dataset.blockPreviews = JSON.stringify(previews); render(); renderStyles(card, 'column-' + index + '-image'); }; reader.readAsDataURL(file); }); }
        input.click();
      }));
      previewSection.querySelectorAll('[data-empty-column]').forEach(button => button.addEventListener('click', event => { event.stopPropagation(); button.closest('.preview-empty-column-wrap')?.classList.toggle('is-open'); }));
      previewSection.querySelectorAll('[data-empty-column-choice]').forEach(button => button.addEventListener('click', event => { event.stopPropagation(); const index = Number(button.dataset.emptyColumnIndex); blocks[index] = { ...blocks[index], type: button.dataset.emptyColumnChoice, title: '', text: '' }; getField(card, 'blocks').value = JSON.stringify(blocks); focusCard(card, 'section'); render(); queueSnapshot(); }));
      previewSection.querySelector('.preview-column-divider')?.addEventListener('click', event => {
        event.stopPropagation();
        const nextCount = Math.min(3, gridColumns + 1);
        while (blocks.length < nextCount) blocks.push({ type: 'empty', title: '', text: '' });
        getField(card, 'blocks').value = JSON.stringify(blocks);
        getField(card, 'grid_columns').value = String(nextCount); focusCard(card, 'section'); render();
      });
      if (type === 'image_text') {
        const swap = document.createElement('button');
        swap.type = 'button'; swap.className = 'preview-swap-button';
        swap.innerHTML = '⇄ <span>Swap image &amp; text</span>';
        swap.title = 'Move image to the ' + (position === 'left' ? 'right' : 'left');
        swap.addEventListener('click', event => { event.stopPropagation(); ensureField(card, 'image_position', 'left').value = position === 'left' ? 'right' : 'left'; focusCard(card); render(); });
        previewSection.appendChild(swap);
      }
      // The public theme has broad heading/paragraph alignment rules. Apply the
      // builder value directly to every editable text node so the editor canvas
      // always mirrors the saved public layout.
      previewSection.querySelectorAll('.preview-section-copy, .preview-grid-heading, [data-preview-field], [data-preview-extra], .preview-section-copy small').forEach(element => element.style.setProperty('text-align', textAlign, 'important'));
      const imageFrame = previewSection.querySelector('.preview-image-frame');
      if (imageFrame && (type === 'image_text' || type === 'image')) { imageFrame.style.width = (getValue(card, 'image_size') || (type === 'image' ? '100' : '42')) + '%'; }
      if (imageFrame) { imageFrame.addEventListener('click', event => { event.stopPropagation(); const action = event.target.closest('.preview-image-action'); if (action) { imageInput?.click(); return; } focusCard(card, 'image'); }); }
      [['heading', '[data-preview-field="heading"]'], ['content', '[data-preview-field="content"]']].forEach(([key, selector]) => previewSection.querySelectorAll(selector).forEach(element => { const style = selectedStyles[key]; element.style.padding = style.padding_y + 'px ' + style.padding_x + 'px'; element.style.margin = style.margin_y + 'px ' + style.margin_x + 'px'; element.style.fontWeight = style.font_weight; element.style.fontStyle = style.font_style; element.style.textDecoration = style.text_decoration; }));
      previewSection.addEventListener('click', event => { const selectedColumnElement = event.target.closest('[data-preview-column-target]'); const editable = event.target.closest('[contenteditable]'); const extraList = event.target.closest('[data-preview-extra-list]'); const target = selectedColumnElement?.dataset.previewColumnTarget || editable?.dataset.previewField || (editable?.dataset.previewExtra !== undefined ? 'extra-' + editable.dataset.previewExtra : (extraList ? 'section' : 'section')); focusCard(card, target); if (editable) editable.classList.add('is-editing'); }, true);
      content.appendChild(previewSection);
      const layer = document.createElement('div');
      layer.className = 'section-tree'; layer.dataset.builderId = card.dataset.builderId;
      const treeLabel = type === 'image' ? 'Full-width image' : heading;
      layer.innerHTML = '<div class="section-tree-header"><button type="button" class="section-layer"><span>☷ ' + escape(treeLabel) + '</span><small>' + escape(type.replace('_', ' + ')) + '</small></button><button type="button" class="section-tree-duplicate" title="Duplicate section" aria-label="Duplicate section">⧉</button><button type="button" class="section-tree-delete" title="Delete section" aria-label="Delete section">×</button><button type="button" class="section-tree-toggle" aria-label="Collapse section" aria-expanded="true">⌃</button></div><div class="section-tree-children"></div>';
      const root = layer.querySelector('.section-layer');
      root.draggable = true;
      root.dataset.treeTarget = 'section';
      root.addEventListener('click', () => focusCard(card, 'section'));
      layer.querySelector('.section-tree-duplicate').addEventListener('click', event => { event.stopPropagation(); const copy = card.cloneNode(true); copy.dataset.builderId = ''; sections.insertBefore(copy, card.nextSibling); normalizeSectionIndexes(); render(); });
      layer.querySelector('.section-tree-delete').addEventListener('click', event => { event.stopPropagation(); card.remove(); normalizeSectionIndexes(); render(); queueSnapshot(); });
      layer.querySelector('.section-tree-toggle').addEventListener('click', event => { event.stopPropagation(); const collapsed = layer.classList.toggle('is-collapsed'); event.currentTarget.setAttribute('aria-expanded', String(!collapsed)); event.currentTarget.setAttribute('aria-label', collapsed ? 'Expand section' : 'Collapse section'); event.currentTarget.textContent = collapsed ? '⌄' : '⌃'; });
      root.addEventListener('dragstart', event => { layer.classList.add('is-dragging'); event.dataTransfer.effectAllowed = 'move'; event.dataTransfer.setData('text/plain', card.dataset.builderId); });
      root.addEventListener('dragend', () => layer.classList.remove('is-dragging'));
      root.addEventListener('dragover', event => { event.preventDefault(); event.dataTransfer.dropEffect = 'move'; layer.classList.add('is-drag-over'); });
      root.addEventListener('dragleave', () => layer.classList.remove('is-drag-over'));
      root.addEventListener('drop', event => { event.preventDefault(); layer.classList.remove('is-drag-over'); const sourceId = event.dataTransfer.getData('text/plain'); if (!sourceId || sourceId === card.dataset.builderId) return; const sourceCard = [...sections.querySelectorAll('.page-builder-section')].find(item => item.dataset.builderId === sourceId); if (!sourceCard) return; const cardsNow = [...sections.querySelectorAll('.page-builder-section')]; const targetIndex = cardsNow.indexOf(card); sections.insertBefore(sourceCard, targetIndex > cardsNow.indexOf(sourceCard) ? card.nextSibling : card); normalizeSectionIndexes(); render(); });
      const children = [];
      if (type === 'image' || type === 'image_text') children.push({ target: 'image', label: 'Image' });
      if (type !== 'image') children.push({ target: 'heading', label: 'Heading' }, { target: 'content', label: 'Sub heading' });
      if (button) children.push({ target: 'section', label: 'Button' });
      children.forEach(node => { const child = document.createElement('button'); child.type = 'button'; child.className = 'section-tree-child'; child.dataset.treeTarget = node.target; child.innerHTML = '<span>└</span> ' + node.label; child.addEventListener('click', event => { event.stopPropagation(); focusCard(card, node.target); }); layer.querySelector('.section-tree-children').appendChild(child); });
      list.appendChild(layer);
      if (imageInput && imageInput.files && imageInput.files[0] && !card.dataset.previewImage) {
        const reader = new FileReader();
        reader.onload = event => { card.dataset.previewImage = event.target.result; render(); };
        reader.readAsDataURL(imageInput.files[0]);
      }
    });
  }

  snapshot();
  sections.addEventListener('input', () => { render(); queueSnapshot(); });
  sections.addEventListener('change', queueSnapshot);
  preview.addEventListener('click', event => { if (event.target.closest('button')) window.setTimeout(queueSnapshot, 0); });
  document.getElementById('landing-page-form')?.addEventListener('submit', () => setSaveState('Saving…'));
  document.addEventListener('keydown', event => {
    if (!(event.ctrlKey || event.metaKey)) return;
    if (event.key.toLowerCase() === 'z') { event.preventDefault(); restoreHistory(event.shiftKey ? historyIndex + 1 : historyIndex - 1); }
    if (event.key.toLowerCase() === 'y') { event.preventDefault(); restoreHistory(historyIndex + 1); }
  });
  preview.querySelector('.live-preview-content').addEventListener('input', (event) => {
    const columnIndex = event.target.dataset.previewColumn;
    if (columnIndex !== undefined) {
      const previewSection = event.target.closest('.preview-section');
      const card = previewSection && [...sections.querySelectorAll('.page-builder-section')].find(item => item.dataset.builderId === previewSection.dataset.builderId);
      const blocksField = card && getField(card, 'blocks');
      if (!blocksField) return;
      let blocks = []; try { blocks = JSON.parse(blocksField.value || '[]'); } catch (_) {}
      if (blocks[Number(columnIndex)]) { blocks[Number(columnIndex)][event.target.dataset.previewColumnKey] = event.target.innerText; blocksField.value = JSON.stringify(blocks); }
      return;
    }
    const extraIndex = event.target.dataset.previewExtra;
    if (extraIndex !== undefined) {
      const previewSection = event.target.closest('.preview-section');
      const card = previewSection && [...sections.querySelectorAll('.page-builder-section')].find(item => item.dataset.builderId === previewSection.dataset.builderId);
      const elementsField = card && [...card.querySelectorAll('input, textarea, select')].find(item => item.name && item.name.endsWith('[elements]'));
      if (!elementsField) return;
      let extraElements = [];
      try { extraElements = JSON.parse(elementsField.value || '[]'); } catch (error) { extraElements = []; }
      if (extraElements[Number(extraIndex)]) {
        extraElements[Number(extraIndex)].text = event.target.innerText;
        elementsField.value = JSON.stringify(extraElements);
      }
      return;
    }
    const fieldName = event.target.dataset.previewField;
    if (!fieldName) return;
    const previewSection = event.target.closest('.preview-section');
    const card = [...sections.querySelectorAll('.page-builder-section')].find(item => item.dataset.builderId === previewSection.dataset.builderId);
    const field = card && [...card.querySelectorAll('input, textarea, select')].find(item => item.name && item.name.endsWith('[' + fieldName + ']'));
    if (field) field.value = event.target.innerText;
  });
  preview.querySelector('.live-preview-content').addEventListener('blur', (event) => {
    if (linkPopup.classList.contains('is-open')) return;
    if (event.target.dataset.previewField || event.target.dataset.previewExtra !== undefined || event.target.dataset.previewColumn !== undefined) render();
  }, true);
  preview.querySelector('.live-preview-content').addEventListener('mouseup', event => {
    const editable = event.target.closest('[contenteditable]');
    const selection = window.getSelection();
    if (!editable || !selection || selection.isCollapsed || !selection.toString().trim() || !editable.contains(selection.anchorNode)) return;
    selectedLinkRange = { range: selection.getRangeAt(0).cloneRange(), editable };
    showSelectedLinkRange(selectedLinkRange.range);
    const rect = selectedLinkRange.range.getBoundingClientRect();
    linkPopup.style.left = Math.min(window.innerWidth - 310, Math.max(12, rect.left)) + 'px';
    linkPopup.style.top = (rect.bottom + window.scrollY + 8) + 'px';
    linkPopup.classList.add('is-open');
    linkPopup.elements.url.focus();
  });
  preview.querySelector('.live-preview-content').addEventListener('click', event => {
    const anchor = event.target.closest('[contenteditable] a');
    if (anchor) event.preventDefault();
  }, true);
  preview.querySelector('.live-preview-content').addEventListener('pointerover', event => {
    const anchor = event.target.closest('[contenteditable] a');
    if (anchor) showLinkActions(anchor);
  });
  preview.querySelector('.live-preview-content').addEventListener('pointerout', event => {
    const anchor = event.target.closest('[contenteditable] a');
    if (!anchor || anchor.contains(event.relatedTarget)) return;
    linkActionsTimer = window.setTimeout(() => { if (!linkActions.matches(':hover')) hideLinkActions(); }, 140);
  });
  linkActions.addEventListener('pointerenter', () => window.clearTimeout(linkActionsTimer));
  linkActions.addEventListener('pointerleave', () => hideLinkActions());
  linkActions.querySelector('button').addEventListener('click', () => {
    const anchor = activePreviewLink;
    const editable = anchor?.closest('[contenteditable]');
    if (!anchor || !editable) return;
    const selection = window.getSelection();
    const range = document.createRange();
    range.selectNodeContents(anchor);
    selection.removeAllRanges();
    selection.addRange(range);
    document.execCommand('unlink', false, null);
    saveEditableMarkup(editable);
    hideLinkActions();
  });
  linkPopup.querySelector('.builder-link-cancel').addEventListener('click', () => { clearSelectedLinkRange(); selectedLinkRange = null; linkPopup.classList.remove('is-open'); });
  linkPopup.addEventListener('submit', event => {
    event.preventDefault();
    const url = linkPopup.elements.url.value.trim();
    if (!selectedLinkRange || !url) return;
    const selection = window.getSelection(); selection.removeAllRanges(); selection.addRange(selectedLinkRange.range);
    document.execCommand('createLink', false, url);
    const anchor = selection.anchorNode?.parentElement?.closest('a');
    if (anchor && linkPopup.elements.new_tab.checked) { anchor.target = '_blank'; anchor.rel = 'noopener noreferrer'; }
    saveEditableMarkup(selectedLinkRange.editable);
    linkPopup.reset(); clearSelectedLinkRange(); selectedLinkRange = null; linkPopup.classList.remove('is-open');
  });
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
