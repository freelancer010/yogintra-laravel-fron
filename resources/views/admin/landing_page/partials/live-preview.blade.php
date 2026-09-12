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
  preview.innerHTML = '<div class="live-preview-toolbar"><span><i class="preview-dot"></i>Live page preview</span><span>Desktop canvas</span></div><div class="live-preview-content"></div>';
  canvas.appendChild(preview);

  const addBar = document.createElement('div');
  addBar.className = 'canvas-add-bar';
  addBar.innerHTML = '<button type="button" class="add-section-primary">＋ Add section</button>';
  canvas.appendChild(addBar);
  const picker = document.createElement('div');
  picker.className = 'template-picker';
  picker.innerHTML = '<div class="template-picker-backdrop"></div><div class="template-picker-dialog" role="dialog" aria-modal="true"><button type="button" class="template-picker-close" aria-label="Close">×</button><h3>Add a section</h3><p>Choose a ready-to-edit starting layout.</p><div class="template-picker-grid"><button data-template="text"><b>¶</b><strong>Text</strong><small>Heading and description</small></button><button data-template="image_text"><b>▣</b><strong>Image + text</strong><small>Two-column story</small></button><button data-template="feature_grid"><b>▦</b><strong>Cards / features</strong><small>Repeatable benefit cards</small></button><button data-template="image"><b>▤</b><strong>Full image</strong><small>Image or visual break</small></button><button data-template="cta"><b>↗</b><strong>Button / CTA</strong><small>Prompt people to act</small></button></div></div>';
  document.body.appendChild(picker);
  const openPicker = () => picker.classList.add('is-open');
  const closePicker = () => picker.classList.remove('is-open');
  addBar.querySelector('.add-section-primary').addEventListener('click', openPicker);
  picker.addEventListener('click', event => {
    if (event.target.classList.contains('template-picker-backdrop') || event.target.closest('.template-picker-close')) { closePicker(); return; }
    const template = event.target.closest('[data-template]');
    if (!template) return;
    const type = template.dataset.template;
    const sourceType = ['image', 'feature_grid'].includes(type) ? 'image_text' : type;
    document.querySelector('.add-section[data-section-type="' + sourceType + '"]')?.click();
    setTimeout(() => {
      const card = [...sections.querySelectorAll('.page-builder-section')].at(-1);
      const field = card?.querySelector('select[name$="[section_type]"]');
      if (field && ['image', 'feature_grid'].includes(type)) {
        if (!field.querySelector('option[value="' + type + '"]')) field.add(new Option(type === 'feature_grid' ? 'Feature grid' : 'Image / Hero', type));
        field.value = type;
        if (type === 'image') ensureField(card, 'image_size', '100').value = '100';
        if (type === 'feature_grid') {
          const blocks = ensureField(card, 'blocks', '');
          blocks.value = JSON.stringify([{ icon: '✚', title: 'Traditional Healing', text: '' }, { icon: '♨', title: 'Improve Health', text: '' }, { icon: '☯', title: 'Holistic Wellness', text: '' }]);
          ensureField(card, 'grid_columns', '3').value = '3';
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
  const plainText = (value) => { const element = document.createElement('div'); element.innerHTML = value || ''; return element.textContent || element.innerText || ''; };
  const focusCard = (card, target = 'section') => {
    document.querySelectorAll('.page-builder-section, .preview-section, .section-layer, .section-tree-child, .preview-image-frame').forEach(element => element.classList.remove('is-selected', 'is-selected-target'));
    card.classList.add('is-selected');
    card.dataset.selectedTarget = target;
    document.querySelectorAll('[data-builder-id="' + card.dataset.builderId + '"]').forEach(element => element.classList.add('is-selected'));
    const previewSection = document.querySelector('.preview-section[data-builder-id="' + card.dataset.builderId + '"]');
    const tree = document.querySelector('.section-tree[data-builder-id="' + card.dataset.builderId + '"]');
    if (target === 'image') previewSection?.querySelector('.preview-image-frame')?.classList.add('is-selected-target');
    const treeTarget = tree?.querySelector('[data-tree-target="' + target + '"]');
    (treeTarget || tree?.querySelector('.section-layer'))?.classList.add('is-selected');
    inspector.scrollTo({ top: 0, behavior: 'smooth' });
    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    renderStyles(card, target);
  };

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
    if (type === 'feature_grid' && !blocks.length) { blocks = [{ icon: '✚', title: 'Traditional Healing', text: '' }, { icon: '♨', title: 'Improve Health', text: '' }, { icon: '☯', title: 'Holistic Wellness', text: '' }]; blocksField.value = JSON.stringify(blocks); }
    const blockControls = type === 'feature_grid' ? '<div class="block-editor"><label>Feature layout</label><select data-style="grid_columns"><option value="2" ' + (gridColumns.value === '2' ? 'selected' : '') + '>2 columns</option><option value="3" ' + (gridColumns.value === '3' ? 'selected' : '') + '>3 columns</option><option value="4" ' + (gridColumns.value === '4' ? 'selected' : '') + '>4 columns</option></select><label>Card style</label><select data-style="card_layout"><option value="stacked" ' + (cardLayout.value === 'stacked' ? 'selected' : '') + '>Centered (icon above)</option><option value="icon_left" ' + (cardLayout.value === 'icon_left' ? 'selected' : '') + '>Icon left</option></select><label>Card alignment</label><select data-style="card_alignment"><option value="left" ' + (cardAlignment.value === 'left' ? 'selected' : '') + '>Left</option><option value="center" ' + (cardAlignment.value === 'center' ? 'selected' : '') + '>Center</option><option value="right" ' + (cardAlignment.value === 'right' ? 'selected' : '') + '>Right</option></select><label>Card gap <span>' + gridGap.value + 'px</span></label><input data-style="grid_gap" type="range" min="0" max="100" value="' + gridGap.value + '"><label>Feature cards</label>' + blocks.map((block, index) => '<div class="feature-block-control"><div class="feature-block-image">' + (block.previewImage || block.image ? '<img src="' + escape(block.previewImage || ('/' + String(block.image).replace(/^\//, ''))) + '" alt="">' : '<b>' + escape(block.icon || '✦') + '</b>') + '<button type="button" data-block-image="' + index + '">' + (block.image ? 'Replace image' : 'Add image') + '</button></div><input data-block="' + index + '" data-block-key="icon" value="' + escape(block.icon || '') + '" maxlength="4" aria-label="Icon"><input data-block="' + index + '" data-block-key="title" value="' + escape(block.title || '') + '" aria-label="Title"><textarea data-block="' + index + '" data-block-key="text" aria-label="Description">' + escape(block.text || '') + '</textarea><button type="button" data-remove-block="' + index + '">Remove</button></div>').join('') + '<button type="button" class="add-feature-block">+ Add card</button></div>' : '';
    const extraElementControls = type === 'feature_grid' ? '<div class="block-editor"><label>Extra section elements</label>' + extraElements.map((element, index) => '<div class="feature-block-control extra-element-control"><select data-extra="' + index + '" data-extra-key="type"><option value="heading" ' + (element.type === 'heading' ? 'selected' : '') + '>Heading</option><option value="subheading" ' + (element.type === 'subheading' ? 'selected' : '') + '>Sub heading</option></select><input data-extra="' + index + '" data-extra-key="text" value="' + escape(element.text || '') + '"><label>Colour</label><input data-extra="' + index + '" data-extra-key="color" type="color" value="' + escape(element.color || (element.type === 'heading' ? textColor.value : descriptionColor.value)) + '"><label>Size</label><input data-extra="' + index + '" data-extra-key="size" type="range" min="12" max="56" value="' + escape(element.size || (element.type === 'heading' ? headingSize.value : descriptionSize.value)) + '"><label>Padding</label><input data-extra="' + index + '" data-extra-key="padding" type="range" min="0" max="100" value="' + escape(element.padding || 0) + '"><label>Margin</label><input data-extra="' + index + '" data-extra-key="margin" type="range" min="0" max="100" value="' + escape(element.margin || 0) + '"><button type="button" data-remove-extra="' + index + '">Remove</button></div>').join('') + '<div class="extra-element-actions"><button type="button" class="add-extra-heading">+ Add heading</button><button type="button" class="add-extra-subheading">+ Add sub heading</button></div></div>' : '';
    const targetLabel = target === 'section' ? 'Section' : (target === 'image' ? 'Image' : (target === 'heading' ? 'Heading text' : 'Subtext'));
    const elementControls = target === 'section' ? '<label>Background</label><input data-style="background_color" type="color" value="' + background.value + '"><label>Padding horizontal <span>' + paddingX.value + 'px</span></label><input data-style="padding_x" type="range" min="0" max="160" value="' + paddingX.value + '"><label>Padding vertical <span>' + padding.value + 'px</span></label><input data-style="padding_y" type="range" min="0" max="160" value="' + padding.value + '"><label>Margin horizontal <span>' + marginX.value + 'px</span></label><input data-style="margin_x" type="range" min="0" max="120" value="' + marginX.value + '"><label>Margin vertical <span>' + margin.value + 'px</span></label><input data-style="margin_y" type="range" min="0" max="120" value="' + margin.value + '">' : (target === 'image' ? '<label>Image width <span>' + imageSize.value + '%</span></label><input data-style="image_size" type="range" min="20" max="' + (type === 'image' ? '100' : '75') + '" value="' + imageSize.value + '"><div class="image-size-progress" aria-hidden="true"><span style="width:' + imageSize.value + '%"></span></div><small class="image-help">Hover the image to add or replace it.</small>' : '<label>Text alignment</label><select data-style="text_align"><option value="left" ' + (textAlign.value === 'left' ? 'selected' : '') + '>Left</option><option value="center" ' + (textAlign.value === 'center' ? 'selected' : '') + '>Center</option><option value="right" ' + (textAlign.value === 'right' ? 'selected' : '') + '>Right</option></select>' + (target === 'heading' ? '<label>Heading colour</label><input data-style="text_color" type="color" value="' + textColor.value + '"><label>Heading size <span>' + headingSize.value + 'px</span></label><input data-style="heading_size" type="range" min="16" max="72" value="' + headingSize.value + '">' : '<label>Description colour</label><input data-style="description_color" type="color" value="' + descriptionColor.value + '"><label>Description size <span>' + descriptionSize.value + 'px</span></label><input data-style="description_size" type="range" min="12" max="36" value="' + descriptionSize.value + '">') + '<label>Element padding <span>' + elementData.styles[target].padding_y + 'px</span></label><input data-element-style="padding_y" type="range" min="0" max="120" value="' + elementData.styles[target].padding_y + '"><label>Element margin <span>' + elementData.styles[target].margin_y + 'px</span></label><input data-element-style="margin_y" type="range" min="0" max="120" value="' + elementData.styles[target].margin_y + '">');
    const formatControls = (target === 'heading' || target === 'content') ? '<div class="text-format-controls" aria-label="Text formatting"><span>Text style</span><button type="button" data-format="font_weight" data-format-value="bold" class="' + (elementData.styles[target].font_weight === 'bold' ? 'is-active' : '') + '"><b>B</b></button><button type="button" data-format="font_style" data-format-value="italic" class="' + (elementData.styles[target].font_style === 'italic' ? 'is-active' : '') + '"><i>I</i></button><button type="button" data-format="text_decoration" data-format-value="underline" class="' + (elementData.styles[target].text_decoration === 'underline' ? 'is-active' : '') + '"><u>U</u></button></div>' : '';
    stylePanel.innerHTML = '<div class="builder-inspector-title"><span>' + targetLabel + ' design</span><span>◐</span></div><button type="button" class="delete-selected-section">Delete section</button>' + (target === 'section' ? imageControl + blockControls + extraElementControls : '') + elementControls + formatControls + (target === 'section' ? '<button type="button" class="apply-section-spacing">Apply this spacing to all sections</button>' : '');
    stylePanel.querySelectorAll('[data-style]').forEach(control => {
      const update = () => {
        ensureField(card, control.dataset.style, '').value = control.value;
        control.previousElementSibling?.querySelector('span') && (control.previousElementSibling.querySelector('span').textContent = control.value + (control.dataset.style === 'image_size' ? '%' : 'px'));
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
    stylePanel.querySelectorAll('[data-block]').forEach(control => control.addEventListener('input', () => { blocks[control.dataset.block][control.dataset.blockKey] = control.value; blocksField.value = JSON.stringify(blocks); render(); }));
    stylePanel.querySelectorAll('[data-extra]').forEach(control => control.addEventListener('input', () => { extraElements[control.dataset.extra][control.dataset.extraKey] = control.value; elementsField.value = JSON.stringify(extraElements); render(); }));
    const addExtra = type => { extraElements.push({ type, text: type === 'heading' ? 'New heading' : 'New sub heading', color: type === 'heading' ? textColor.value : descriptionColor.value, size: type === 'heading' ? headingSize.value : descriptionSize.value, padding: 0, margin: 0 }); elementsField.value = JSON.stringify(extraElements); renderStyles(card, target); render(); };
    stylePanel.querySelector('.add-extra-heading')?.addEventListener('click', () => addExtra('heading'));
    stylePanel.querySelector('.add-extra-subheading')?.addEventListener('click', () => addExtra('subheading'));
    stylePanel.querySelectorAll('[data-remove-extra]').forEach(button => button.addEventListener('click', () => { extraElements.splice(button.dataset.removeExtra, 1); elementsField.value = JSON.stringify(extraElements); renderStyles(card, target); render(); }));
    stylePanel.querySelectorAll('[data-block-image]').forEach(button => button.addEventListener('click', () => { const index = button.dataset.blockImage; let input = card.querySelector('[data-block-upload="' + index + '"]'); if (!input) { input = document.createElement('input'); input.type = 'file'; input.accept = 'image/*'; input.hidden = true; input.dataset.blockUpload = index; input.name = blocksField.name.replace('[blocks]', '[block_images][' + index + ']'); card.appendChild(input); input.addEventListener('change', () => { const file = input.files?.[0]; if (!file) return; const reader = new FileReader(); reader.onload = event => { let previews = {}; try { previews = JSON.parse(card.dataset.blockPreviews || '{}'); } catch (_) {} previews[index] = event.target.result; card.dataset.blockPreviews = JSON.stringify(previews); render(); renderStyles(card, target); }; reader.readAsDataURL(file); }); } input.click(); }));
    stylePanel.querySelector('.add-feature-block')?.addEventListener('click', () => { blocks.push({ icon: '✦', title: 'New feature', text: 'Describe the benefit.' }); blocksField.value = JSON.stringify(blocks); renderStyles(card); render(); });
    stylePanel.querySelectorAll('[data-remove-block]').forEach(button => button.addEventListener('click', () => { blocks.splice(button.dataset.removeBlock, 1); blocksField.value = JSON.stringify(blocks); renderStyles(card); render(); }));
    stylePanel.querySelector('.delete-selected-section')?.addEventListener('click', () => { if (!confirm('Delete this section?')) return; card.remove(); stylePanel.innerHTML = '<div class="builder-inspector-title"><span>Design</span><span>◐</span></div><div class="section-empty">Select a section on the canvas</div>'; render(); });
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
      previewSection.style.setProperty('padding', paddingY + 'px ' + paddingX + 'px', 'important');
      previewSection.style.setProperty('margin', marginY + 'px ' + marginX + 'px', 'important');
      previewSection.style.boxSizing = 'border-box';
      previewSection.style.setProperty('text-align', textAlign, 'important');
      const imageMarkup = '<div class="preview-image-frame">' + (image ? '<img class="preview-section-image" src="' + escape(image) + '" alt="">' : '<div class="preview-image-empty">Image area</div>') + '<button type="button" class="preview-image-action">' + (image ? 'Replace image' : 'Add image') + '</button></div>';
      const gridColumns = Math.max(2, Math.min(4, Number(getValue(card, 'grid_columns') || 3)));
      const gridMarkup = '<div class="preview-grid-heading"><h3 contenteditable="true" data-preview-field="heading" style="color:' + escape(textColor) + ';font-size:' + escape(headingSize) + 'px">' + escape(heading) + '</h3>' + extraElements.map(element => element.type === 'heading' ? '<h3 style="color:' + escape(element.color || textColor) + ';font-size:' + escape(element.size || headingSize) + 'px;padding:' + escape(element.padding || 0) + 'px;margin:' + escape(element.margin || 0) + 'px">' + escape(element.text) + '</h3>' : '<p style="color:' + escape(element.color || descriptionColor) + ';font-size:' + escape(element.size || descriptionSize) + 'px;padding:' + escape(element.padding || 0) + 'px;margin:' + escape(element.margin || 0) + 'px">' + escape(element.text) + '</p>').join('') + '<p contenteditable="true" data-preview-field="content" style="color:' + escape(descriptionColor) + ';font-size:' + escape(descriptionSize) + 'px">' + escape(text) + '</p></div><div class="preview-feature-grid" style="grid-template-columns:repeat(' + gridColumns + ', minmax(0,1fr));gap:' + escape(getValue(card, 'grid_gap') || '24') + 'px">' + blocks.map(block => '<div class="preview-feature ' + (getValue(card, 'card_layout') === 'icon_left' ? 'is-icon-left' : 'is-stacked') + '" style="text-align:' + escape(getValue(card, 'card_alignment') || 'center') + '">' + (block.previewImage || block.image ? '<img src="' + escape(block.previewImage || ('/' + String(block.image).replace(/^\//, ''))) + '" alt="">' : '<b>' + escape(block.icon || '✦') + '</b>') + '<div><h4>' + escape(block.title || 'Feature title') + '</h4>' + (block.text ? '<p>' + escape(block.text) + '</p>' : '') + '</div></div>').join('') + '</div>';
      previewSection.innerHTML = type === 'feature_grid' ? gridMarkup : (type === 'image' ? '<div class="preview-image-hero">' + imageMarkup + '</div>' : '<div class="preview-section-row ' + (position === 'right' ? 'is-right' : '') + '">' + (type === 'image_text' ? imageMarkup : '') + '<div class="preview-section-copy"><small>' + escape(type.replace('_', ' + ')) + '</small><h3 contenteditable="true" data-preview-field="heading" style="color:' + escape(textColor) + ';font-size:' + escape(headingSize) + 'px">' + escape(heading) + '</h3><p contenteditable="true" data-preview-field="content" style="color:' + escape(descriptionColor) + ';font-size:' + escape(descriptionSize) + 'px">' + escape(text) + '</p>' + (button ? '<span class="preview-cta">' + escape(button) + '</span>' : '') + '</div></div>');
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
      previewSection.querySelectorAll('.preview-section-copy, .preview-grid-heading, [data-preview-field], .preview-section-copy small').forEach(element => element.style.setProperty('text-align', textAlign, 'important'));
      const imageFrame = previewSection.querySelector('.preview-image-frame');
      if (imageFrame && (type === 'image_text' || type === 'image')) { imageFrame.style.width = (getValue(card, 'image_size') || (type === 'image' ? '100' : '42')) + '%'; }
      if (imageFrame) { imageFrame.addEventListener('click', event => { event.stopPropagation(); const action = event.target.closest('.preview-image-action'); if (action) { imageInput?.click(); return; } focusCard(card, 'image'); }); }
      [['heading', '[data-preview-field="heading"]'], ['content', '[data-preview-field="content"]']].forEach(([key, selector]) => previewSection.querySelectorAll(selector).forEach(element => { const style = selectedStyles[key]; element.style.padding = style.padding_y + 'px ' + style.padding_x + 'px'; element.style.margin = style.margin_y + 'px ' + style.margin_x + 'px'; element.style.fontWeight = style.font_weight; element.style.fontStyle = style.font_style; element.style.textDecoration = style.text_decoration; }));
      previewSection.addEventListener('click', event => { const editable = event.target.closest('[contenteditable]'); const target = editable?.dataset.previewField || 'section'; focusCard(card, target); if (editable) editable.classList.add('is-editing'); });
      content.appendChild(previewSection);
      const layer = document.createElement('div');
      layer.className = 'section-tree'; layer.dataset.builderId = card.dataset.builderId;
      const treeLabel = type === 'image' ? 'Full-width image' : heading;
      layer.innerHTML = '<div class="section-tree-header"><button type="button" class="section-layer"><span>☷ ' + escape(treeLabel) + '</span><small>' + escape(type.replace('_', ' + ')) + '</small></button><button type="button" class="section-tree-toggle" aria-label="Collapse section" aria-expanded="true">⌃</button></div><div class="section-tree-children"></div>';
      const root = layer.querySelector('.section-layer');
      root.draggable = true;
      root.dataset.treeTarget = 'section';
      root.addEventListener('click', () => focusCard(card, 'section'));
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
