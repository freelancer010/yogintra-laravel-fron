<div class="form-group row">
  <label class="col-sm-3 col-form-label">Application Name <small class="text-muted">(max 100 chars)</small></label>
  <div class="col-sm-9">
    <input type="text" class="form-control @error('app_name') is-invalid @enderror" name="app_name" value="{{ old('app_name', $setting->app_name) }}" maxlength="100" required data-length-counter>
    <small class="form-text text-muted text-right" data-counter-for="app_name"></small>
    @error('app_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3 col-form-label">Meta Title <small class="text-muted">(max 60 chars)</small></label>
  <div class="col-sm-9">
    <input type="text" class="form-control @error('app_meta_title') is-invalid @enderror" name="app_meta_title" value="{{ old('app_meta_title', $setting->app_meta_title) }}" maxlength="60" data-length-counter>
    <small class="form-text text-muted text-right" data-counter-for="app_meta_title"></small>
    @error('app_meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3 col-form-label">Meta Description <small class="text-muted">(max 160 chars)</small></label>
  <div class="col-sm-9">
    <textarea class="form-control @error('app_meta_description') is-invalid @enderror" name="app_meta_description" maxlength="160" data-length-counter>{{ old('app_meta_description', $setting->app_meta_description) }}</textarea>
    <small class="form-text text-muted text-right" data-counter-for="app_meta_description"></small>
    @error('app_meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3 col-form-label">Meta Keywords <small class="text-muted">(max 255 chars)</small></label>
  <div class="col-sm-9">
    <textarea class="form-control @error('app_keywords') is-invalid @enderror" name="app_keywords" maxlength="255" data-length-counter>{{ old('app_keywords', $setting->app_keywords) }}</textarea>
    <small class="form-text text-muted text-right" data-counter-for="app_keywords"></small>
    @error('app_keywords')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3 col-form-label">Footer About Us <small class="text-muted">(max 200 chars)</small></label>
  <div class="col-sm-9">
    <textarea class="form-control @error('footer_about_us') is-invalid @enderror" name="footer_about_us" maxlength="200" data-length-counter>{{ old('footer_about_us', $setting->footer_about_us) }}</textarea>
    <small class="form-text text-muted text-right" data-counter-for="footer_about_us"></small>
    @error('footer_about_us')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>
