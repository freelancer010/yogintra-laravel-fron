<div class="form-group">
    <label>Sticky Logo</label>
    <input type="file" name="app_sticky_logo" class="form-control">
    @if (!empty($setting->app_sticky_logo))
        <br>
        <img src="{{ asset($setting->app_sticky_logo) }}" width="120px">
    @endif
</div>

<div class="form-group">
    <label>Footer Logo</label>
    <input type="file" name="app_footer_logo" class="form-control">
    @if (!empty($setting->app_footer_logo))
        <br>
        <img src="{{ asset($setting->app_footer_logo) }}" width="120px">
    @endif
</div>

<div class="form-group">
    <label>Favicon</label>
    <input type="file" name="fevicon" class="form-control">
    @if (!empty($setting->fevicon))
        <br>
        <img src="{{ asset($setting->fevicon) }}" width="32px">
    @endif
</div>
