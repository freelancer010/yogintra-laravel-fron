@extends('layouts.admin')
@include('admin.landing_page.partials.builder-styles')

@section('content')

@if($errors->any())
  <div class="builder-toast builder-toast-error" role="alert">{{ $errors->first() }}</div>
@endif

<section class="content landing-builder-shell">
<div class="container-fluid">
    <div class="row">
    <div class="col-sm-12">
        <div class="card card-default">
        <div class="card-header">
            <div class="d-flex align-items-center w-100 landing-page-header">
                <h3 class="card-title mb-0">Edit landing page</h3>
                <div class="landing-page-header-actions ml-auto d-flex align-items-center justify-content-end">
                    <a href="{{ url('/city/' . $page->page_slug) }}" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm mr-2"><i class="fas fa-external-link-alt" aria-hidden="true"></i> View live page</a>
                    <button type="button" class="btn btn-outline-warning btn-sm mr-2" id="classic-layout-toggle"><i class="fas fa-history" aria-hidden="true"></i> Classic layout: <span>{{ ($page->use_classic_layout ?? false) ? 'On' : 'Off' }}</span></button>
                    <button type="submit" form="landing-page-form" formnovalidate class="btn btn-success builder-submit floating-update-button">Update page</button>
                </div>
            </div>
        </div>

        <form id="landing-page-form" action="{{ route('admin.landing-pages.update', $page->page_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 form-group mb-5 border-bottom text-center pb-5">
                        <label>Page Image</label><br>
                        @if($page->page_image)
                            <img id="preview-image" src="{{ asset($page->page_image) }}" width="45%" alt="Page Image">
                        @endif
                        <input type="file" name="page_image" class="form-control w-50 m-auto" onchange="previewImage(event)">
                    </div>
                        
                    <div class="col-md-6 form-group">
                        <label>Page Name <span class="text-danger">*</span></label>
                        <input type="text" name="page_name" class="form-control" required value="{{ $page->page_name }}">
                    </div>

                    <div class="col-md-6 form-group">
                    <label>Page Slug</label>
                    <input type="text" name="page_slug" class="form-control" required pattern="[a-z0-9]+(?:-[a-z0-9]+)*" value="{{ $page->page_slug }}">
                    <small class="form-text text-muted">Published at /city/{{ $page->page_slug }}</small>
                    </div>

                    <div class="col-md-6 form-group">
                    <label>Meta Description</label>
                    <textarea name="page_meta_description" class="form-control">{{ $page->page_meta_description }}</textarea>
                    </div>

                    <div class="col-md-6 form-group">
                    <label>Meta Keywords</label>
                    <textarea name="page_keywords" class="form-control">{{ $page->page_keywords }}</textarea>
                    </div>

                    <div class="col-md-6 form-group">
                    <label>Meta Title</label>
                    <input type="text" name="page_meta_title" class="form-control" value="{{ $page->page_meta_title }}">
                    </div>

                    <div class="col-md-6 form-group">
                    <label>Head Code</label>
                    <textarea name="page_head_code" class="form-control">{{ $page->page_head_code }}</textarea>
                    </div>

                    <div class="col-md-12 form-group">
                      <div class="builder-field d-flex align-items-center justify-content-between" style="gap:16px;">
                        <div><label class="mb-1">Page rendering</label><p class="mb-0 text-muted small">Use the original classic page design instead of the visual builder sections. Your builder content is retained and can be re-enabled at any time.</p></div>
                        <div class="custom-control custom-switch flex-shrink-0">
                          <input type="hidden" name="use_classic_layout" value="0">
                          <input type="checkbox" class="custom-control-input" id="use-classic-layout" name="use_classic_layout" value="1" {{ ($page->use_classic_layout ?? false) ? 'checked' : '' }}>
                          <label class="custom-control-label" for="use-classic-layout">Use classic layout</label>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12 form-group">
                    <label>Heading <span class="text-danger">*</span></label>
                    <input type="text" name="page_image_title" class="form-control" required value="{{ $page->page_image_title }}">
                    </div>

                    <div class="col-md-12 form-group">
                    <label>Sub-heading <span class="text-danger">*</span></label>
                    <input type="text" name="page_image_description" class="form-control" required value="{{ $page->page_image_description }}">
                    </div>

                    <div class="col-md-12">
                      <div class="card border-primary mt-3 builder-section-panel">
                        <div class="card-header d-flex justify-content-between align-items-center">
                          <strong>Page Builder</strong>
                          <div class="section-palette"><button type="button" class="add-section" data-section-type="text">✦ Text</button><button type="button" class="add-section" data-section-type="image_text">▧ Image + Text</button><button type="button" class="add-section" data-section-type="cta">↗ CTA</button></div>
                        </div>
                        @if($sections->isEmpty())
                          <div class="alert alert-info m-3 mb-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 12px;">
                              <div><strong>Convert the classic page layout.</strong><br><small>This creates editable, city-aware sections from the old shared landing-page content. Review and personalise the generated copy before publishing.</small></div>
                              <button type="submit" form="landing-page-form" formaction="{{ route('admin.landing-pages.convert-classic', $page->page_id) }}" formmethod="POST" class="btn btn-primary">Convert classic layout</button>
                            </div>
                          </div>
                        @endif
                        <div class="card-body" id="sections">
                          @foreach($sections as $index => $section)
                            <div class="card border mb-3 page-builder-section">
                              <div class="card-header d-flex justify-content-between"><strong>Section</strong><div><button type="button" class="btn btn-outline-secondary btn-sm move-up">↑</button> <button type="button" class="btn btn-outline-secondary btn-sm move-down">↓</button> <button type="button" class="btn btn-outline-danger btn-sm remove-section">Remove</button></div></div>
                              <div class="card-body">
                                {{-- Hidden persistence fields hydrate the visual canvas on reload. --}}
                                <input type="hidden" name="sections[{{ $index }}][padding_x]" value="{{ $section->padding_x ?? 0 }}">
                                <input type="hidden" name="sections[{{ $index }}][margin_x]" value="{{ $section->margin_x ?? 0 }}">
                                <input type="hidden" name="sections[{{ $index }}][text_color]" value="{{ $section->text_color ?? '#183c45' }}">
                                <input type="hidden" name="sections[{{ $index }}][heading_size]" value="{{ $section->heading_size ?? 32 }}">
                                <input type="hidden" name="sections[{{ $index }}][description_color]" value="{{ $section->description_color ?? '#647b82' }}">
                                <input type="hidden" name="sections[{{ $index }}][description_size]" value="{{ $section->description_size ?? 16 }}">
                                <input type="hidden" name="sections[{{ $index }}][text_align]" value="{{ $section->text_align ?? 'left' }}">
                                <input type="hidden" name="sections[{{ $index }}][element_styles]" value="{{ $section->element_styles ?? '{}' }}">
                                <input type="hidden" name="sections[{{ $index }}][blocks]" value="{{ $section->blocks ?? '' }}">
                                <input type="hidden" name="sections[{{ $index }}][elements]" value="{{ $section->elements ?? '' }}">
                                <input type="hidden" name="sections[{{ $index }}][grid_columns]" value="{{ $section->grid_columns ?? 3 }}">
                                <input type="hidden" name="sections[{{ $index }}][card_layout]" value="{{ $section->card_layout ?? 'stacked' }}">
                                <input type="hidden" name="sections[{{ $index }}][card_alignment]" value="{{ $section->card_alignment ?? 'center' }}">
                                <input type="hidden" name="sections[{{ $index }}][grid_gap]" value="{{ $section->grid_gap ?? 24 }}">
                                <input type="hidden" name="sections[{{ $index }}][image_size]" value="{{ $section->image_size ?? 42 }}">
                                <div class="row">
                                <div class="col-md-4 form-group"><label>Layout</label><select name="sections[{{ $index }}][section_type]" class="form-control"><option value="text" @selected($section->section_type === 'text')>Text</option><option value="image_text" @selected($section->section_type === 'image_text')>Image + Text</option><option value="feature_grid" @selected($section->section_type === 'feature_grid')>Feature grid</option><option value="custom_columns" @selected($section->section_type === 'custom_columns')>Empty columns</option><option value="testimonial" @selected($section->section_type === 'testimonial')>Testimonials</option><option value="faq" @selected($section->section_type === 'faq')>Homepage FAQ</option><option value="image" @selected($section->section_type === 'image')>Image / Hero</option><option value="cta" @selected($section->section_type === 'cta')>Call to Action</option></select></div>
                                <div class="col-md-4 form-group"><label>Background</label><input name="sections[{{ $index }}][background_color]" class="form-control" value="{{ $section->background_color }}" placeholder="#ffffff"></div>
                                <div class="col-md-4 form-group"><label>Image</label><input type="file" name="sections[{{ $index }}][image]" class="form-control" accept="image/*">@if($section->image)<input type="hidden" name="sections[{{ $index }}][existing_image]" value="{{ $section->image }}"><small class="d-block mt-1">Current: {{ basename($section->image) }}</small>@endif</div>
                                <div class="col-md-12"><div class="layout-tools"><div><label>Image side</label><select name="sections[{{ $index }}][image_position]" class="form-control"><option value="left" @selected(($section->image_position ?? 'left') === 'left')>Left</option><option value="right" @selected(($section->image_position ?? 'left') === 'right')>Right</option></select></div><div class="range-control"><label>Section padding <span class="range-value">{{ $section->padding_y ?? 48 }}px</span></label><input type="range" name="sections[{{ $index }}][padding_y]" min="0" max="160" value="{{ $section->padding_y ?? 48 }}" oninput="this.previousElementSibling.querySelector('.range-value').textContent=this.value+'px'"></div><div class="range-control"><label>Section margin <span class="range-value">{{ $section->margin_y ?? 0 }}px</span></label><input type="range" name="sections[{{ $index }}][margin_y]" min="0" max="120" value="{{ $section->margin_y ?? 0 }}" oninput="this.previousElementSibling.querySelector('.range-value').textContent=this.value+'px'"></div></div></div>
                                <div class="col-md-12 form-group"><label>Heading</label><input name="sections[{{ $index }}][heading]" class="form-control" value="{{ $section->heading }}"></div>
                                <div class="col-md-12 form-group"><label>Text / HTML</label><textarea name="sections[{{ $index }}][content]" class="form-control" rows="5">{{ $section->content }}</textarea></div>
                                <div class="col-md-4 form-group"><label>Image alt text</label><input name="sections[{{ $index }}][image_alt]" class="form-control" value="{{ $section->image_alt }}"></div>
                                <div class="col-md-4 form-group"><label>Button text</label><input name="sections[{{ $index }}][button_text]" class="form-control" value="{{ $section->button_text }}"></div>
                                <div class="col-md-4 form-group"><label>Button URL</label><input type="url" name="sections[{{ $index }}][button_url]" class="form-control" value="{{ $section->button_url }}"></div>
                              </div></div>
                            </div>
                          @endforeach
                        </div>
                      </div>
                    </div>

                </div>
            </div>
        </form>

        </div>
    </div>
    </div>
</div>
</section>
<script>
    function previewImage(event) {
        if (!event.target.files?.[0]) return;
        const reader = new FileReader();
        reader.onload = function () {
        let output = document.getElementById('preview-image');
        if (!output) { output = document.createElement('img'); output.id = 'preview-image'; event.target.parentElement.prepend(output); }
        output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    let sectionIndex = {{ $sections->count() }};
    const sections = document.getElementById('sections');
    document.querySelectorAll('.add-section').forEach((button) => button.addEventListener('click', () => {
      sections.querySelector('.section-empty')?.remove();
      const index = sectionIndex++;
      const type = button.dataset.sectionType;
      const card = document.createElement('div');
      card.className = 'card border mb-3 page-builder-section';
      card.innerHTML = `<div class="card-header d-flex justify-content-between"><strong>Section</strong><div><button type="button" class="btn btn-outline-secondary btn-sm move-up">↑</button> <button type="button" class="btn btn-outline-secondary btn-sm move-down">↓</button> <button type="button" class="btn btn-outline-danger btn-sm remove-section">Remove</button></div></div><div class="card-body"><div class="row"><div class="col-md-4 form-group"><label>Layout</label><select name="sections[${index}][section_type]" class="form-control"><option value="text" ${type === 'text' ? 'selected' : ''}>Text</option><option value="image_text" ${type === 'image_text' ? 'selected' : ''}>Image + Text</option><option value="custom_columns" ${type === 'custom_columns' ? 'selected' : ''}>Empty columns</option><option value="testimonial" ${type === 'testimonial' ? 'selected' : ''}>Testimonials</option><option value="faq" ${type === 'faq' ? 'selected' : ''}>Homepage FAQ</option><option value="cta" ${type === 'cta' ? 'selected' : ''}>Call to Action</option></select></div><div class="col-md-4 form-group"><label>Background</label><input name="sections[${index}][background_color]" class="form-control" placeholder="#ffffff"></div><div class="col-md-4 form-group"><label>Image</label><input type="file" name="sections[${index}][image]" class="form-control" accept="image/*"></div><div class="col-md-12"><div class="layout-tools"><div><label>Image side</label><select name="sections[${index}][image_position]" class="form-control"><option value="left">Left</option><option value="right">Right</option></select></div><div class="range-control"><label>Section padding <span class="range-value">48px</span></label><input type="range" name="sections[${index}][padding_y]" min="0" max="160" value="48" oninput="this.previousElementSibling.querySelector('.range-value').textContent=this.value+'px'"></div><div class="range-control"><label>Section margin <span class="range-value">0px</span></label><input type="range" name="sections[${index}][margin_y]" min="0" max="120" value="0" oninput="this.previousElementSibling.querySelector('.range-value').textContent=this.value+'px'"></div></div></div><div class="col-md-12 form-group"><label>Heading</label><input name="sections[${index}][heading]" class="form-control"></div><div class="col-md-12 form-group"><label>Text / HTML</label><textarea name="sections[${index}][content]" class="form-control" rows="5"></textarea></div><div class="col-md-4 form-group"><label>Image alt text</label><input name="sections[${index}][image_alt]" class="form-control"></div><div class="col-md-4 form-group"><label>Button text</label><input name="sections[${index}][button_text]" class="form-control"></div><div class="col-md-4 form-group"><label>Button URL</label><input type="url" name="sections[${index}][button_url]" class="form-control"></div></div></div>`;
      sections.appendChild(card);
    }));
    sections.addEventListener('click', (event) => {
      const card = event.target.closest('.page-builder-section');
      if (!card) return;
      if (event.target.closest('.remove-section')) { card.classList.add('is-removing'); setTimeout(() => { card.remove(); if (!sections.children.length) sections.innerHTML = '<div class="section-empty">Choose a section type above to start building your page.</div>'; }, 220); }
      if (event.target.closest('.move-up') && card.previousElementSibling) sections.insertBefore(card, card.previousElementSibling);
      if (event.target.closest('.move-down') && card.nextElementSibling) sections.insertBefore(card.nextElementSibling, card);
    });
    document.body.classList.add('landing-builder-focus');
    const builderMenuButton = document.getElementById('sidebar-toggle');
    builderMenuButton.addEventListener('click', function () { document.body.classList.toggle('landing-builder-focus'); this.textContent = document.body.classList.contains('landing-builder-focus') ? 'Show menu' : 'Focus editor'; });
    const formBody = document.querySelector('.landing-builder-shell form .card-body');
    const workspace = document.createElement('div');
    workspace.className = 'builder-workspace';
    workspace.innerHTML = '<main class="builder-canvas"><div class="builder-canvas-header"><div><h4>Page canvas</h4><small class="text-muted">Click preview text to edit it inline</small></div><button type="button" class="builder-settings-button" data-toggle="modal" data-target="#page-settings-modal"><i class="fa fa-cog" aria-hidden="true"></i><span>Manage page settings</span></button></div></main><aside class="builder-inspector"><div class="builder-inspector-title"><span>Section editor</span><span>✦</span></div></aside>';
    formBody.prepend(workspace);
    @if($sections->isEmpty())
    const classicConversionNotice = document.createElement('div');
    classicConversionNotice.className = 'alert alert-info mt-3 mb-0';
    classicConversionNotice.innerHTML = '<div class="d-flex flex-wrap align-items-center justify-content-between" style="gap:12px"><div><strong>Convert the classic page layout</strong><br><small>Create editable, city-aware sections from the old shared landing-page content.</small></div><button type="submit" class="btn btn-primary">Convert classic layout</button></div>';
    const classicConversionButton = classicConversionNotice.querySelector('button');
    classicConversionButton.formAction = '{{ route('admin.landing-pages.convert-classic', $page->page_id) }}';
    classicConversionButton.formMethod = 'post';
    workspace.querySelector('.builder-canvas').appendChild(classicConversionNotice);
    @endif
    const inspector = workspace.querySelector('.builder-inspector');
    const heroEditor = document.createElement('section');
    heroEditor.className = 'hero-editor';
    heroEditor.innerHTML = '<div class="hero-editor-heading"><div><strong>Hero section</strong><small>Edit the page image and its overlay content here.</small></div><span>Hero</span></div><div class="hero-editor-fields"></div>';
    workspace.querySelector('.builder-canvas').appendChild(heroEditor);
    const heroFields = [...formBody.querySelectorAll('.form-group')].filter(group => group.querySelector('[name="page_image"], [name="page_image_title"], [name="page_image_description"]'));
    heroFields.forEach(group => heroEditor.querySelector('.hero-editor-fields').appendChild(group));
    const heroImageInput = heroEditor.querySelector('[name="page_image"]');
    const heroTitleInput = heroEditor.querySelector('[name="page_image_title"]');
    const heroDescriptionInput = heroEditor.querySelector('[name="page_image_description"]');
    const currentHeroImage = heroEditor.querySelector('#preview-image')?.src || '';
    const heroStage = document.createElement('div');
    heroStage.className = 'hero-canvas-stage';
    heroStage.innerHTML = '<button type="button" class="hero-image-action"><span>' + (currentHeroImage ? 'Change hero image' : 'Add hero image') + '</span></button><div class="hero-canvas-copy"><small>Hero content · click text to edit</small><h2 contenteditable="true">' + (heroTitleInput.value || 'Hero heading') + '</h2><p contenteditable="true">' + (heroDescriptionInput.value || 'Add a supporting hero message.') + '</p></div>';
    if (currentHeroImage) heroStage.style.backgroundImage = 'linear-gradient(90deg, rgba(25,19,15,.43), rgba(25,19,15,.68)), url("' + currentHeroImage + '")';
    heroEditor.querySelector('.hero-editor-fields').before(heroStage);
    heroEditor.querySelector('.hero-editor-fields').classList.add('hero-persistence-fields');
    heroStage.querySelector('.hero-image-action').addEventListener('click', () => heroImageInput.click());
    heroStage.querySelector('h2').addEventListener('input', event => { heroTitleInput.value = event.target.innerText; });
    heroStage.querySelector('p').addEventListener('input', event => { heroDescriptionInput.value = event.target.innerText; });
    heroImageInput.addEventListener('change', event => { if (!event.target.files?.[0]) return; const reader = new FileReader(); reader.onload = () => { heroStage.style.backgroundImage = 'linear-gradient(90deg, rgba(25,19,15,.43), rgba(25,19,15,.68)), url("' + reader.result + '")'; heroStage.querySelector('.hero-image-action span').textContent = 'Change hero image'; }; reader.readAsDataURL(event.target.files[0]); });
    const settingsModal = document.createElement('div');
    settingsModal.className = 'modal fade'; settingsModal.id = 'page-settings-modal'; settingsModal.tabIndex = -1;
    settingsModal.innerHTML = '<div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Manage page settings</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div><div class="modal-body row" id="page-settings-fields"></div><div class="modal-footer"><a class="btn btn-outline-danger mr-auto" href="{{ route('admin.landing-pages.destroy', $page->page_id) }}" onclick="return confirm(\'Delete this landing page?\')">Delete page</a><button type="button" class="btn btn-secondary" data-dismiss="modal">Done</button></div></div></div>';
    formBody.appendChild(settingsModal);
    const settingsFields = settingsModal.querySelector('#page-settings-fields');
    formBody.querySelectorAll('.form-group').forEach(group => { if (!group.closest('.builder-section-panel') && !group.closest('.hero-editor')) settingsFields.appendChild(group); });
    const classicLayoutInput = formBody.querySelector('#use-classic-layout');
    const classicLayoutToggle = document.getElementById('classic-layout-toggle');
    const syncClassicLayoutToggle = () => {
      const enabled = classicLayoutInput?.checked;
      classicLayoutToggle?.classList.toggle('btn-warning', enabled);
      classicLayoutToggle?.classList.toggle('btn-outline-warning', !enabled);
      const label = classicLayoutToggle?.querySelector('span');
      if (label) label.textContent = enabled ? 'On' : 'Off';
      if (classicLayoutToggle) classicLayoutToggle.title = enabled ? 'Classic layout will be shown after you update the page.' : 'Builder layout will be shown after you update the page.';
    };
    classicLayoutToggle?.addEventListener('click', () => { if (classicLayoutInput) { classicLayoutInput.checked = !classicLayoutInput.checked; syncClassicLayoutToggle(); } });
    classicLayoutInput?.addEventListener('change', syncClassicLayoutToggle);
    syncClassicLayoutToggle();
    const panel = formBody.querySelector('.builder-section-panel');
    if (panel) workspace.querySelector('.builder-inspector').appendChild(panel.closest('.col-md-12'));
    const submit = formBody.querySelector('.builder-submit');
    if (submit) {
      const submitWrapper = submit.closest('.col-md-12');
      workspace.querySelector('.builder-inspector-title').appendChild(submit);
      submit.classList.add('builder-inspector-submit');
      submitWrapper?.remove();
    }
</script>
@include('admin.landing_page.partials.live-preview')
<script>setTimeout(() => document.querySelector('.builder-toast')?.classList.add('is-hidden'), 3500);</script>
@endsection
