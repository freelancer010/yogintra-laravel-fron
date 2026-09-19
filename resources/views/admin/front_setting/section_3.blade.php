@extends('layouts.admin')

@section('content')
@php
    $fixedImages = json_decode($setting->section3_fixed_card_images ?: '{}', true) ?: [];
    $fixedCards = [
        'ttc' => ['label' => 'TTC', 'default' => 'assets/icon-thumb3-150x150.jpg'],
        'retreat' => ['label' => 'Retreat', 'default' => 'assets/icon-thumb4-150x150.jpg'],
        'workshop' => ['label' => 'Workshop', 'default' => 'assets/icon-thumb1-150x150.webp'],
        'yoga_center' => ['label' => 'Yoga Center', 'default' => 'uploads/yog_center.jpg'],
    ];
@endphp

<div class="content-header">
    <div class="container-fluid"><h1 class="mb-0">Section 3 builder</h1></div>
</div>

<section class="content">
    <div class="container-fluid">
        @include('admin.partials.flash')
        <form method="POST" action="{{ route('admin.front.section3.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="section3-canvas" id="section3Canvas" style="background-image:url('{{ asset($setting->section3_background_image ?: 'assets/parallax-decor2.png') }}')">
                        <div class="canvas-copy" id="canvasCopy">
                            <p class="canvas-kicker">YogIntra services</p>
                            <h2 id="previewHeading"></h2>
                            <p id="previewDescription"></p>
                        </div>
                        <div class="service-preview-grid">
                            @foreach($serviceCategories as $category)
                                <article class="service-preview-card is-readonly">
                                    <img src="{{ asset($category->service_cat_image) }}" alt="{{ $category->service_cat_name }}">
                                    <span>{{ $category->service_cat_name }}</span>
                                    <small>Service image</small>
                                </article>
                            @endforeach
                            @foreach($fixedCards as $key => $card)
                                <article class="service-preview-card" data-card="{{ $key }}">
                                    <img src="{{ asset($fixedImages[$key] ?? $card['default']) }}" alt="{{ $card['label'] }}">
                                    <span>{{ $card['label'] }}</span>
                                    <small>Editable image</small>
                                </article>
                            @endforeach
                        </div>
                    </div>
                    <p class="text-muted mt-2 mb-0"><i class="fas fa-eye mr-1"></i>Canvas preview: the first four category images are shown for reference; TTC, Retreat, Workshop and Yoga Center are editable below.</p>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card card-outline card-info section3-inspector">
                        <div class="card-header"><h3 class="card-title font-weight-bold">Section inspector</h3></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="section3Heading">Heading</label>
                                <textarea id="section3Heading" class="form-control" name="section3_heading" rows="3" required>{{ old('section3_heading', $setting->section3_heading ?: 'A BRIEF DESCRIPTION OF THE TYPES OF YOGA SERVICES') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="section3Description">Description</label>
                                <textarea id="section3Description" class="form-control" name="section3_description" rows="4" required>{{ old('section3_description', $setting->section3_description ?: 'We at YogIntra provide various services to the nature of the clients. Wish how you would like to spend your time here we can talk and come to a conclusion.') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="section3Padding" class="d-flex justify-content-between"><span>Vertical padding</span><strong id="paddingValue"></strong></label>
                                <input id="section3Padding" class="custom-range" type="range" min="20" max="180" name="section3_padding_y" value="{{ old('section3_padding_y', $setting->section3_padding_y ?: 70) }}">
                            </div>
                            <div class="form-group mb-4">
                                <label for="section3Background">Replace background</label>
                                <input id="section3Background" class="form-control-file" type="file" name="section3_background_image" accept="image/*">
                                <small class="form-text text-muted">Leave empty to keep the current background.</small>
                            </div>

                            <div class="fixed-image-heading"><span>Fixed card images</span><small>Optional replacements</small></div>
                            <div class="row">
                                @foreach($fixedCards as $key => $card)
                                    <div class="col-6 mb-3">
                                        <label class="fixed-upload" for="fixedImage{{ $key }}">
                                            <img id="preview{{ $key }}" src="{{ asset($fixedImages[$key] ?? $card['default']) }}" alt="{{ $card['label'] }} preview">
                                            <span>{{ $card['label'] }}</span>
                                            <em>Choose image</em>
                                        </label>
                                        <input id="fixedImage{{ $key }}" class="d-none fixed-image-input" data-key="{{ $key }}" type="file" name="section3_fixed_images[{{ $key }}]" accept="image/*">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer text-right"><button class="btn btn-info px-4" type="submit">Save Section 3</button></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<style>
    .section3-canvas{min-height:690px;padding:70px 38px;background-position:center;background-size:cover;border:1px solid #b8dfe3;border-radius:16px;overflow:hidden}
    .canvas-copy{max-width:760px;margin:0 auto 32px;padding:25px 30px;text-align:center;background:rgba(255,255,255,.88);border-radius:16px;box-shadow:0 12px 32px rgba(20,69,78,.12)}
    .canvas-copy h2{color:#123f4a;font-weight:800;font-size:clamp(24px,3vw,40px);margin:0 0 12px}.canvas-copy p{margin:0;color:#526d75;font-size:16px;line-height:1.7}.canvas-copy .canvas-kicker{margin-bottom:8px;color:#14737c;font-size:11px;text-transform:uppercase;letter-spacing:1.4px;font-weight:800}
    .service-preview-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px}.service-preview-card{min-height:190px;padding:18px 12px 14px;display:flex;align-items:center;justify-content:center;flex-direction:column;text-align:center;background:rgba(255,255,255,.94);border:2px solid rgba(255,255,255,.8);border-radius:16px;box-shadow:0 12px 24px rgba(22,64,74,.15)}.service-preview-card img{width:94px;height:94px;object-fit:cover;border-radius:50%;border:3px solid #fff;box-shadow:0 4px 14px rgba(19,73,81,.2)}.service-preview-card span{margin-top:11px;color:#123f4a;font-weight:800}.service-preview-card small{margin-top:3px;color:#19818a;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.6px}.service-preview-card.is-readonly small{color:#87969a}
    .section3-inspector{position:sticky;top:18px;border-radius:14px;overflow:hidden}.section3-inspector .card-header{padding:18px 20px}.section3-inspector .card-body{padding:22px}.section3-inspector label{color:#315863;font-size:13px;font-weight:700}.fixed-image-heading{display:flex;justify-content:space-between;align-items:baseline;padding-top:15px;margin-bottom:15px;border-top:1px solid #dce9eb;color:#164550;font-weight:800}.fixed-image-heading small{color:#769097;font-weight:600}.fixed-upload{width:100%;min-height:130px;margin:0;padding:10px;display:flex;align-items:center;justify-content:center;flex-direction:column;cursor:pointer;text-align:center;border:1px dashed #91c9cf;border-radius:11px;background:#f7fbfb;transition:.2s}.fixed-upload:hover{background:#ebf8f8;border-color:#127881}.fixed-upload img{width:58px;height:58px;object-fit:cover;border-radius:50%;margin-bottom:7px}.fixed-upload span{font-size:12px;color:#164550;font-weight:800}.fixed-upload em{font-size:10px;font-style:normal;color:#16818b}.section3-inspector .card-footer{background:#f8fbfb}
    @media(max-width:991.98px){.section3-inspector{position:static}.service-preview-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:575.98px){.section3-canvas{padding:36px 16px;min-height:0}.canvas-copy{padding:20px 16px}.service-preview-grid{gap:10px}.service-preview-card{min-height:164px;padding:14px 7px}.service-preview-card img{width:72px;height:72px}.service-preview-card span{font-size:12px}}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const heading = document.getElementById('section3Heading'), description = document.getElementById('section3Description'), padding = document.getElementById('section3Padding');
    const previewHeading = document.getElementById('previewHeading'), previewDescription = document.getElementById('previewDescription'), canvas = document.getElementById('section3Canvas'), paddingValue = document.getElementById('paddingValue');
    const render = () => { previewHeading.textContent = heading.value; previewDescription.textContent = description.value; canvas.style.paddingTop = padding.value + 'px'; canvas.style.paddingBottom = padding.value + 'px'; paddingValue.textContent = padding.value + 'px'; };
    [heading, description, padding].forEach(input => input.addEventListener('input', render)); render();
    document.getElementById('section3Background').addEventListener('change', function () { if (!this.files[0]) return; const reader = new FileReader(); reader.onload = event => canvas.style.backgroundImage = `url('${event.target.result}')`; reader.readAsDataURL(this.files[0]); });
    document.querySelectorAll('.fixed-image-input').forEach(input => input.addEventListener('change', function () { if (!this.files[0]) return; const reader = new FileReader(), key = this.dataset.key; reader.onload = event => { document.getElementById('preview' + key).src = event.target.result; document.querySelector(`[data-card="${key}"] img`).src = event.target.result; }; reader.readAsDataURL(this.files[0]); }));
});
</script>
@endsection
