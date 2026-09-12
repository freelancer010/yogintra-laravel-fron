@extends('layouts.admin')
@include('admin.landing_page.partials.builder-styles')

@section('content')

  <section class="content landing-builder-shell">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-default">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center"><h3 class="card-title mb-0">Create a landing page</h3><div><button class="focus-toggle mr-2" type="button" id="sidebar-toggle">Show menu</button><button type="submit" form="landing-page-form" class="btn btn-success builder-submit">Save &amp; Publish</button></div></div>
            </div>

            <form id="landing-page-form" action="{{ route('admin.landing-pages.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                @if(session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                  <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                  <div class="alert alert-danger">
                    <ul class="mb-0">
                      @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                <div class="builder-hero-label col-12">Page settings &amp; hero</div>
                <div class="row">
                  <div class="col-md-6 form-group"><div class="builder-field">
                    <label>Page Name <span class="text-danger">*</span></label>
                    <input type="text" name="page_name" class="form-control" id="page_name" required>
                  </div></div>
                  <div class="col-md-6 form-group"><div class="builder-field">
                    <label>Page Slug <span class="text-danger">*</span></label>
                    <input type="text" name="page_slug" class="form-control" id="page_slug" required pattern="[a-z0-9]+(?:-[a-z0-9]+)*" placeholder="online-yoga-in-mumbai">
                    <small class="form-text text-muted">This page will be published at /city/your-slug.</small>
                  </div></div>
                  <div class="col-md-6 form-group"><div class="builder-field">
                    <label>Meta Description</label>
                    <textarea name="page_meta_description" class="form-control"></textarea>
                  </div></div>
                  <div class="col-md-6 form-group"><div class="builder-field">
                    <label>Meta Keywords</label>
                    <textarea name="page_keywords" class="form-control"></textarea>
                  </div></div>
                  <div class="col-md-6 form-group"><div class="builder-field">
                    <label>Meta Title</label>
                    <input type="text" name="page_meta_title" class="form-control">
                  </div></div>
                  <div class="col-md-6 form-group"><div class="builder-field">
                    <label>Head Code</label>
                    <textarea name="page_head_code" class="form-control"></textarea>
                  </div></div>
                  <div class="col-md-12 form-group"><div class="builder-field">
                    <label>Heading <span class="text-danger">*</span></label>
                    <input type="text" name="page_image_title" class="form-control" required>
                  </div></div>
                  <div class="col-md-12 form-group"><div class="builder-field">
                    <label>Sub-heading <span class="text-danger">*</span></label>
                    <input type="text" name="page_image_description" class="form-control" required>
                  </div></div>
                  <div class="col-md-12">
                    <div class="card border-primary mt-3 builder-section-panel">
                      <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Page Builder</strong>
                        <div class="section-palette"><button type="button" class="add-section" data-section-type="text">✦ Text</button><button type="button" class="add-section" data-section-type="image_text">▧ Image + Text</button><button type="button" class="add-section" data-section-type="cta">↗ CTA</button></div>
                      </div>
                      <div class="card-body" id="sections"><div class="section-empty">Choose a section type above to start building your page.</div></div>
                      <div class="card-footer text-muted">Sections animate into place. Use ↑ and ↓ to set the public page order.</div>
                    </div>
                  </div>
                  <div class="col-md-6 form-group">
                    <label>Page Image <span class="text-danger">*</span></label>
                    <input type="file" name="page_image" class="form-control" onchange="previewImage(event)">
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
  document.getElementById("page_name").addEventListener("keyup", function () {
    const name = this.value.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    document.getElementById("page_slug").value = name;
  });

  let sectionIndex = 0;
  const sections = document.getElementById('sections');
  document.querySelectorAll('.add-section').forEach((button) => button.addEventListener('click', () => {
    sections.querySelector('.section-empty')?.remove();
    const index = sectionIndex++;
    const type = button.dataset.sectionType;
    const card = document.createElement('div');
    card.className = 'card border mb-3 page-builder-section';
    card.innerHTML = `
      <div class="card-header d-flex justify-content-between"><strong>Section</strong><div><button type="button" class="btn btn-outline-secondary btn-sm move-up">↑</button> <button type="button" class="btn btn-outline-secondary btn-sm move-down">↓</button> <button type="button" class="btn btn-outline-danger btn-sm remove-section">Remove</button></div></div>
      <div class="card-body"><div class="row">
        <div class="col-md-4 form-group"><label>Layout</label><select name="sections[${index}][section_type]" class="form-control"><option value="text" ${type === 'text' ? 'selected' : ''}>Text</option><option value="image_text" ${type === 'image_text' ? 'selected' : ''}>Image + Text</option><option value="cta" ${type === 'cta' ? 'selected' : ''}>Call to Action</option></select></div>
        <div class="col-md-4 form-group"><label>Background</label><input name="sections[${index}][background_color]" class="form-control" placeholder="#ffffff" pattern="#[0-9A-Fa-f]{6}"></div>
        <div class="col-md-4 form-group"><label>Image</label><input type="file" name="sections[${index}][image]" class="form-control" accept="image/*"></div>
        <div class="col-md-12"><div class="layout-tools"><div><label>Image side</label><select name="sections[${index}][image_position]" class="form-control"><option value="left">Left</option><option value="right">Right</option></select></div><div class="range-control"><label>Section padding <span class="range-value">48px</span></label><input type="range" name="sections[${index}][padding_y]" min="0" max="160" value="48" oninput="this.previousElementSibling.querySelector('.range-value').textContent=this.value+'px'"></div><div class="range-control"><label>Section margin <span class="range-value">0px</span></label><input type="range" name="sections[${index}][margin_y]" min="0" max="120" value="0" oninput="this.previousElementSibling.querySelector('.range-value').textContent=this.value+'px'"></div></div></div>
        <div class="col-md-12 form-group"><label>Heading</label><input name="sections[${index}][heading]" class="form-control" maxlength="255"></div>
        <div class="col-md-12 form-group"><label>Text / HTML</label><textarea name="sections[${index}][content]" class="form-control" rows="5"></textarea></div>
        <div class="col-md-4 form-group"><label>Image alt text</label><input name="sections[${index}][image_alt]" class="form-control"></div>
        <div class="col-md-4 form-group"><label>Button text</label><input name="sections[${index}][button_text]" class="form-control"></div>
        <div class="col-md-4 form-group"><label>Button URL</label><input type="url" name="sections[${index}][button_url]" class="form-control" placeholder="https://example.com"></div>
      </div></div>`;
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
  workspace.innerHTML = '<main class="builder-canvas"><div class="builder-canvas-header"><div><h4>Page canvas</h4><small class="text-muted">Click preview text to edit it inline</small></div><button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#page-settings-modal">Manage page settings</button></div></main><aside class="builder-inspector"><div class="builder-inspector-title"><span>Section editor</span><span>✦</span></div></aside>';
  formBody.prepend(workspace);
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
  const heroStage = document.createElement('div');
  heroStage.className = 'hero-canvas-stage';
  heroStage.innerHTML = '<button type="button" class="hero-image-action"><span>Add hero image</span></button><div class="hero-canvas-copy"><small>Hero content · click text to edit</small><h2 contenteditable="true">Hero heading</h2><p contenteditable="true">Add a supporting hero message.</p></div>';
  heroEditor.querySelector('.hero-editor-fields').before(heroStage);
  heroEditor.querySelector('.hero-editor-fields').classList.add('hero-persistence-fields');
  heroStage.querySelector('.hero-image-action').addEventListener('click', () => heroImageInput.click());
  heroStage.querySelector('h2').addEventListener('input', event => { heroTitleInput.value = event.target.innerText; });
  heroStage.querySelector('p').addEventListener('input', event => { heroDescriptionInput.value = event.target.innerText; });
  heroImageInput.addEventListener('change', event => { if (!event.target.files?.[0]) return; const reader = new FileReader(); reader.onload = () => { heroStage.style.backgroundImage = 'linear-gradient(90deg, rgba(25,19,15,.43), rgba(25,19,15,.68)), url("' + reader.result + '")'; heroStage.querySelector('.hero-image-action span').textContent = 'Change hero image'; }; reader.readAsDataURL(event.target.files[0]); });
  const settingsModal = document.createElement('div');
  settingsModal.className = 'modal fade'; settingsModal.id = 'page-settings-modal'; settingsModal.tabIndex = -1;
  settingsModal.innerHTML = '<div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Manage page settings</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div><div class="modal-body row" id="page-settings-fields"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Done</button></div></div></div>';
  formBody.appendChild(settingsModal);
  const settingsFields = settingsModal.querySelector('#page-settings-fields');
  formBody.querySelectorAll('.form-group').forEach(group => { if (!group.closest('.builder-section-panel') && !group.closest('.hero-editor')) settingsFields.appendChild(group); });
  const panel = formBody.querySelector('.builder-section-panel');
  if (panel) workspace.querySelector('.builder-inspector').appendChild(panel.closest('.col-md-12'));
  const submit = formBody.querySelector('.builder-submit');
  if (submit) inspector.appendChild(submit.closest('.col-md-12'));
</script>
@include('admin.landing_page.partials.live-preview')
@endsection
