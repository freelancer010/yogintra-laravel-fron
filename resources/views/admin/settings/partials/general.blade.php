<div class="form-group row">
  <label class="col-sm-3 col-form-label">Application Name</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" name="app_name" value="{{ $setting->app_name }}" required>
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3 col-form-label">Meta Title</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" name="app_meta_title" value="{{ $setting->app_meta_title }}">
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3 col-form-label">Meta Description</label>
  <div class="col-sm-9">
    <textarea class="form-control" name="app_meta_description">{{ $setting->app_meta_description }}</textarea>
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3 col-form-label">Meta Keywords</label>
  <div class="col-sm-9">
    <textarea class="form-control" name="app_keywords">{{ $setting->app_keywords }}</textarea>
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3 col-form-label">Footer About Us</label>
  <div class="col-sm-9">
    <textarea class="form-control" name="footer_about_us">{{ $setting->footer_about_us }}</textarea>
  </div>
</div>
