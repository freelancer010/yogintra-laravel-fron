@extends('layouts.admin')
@include('admin.landing_page.partials.builder-styles')

@section('content')

<section class="content landing-builder-shell">
<div class="container-fluid">
    <div class="row">
    <div class="col-sm-12">
        <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title mb-1">Edit landing page</h3>
            <div class="d-flex justify-content-between align-items-center"><div class="small opacity-75">Refine content, rearrange sections, and republish confidently.</div><button class="focus-toggle" type="button" id="sidebar-toggle">Show menu</button></div>
        </div>

        <form action="{{ route('admin.landing-pages.update', $page->page_id) }}" method="POST" enctype="multipart/form-data">
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
                        <div class="card-body" id="sections">
                          @foreach($sections as $index => $section)
                            <div class="card border mb-3 page-builder-section">
                              <div class="card-header d-flex justify-content-between"><strong>Section</strong><div><button type="button" class="btn btn-outline-secondary btn-sm move-up">↑</button> <button type="button" class="btn btn-outline-secondary btn-sm move-down">↓</button> <button type="button" class="btn btn-outline-danger btn-sm remove-section">Remove</button></div></div>
                              <div class="card-body"><div class="row">
                                <div class="col-md-4 form-group"><label>Layout</label><select name="sections[{{ $index }}][section_type]" class="form-control"><option value="text" @selected($section->section_type === 'text')>Text</option><option value="image_text" @selected($section->section_type === 'image_text')>Image + Text</option><option value="cta" @selected($section->section_type === 'cta')>Call to Action</option></select></div>
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

                    <div class="col-md-12">
                    <button type="submit" class="btn btn-success builder-submit float-right">Save &amp; Publish</button>
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
        const reader = new FileReader();
        reader.onload = function () {
        const output = document.getElementById('preview-image');
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
      card.innerHTML = `<div class="card-header d-flex justify-content-between"><strong>Section</strong><div><button type="button" class="btn btn-outline-secondary btn-sm move-up">↑</button> <button type="button" class="btn btn-outline-secondary btn-sm move-down">↓</button> <button type="button" class="btn btn-outline-danger btn-sm remove-section">Remove</button></div></div><div class="card-body"><div class="row"><div class="col-md-4 form-group"><label>Layout</label><select name="sections[${index}][section_type]" class="form-control"><option value="text" ${type === 'text' ? 'selected' : ''}>Text</option><option value="image_text" ${type === 'image_text' ? 'selected' : ''}>Image + Text</option><option value="cta" ${type === 'cta' ? 'selected' : ''}>Call to Action</option></select></div><div class="col-md-4 form-group"><label>Background</label><input name="sections[${index}][background_color]" class="form-control" placeholder="#ffffff"></div><div class="col-md-4 form-group"><label>Image</label><input type="file" name="sections[${index}][image]" class="form-control" accept="image/*"></div><div class="col-md-12"><div class="layout-tools"><div><label>Image side</label><select name="sections[${index}][image_position]" class="form-control"><option value="left">Left</option><option value="right">Right</option></select></div><div class="range-control"><label>Section padding <span class="range-value">48px</span></label><input type="range" name="sections[${index}][padding_y]" min="0" max="160" value="48" oninput="this.previousElementSibling.querySelector('.range-value').textContent=this.value+'px'"></div><div class="range-control"><label>Section margin <span class="range-value">0px</span></label><input type="range" name="sections[${index}][margin_y]" min="0" max="120" value="0" oninput="this.previousElementSibling.querySelector('.range-value').textContent=this.value+'px'"></div></div></div><div class="col-md-12 form-group"><label>Heading</label><input name="sections[${index}][heading]" class="form-control"></div><div class="col-md-12 form-group"><label>Text / HTML</label><textarea name="sections[${index}][content]" class="form-control" rows="5"></textarea></div><div class="col-md-4 form-group"><label>Image alt text</label><input name="sections[${index}][image_alt]" class="form-control"></div><div class="col-md-4 form-group"><label>Button text</label><input name="sections[${index}][button_text]" class="form-control"></div><div class="col-md-4 form-group"><label>Button URL</label><input type="url" name="sections[${index}][button_url]" class="form-control"></div></div></div>`;
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
    document.getElementById('sidebar-toggle').addEventListener('click', function () { document.body.classList.toggle('landing-builder-focus'); this.textContent = document.body.classList.contains('landing-builder-focus') ? 'Show menu' : 'Focus editor'; });
    const formBody = document.querySelector('.landing-builder-shell form .card-body');
    const workspace = document.createElement('div');
    workspace.className = 'builder-workspace';
    workspace.innerHTML = '<main class="builder-canvas"><div class="builder-canvas-header"><div><h4>Page canvas</h4><small class="text-muted">Click preview text to edit it inline</small></div><button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#page-settings-modal">Manage page settings</button></div></main><aside class="builder-inspector"><div class="builder-inspector-title"><span>Section editor</span><span>✦</span></div></aside>';
    formBody.prepend(workspace);
    const inspector = workspace.querySelector('.builder-inspector');
    const settingsModal = document.createElement('div');
    settingsModal.className = 'modal fade'; settingsModal.id = 'page-settings-modal'; settingsModal.tabIndex = -1;
    settingsModal.innerHTML = '<div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Manage page settings</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div><div class="modal-body row" id="page-settings-fields"></div><div class="modal-footer"><a class="btn btn-outline-danger mr-auto" href="{{ route('admin.landing-pages.destroy', $page->page_id) }}" onclick="return confirm(\'Delete this landing page?\')">Delete page</a><button type="button" class="btn btn-secondary" data-dismiss="modal">Done</button></div></div></div>';
    formBody.appendChild(settingsModal);
    const settingsFields = settingsModal.querySelector('#page-settings-fields');
    formBody.querySelectorAll('.form-group').forEach(group => { if (!group.closest('.builder-section-panel')) settingsFields.appendChild(group); });
    const panel = formBody.querySelector('.builder-section-panel');
    if (panel) workspace.querySelector('.builder-inspector').appendChild(panel.closest('.col-md-12'));
    const submit = formBody.querySelector('.builder-submit');
    if (submit) inspector.appendChild(submit.closest('.col-md-12'));
</script>
@include('admin.landing_page.partials.live-preview')
@endsection
