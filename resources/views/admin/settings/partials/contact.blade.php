<div class="form-group">
    <label>Address</label>
    <textarea name="app_address" class="form-control" rows="3">{{ old('app_address', $setting->app_address) }}</textarea>
</div>

<div class="form-group">
    <label>Phone Number</label>
    <input type="text" name="app_mobile" class="form-control" value="{{ old('app_mobile', $setting->app_mobile) }}">
</div>

<div class="form-group">
    <label>Email Address</label>
    <input type="email" name="app_email" class="form-control" value="{{ old('app_email', $setting->app_email) }}">
</div>

<div class="form-group">
    <label>Map Embed Code</label>
    <textarea name="map_iframe" class="form-control" rows="4">{{ old('map_iframe', $setting->map_iframe) }}</textarea>
</div>
