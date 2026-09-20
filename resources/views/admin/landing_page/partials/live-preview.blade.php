<script>
(() => {
  const sections = document.getElementById('sections');
  const canvas = document.querySelector('.builder-canvas');
  const inspector = document.querySelector('.builder-inspector');
  if (!sections || !canvas || !inspector) return;
  // Settings are kept in a modal; Laravel remains the source of validation so a
  // hidden browser-required field can never block the Publish action.
  document.getElementById('landing-page-form').noValidate = true;
  const builderForm = document.getElementById('landing-page-form');
  let builderDirty = false;

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
  elementToolbar.innerHTML = '<button type="button" data-toolbar-action="edit">Edit</button><button type="button" data-toolbar-action="link">Link</button><button type="button" data-toolbar-action="align">Align</button><button type="button" data-toolbar-action="duplicate">Duplicate</button><button type="button" data-toolbar-action="delete">Delete</button>';
  document.body.appendChild(elementToolbar);

  const addBar = document.createElement('div');
  addBar.className = 'canvas-add-bar';
  addBar.innerHTML = '<button type="button" class="add-section-primary">＋ Add section</button>';
  canvas.appendChild(addBar);
  const picker = document.createElement('div');
  picker.className = 'template-picker';
  picker.innerHTML = '<div class="template-picker-backdrop"></div><div class="template-picker-dialog" role="dialog" aria-modal="true"><button type="button" class="template-picker-close" aria-label="Close">×</button><h3>Add a section</h3><p>Choose a ready-to-edit starting layout.</p><div class="template-picker-grid"><button data-template="services"><b>▦</b><strong>Services</strong><small>Repeatable service cards</small></button><button data-template="text"><b>¶</b><strong>Heading + Subtext</strong><small>Heading and description</small></button><button data-template="custom_columns"><b>▥</b><strong>Empty section</strong><small>Build a 1-, 2-, or 3-column layout</small></button><button data-template="image_text"><b>▣</b><strong>Image + text</strong><small>Two-column story</small></button><button data-template="feature_grid"><b>▦</b><strong>Cards / features</strong><small>Repeatable benefit cards</small></button><button data-template="testimonial"><b>★</b><strong>Testimonials</strong><small>Use existing client reviews</small></button><button data-template="faq"><b>?</b><strong>FAQ</strong><small>Common questions and answers</small></button><button data-template="contact"><b>✉</b><strong>Contact</strong><small>Contact call to action</small></button><button data-template="image"><b>▤</b><strong>Full image</strong><small>Image or visual break</small></button><button data-template="cta"><b>↗</b><strong>Button / CTA</strong><small>Prompt people to act</small></button></div><div class="template-saved-blocks"><strong>Saved blocks</strong><div data-saved-block-list><small>No saved blocks yet. Select a section and save it from Page structure.</small></div></div></div>';
  document.body.appendChild(picker);
  const openPicker = () => picker.classList.add('is-open');
  const closePicker = () => picker.classList.remove('is-open');
  const savedBlocksKey = 'yogintra-builder-saved-blocks-v1';
  const savedBlocks = () => { try { return JSON.parse(localStorage.getItem(savedBlocksKey) || '[]'); } catch (_) { return []; } };
  const paintSavedBlocks = () => {
    const list = picker.querySelector('[data-saved-block-list]');
    const blocks = savedBlocks();
    list.innerHTML = blocks.length ? blocks.map((block, index) => '<button type="button" data-saved-block="' + index + '">' + escape(block.name) + '</button>').join('') : '<small>No saved blocks yet. Select a section and save it from Page structure.</small>';
  };
  addBar.querySelector('.add-section-primary').addEventListener('click', openPicker);
  picker.addEventListener('click', event => {
    if (event.target.classList.contains('template-picker-backdrop') || event.target.closest('.template-picker-close')) { closePicker(); return; }
    const savedBlock = event.target.closest('[data-saved-block]');
    if (savedBlock) {
      const block = savedBlocks()[Number(savedBlock.dataset.savedBlock)];
      if (!block?.markup) return;
      const holder = document.createElement('div'); holder.innerHTML = block.markup;
      const card = holder.firstElementChild;
      if (!card) return;
      card.dataset.builderId = '';
      sections.appendChild(card); normalizeSectionIndexes(); render(); focusCard([...sections.querySelectorAll('.page-builder-section')].at(-1)); queueSnapshot(); closePicker(); return;
    }
    const template = event.target.closest('[data-template]');
    if (!template) return;
    const type = template.dataset.template;
    const templateAlias = { services: 'feature_grid', contact: 'cta' };
    const resolvedType = templateAlias[type] || type;
    const sourceType = ['image', 'feature_grid', 'custom_columns', 'testimonial', 'faq'].includes(resolvedType) ? 'image_text' : resolvedType;
    document.querySelector('.add-section[data-section-type="' + sourceType + '"]')?.click();
    setTimeout(() => {
      const card = [...sections.querySelectorAll('.page-builder-section')].at(-1);
      const field = card?.querySelector('select[name$="[section_type]"]');
      if (card && type === 'text') { ensureField(card, 'heading', 'Section heading').value = 'Section heading'; ensureField(card, 'content', 'Add text to describe this section.').value = 'Add text to describe this section.'; }
      if (card && type === 'image_text') { ensureField(card, 'heading', 'Section heading').value = 'Section heading'; ensureField(card, 'content', 'Add text to describe this section.').value = 'Add text to describe this section.'; }
      if (card && type === 'cta') { ensureField(card, 'heading', 'Ready to get started?').value = 'Ready to get started?'; ensureField(card, 'content', 'Add a clear next step for your visitors.').value = 'Add a clear next step for your visitors.'; ensureField(card, 'button_text', 'Contact us').value = 'Contact us'; ensureField(card, 'button_url', '/contact').value = '/contact'; }
      if (field && ['image', 'feature_grid', 'custom_columns', 'testimonial', 'faq', 'image_text', 'cta'].includes(resolvedType)) {
        const usesCustomBlocks = resolvedType === 'testimonial' || resolvedType === 'faq';
        if (!field.querySelector('option[value="' + (usesCustomBlocks ? 'custom_columns' : resolvedType) + '"]')) field.add(new Option(({ image: 'Image / Hero', feature_grid: 'Feature grid', custom_columns: 'Empty columns' })[usesCustomBlocks ? 'custom_columns' : resolvedType], usesCustomBlocks ? 'custom_columns' : resolvedType));
        field.value = usesCustomBlocks ? 'custom_columns' : resolvedType;
        if (resolvedType === 'image') ensureField(card, 'image_size', '100').value = '100';
        if (resolvedType === 'feature_grid') {
          const blocks = ensureField(card, 'blocks', '');
          const managedServices = Array.isArray(window.landingBuilderServices) ? window.landingBuilderServices : [];
          const serviceBlocks = managedServices.filter(service => service.os_heading).map(service => ({ image: service.os_image || '', title: service.os_heading, text: '' }));
          blocks.value = JSON.stringify(type === 'services' && serviceBlocks.length ? serviceBlocks : [{ icon: '✚', title: 'Traditional Healing', text: '' }, { icon: '♨', title: 'Improve Health', text: '' }, { icon: '☯', title: 'Holistic Wellness', text: '' }]);
          ensureField(card, 'grid_columns', '3').value = '3';
        }
        if (resolvedType === 'custom_columns') {
          ensureField(card, 'heading', '').value = '';
          ensureField(card, 'content', '').value = '';
          ensureField(card, 'blocks', '[]').value = JSON.stringify([{ type: 'empty' }]);
          ensureField(card, 'grid_columns', '1').value = '1';
        }
        if (resolvedType === 'testimonial') {
          ensureField(card, 'heading', 'What our clients say').value = 'What our clients say';
          ensureField(card, 'content', '').value = '';
          ensureField(card, 'blocks', '[]').value = JSON.stringify([{ type: 'empty' }, { type: 'testimonial', image: '', rating: 5, review: 'YogIntra made my wellness journey feel supported, calm and genuinely personal.' }]);
          ensureField(card, 'grid_columns', '1').value = '1';
          ensureField(card, 'text_align', 'center').value = 'center';
        }
        if (resolvedType === 'faq') {
          ensureField(card, 'heading', 'Frequently asked questions').value = 'Frequently asked questions';
          ensureField(card, 'content', '').value = '';
          ensureField(card, 'blocks', '[]').value = JSON.stringify([{ type: 'empty' }, { type: 'faq', question: 'What would you like to know?', answer: 'Add a clear and helpful answer for visitors.' }]);
          ensureField(card, 'grid_columns', '1').value = '1';
          ensureField(card, 'text_align', 'center').value = 'center';
        }
        if (type === 'contact') { ensureField(card, 'heading', 'Ready to begin?').value = 'Ready to begin?'; ensureField(card, 'content', 'Talk to our team about the right yoga service for you.').value = 'Talk to our team about the right yoga service for you.'; ensureField(card, 'button_text', 'Contact us').value = 'Contact us'; ensureField(card, 'button_url', '/contact').value = '/contact'; ensureField(card, 'text_align', 'center').value = 'center'; }
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

  const inspectorTabs = document.createElement('div');
  inspectorTabs.className = 'builder-inspector-tabs';
  inspectorTabs.innerHTML = '<button type="button" class="is-active" data-inspector-tab="editor">Editor</button><button type="button" data-inspector-tab="elements">Elements</button>';
  inspector.insertBefore(inspectorTabs, stylePanel);
  const elementsPanel = document.createElement('div');
  elementsPanel.className = 'builder-elements-panel';
  elementsPanel.innerHTML = '<p>Drag an element onto a section, or select a section and click an item.</p><div class="builder-element-library"><button type="button" draggable="true" data-library-element="heading"><b>H</b><span>Heading</span></button><button type="button" draggable="true" data-library-element="subtext"><b>¶</b><span>Subtext</span></button><button type="button" draggable="true" data-library-element="button"><b>↗</b><span>Button</span></button><button type="button" draggable="true" data-library-element="bullets"><b>•</b><span>Bullet list</span></button><button type="button" draggable="true" data-library-element="image"><b>▧</b><span>Image</span></button></div><small>Images add or replace the section image; column sections support up to three draggable columns.</small>';
  inspector.insertBefore(elementsPanel, stylePanel);
  const setInspectorTab = tab => {
    inspectorTabs.querySelectorAll('button').forEach(button => button.classList.toggle('is-active', button.dataset.inspectorTab === tab));
    stylePanel.hidden = tab !== 'editor'; elementsPanel.hidden = tab !== 'elements';
  };
  inspectorTabs.addEventListener('click', event => { const tab = event.target.closest('[data-inspector-tab]')?.dataset.inspectorTab; if (tab) setInspectorTab(tab); });
  setInspectorTab('editor');

  const layers = document.createElement('div');
  layers.className = 'section-layers is-collapsed';
  layers.innerHTML = '<button type="button" class="section-layers-toggle" aria-expanded="false"><span>Page structure</span><b id="layer-count">0 sections</b><i class="fas fa-chevron-down" aria-hidden="true"></i></button><div id="section-layers-list"></div>';
  inspector.appendChild(layers);
  layers.querySelector('.section-layers-toggle').addEventListener('click', event => { const expanded = layers.classList.toggle('is-collapsed') === false; event.currentTarget.setAttribute('aria-expanded', String(expanded)); event.currentTarget.querySelector('i').classList.toggle('is-expanded', expanded); });

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
    const markup = richPreview(editable.innerHTML);
    const listMarkup = () => [...editable.children].filter(item => item.tagName === 'LI').map(item => richPreview(item.innerHTML).trim()).filter(Boolean).join('\n');
    if (editable.dataset.previewField) { const field = getField(card, editable.dataset.previewField); if (field) field.value = markup; }
    if (editable.dataset.previewColumn !== undefined) { const blocksField = getField(card, 'blocks'); let blocks = []; try { blocks = JSON.parse(blocksField.value || '[]'); } catch (_) {} if (blocks[Number(editable.dataset.previewColumn)]) { const key = editable.dataset.previewColumnKey; const elementMatch = /^element-(\d+)$/.exec(key); if (elementMatch) { const element = blocks[Number(editable.dataset.previewColumn)].elements?.[Number(elementMatch[1])]; if (element) { if (element.type === 'bullets') element.items = listMarkup(); else element.text = markup; } } else { blocks[Number(editable.dataset.previewColumn)][key] = key === 'bullets' ? listMarkup() : markup; } blocksField.value = JSON.stringify(blocks); } }
    if (editable.dataset.previewExtra !== undefined) { const elementsField = getField(card, 'elements'); let elements = []; try { elements = JSON.parse(elementsField.value || '[]'); } catch (_) {} if (elements[Number(editable.dataset.previewExtra)]) { elements[Number(editable.dataset.previewExtra)].text = markup; elementsField.value = JSON.stringify(elements); } }
    if (editable.dataset.previewExtraList !== undefined) { const elementsField = getField(card, 'elements'); let elements = []; try { elements = JSON.parse(elementsField.value || '[]'); } catch (_) {} if (elements[Number(editable.dataset.previewExtraList)]) { elements[Number(editable.dataset.previewExtraList)].items = listMarkup(); elementsField.value = JSON.stringify(elements); } }
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
  const queueSnapshot = () => { builderDirty = true; window.clearTimeout(historyTimer); historyTimer = window.setTimeout(snapshot, 350); setSaveState('Unsaved changes'); };
  const flushSnapshot = () => { window.clearTimeout(historyTimer); snapshot(); };
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
  const addElementToSection = (card, type, targetColumnIndex = null) => {
    if (!card || !type) return;
    const sectionType = getValue(card, 'section_type');
    if (sectionType === 'custom_columns') {
      const blocksField = ensureField(card, 'blocks', '[]'); let blocks = []; try { blocks = JSON.parse(blocksField.value || '[]'); } catch (_) {}
      const gridColumns = ensureField(card, 'grid_columns', '1');
      const visibleColumns = Math.max(1, Number(gridColumns.value));
      const requestedColumn = targetColumnIndex !== null && targetColumnIndex < visibleColumns ? targetColumnIndex : -1;
      const firstEmptyColumn = blocks.slice(0, visibleColumns).findIndex(block => block?.type === 'empty');
      const columnIndex = requestedColumn >= 0 ? requestedColumn : (firstEmptyColumn >= 0 ? firstEmptyColumn : 0);
      const element = type === 'heading' ? { type:'heading', text:'New heading' } : type === 'subtext' ? { type:'subtext', text:'Add supporting text.' } : type === 'bullets' ? { type:'bullets', items:'First point\nSecond point\nThird point' } : type === 'button' ? { type:'button', button_text:'Button label', button_url:'#' } : { type:'image', image:'', image_size:100 };
      const currentBlock = blocks[columnIndex] || { type:'empty' };
      if (currentBlock.type === 'empty') {
        // Images are elements too. Keeping them in the column's ordered stack
        // means they can be dragged above or below any later text or button.
        blocks[columnIndex] = { type:'stack', elements:[element], image:'', image_size:100 };
      } else {
        // Convert older image-only columns into the same flexible stack before
        // appending another element, preserving the already selected image.
        if (currentBlock.type === 'image') {
          currentBlock.type = 'stack';
          currentBlock.elements = [{ type:'image', image_size:currentBlock.image_size ?? 100 }];
        }
        currentBlock.elements ||= [];
        currentBlock.elements.push(element);
        blocks[columnIndex] = currentBlock;
      }
      blocksField.value = JSON.stringify(blocks);
      render(); focusCard(card, type === 'image' ? 'column-' + columnIndex + '-image' : 'section'); queueSnapshot();
      if (type === 'image') {
        // A dropped image belongs to this column, not to the section's legacy
        // image input. Use a column upload field so the selected file reaches
        // both the immediate preview and the section save payload.
        let input = card.querySelector('[data-block-upload="' + columnIndex + '"]');
        if (!input) {
          input = document.createElement('input'); input.type = 'file'; input.accept = 'image/*'; input.hidden = true;
          input.dataset.blockUpload = columnIndex;
          input.name = blocksField.name.replace('[blocks]', '[block_images][' + columnIndex + ']');
          card.appendChild(input);
          input.addEventListener('change', () => {
            const file = input.files?.[0]; if (!file) return;
            const reader = new FileReader();
            reader.onload = loaded => {
              let previews = {}; try { previews = JSON.parse(card.dataset.blockPreviews || '{}'); } catch (_) {}
              previews[columnIndex] = loaded.target.result;
              card.dataset.blockPreviews = JSON.stringify(previews);
              render(); focusCard(card, 'column-' + columnIndex + '-image'); queueSnapshot();
            };
            reader.readAsDataURL(file);
          });
        }
        input.value = '';
        input.click();
      }
      return;
    }
    if (type === 'image') { focusCard(card, 'image'); card.querySelector('input[type=file]')?.click(); return; }
    if (type === 'button') { ensureField(card, 'button_text', 'Button label').value ||= 'Button label'; ensureField(card, 'button_url', '#').value ||= '#'; render(); focusCard(card, 'section'); queueSnapshot(); return; }
    const elementsField = ensureField(card, 'elements', '[]'); let elements = []; try { elements = JSON.parse(elementsField.value || '[]'); } catch (_) {}
    elements.push(type === 'heading' ? { type:'heading', text:'New heading', color:getValue(card, 'text_color') || '#183c45', size:Number(getValue(card, 'heading_size') || 32), padding:0, margin:0 } : type === 'bullets' ? { type:'bullet_list', items:'First point\nSecond point\nThird point', color:getValue(card, 'description_color') || '#647b82', size:Number(getValue(card, 'description_size') || 16), item_gap:8, padding:0, margin:0 } : { type:'subheading', text:'Add supporting text.', color:getValue(card, 'description_color') || '#647b82', size:Number(getValue(card, 'description_size') || 16), padding:0, margin:0 });
    elementsField.value = JSON.stringify(elements); render(); focusCard(card, 'extra-' + (elements.length - 1)); queueSnapshot();
  };
  elementsPanel.querySelectorAll('[data-library-element]').forEach(item => {
    item.addEventListener('dragstart', event => { event.dataTransfer.effectAllowed = 'copy'; event.dataTransfer.setData('application/x-builder-element', item.dataset.libraryElement); });
    item.addEventListener('click', () => { const selected = sections.querySelector('.page-builder-section.is-selected'); if (!selected) { alert('Select a section first, then choose an element.'); return; } addElementToSection(selected, item.dataset.libraryElement); });
  });
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
  paintSavedBlocks();
  const listItems = element => String(element.items || '').split(/\r?\n/).map(item => item.trim()).filter(Boolean);
  const previewExtraElement = (element, index, textColor, headingSize, descriptionColor, descriptionSize) => {
    const color = escape(element.color || (element.type === 'heading' ? textColor : descriptionColor));
    const size = escape(element.size || (element.type === 'heading' ? headingSize : descriptionSize));
    const spacing = 'padding:' + escape(element.padding_top ?? element.padding ?? 0) + 'px ' + escape(element.padding_right ?? element.padding ?? 0) + 'px ' + escape(element.padding_bottom ?? element.padding ?? 0) + 'px ' + escape(element.padding_left ?? element.padding ?? 0) + 'px;margin:' + escape(element.margin_top ?? element.margin ?? 0) + 'px ' + escape(element.margin_right ?? element.margin ?? 0) + 'px ' + escape(element.margin_bottom ?? element.margin ?? 0) + 'px ' + escape(element.margin_left ?? element.margin ?? 0) + 'px';
    if (element.type === 'bullet_list' || element.type === 'numbered_list') {
      const tag = element.type === 'numbered_list' ? 'ol' : 'ul';
      const items = listItems(element);
      return '<' + tag + ' class="preview-builder-list" contenteditable="true" data-preview-extra-list="' + index + '" style="color:' + color + ';font-size:' + size + 'px;' + spacing + ';--list-item-gap:' + escape(element.item_gap ?? 8) + 'px">' + (items.length ? items.map(item => '<li>' + richPreview(item) + '</li>').join('') : '<li>Add list items in the editor</li>') + '</' + tag + '>';
    }
    return element.type === 'heading'
      ? '<h3 contenteditable="true" data-preview-extra="' + index + '" style="color:' + color + ';font-size:' + size + 'px;' + spacing + '">' + richPreview(element.text) + '</h3>'
      : '<p contenteditable="true" data-preview-extra="' + index + '" style="color:' + color + ';font-size:' + size + 'px;' + spacing + '">' + richPreview(element.text) + '</p>';
  };
  const focusCard = (card, target = 'section') => {
    document.querySelectorAll('.page-builder-section, .preview-section, .section-layer, .section-tree-child, .preview-image-frame, .preview-section [data-preview-field], .preview-section [data-preview-column-target]').forEach(element => element.classList.remove('is-selected', 'is-selected-target'));
    card.classList.add('is-selected');
    card.dataset.selectedTarget = target;
    const selectedElement = inspector.querySelector('[data-selected-element]');
    selectedElement?.closest('.builder-selected-element')?.classList.remove('is-empty');
    const columnTarget = /^column-\d+-(title|text|small_text|bullets|image|button|testimonial|faq|container)$/.exec(target);
    const stackedTarget = /^column-(\d+)-element-(\d+)$/.exec(target);
    let stackedLabel = null;
    if (stackedTarget) {
      const blocksField = getField(card, 'blocks'); let blocks = [];
      try { blocks = JSON.parse(blocksField?.value || '[]'); } catch (_) {}
      const elementType = blocks[Number(stackedTarget[1])]?.elements?.[Number(stackedTarget[2])]?.type;
      stackedLabel = ({ heading:'Heading', subtext:'Subtext', bullets:'Bullet list', button:'Button', image:'Image' })[elementType] || 'Element';
    }
    const selectedLabel = stackedLabel || (columnTarget
      ? ({ title: 'Heading', text: 'Text', small_text: 'Supporting text', bullets: 'Bullet list', image: 'Image', button: 'Button', testimonial: 'Testimonial', faq: 'FAQ', container: 'Column' })[columnTarget[1]]
      : ({ section: 'Section', heading: 'Heading', content: 'Text', image: 'Image' })[target] || 'Section');
    if (selectedElement) selectedElement.textContent = selectedLabel;
    document.querySelectorAll('[data-builder-id="' + card.dataset.builderId + '"]').forEach(element => element.classList.add('is-selected'));
    const previewSection = document.querySelector('.preview-section[data-builder-id="' + card.dataset.builderId + '"]');
    const tree = document.querySelector('.section-tree[data-builder-id="' + card.dataset.builderId + '"]');
    tree?.classList.remove('is-collapsed');
    if (tree) { const toggle = tree.querySelector('.section-tree-toggle'); toggle?.setAttribute('aria-expanded', 'true'); toggle?.classList.add('is-expanded'); }
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
    if (action === 'duplicate') {
      if (target === 'section') { const copy = card.cloneNode(true); copy.dataset.builderId = ''; sections.insertBefore(copy, card.nextSibling); normalizeSectionIndexes(); render(); queueSnapshot(); return; }
      const elementsField = getField(card, 'elements'); let elements = []; try { elements = JSON.parse(elementsField?.value || '[]'); } catch (_) {}
      const extraTarget = /^extra-(\d+)$/.exec(target);
      if (extraTarget && elements[Number(extraTarget[1])]) {
        elements.splice(Number(extraTarget[1]) + 1, 0, JSON.parse(JSON.stringify(elements[Number(extraTarget[1])])));
      } else if (target === 'heading' || target === 'content') {
        elements.push({ type: target === 'heading' ? 'heading' : 'subheading', text: getValue(card, target), items: '', item_gap: 8, color: target === 'heading' ? getValue(card, 'text_color') : getValue(card, 'description_color'), size: Number(target === 'heading' ? getValue(card, 'heading_size') : getValue(card, 'description_size')), padding: 0, margin: 0 });
      } else { return; }
      if (elementsField) elementsField.value = JSON.stringify(elements);
      render(); queueSnapshot(); return;
    }
    if (action === 'delete') {
      if (target === 'section') { card.remove(); normalizeSectionIndexes(); elementToolbar.classList.remove('is-open'); render(); queueSnapshot(); return; }
      const extraTarget = /^extra-(\d+)$/.exec(target);
      if (extraTarget) { const elementsField = getField(card, 'elements'); let elements = []; try { elements = JSON.parse(elementsField?.value || '[]'); } catch (_) {} elements.splice(Number(extraTarget[1]), 1); if (elementsField) elementsField.value = JSON.stringify(elements); render(); queueSnapshot(); }
      return;
    }
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
    const imageAlt = ensureField(card, 'image_alt', '');
    // Give every image a useful accessibility baseline without replacing
    // anything the editor has explicitly written.
    if (!imageAlt.value.trim()) {
      const headingForAlt = getValue(card, 'heading').replace(/<[^>]*>/g, '').trim();
      const imagePathForAlt = getValue(card, 'existing_image');
      const fileNameForAlt = imagePathForAlt.split('/').pop()?.replace(/\.[^.]+$/, '').replace(/[-_]+/g, ' ').trim();
      imageAlt.value = headingForAlt ? headingForAlt + ' image' : (fileNameForAlt || 'YogIntra image');
    }
    const imageCrop = ensureField(card, 'image_crop', 'original');
    const imageFocalX = ensureField(card, 'image_focal_x', '50');
    const imageFocalY = ensureField(card, 'image_focal_y', '50');
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
    const extraTarget = /^extra-(\d+)$/.exec(target);
    if (extraTarget) {
      const index = Number(extraTarget[1]);
      const element = extraElements[index];
      if (!element) { focusCard(card, 'section'); return; }
      const isList = ['bullet_list', 'numbered_list'].includes(element.type);
      const label = element.type === 'heading' ? 'Heading' : (isList ? 'List' : 'Subtext');
      const side = (sideLabel, key, fallback) => '<label>' + sideLabel + '<span class="button-side-input"><input data-extra="' + index + '" data-extra-key="' + key + '" type="number" min="0" max="160" value="' + escape(element[key] ?? fallback ?? 0) + '"><em>px</em></span></label>';
      const spacing = '<div class="column-spacing-controls"><strong>Padding</strong><div class="button-side-controls">' + side('Top', 'padding_top', element.padding) + side('Right', 'padding_right', element.padding) + side('Bottom', 'padding_bottom', element.padding) + side('Left', 'padding_left', element.padding) + '</div><strong>Margin</strong><div class="button-side-controls">' + side('Top', 'margin_top', element.margin) + side('Right', 'margin_right', element.margin) + side('Bottom', 'margin_bottom', element.margin) + side('Left', 'margin_left', element.margin) + '</div></div>';
      stylePanel.innerHTML = '<div class="builder-inspector-title"><span>' + label + ' design</span><span>◐</span></div><button type="button" class="back-to-column">← Back to section</button>' + (isList ? '<label>List items <small>One item per line</small></label><textarea data-extra="' + index + '" data-extra-key="items" rows="6">' + escape(element.items || '') + '</textarea>' : '<label>Edit ' + label.toLowerCase() + '</label><textarea data-extra="' + index + '" data-extra-key="text" rows="4">' + escape(element.text || '') + '</textarea>') + '<label>Colour</label><input data-extra="' + index + '" data-extra-key="color" type="color" value="' + escape(element.color || (element.type === 'heading' ? textColor.value : descriptionColor.value)) + '"><label>Font size <span>' + escape(element.size || (element.type === 'heading' ? headingSize.value : descriptionSize.value)) + 'px</span></label><input data-extra="' + index + '" data-extra-key="size" type="range" min="12" max="56" value="' + escape(element.size || (element.type === 'heading' ? headingSize.value : descriptionSize.value)) + '">' + spacing;
      stylePanel.querySelectorAll('[data-extra]').forEach(control => { const update = () => { extraElements[index][control.dataset.extraKey] = control.value; elementsField.value = JSON.stringify(extraElements); render(); queueSnapshot(); }; control.addEventListener('input', update); control.addEventListener('change', update); });
      stylePanel.querySelector('.back-to-column')?.addEventListener('click', () => focusCard(card, 'section'));
      return;
    }
    const stackedElementTarget = type === 'custom_columns' && /^column-(\d+)-element-(\d+)$/.exec(target);
    if (stackedElementTarget) {
      const columnIndex = Number(stackedElementTarget[1]);
      const elementIndex = Number(stackedElementTarget[2]);
      const block = blocks[columnIndex] || {};
      const element = block.elements?.[elementIndex];
      if (!element) { focusCard(card, 'section'); return; }
      if (element.type === 'button') {
        element.styles ||= {}; element.styles.width ??= 'auto';
        const buttonDefaults = { padding_top:12, padding_right:24, padding_bottom:12, padding_left:24, margin_top:0, margin_right:0, margin_bottom:0, margin_left:0 };
        Object.entries(buttonDefaults).forEach(([key, value]) => element.styles[key] ??= value);
        blocks[columnIndex] = block; blocksField.value = JSON.stringify(blocks);
        const sideControl = (label, key) => '<label>' + label + '<span class="button-side-input"><input data-stacked-button="' + key + '" type="number" min="0" max="120" value="' + element.styles[key] + '"><em>px</em></span></label>';
        stylePanel.innerHTML = '<div class="builder-inspector-title"><span>Button design</span><span>↗</span></div><button type="button" class="back-to-column">← Back to section</button><label>Button label</label><input data-stacked-button="button_text" value="' + escape(element.button_text || '') + '" placeholder="Button label"><label>Button link</label><input data-stacked-button="button_url" value="' + escape(element.button_url || '') + '" placeholder="/contact or https://..."><label>Button width</label><select data-stacked-button="width"><option value="auto" ' + (element.styles.width === 'auto' ? 'selected' : '') + '>Fit content</option><option value="100%" ' + (element.styles.width === '100%' ? 'selected' : '') + '>Full column width</option></select><div class="column-spacing-controls"><strong>Padding</strong><div class="button-side-controls">' + sideControl('Top', 'padding_top') + sideControl('Right', 'padding_right') + sideControl('Bottom', 'padding_bottom') + sideControl('Left', 'padding_left') + '</div><strong>Margin</strong><div class="button-side-controls">' + sideControl('Top', 'margin_top') + sideControl('Right', 'margin_right') + sideControl('Bottom', 'margin_bottom') + sideControl('Left', 'margin_left') + '</div></div>';
        const updateButton = control => {
          const key = control.dataset.stackedButton;
          if (['button_text', 'button_url'].includes(key)) element[key] = control.value;
          else element.styles[key] = key === 'width' ? control.value : Number(control.value);
          const previewButton = preview.querySelector('[data-preview-column-target="' + target + '"]');
          if (previewButton) {
            if (key === 'button_text') previewButton.textContent = element.button_text || 'Button label';
            previewButton.style.width = element.styles.width || 'auto';
            previewButton.style.padding = (element.styles.padding_top ?? 12) + 'px ' + (element.styles.padding_right ?? 24) + 'px ' + (element.styles.padding_bottom ?? 12) + 'px ' + (element.styles.padding_left ?? 24) + 'px';
            const previewRow = previewButton.closest('.preview-draggable-row');
            if (previewRow) {
              previewRow.style.setProperty('--preview-row-margin-top', (element.styles.margin_top ?? 0) + 'px');
              previewRow.style.setProperty('--preview-row-margin-right', (element.styles.margin_right ?? 0) + 'px');
              previewRow.style.setProperty('--preview-row-margin-bottom', (element.styles.margin_bottom ?? 0) + 'px');
              previewRow.style.setProperty('--preview-row-margin-left', (element.styles.margin_left ?? 0) + 'px');
            }
          }
          blocks[columnIndex] = block; blocksField.value = JSON.stringify(blocks); queueSnapshot();
        };
        // Do not redraw this panel on change: rebuilding the canvas while a
        // numeric field is active restored stale values and made margins snap
        // back to zero. The hidden blocks field is updated on every keystroke.
        stylePanel.querySelectorAll('[data-stacked-button]').forEach(control => { control.addEventListener('input', () => updateButton(control)); control.addEventListener('change', () => updateButton(control)); });
        stylePanel.querySelector('.back-to-column')?.addEventListener('click', () => focusCard(card, 'section'));
        return;
      }
      // Heading, subtext and lists added inside a column are independent
      // elements. They need their own inspector rather than falling through
      // to the section-level editor.
      element.styles ||= {};
      const isListElement = element.type === 'bullets';
      const elementLabel = ({ heading: 'Heading', subtext: 'Subtext', bullets: 'Bullet list', image: 'Image' })[element.type] || 'Element';
      const elementDefaults = { color: element.type === 'heading' ? textColor.value : descriptionColor.value, size: element.type === 'heading' ? 24 : 16, align: textAlign.value, padding_top: 0, padding_right: 0, padding_bottom: 0, padding_left: 0, margin_top: 0, margin_right: 0, margin_bottom: 0, margin_left: 0 };
      Object.entries(elementDefaults).forEach(([key, value]) => element.styles[key] ??= value);
      const stackedSide = (side, key) => '<label>' + side + '<span class="button-side-input"><input data-stacked-element="' + key + '" type="number" min="0" max="160" value="' + escape(element.styles[key]) + '"><em>px</em></span></label>';
      const stackedSpacing = '<div class="column-spacing-controls"><strong>Padding</strong><div class="button-side-controls">' + stackedSide('Top', 'padding_top') + stackedSide('Right', 'padding_right') + stackedSide('Bottom', 'padding_bottom') + stackedSide('Left', 'padding_left') + '</div><strong>Margin</strong><div class="button-side-controls">' + stackedSide('Top', 'margin_top') + stackedSide('Right', 'margin_right') + stackedSide('Bottom', 'margin_bottom') + stackedSide('Left', 'margin_left') + '</div></div>';
      const stackedText = isListElement
        ? '<label>List items <small>One item per line</small></label><textarea data-stacked-element="items" rows="6">' + escape(element.items || '') + '</textarea>'
        : '<label>Edit ' + elementLabel.toLowerCase() + '</label><textarea data-stacked-element="text" rows="4">' + escape(element.text || '') + '</textarea>';
      stylePanel.innerHTML = '<div class="builder-inspector-title"><span>' + elementLabel + ' design</span><span>◐</span></div><button type="button" class="back-to-column">← Back to section</button>' + stackedText + '<label>Text alignment</label><select data-stacked-element="align"><option value="left" ' + (element.styles.align === 'left' ? 'selected' : '') + '>Left</option><option value="center" ' + (element.styles.align === 'center' ? 'selected' : '') + '>Center</option><option value="right" ' + (element.styles.align === 'right' ? 'selected' : '') + '>Right</option></select><label>Colour</label><input data-stacked-element="color" type="color" value="' + escape(element.styles.color) + '"><label>Font size <span>' + escape(element.styles.size) + 'px</span></label><input data-stacked-element="size" type="range" min="12" max="56" value="' + escape(element.styles.size) + '">' + stackedSpacing;
      const updateStackedElement = control => {
        const key = control.dataset.stackedElement;
        if (['text', 'items'].includes(key)) element[key] = control.value;
        else element.styles[key] = ['align', 'color'].includes(key) ? control.value : Number(control.value);
        blocks[columnIndex] = block; blocksField.value = JSON.stringify(blocks); render(); queueSnapshot();
      };
      stylePanel.querySelectorAll('[data-stacked-element]').forEach(control => { control.addEventListener('input', () => updateStackedElement(control)); control.addEventListener('change', () => updateStackedElement(control)); });
      stylePanel.querySelector('.back-to-column')?.addEventListener('click', () => focusCard(card, 'section'));
      return;
    }
    const columnTarget = type === 'custom_columns' && /^column-(\d+)-(title|text|small_text|bullets|image|button|testimonial|faq|container)$/.exec(target);
    if (columnTarget) {
      const columnIndex = Number(columnTarget[1]);
      const elementKey = columnTarget[2];
      const block = blocks[columnIndex] || {};
      if (elementKey === 'testimonial') {
        block.rating = Math.max(1, Math.min(5, Number(block.rating || 5)));
        block.review = block.review || 'Share a client experience here.';
        blocks[columnIndex] = block;
        blocksField.value = JSON.stringify(blocks);
        const image = block.previewImage || block.image;
        const testimonialCount = blocks.filter(item => item.type === 'testimonial').length;
        stylePanel.innerHTML = '<div class="builder-inspector-title"><span>Testimonial card</span><span>★</span></div><button type="button" class="back-to-column">← Back to section</button><div class="testimonial-slider-status"><strong>' + testimonialCount + ' card' + (testimonialCount === 1 ? '' : 's') + ' in this slider</strong><span>Add as many cards as you need; visitors see them as one responsive slider.</span></div><div class="testimonial-editor-preview">' + (image ? '<img src="' + escape(block.previewImage || ('/' + String(block.image).replace(/^\//, ''))) + '" alt="">' : '<span>◉</span>') + '<div><b>' + '★'.repeat(block.rating) + '<i>' + '☆'.repeat(5 - block.rating) + '</i></b><p>' + escape(block.review) + '</p></div></div><label>Client image</label><button type="button" class="testimonial-image-button" data-block-image="' + columnIndex + '">' + (image ? 'Replace image' : 'Upload image') + '</button><small>Use a square client photo for the best result.</small><label>Star rating</label><select data-testimonial-field="rating"><option value="5" ' + (block.rating === 5 ? 'selected' : '') + '>5 stars</option><option value="4" ' + (block.rating === 4 ? 'selected' : '') + '>4 stars</option><option value="3" ' + (block.rating === 3 ? 'selected' : '') + '>3 stars</option><option value="2" ' + (block.rating === 2 ? 'selected' : '') + '>2 stars</option><option value="1" ' + (block.rating === 1 ? 'selected' : '') + '>1 star</option></select><label>Review</label><textarea data-testimonial-field="review" rows="6" placeholder="Write the client review">' + escape(block.review) + '</textarea><button type="button" class="add-testimonial-card">＋ Add another testimonial</button><button type="button" class="remove-testimonial-row">Remove testimonial</button>';
        stylePanel.querySelector('.back-to-column')?.addEventListener('click', () => focusCard(card, 'section'));
        stylePanel.querySelectorAll('[data-testimonial-field]').forEach(control => control.addEventListener('input', () => { block[control.dataset.testimonialField] = control.dataset.testimonialField === 'rating' ? Number(control.value) : control.value; blocks[columnIndex] = block; blocksField.value = JSON.stringify(blocks); render(); }));
        stylePanel.querySelector('[data-block-image]')?.addEventListener('click', () => {
          let input = card.querySelector('[data-block-upload="' + columnIndex + '"]');
          if (!input) {
            input = document.createElement('input'); input.type = 'file'; input.accept = 'image/*'; input.hidden = true; input.dataset.blockUpload = columnIndex; input.name = blocksField.name.replace('[blocks]', '[block_images][' + columnIndex + ']'); card.appendChild(input);
            input.addEventListener('change', () => { const file = input.files?.[0]; if (!file) return; const reader = new FileReader(); reader.onload = event => { let previews = {}; try { previews = JSON.parse(card.dataset.blockPreviews || '{}'); } catch (_) {} previews[columnIndex] = event.target.result; card.dataset.blockPreviews = JSON.stringify(previews); render(); focusCard(card, 'column-' + columnIndex + '-testimonial'); }; reader.readAsDataURL(file); });
          }
          input.click();
        });
        stylePanel.querySelector('.add-testimonial-card')?.addEventListener('click', () => {
          blocks.push({ type: 'testimonial', image: '', rating: 5, review: 'YogIntra helped me build a calmer, healthier routine.' });
          blocksField.value = JSON.stringify(blocks);
          render();
          focusCard(card, 'column-' + (blocks.length - 1) + '-testimonial');
          queueSnapshot();
        });
        stylePanel.querySelector('.remove-testimonial-row')?.addEventListener('click', () => { blocks.splice(columnIndex, 1); blocksField.value = JSON.stringify(blocks); focusCard(card, 'section'); render(); queueSnapshot(); });
        return;
      }
      if (elementKey === 'faq') {
        block.question = block.question || 'What would you like to know?';
        block.answer = block.answer || 'Add a clear and helpful answer for visitors.';
        blocks[columnIndex] = block;
        blocksField.value = JSON.stringify(blocks);
        const faqCount = blocks.filter(item => item.type === 'faq').length;
        stylePanel.innerHTML = '<div class="builder-inspector-title"><span>FAQ item</span><span>?</span></div><button type="button" class="back-to-column">← Back to section</button><div class="faq-slider-status"><strong>' + faqCount + ' FAQ' + (faqCount === 1 ? '' : 's') + ' in this section</strong><span>Visitors see these questions together in an accordion.</span></div><div class="faq-editor-preview"><b>Q</b><div><strong>' + escape(block.question) + '</strong><p>' + escape(block.answer) + '</p></div></div><label>Question</label><textarea data-faq-field="question" rows="3" placeholder="Write the question">' + escape(block.question) + '</textarea><label>Answer</label><textarea data-faq-field="answer" rows="6" placeholder="Write a helpful answer">' + escape(block.answer) + '</textarea><button type="button" class="add-faq-card">＋ Add another FAQ</button><button type="button" class="remove-faq-row">Remove FAQ</button>';
        stylePanel.querySelector('.back-to-column')?.addEventListener('click', () => focusCard(card, 'section'));
        stylePanel.querySelectorAll('[data-faq-field]').forEach(control => control.addEventListener('input', () => { block[control.dataset.faqField] = control.value; blocks[columnIndex] = block; blocksField.value = JSON.stringify(blocks); render(); }));
        stylePanel.querySelector('.add-faq-card')?.addEventListener('click', () => { blocks.push({ type: 'faq', question: 'New frequently asked question', answer: 'Add a helpful answer here.' }); blocksField.value = JSON.stringify(blocks); render(); focusCard(card, 'column-' + (blocks.length - 1) + '-faq'); queueSnapshot(); });
        stylePanel.querySelector('.remove-faq-row')?.addEventListener('click', () => { blocks.splice(columnIndex, 1); blocksField.value = JSON.stringify(blocks); focusCard(card, 'section'); render(); queueSnapshot(); });
        return;
      }
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
      const isBulletList = elementKey === 'bullets';
      const textEditor = !isImage && !isButton
        ? (isBulletList
          ? '<label>List items <small>One item per line</small></label><textarea data-column-bullets-editor rows="6" placeholder="First item&#10;Second item&#10;Third item">' + escape(block.bullets || '') + '</textarea><label>Item gap <span>' + escape(style.item_gap ?? block.item_gap ?? 8) + 'px</span></label><input data-column-style="item_gap" type="range" min="0" max="48" value="' + escape(style.item_gap ?? block.item_gap ?? 8) + '">'
          : '<label>Edit ' + label.toLowerCase() + '</label><textarea data-column-text-editor rows="4" placeholder="Paste or type text here">' + escape(block[elementKey] || '') + '</textarea>')
        : '';
      style.color ??= elementKey === 'title' ? textColor.value : descriptionColor.value;
      style.size ??= elementKey === 'title' ? 24 : 16;
      style.padding ??= 0; style.margin ??= 0; style.align ??= textAlign.value;
      const sideDefaults = { padding_top: style.padding, padding_right: style.padding, padding_bottom: style.padding, padding_left: style.padding, margin_top: style.margin, margin_right: style.margin, margin_bottom: style.margin, margin_left: style.margin };
      Object.entries(sideDefaults).forEach(([key, value]) => style[key] ??= value);
      blocks[columnIndex] = block; blocksField.value = JSON.stringify(blocks);
      const sideControl = (side, key) => '<label>' + side + '<span class="button-side-input"><input data-column-style="' + key + '" type="number" min="0" max="160" value="' + escape(style[key]) + '"><em>px</em></span></label>';
      const sideSpacingControls = '<div class="column-spacing-controls"><strong>Padding</strong><div class="button-side-controls">' + sideControl('Top', 'padding_top') + sideControl('Right', 'padding_right') + sideControl('Bottom', 'padding_bottom') + sideControl('Left', 'padding_left') + '</div><strong>Margin</strong><div class="button-side-controls">' + sideControl('Top', 'margin_top') + sideControl('Right', 'margin_right') + sideControl('Bottom', 'margin_bottom') + sideControl('Left', 'margin_left') + '</div></div>';
      stylePanel.innerHTML = '<div class="builder-inspector-title"><span>' + label + ' design</span><span>◐</span></div><button type="button" class="back-to-column">← Back to section</button>' + textEditor + (isButton ? '<label>Button label</label><input data-column-button="button_text" value="' + escape(block.button_text || '') + '"><label>Button URL</label><input data-column-button="button_url" value="' + escape(block.button_url || '') + '" placeholder="/contact or https://..."><small>Both label and URL are required for the live button.</small>' : (isImage ? '<label>Image width <span>' + escape(block.image_size ?? 100) + '%</span></label><input data-column-image-width type="range" min="20" max="100" value="' + escape(block.image_size ?? 100) + '">' : '<label>Text alignment</label><select data-column-style="align"><option value="left" ' + (style.align === 'left' ? 'selected' : '') + '>Left</option><option value="center" ' + (style.align === 'center' ? 'selected' : '') + '>Center</option><option value="right" ' + (style.align === 'right' ? 'selected' : '') + '>Right</option></select><label>Colour</label><input data-column-style="color" type="color" value="' + escape(style.color) + '"><label>Font size <span>' + escape(style.size) + 'px</span></label><input data-column-style="size" type="range" min="12" max="56" value="' + escape(style.size) + '">')) + sideSpacingControls;
      const updateColumnStyle = control => { if (control.dataset.columnImageWidth !== undefined) block.image_size = Number(control.value); else block.styles[elementKey][control.dataset.columnStyle] = control.dataset.columnStyle === 'align' || control.dataset.columnStyle === 'color' ? control.value : Number(control.value); blocksField.value = JSON.stringify(blocks); control.previousElementSibling?.querySelector('span') && (control.previousElementSibling.querySelector('span').textContent = control.value + (control.dataset.columnImageWidth !== undefined ? '%' : 'px')); render(); };
      stylePanel.querySelectorAll('[data-column-style], [data-column-image-width]').forEach(control => { control.addEventListener('input', () => updateColumnStyle(control)); control.addEventListener('change', () => updateColumnStyle(control)); });
      stylePanel.querySelector('[data-column-text-editor]')?.addEventListener('input', event => { block[elementKey] = event.target.value; blocks[columnIndex] = block; blocksField.value = JSON.stringify(blocks); preview.querySelector('.preview-section[data-builder-id="' + card.dataset.builderId + '"] [data-preview-column="' + columnIndex + '"][data-preview-column-key="' + elementKey + '"]')?.replaceChildren(document.createTextNode(event.target.value)); queueSnapshot(); });
      stylePanel.querySelector('[data-column-text-editor]')?.addEventListener('change', () => render());
      stylePanel.querySelector('[data-column-bullets-editor]')?.addEventListener('input', event => { block.bullets = event.target.value; blocks[columnIndex] = block; blocksField.value = JSON.stringify(blocks); render(); queueSnapshot(); });
      stylePanel.querySelectorAll('[data-column-button]').forEach(control => control.addEventListener('input', () => { block[control.dataset.columnButton] = control.value; blocks[columnIndex] = block; blocksField.value = JSON.stringify(blocks); render(); }));
      stylePanel.querySelector('.back-to-column')?.addEventListener('click', () => focusCard(card, 'section'));
      return;
    }
    if (type === 'feature_grid' && !blocks.length) { blocks = [{ icon: '✚', title: 'Traditional Healing', text: '' }, { icon: '♨', title: 'Improve Health', text: '' }, { icon: '☯', title: 'Holistic Wellness', text: '' }]; blocksField.value = JSON.stringify(blocks); }
    const blockControls = type === 'feature_grid' ? '<div class="block-editor"><label>Feature layout</label><select data-style="grid_columns"><option value="2" ' + (gridColumns.value === '2' ? 'selected' : '') + '>2 columns</option><option value="3" ' + (gridColumns.value === '3' ? 'selected' : '') + '>3 columns</option><option value="4" ' + (gridColumns.value === '4' ? 'selected' : '') + '>4 columns</option></select><label>Card style</label><select data-style="card_layout"><option value="stacked" ' + (cardLayout.value === 'stacked' ? 'selected' : '') + '>Centered (icon above)</option><option value="icon_left" ' + (cardLayout.value === 'icon_left' ? 'selected' : '') + '>Icon left</option></select><label>Card alignment</label><select data-style="card_alignment"><option value="left" ' + (cardAlignment.value === 'left' ? 'selected' : '') + '>Left</option><option value="center" ' + (cardAlignment.value === 'center' ? 'selected' : '') + '>Center</option><option value="right" ' + (cardAlignment.value === 'right' ? 'selected' : '') + '>Right</option></select><label>Card gap <span>' + gridGap.value + 'px</span></label><input data-style="grid_gap" type="range" min="0" max="100" value="' + gridGap.value + '"><label>Feature cards</label>' + blocks.map((block, index) => '<div class="feature-block-control"><div class="feature-block-image">' + (block.previewImage || block.image ? '<img src="' + escape(block.previewImage || ('/' + String(block.image).replace(/^\//, ''))) + '" alt="">' : '<b>' + escape(block.icon || '✦') + '</b>') + '<button type="button" data-block-image="' + index + '">' + (block.image ? 'Replace image' : 'Add image') + '</button></div><input data-block="' + index + '" data-block-key="icon" value="' + escape(block.icon || '') + '" maxlength="4" aria-label="Icon"><input data-block="' + index + '" data-block-key="title" value="' + escape(block.title || '') + '" aria-label="Title"><textarea data-block="' + index + '" data-block-key="text" aria-label="Description">' + escape(block.text || '') + '</textarea><button type="button" data-remove-block="' + index + '">Remove</button></div>').join('') + '<button type="button" class="add-feature-block">+ Add card</button></div>' : '';
    if (type === 'custom_columns' && !blocks.length) { blocks = [{ type: 'empty' }]; blocksField.value = JSON.stringify(blocks); }
    const columnControls = type === 'custom_columns' ? '<div class="block-editor"><label>Section division</label><select data-column-count><option value="1" ' + (gridColumns.value === '1' ? 'selected' : '') + '>1 column — 100% width</option><option value="2" ' + (gridColumns.value === '2' ? 'selected' : '') + '>2 columns — 50% each</option><option value="3" ' + (gridColumns.value === '3' ? 'selected' : '') + '>3 columns — 33.33% each</option></select><small>Choose what each visible column should contain.</small>' + blocks.slice(0, Number(gridColumns.value || 1)).map((block, index) => '<div class="feature-block-control column-control"><label>Column ' + (index + 1) + '</label><select data-block="' + index + '" data-block-key="type"><option value="text" ' + ((block.type || 'text') === 'text' ? 'selected' : '') + '>Text</option><option value="image" ' + (block.type === 'image' ? 'selected' : '') + '>Image</option><option value="button" ' + (block.type === 'button' ? 'selected' : '') + '>Button / CTA</option></select>' + ((block.type || 'text') === 'image' ? '<div class="feature-block-image">' + (block.previewImage || block.image ? '<img src="' + escape(block.previewImage || ('/' + String(block.image).replace(/^\//, ''))) + '" alt="">' : '<b>▧</b>') + '<button type="button" data-block-image="' + index + '">' + (block.image ? 'Replace image' : 'Add image') + '</button></div><label>Image width <span>' + escape(block.image_size ?? 100) + '%</span></label><input data-block="' + index + '" data-block-key="image_size" type="range" min="20" max="100" value="' + escape(block.image_size ?? 100) + '">' : ((block.type || 'text') === 'button' ? '<input data-block="' + index + '" data-block-key="button_text" value="' + escape(block.button_text || '') + '" placeholder="Button label"><input data-block="' + index + '" data-block-key="button_url" value="' + escape(block.button_url || '') + '" placeholder="https://...">' : '<input data-block="' + index + '" data-block-key="title" value="' + escape(block.title || '') + '" placeholder="Heading"><textarea data-block="' + index + '" data-block-key="text" placeholder="Text">' + escape(block.text || '') + '</textarea>')) + '</div>').join('') + '</div>' : '';
    const extraElementControls = !['image', 'testimonial', 'faq', 'custom_columns'].includes(type) ? '<div class="block-editor"><label>Extra section elements</label>' + extraElements.map((element, index) => {
      const isList = element.type === 'bullet_list' || element.type === 'numbered_list';
      const defaultColor = element.type === 'heading' ? textColor.value : descriptionColor.value;
      const defaultSize = element.type === 'heading' ? headingSize.value : descriptionSize.value;
      const side = (label, key, fallback) => '<label>' + label + '<span class="button-side-input"><input data-extra="' + index + '" data-extra-key="' + key + '" type="number" min="0" max="160" value="' + escape(element[key] ?? fallback ?? 0) + '"><em>px</em></span></label>';
      const spacing = '<div class="column-spacing-controls"><strong>Padding</strong><div class="button-side-controls">' + side('Top', 'padding_top', element.padding) + side('Right', 'padding_right', element.padding) + side('Bottom', 'padding_bottom', element.padding) + side('Left', 'padding_left', element.padding) + '</div><strong>Margin</strong><div class="button-side-controls">' + side('Top', 'margin_top', element.margin) + side('Right', 'margin_right', element.margin) + side('Bottom', 'margin_bottom', element.margin) + side('Left', 'margin_left', element.margin) + '</div></div>';
      return '<div class="feature-block-control extra-element-control"><select data-extra="' + index + '" data-extra-key="type"><option value="heading" ' + (element.type === 'heading' ? 'selected' : '') + '>Heading</option><option value="subheading" ' + (element.type === 'subheading' ? 'selected' : '') + '>Sub heading</option><option value="bullet_list" ' + (element.type === 'bullet_list' ? 'selected' : '') + '>• Bulleted list</option><option value="numbered_list" ' + (element.type === 'numbered_list' ? 'selected' : '') + '>1. Numbered list</option></select>' + (isList ? '<label>List items <small>One item per line</small></label><textarea data-extra="' + index + '" data-extra-key="items" rows="4" placeholder="First item&#10;Second item">' + escape(element.items || '') + '</textarea><label>Item gap <span>' + escape(element.item_gap ?? 8) + 'px</span></label><input data-extra="' + index + '" data-extra-key="item_gap" type="range" min="0" max="48" value="' + escape(element.item_gap ?? 8) + '">' : '<input data-extra="' + index + '" data-extra-key="text" value="' + escape(element.text || '') + '">') + '<label>Colour</label><input data-extra="' + index + '" data-extra-key="color" type="color" value="' + escape(element.color || defaultColor) + '"><label>Font size <span>' + escape(element.size || defaultSize) + 'px</span></label><input data-extra="' + index + '" data-extra-key="size" type="range" min="12" max="56" value="' + escape(element.size || defaultSize) + '">' + spacing + '<button type="button" data-remove-extra="' + index + '">Remove</button></div>';
    }).join('') + '<div class="extra-element-actions"><button type="button" class="add-extra-heading">+ Add heading</button><button type="button" class="add-extra-subheading">+ Add sub heading</button><button type="button" class="add-extra-bullet-list">+ Bulleted list</button><button type="button" class="add-extra-numbered-list">+ Numbered list</button></div></div>' : '';
    const targetLabel = target === 'section' ? 'Section' : (target === 'image' ? 'Image' : (target === 'heading' ? 'Heading text' : 'Subtext'));
    const backgroundImage = getValue(card, 'existing_background_image');
    const backgroundMode = ensureField(card, 'background_mode', backgroundImage ? 'image' : 'color');
    const backgroundPosition = ensureField(card, 'background_position', 'center');
    const backgroundParallax = ensureField(card, 'background_parallax', '0');
    const overlayColor = ensureField(card, 'background_overlay_color', '#000000');
    const overlayOpacity = ensureField(card, 'background_overlay_opacity', '0');
    const backgroundControls = '<div class="section-background-media"><div class="background-mode-toggle"><button type="button" data-background-mode="color" class="' + (backgroundMode.value === 'color' ? 'is-active' : '') + '">Colour</button><button type="button" data-background-mode="image" class="' + (backgroundMode.value === 'image' ? 'is-active' : '') + '">Image</button></div><div class="background-image-options ' + (backgroundMode.value === 'image' ? '' : 'is-hidden') + '"><label>Background image</label><input data-background-image type="file" accept="image/*"><small>' + (backgroundImage ? 'Current image selected' : 'Upload an image for this section') + '</small><label>Image position</label><select data-style="background_position"><option value="left" ' + (backgroundPosition.value === 'left' ? 'selected' : '') + '>Left</option><option value="center" ' + (backgroundPosition.value === 'center' ? 'selected' : '') + '>Center</option><option value="right" ' + (backgroundPosition.value === 'right' ? 'selected' : '') + '>Right</option><option value="top" ' + (backgroundPosition.value === 'top' ? 'selected' : '') + '>Top</option><option value="bottom" ' + (backgroundPosition.value === 'bottom' ? 'selected' : '') + '>Bottom</option></select><label>Overlay colour</label><input data-style="background_overlay_color" type="color" value="' + overlayColor.value + '"><label>Overlay opacity <span>' + overlayOpacity.value + '%</span></label><input data-style="background_overlay_opacity" type="range" min="0" max="90" value="' + overlayOpacity.value + '"><label class="builder-switch"><input data-style="background_parallax" type="checkbox" value="1" ' + (backgroundParallax.value === '1' ? 'checked' : '') + '><span class="builder-switch-track"></span><span>Desktop parallax</span></label><small>Moves the background at a different speed while visitors scroll. Disabled on mobile.</small></div></div>';
    const elementControls = target === 'section' ? '<label>Background</label><input data-style="background_color" type="color" value="' + background.value + '"><label>Padding horizontal <span>' + paddingX.value + 'px</span></label><input data-style="padding_x" type="range" min="0" max="160" value="' + paddingX.value + '"><label>Padding vertical <span>' + padding.value + 'px</span></label><input data-style="padding_y" type="range" min="0" max="160" value="' + padding.value + '"><label>Margin horizontal <span>' + marginX.value + 'px</span></label><input data-style="margin_x" type="range" min="0" max="120" value="' + marginX.value + '"><label>Margin vertical <span>' + margin.value + 'px</span></label><input data-style="margin_y" type="range" min="0" max="120" value="' + margin.value + '">' : (target === 'image' ? '<label>Image width <span>' + imageSize.value + '%</span></label><input data-style="image_size" type="range" min="20" max="' + (type === 'image' ? '100' : '75') + '" value="' + imageSize.value + '"><div class="image-size-progress" aria-hidden="true"><span style="width:' + imageSize.value + '%"></span></div><label>Alt text</label><input data-style="image_alt" value="' + escape(imageAlt.value) + '" placeholder="Describe this image"><label>Crop ratio</label><select data-style="image_crop"><option value="original" ' + (imageCrop.value === 'original' ? 'selected' : '') + '>Original</option><option value="1:1" ' + (imageCrop.value === '1:1' ? 'selected' : '') + '>Square (1:1)</option><option value="4:3" ' + (imageCrop.value === '4:3' ? 'selected' : '') + '>Landscape (4:3)</option><option value="16:9" ' + (imageCrop.value === '16:9' ? 'selected' : '') + '>Wide (16:9)</option><option value="3:4" ' + (imageCrop.value === '3:4' ? 'selected' : '') + '>Portrait (3:4)</option></select><label>Focal point horizontal <span>' + imageFocalX.value + '%</span></label><input data-style="image_focal_x" type="range" min="0" max="100" value="' + imageFocalX.value + '"><label>Focal point vertical <span>' + imageFocalY.value + '%</span></label><input data-style="image_focal_y" type="range" min="0" max="100" value="' + imageFocalY.value + '"><button type="button" class="remove-section-image">Remove image</button><small class="image-help">Replace, crop, and set the visual focus without losing your alt text.</small>' : '<label>Text alignment</label><select data-style="text_align"><option value="left" ' + (textAlign.value === 'left' ? 'selected' : '') + '>Left</option><option value="center" ' + (textAlign.value === 'center' ? 'selected' : '') + '>Center</option><option value="right" ' + (textAlign.value === 'right' ? 'selected' : '') + '>Right</option></select>' + (target === 'heading' ? '<label>Heading colour</label><input data-style="text_color" type="color" value="' + textColor.value + '"><label>Heading size <span>' + headingSize.value + 'px</span></label><input data-style="heading_size" type="range" min="16" max="72" value="' + headingSize.value + '">' : '<label>Description colour</label><input data-style="description_color" type="color" value="' + descriptionColor.value + '"><label>Description size <span>' + descriptionSize.value + 'px</span></label><input data-style="description_size" type="range" min="12" max="36" value="' + descriptionSize.value + '">') + '<label>Element padding <span>' + elementData.styles[target].padding_y + 'px</span></label><input data-element-style="padding_y" type="range" min="0" max="120" value="' + elementData.styles[target].padding_y + '"><label>Element margin <span>' + elementData.styles[target].margin_y + 'px</span></label><input data-element-style="margin_y" type="range" min="0" max="120" value="' + elementData.styles[target].margin_y + '">');
    const directTextEditor = (target === 'heading' || target === 'content') ? '<label>Edit ' + (target === 'heading' ? 'heading' : 'text') + '</label><textarea data-text-editor rows="4" placeholder="Paste or type text here">' + escape(getValue(card, target)) + '</textarea>' : '';
    const formatControls = (target === 'heading' || target === 'content') ? '<div class="text-format-controls" aria-label="Text formatting"><span>Text style</span><button type="button" data-format="font_weight" data-format-value="bold" class="' + (elementData.styles[target].font_weight === 'bold' ? 'is-active' : '') + '"><b>B</b></button><button type="button" data-format="font_style" data-format-value="italic" class="' + (elementData.styles[target].font_style === 'italic' ? 'is-active' : '') + '"><i>I</i></button><button type="button" data-format="text_decoration" data-format-value="underline" class="' + (elementData.styles[target].text_decoration === 'underline' ? 'is-active' : '') + '"><u>U</u></button></div>' : '';
    stylePanel.innerHTML = '<div class="builder-inspector-title"><span>' + targetLabel + ' design</span><span>◐</span></div><button type="button" class="delete-selected-section">Delete section</button>' + (target === 'section' ? imageControl + blockControls + columnControls + extraElementControls + backgroundControls : '') + directTextEditor + elementControls + formatControls + (target === 'section' ? '<button type="button" class="apply-section-spacing">Apply this spacing to all sections</button>' : '');
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
    stylePanel.querySelector('[data-text-editor]')?.addEventListener('input', event => { const field = getField(card, target); if (!field) return; field.value = event.target.value; preview.querySelector('.preview-section[data-builder-id="' + card.dataset.builderId + '"] [data-preview-field="' + target + '"]')?.replaceChildren(document.createTextNode(event.target.value)); queueSnapshot(); });
    stylePanel.querySelector('[data-text-editor]')?.addEventListener('change', () => render());
    stylePanel.querySelectorAll('[data-format]').forEach(button => button.addEventListener('click', () => { const property = button.dataset.format; const value = button.dataset.formatValue; const inactiveValue = property === 'font_weight' ? 'normal' : (property === 'font_style' ? 'normal' : 'none'); elementData.styles[target][property] = elementData.styles[target][property] === value ? inactiveValue : value; elementData.field.value = JSON.stringify(elementData.styles); renderStyles(card, target); render(); }));
    stylePanel.querySelector('.apply-section-spacing')?.addEventListener('click', () => {
      const spacing = ['padding_x', 'padding_y', 'margin_x', 'margin_y'];
      [...sections.querySelectorAll('.page-builder-section')].forEach(otherCard => spacing.forEach(property => ensureField(otherCard, property, '0').value = ensureField(card, property, '0').value));
      render();
    });
    stylePanel.querySelector('[data-section-image]')?.addEventListener('change', event => { const target = card.querySelector('input[type=file]'); if (!target || !event.target.files.length) return; target.files = event.target.files; delete card.dataset.previewImage; target.dispatchEvent(new Event('change', { bubbles: true })); });
    stylePanel.querySelector('.remove-section-image')?.addEventListener('click', () => { const existing = getField(card, 'existing_image'); if (existing) existing.value = ''; const upload = card.querySelector('input[type=file]'); if (upload) upload.value = ''; delete card.dataset.previewImage; render(); queueSnapshot(); });
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
    stylePanel.querySelector('.delete-selected-section')?.addEventListener('click', () => { card.remove(); const selectedElement = inspector.querySelector('[data-selected-element]'); if (selectedElement) { selectedElement.textContent = ''; selectedElement.closest('.builder-selected-element')?.classList.add('is-empty'); } stylePanel.innerHTML = '<div class="builder-inspector-title"><span>Design</span><span>◐</span></div><div class="section-empty">Select a section on the canvas</div>'; render(); });
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
      const imageCrop = getValue(card, 'image_crop') || 'original';
      const imageFocal = (getValue(card, 'image_focal_x') || '50') + '% ' + (getValue(card, 'image_focal_y') || '50') + '%';
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
      const imageMarkup = '<div class="preview-image-frame" style="' + (imageCrop !== 'original' ? 'aspect-ratio:' + escape(imageCrop) + ';overflow:hidden;' : '') + '">' + (image ? '<img class="preview-section-image" src="' + escape(image) + '" alt="' + escape(getValue(card, 'image_alt')) + '" style="width:100%;height:' + (imageCrop !== 'original' ? '100%' : 'auto') + ';object-fit:cover;object-position:' + escape(imageFocal) + ';">' : '<div class="preview-image-empty">Image area</div>') + '<button type="button" class="preview-image-action">' + (image ? 'Replace image' : 'Add image') + '</button></div>';
      const gridColumns = type === 'custom_columns' ? Math.max(1, Math.min(3, Number(getValue(card, 'grid_columns') || 1))) : Math.max(2, Math.min(4, Number(getValue(card, 'grid_columns') || 3)));
      const gridMarkup = '<div class="preview-grid-heading"><h3 contenteditable="true" data-preview-field="heading" style="color:' + escape(textColor) + ';font-size:' + escape(headingSize) + 'px">' + richPreview(heading) + '</h3>' + extraElements.map((element, extraIndex) => previewExtraElement(element, extraIndex, textColor, headingSize, descriptionColor, descriptionSize)).join('') + '<p contenteditable="true" data-preview-field="content" style="color:' + escape(descriptionColor) + ';font-size:' + escape(descriptionSize) + 'px">' + richPreview(text) + '</p></div><div class="preview-feature-grid" style="grid-template-columns:repeat(' + gridColumns + ', minmax(0,1fr));gap:' + escape(getValue(card, 'grid_gap') || '24') + 'px">' + blocks.map(block => '<div class="preview-feature ' + (getValue(card, 'card_layout') === 'icon_left' ? 'is-icon-left' : 'is-stacked') + '" style="text-align:' + escape(getValue(card, 'card_alignment') || 'center') + '">' + (block.previewImage || block.image ? '<img src="' + escape(block.previewImage || ('/' + String(block.image).replace(/^\//, ''))) + '" alt="">' : '<b>' + escape(block.icon || '✦') + '</b>') + '<div><h4>' + richPreview(block.title || 'Feature title') + '</h4>' + (block.text ? '<p>' + richPreview(block.text) + '</p>' : '') + '</div></div>').join('') + '</div>';
      const columnStyle = (block, key, element = null) => { const style = element?.styles || (block.styles || {})[key] || {}; const padding = style.padding ?? 0; const margin = style.margin ?? 0; return 'color:' + escape(style.color || (key === 'title' ? textColor : descriptionColor)) + ';font-size:' + escape(style.size || (key === 'title' ? 24 : 16)) + 'px;padding:' + escape(style.padding_top ?? padding) + 'px ' + escape(style.padding_right ?? padding) + 'px ' + escape(style.padding_bottom ?? padding) + 'px ' + escape(style.padding_left ?? padding) + 'px;margin:' + escape(style.margin_top ?? margin) + 'px ' + escape(style.margin_right ?? margin) + 'px ' + escape(style.margin_bottom ?? margin) + 'px ' + escape(style.margin_left ?? margin) + 'px;text-align:' + escape(style.align || textAlign) + ';'; };
      const columnExtraMarkup = (block, index) => (block.small_text ? '<small class="preview-column-support" contenteditable="true" data-preview-column="' + index + '" data-preview-column-key="small_text" data-preview-column-target="column-' + index + '-small_text" style="' + columnStyle(block, 'small_text') + '">' + escape(block.small_text) + '</small>' : '') + (block.bullets ? '<ul class="preview-builder-list" contenteditable="true" data-preview-column="' + index + '" data-preview-column-key="bullets" data-preview-column-target="column-' + index + '-bullets" style="' + columnStyle(block, 'bullets') + ';--list-item-gap:' + escape((block.styles || {}).bullets?.item_gap ?? block.item_gap ?? 8) + 'px">' + String(block.bullets).split(/\r?\n/).filter(Boolean).map(item => '<li>' + richPreview(item) + '</li>').join('') + '</ul>' : '');
      const stackedColumnElements = (block, index) => (block.elements || []).map((element, elementIndex) => {
        const target = 'column-' + index + '-element-' + elementIndex;
        const elementSpacing = element.styles || {};
        const rowStart = '<div class="preview-draggable-row" draggable="true" data-column-element-column="' + index + '" data-column-element-index="' + elementIndex + '" style="--preview-row-margin-top:' + escape(elementSpacing.margin_top ?? elementSpacing.margin ?? 0) + 'px;--preview-row-margin-right:' + escape(elementSpacing.margin_right ?? elementSpacing.margin ?? 0) + 'px;--preview-row-margin-bottom:' + escape(elementSpacing.margin_bottom ?? elementSpacing.margin ?? 0) + 'px;--preview-row-margin-left:' + escape(elementSpacing.margin_left ?? elementSpacing.margin ?? 0) + 'px;"><span class="preview-row-handle" title="Drag to reorder" aria-hidden="true">⠿</span><button type="button" class="preview-row-delete" data-delete-column-element="' + index + ':' + elementIndex + '" title="Delete element" aria-label="Delete element"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>';
        const rowEnd = '</div>';
        if (element.type === 'heading') return rowStart + '<h4 class="preview-column-row" contenteditable="true" data-preview-column="' + index + '" data-preview-column-key="element-' + elementIndex + '" data-preview-column-target="' + target + '" style="' + columnStyle(block, 'title', element) + '">' + escape(element.text || 'New heading') + '</h4>' + rowEnd;
        if (element.type === 'subtext') return rowStart + '<p class="preview-column-row" contenteditable="true" data-preview-column="' + index + '" data-preview-column-key="element-' + elementIndex + '" data-preview-column-target="' + target + '" style="white-space:pre-wrap;' + columnStyle(block, 'text', element) + '">' + escape(element.text || 'Add supporting text.') + '</p>' + rowEnd;
        if (element.type === 'bullets') return rowStart + '<ul class="preview-builder-list preview-column-row" contenteditable="true" data-preview-column="' + index + '" data-preview-column-key="element-' + elementIndex + '" data-preview-column-target="' + target + '" style="' + columnStyle(block, 'bullets', element) + '">' + String(element.items || '').split(/\r?\n/).filter(Boolean).map(item => '<li>' + escape(item) + '</li>').join('') + '</ul>' + rowEnd;
        if (element.type === 'button') { const style = element.styles || {}; const buttonRowStart = rowStart.replace('class="preview-draggable-row"', 'class="preview-draggable-row preview-button-row" style="--preview-row-margin-top:' + escape(style.margin_top ?? 0) + 'px;--preview-row-margin-right:' + escape(style.margin_right ?? 0) + 'px;--preview-row-margin-bottom:' + escape(style.margin_bottom ?? 0) + 'px;--preview-row-margin-left:' + escape(style.margin_left ?? 0) + 'px;"'); return buttonRowStart + '<span class="preview-cta preview-column-row" data-preview-column-target="' + target + '" style="width:' + escape(style.width || 'auto') + ';padding:' + escape(style.padding_top ?? 12) + 'px ' + escape(style.padding_right ?? 24) + 'px ' + escape(style.padding_bottom ?? 12) + 'px ' + escape(style.padding_left ?? 24) + 'px;">' + escape(element.button_text || 'Button label') + '</span>' + rowEnd; }
        const imageSource = block.previewImage || block.image;
        return rowStart + (imageSource ? '<div class="preview-column-image-frame preview-column-row" data-preview-column-target="' + target + '"><img data-preview-column-image="' + index + '" style="width:' + escape(element.image_size ?? block.image_size ?? 100) + '%;max-width:100%;height:auto" src="' + escape(imageSource.startsWith('data:') ? imageSource : ('/' + String(imageSource).replace(/^\//, ''))) + '" alt=""><button type="button" class="preview-column-image-replace" data-preview-empty-image="' + index + '">↻ Replace image</button></div>' : '<button type="button" class="preview-image-empty preview-column-row" data-preview-column-target="' + target + '" data-preview-empty-image="' + index + '"><span aria-hidden="true">▧</span><strong>Add image</strong></button>') + rowEnd;
      }).join('');
      const testimonialRows = blocks.slice(gridColumns).map((block, index) => ({ block, index: index + gridColumns })).filter(item => item.block.type === 'testimonial');
      const testimonialMarkup = testimonialRows.length ? '<div class="preview-special-heading"><h3 contenteditable="true" data-preview-field="heading" style="color:' + escape(textColor) + ';font-size:' + escape(headingSize) + 'px">' + richPreview(heading) + '</h3></div><div class="preview-testimonial-rows">' + testimonialRows.map(item => { const testimonial = item.block; const image = testimonial.previewImage || testimonial.image; const rating = Math.max(1, Math.min(5, Number(testimonial.rating || 5))); return '<article class="preview-testimonial-row" data-preview-column-target="column-' + item.index + '-testimonial"><div class="preview-testimonial-avatar">' + (image ? '<img src="' + escape(testimonial.previewImage || ('/' + String(testimonial.image).replace(/^\//, ''))) + '" alt="">' : '◉') + '</div><div><div class="preview-testimonial-stars">' + '★'.repeat(rating) + '<i>' + '☆'.repeat(5 - rating) + '</i></div><blockquote>“' + escape(testimonial.review || 'Share a client experience here.') + '”</blockquote><small>Click to edit testimonial</small></div></article>'; }).join('') + '</div>' : '';
      const faqRows = blocks.slice(gridColumns).map((block, index) => ({ block, index: index + gridColumns })).filter(item => item.block.type === 'faq');
      const faqMarkup = faqRows.length ? '<div class="preview-special-heading"><h3 contenteditable="true" data-preview-field="heading" style="color:' + escape(textColor) + ';font-size:' + escape(headingSize) + 'px">' + richPreview(heading) + '</h3></div><div class="preview-faq-rows">' + faqRows.map(item => '<article class="preview-faq-row" data-preview-column-target="column-' + item.index + '-faq"><b>+</b><div><strong>' + escape(item.block.question || 'What would you like to know?') + '</strong><p>' + escape(item.block.answer || 'Add a helpful answer for visitors.') + '</p><small>Click to edit FAQ</small></div></article>').join('') + '</div>' : '';
      const columnMarkup = '<div class="preview-custom-columns-wrap"><div class="preview-feature-grid preview-custom-columns" style="grid-template-columns:repeat(' + gridColumns + ', minmax(0,1fr));gap:' + escape(getValue(card, 'grid_gap') || '24') + 'px">' + blocks.slice(0, gridColumns).map((block, index) => '<div class="preview-feature is-stacked preview-column-stack" style="text-align:' + escape(textAlign) + '">' + (block.type === 'image' ? (block.previewImage || block.image ? '<div class="preview-column-image-frame" data-preview-column-target="column-' + index + '-image"><img data-preview-column-image="' + index + '" style="width:' + escape(block.image_size ?? 100) + '%;max-width:100%;height:auto;margin:0 auto" src="' + escape(block.previewImage || ('/' + String(block.image).replace(/^\//, ''))) + '" alt=""><button type="button" class="preview-column-image-replace" data-preview-empty-image="' + index + '">↻ Replace image</button></div>' : '<button type="button" class="preview-image-empty" data-preview-empty-image="' + index + '"><span aria-hidden="true">▧</span><strong>Add image</strong><small>Click to upload</small></button>') + stackedColumnElements(block, index) : (block.type === 'button' ? '<span class="preview-cta">' + escape(block.button_text || 'Button label') + '</span>' : '<div>' + (block.title ? '<h4 contenteditable="true" data-preview-column="' + index + '" data-preview-column-key="title" data-preview-column-target="column-' + index + '-title" style="' + columnStyle(block, 'title') + '">' + escape(block.title) + '</h4>' : '') + (block.text ? '<p contenteditable="true" data-preview-column="' + index + '" data-preview-column-key="text" data-preview-column-target="column-' + index + '-text" style="white-space:pre-wrap;' + columnStyle(block, 'text') + '">' + escape(block.text) + '</p>' : '') + stackedColumnElements(block, index) + '</div>')) + columnExtraMarkup(block, index) + '<div class="preview-column-drop-hint">Drop another element here</div>' + (gridColumns > 1 ? '<button type="button" class="preview-column-remove" data-column-remove="' + index + '" title="Remove column" aria-label="Remove column">×</button>' : '') + '</div>').join('') + '</div>' + testimonialMarkup + faqMarkup + (gridColumns < 3 ? '<button type="button" class="preview-column-divider" title="Split into ' + (gridColumns + 1) + ' columns" aria-label="Add a column">+</button>' : '') + '</div>';
      const textExtraMarkup = !['image', 'feature_grid', 'testimonial', 'faq'].includes(type) ? extraElements.map((element, extraIndex) => previewExtraElement(element, extraIndex, textColor, headingSize, descriptionColor, descriptionSize)).join('') : '';
      previewSection.innerHTML = type === 'feature_grid' ? gridMarkup : (type === 'custom_columns' ? columnMarkup : (type === 'image' ? '<div class="preview-image-hero">' + imageMarkup + '</div>' : '<div class="preview-section-row ' + (position === 'right' ? 'is-right' : '') + '">' + (type === 'image_text' ? imageMarkup : '') + '<div class="preview-section-copy"><small>' + escape(type.replace('_', ' + ')) + '</small><h3 contenteditable="true" data-preview-field="heading" style="color:' + escape(textColor) + ';font-size:' + escape(headingSize) + 'px">' + richPreview(heading) + '</h3>' + textExtraMarkup + '<p contenteditable="true" data-preview-field="content" style="color:' + escape(descriptionColor) + ';font-size:' + escape(descriptionSize) + 'px">' + richPreview(text) + '</p>' + (button ? '<span class="preview-cta">' + escape(button) + '</span>' : '') + '</div></div>'));
      // Public builder sections use a centred content container. Keep the
      // canvas geometry identical so saved padding is represented honestly.
      if (type !== 'image') {
        const sectionContainer = document.createElement('div');
        sectionContainer.className = 'preview-section-container';
        while (previewSection.firstChild) sectionContainer.appendChild(previewSection.firstChild);
        previewSection.appendChild(sectionContainer);
      }
      if (type === 'custom_columns' && blocks[0]?.type === 'empty' && (testimonialRows.length || faqRows.length)) previewSection.querySelector('.preview-column-stack')?.remove();
      if (type === 'custom_columns') blocks.slice(0, gridColumns).forEach((block, index) => { if (block.type === 'empty') { const column = previewSection.querySelectorAll('.preview-column-stack')[index]; const primary = column?.firstElementChild; if (primary) primary.outerHTML = '<div class="preview-empty-column-drop">Drag an element here</div>'; } });
      if (type === 'custom_columns') blocks.slice(0, gridColumns).forEach((block, index) => { if (block.type === 'button') { const button = previewSection.querySelectorAll('.preview-column-stack')[index]?.querySelector('.preview-cta'); const style = (block.styles || {}).button || {}; if (button) { button.setAttribute('data-preview-column-target', 'column-' + index + '-button'); if (Number(style.padding || 0) > 0) button.style.padding = Number(style.padding) + 'px'; if (Number(style.margin || 0) > 0) button.style.margin = Number(style.margin) + 'px'; } } });
      previewSection.querySelectorAll('.preview-column-stack').forEach((column, index) => { const block = blocks[index] || {}; column.style.padding = Number(block.padding_y || 0) + 'px ' + Number(block.padding_x || 0) + 'px'; column.style.margin = Number(block.margin_y || 0) + 'px ' + Number(block.margin_x || 0) + 'px'; });
      previewSection.querySelectorAll('.preview-column-stack').forEach((column, index) => { const block = blocks[index] || {}; column.dataset.previewColumnTarget = 'column-' + index + '-container'; column.style.justifyContent = ({ start:'flex-start', center:'center', end:'flex-end' })[block.vertical_align || 'start']; });
      // Store every stacked element's outer margin on its draggable row. The
      // canvas then has the exact same geometry as the public page.
      previewSection.querySelectorAll('.preview-draggable-row').forEach(row => {
        const block = blocks[Number(row.dataset.columnElementColumn)] || {};
        const element = block.elements?.[Number(row.dataset.columnElementIndex)] || {};
        const style = element.styles || {};
        row.style.setProperty('margin', (style.margin_top ?? 0) + 'px ' + (style.margin_right ?? 0) + 'px ' + (style.margin_bottom ?? 0) + 'px ' + (style.margin_left ?? 0) + 'px', 'important');
      });
      previewSection.querySelectorAll('[data-preview-field]').forEach(element => { const field = getField(card, element.dataset.previewField); if (field && /<a\b/i.test(field.value)) element.innerHTML = richPreview(field.value); });
      previewSection.querySelectorAll('[data-preview-column]').forEach(element => { const block = blocks[Number(element.dataset.previewColumn)]; const value = block?.[element.dataset.previewColumnKey]; if (value && /<a\b/i.test(value)) element.innerHTML = richPreview(value); });
      previewSection.querySelectorAll('[data-preview-extra]').forEach(element => { const extra = extraElements[Number(element.dataset.previewExtra)]; if (extra?.text && /<a\b/i.test(extra.text)) element.innerHTML = richPreview(extra.text); });
      const sectionActions = document.createElement('div');
      sectionActions.className = 'preview-section-actions';
      if (type === 'feature_grid') {
        sectionActions.innerHTML = '<button type="button" class="preview-section-add" data-quick-add-feature>＋ Add feature card</button>';
      } else if (type === 'custom_columns') {
        sectionActions.innerHTML = '<button type="button" class="preview-section-add" data-quick-add-trigger>＋ Add element</button><div class="preview-section-add-menu"><small>Add to this section</small>' + (gridColumns < 3 ? '<button type="button" data-quick-add-column="heading">Heading</button><button type="button" data-quick-add-column="subtext">Subtext</button><button type="button" data-quick-add-column="button">Button</button><button type="button" data-quick-add-column="bullets">Bulleted list</button><button type="button" data-quick-add-column="image">Image</button>' : '') + '</div>';
      } else if (!['image', 'testimonial', 'faq', 'custom_columns'].includes(type)) {
        sectionActions.innerHTML = '<button type="button" class="preview-section-add" data-quick-add-trigger>＋ Add element</button><div class="preview-section-add-menu"><button type="button" data-quick-add-extra="heading">Heading</button><button type="button" data-quick-add-extra="subheading">Subheading</button><button type="button" data-quick-add-extra="bullet_list">Bulleted list</button><button type="button" data-quick-add-extra="numbered_list">Numbered list</button></div>';
      }
      if (false && sectionActions.innerHTML) {
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
            const choice = columnChoice.dataset.quickAddColumn;
            blocks[nextCount - 1] = choice === 'heading' ? { type: 'text', title: 'New heading', text: '' } : (choice === 'subtext' ? { type: 'text', title: '', text: 'Add supporting text.' } : (choice === 'bullets' ? { type: 'text', title: '', text: '', bullets: 'First point\nSecond point\nThird point' } : { ...blocks[nextCount - 1], type: choice }));
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
      previewSection.querySelectorAll('.preview-draggable-row').forEach(row => {
        row.addEventListener('dragstart', event => { event.stopPropagation(); row.classList.add('is-dragging'); event.dataTransfer.effectAllowed = 'move'; event.dataTransfer.setData('application/x-builder-column-element', JSON.stringify({ column: Number(row.dataset.columnElementColumn), index: Number(row.dataset.columnElementIndex) })); });
        row.addEventListener('dragend', () => row.classList.remove('is-dragging'));
        row.addEventListener('dragover', event => { if (!event.dataTransfer.types.includes('application/x-builder-column-element')) return; event.preventDefault(); event.stopPropagation(); row.classList.add('is-drop-target'); event.dataTransfer.dropEffect = 'move'; });
        row.addEventListener('dragleave', () => row.classList.remove('is-drop-target'));
        row.addEventListener('drop', event => {
          const raw = event.dataTransfer.getData('application/x-builder-column-element'); if (!raw) return;
          event.preventDefault(); event.stopPropagation(); row.classList.remove('is-drop-target');
          let source; try { source = JSON.parse(raw); } catch (_) { return; }
          const targetColumn = Number(row.dataset.columnElementColumn); const targetIndex = Number(row.dataset.columnElementIndex);
          const sourceElements = blocks[source.column]?.elements; const targetElements = blocks[targetColumn]?.elements;
          if (!sourceElements || !targetElements || !sourceElements[source.index]) return;
          const [moved] = sourceElements.splice(source.index, 1);
          const insertionIndex = source.column === targetColumn && source.index < targetIndex ? targetIndex - 1 : targetIndex;
          targetElements.splice(insertionIndex, 0, moved);
          getField(card, 'blocks').value = JSON.stringify(blocks); render(); focusCard(card, 'section'); queueSnapshot();
        });
      });
      previewSection.querySelectorAll('[data-delete-column-element]').forEach(button => button.addEventListener('click', event => {
        event.preventDefault(); event.stopPropagation();
        const [columnIndex, elementIndex] = button.dataset.deleteColumnElement.split(':').map(Number);
        const elements = blocks[columnIndex]?.elements;
        if (!elements || !elements[elementIndex]) return;
        elements.splice(elementIndex, 1);
        getField(card, 'blocks').value = JSON.stringify(blocks);
        render(); focusCard(card, 'section'); queueSnapshot();
      }));
      previewSection.querySelectorAll('.preview-column-stack').forEach((column, columnIndex) => {
        column.addEventListener('dragover', event => { if (!event.dataTransfer.types.includes('application/x-builder-element')) return; event.preventDefault(); event.stopPropagation(); column.classList.add('is-element-drop-target'); event.dataTransfer.dropEffect = 'copy'; });
        column.addEventListener('dragleave', () => column.classList.remove('is-element-drop-target'));
        column.addEventListener('drop', event => { const type = event.dataTransfer.getData('application/x-builder-element'); if (!type) return; event.preventDefault(); event.stopPropagation(); column.classList.remove('is-element-drop-target'); addElementToSection(card, type, columnIndex); });
      });
      previewSection.addEventListener('dragover', event => { if (!event.dataTransfer.types.includes('application/x-builder-element')) return; event.preventDefault(); previewSection.classList.add('is-element-drop-target'); event.dataTransfer.dropEffect = 'copy'; });
      previewSection.addEventListener('dragleave', () => previewSection.classList.remove('is-element-drop-target'));
      previewSection.addEventListener('drop', event => { const type = event.dataTransfer.getData('application/x-builder-element'); if (!type) return; event.preventDefault(); previewSection.classList.remove('is-element-drop-target'); addElementToSection(card, type); });
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
      previewSection.querySelectorAll('[data-empty-column-choice]').forEach(button => button.addEventListener('click', event => { event.stopPropagation(); const index = Number(button.dataset.emptyColumnIndex); const choice = button.dataset.emptyColumnChoice; blocks[index] = choice === 'heading' ? { type: 'text', title: 'New heading', text: '' } : (choice === 'subtext' ? { type: 'text', title: '', text: 'Add supporting text.' } : (choice === 'bullets' ? { type: 'text', title: '', text: '', bullets: 'First point\nSecond point\nThird point' } : { ...blocks[index], type: choice, title: '', text: '' })); getField(card, 'blocks').value = JSON.stringify(blocks); focusCard(card, 'section'); render(); queueSnapshot(); }));
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
      if (faqRows.length) previewSection.querySelector('.preview-special-heading h3')?.style.setProperty('text-align', 'center', 'important');
      const imageFrame = previewSection.querySelector('.preview-image-frame');
      if (imageFrame && (type === 'image_text' || type === 'image')) { imageFrame.style.width = (getValue(card, 'image_size') || (type === 'image' ? '100' : '42')) + '%'; }
      if (imageFrame) { imageFrame.addEventListener('click', event => { event.stopPropagation(); const action = event.target.closest('.preview-image-action'); if (action) { imageInput?.click(); return; } focusCard(card, 'image'); }); }
      [['heading', '[data-preview-field="heading"]'], ['content', '[data-preview-field="content"]']].forEach(([key, selector]) => previewSection.querySelectorAll(selector).forEach(element => { const style = selectedStyles[key]; element.style.padding = style.padding_y + 'px ' + style.padding_x + 'px'; element.style.margin = style.margin_y + 'px ' + style.margin_x + 'px'; element.style.fontWeight = style.font_weight; element.style.fontStyle = style.font_style; element.style.textDecoration = style.text_decoration; }));
      previewSection.addEventListener('click', event => { const selectedColumnElement = event.target.closest('[data-preview-column-target]'); const editable = event.target.closest('[contenteditable]'); const extraList = event.target.closest('[data-preview-extra-list]'); const extraTarget = extraList ? 'extra-' + extraList.dataset.previewExtraList : null; const target = selectedColumnElement?.dataset.previewColumnTarget || editable?.dataset.previewField || (editable?.dataset.previewExtra !== undefined ? 'extra-' + editable.dataset.previewExtra : 'section'); const elementTarget = extraTarget || target; focusCard(card, elementTarget); if (editable) editable.classList.add('is-editing'); }, true);
      content.appendChild(previewSection);
      const layer = document.createElement('div');
      layer.className = 'section-tree is-collapsed'; layer.dataset.builderId = card.dataset.builderId;
      const treeLabel = type === 'image' ? 'Full-width image' : heading;
      layer.innerHTML = '<div class="section-tree-header"><button type="button" class="section-layer"><span>☷ ' + escape(treeLabel) + '</span><small>' + escape(type.replace('_', ' + ')) + '</small></button><button type="button" class="section-tree-delete" title="Delete section" aria-label="Delete section"><i class="fas fa-trash-alt" aria-hidden="true"></i></button><button type="button" class="section-tree-toggle" aria-label="Expand section" aria-expanded="false"><i class="fas fa-chevron-down" aria-hidden="true"></i></button></div><div class="section-tree-children"></div>';
      const root = layer.querySelector('.section-layer');
      root.draggable = true;
      root.dataset.treeTarget = 'section';
      root.addEventListener('click', () => focusCard(card, 'section'));
      layer.querySelector('.section-tree-delete').addEventListener('click', event => { event.stopPropagation(); card.remove(); normalizeSectionIndexes(); render(); queueSnapshot(); });
      layer.querySelector('.section-tree-toggle').addEventListener('click', event => { event.stopPropagation(); const collapsed = layer.classList.toggle('is-collapsed'); event.currentTarget.setAttribute('aria-expanded', String(!collapsed)); event.currentTarget.setAttribute('aria-label', collapsed ? 'Expand section' : 'Collapse section'); event.currentTarget.classList.toggle('is-expanded', !collapsed); });
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
  const syncActiveStackedButton = () => {
    const card = sections.querySelector('.page-builder-section.is-selected');
    const target = card?.dataset.selectedTarget || '';
    const match = /^column-(\d+)-element-(\d+)$/.exec(target);
    if (!card || !match || !stylePanel.querySelector('[data-stacked-button]')) return;
    const blocksField = getField(card, 'blocks');
    if (!blocksField) return;
    let blocks = [];
    try { blocks = JSON.parse(blocksField.value || '[]'); } catch (_) { return; }
    const element = blocks[Number(match[1])]?.elements?.[Number(match[2])];
    if (!element || element.type !== 'button') return;
    element.styles ||= {};
    stylePanel.querySelectorAll('[data-stacked-button]').forEach(control => {
      const key = control.dataset.stackedButton;
      if (key === 'button_text' || key === 'button_url') element[key] = control.value;
      else element.styles[key] = key === 'width' ? control.value : Number(control.value || 0);
    });
    blocksField.value = JSON.stringify(blocks);
  };
  document.getElementById('landing-page-form')?.addEventListener('submit', () => {
    // Contenteditable nodes are outside the form cards, so synchronise them
    // explicitly before the browser serialises the hidden section fields.
    // The inspector itself is outside the card, so commit its live numeric
    // controls here as well before the browser builds the POST payload.
    syncActiveStackedButton();
    preview.querySelectorAll('.live-preview-content [contenteditable]').forEach(saveEditableMarkup);
    setSaveState('Saving…');
  });
  document.addEventListener('keydown', event => {
    if (!(event.ctrlKey || event.metaKey)) return;
    if (!event.target.closest('.live-preview-content [contenteditable]')) return;
    const key = event.key.toLowerCase();
    if (key === 'z') { event.preventDefault(); flushSnapshot(); restoreHistory(event.shiftKey ? historyIndex + 1 : historyIndex - 1); }
    if (key === 'y') { event.preventDefault(); flushSnapshot(); restoreHistory(historyIndex + 1); }
  });
  preview.querySelector('.live-preview-content').addEventListener('paste', (event) => {
    const editable = event.target.closest('[contenteditable]');
    const text = event.clipboardData?.getData('text/plain');
    if (!editable || text === undefined) return;
    event.preventDefault();
    document.execCommand('insertText', false, text);
  });
  preview.querySelector('.live-preview-content').addEventListener('input', (event) => {
    const columnIndex = event.target.dataset.previewColumn;
    if (columnIndex !== undefined) {
      const previewSection = event.target.closest('.preview-section');
      const card = previewSection && [...sections.querySelectorAll('.page-builder-section')].find(item => item.dataset.builderId === previewSection.dataset.builderId);
      const blocksField = card && getField(card, 'blocks');
      if (!blocksField) return;
      let blocks = []; try { blocks = JSON.parse(blocksField.value || '[]'); } catch (_) {}
      if (blocks[Number(columnIndex)]) { const key = event.target.dataset.previewColumnKey; const elementMatch = /^element-(\d+)$/.exec(key); if (elementMatch) { const element = blocks[Number(columnIndex)].elements?.[Number(elementMatch[1])]; if (element) { if (element.type === 'bullets') element.items = [...event.target.querySelectorAll('li')].map(item => item.innerText).join('\n'); else element.text = event.target.innerText; } } else { blocks[Number(columnIndex)][key] = event.target.innerText; } blocksField.value = JSON.stringify(blocks); }
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
  preview.querySelector('.live-preview-content').addEventListener('input', queueSnapshot);
  preview.querySelector('.live-preview-content').addEventListener('blur', (event) => {
    if (linkPopup.classList.contains('is-open')) return;
    if (event.target.dataset.previewField || event.target.dataset.previewExtra !== undefined || event.target.dataset.previewExtraList !== undefined || event.target.dataset.previewColumn !== undefined) { saveEditableMarkup(event.target); render(); }
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
  builderForm.addEventListener('submit', () => { builderDirty = false; setSaveState('Saving…'); });
  builderForm.addEventListener('input', () => { builderDirty = true; setSaveState('Unsaved changes'); });
  builderForm.addEventListener('change', () => { builderDirty = true; setSaveState('Unsaved changes'); });
  window.addEventListener('beforeunload', event => {
    if (!builderDirty) return;
    event.preventDefault();
    event.returnValue = 'You have unsaved landing-page changes.';
    return event.returnValue;
  });
  new MutationObserver(render).observe(sections, { childList: true, subtree: false });
  render();
})();
</script>
