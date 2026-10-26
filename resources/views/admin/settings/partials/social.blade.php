<div class="form-group">
    <label>Facebook URL</label>
    <input type="url" name="facebook" class="form-control" maxlength="500" value="{{ old('facebook', $setting->facebook) }}" placeholder="https://www.facebook.com/your-page">
</div>

<div class="form-group">
    <label>Twitter URL</label>
    <input type="url" name="twitter" class="form-control" maxlength="500" value="{{ old('twitter', $setting->twitter) }}" placeholder="https://x.com/your-profile">
</div>

<div class="form-group">
    <label>YouTube URL</label>
    <input type="url" name="youtube" class="form-control" maxlength="500" value="{{ old('youtube', $setting->youtube) }}" placeholder="https://www.youtube.com/@your-channel">
</div>

<div class="form-group">
    <label>Instagram URL</label>
    <input type="url" name="instagram" class="form-control" maxlength="500" value="{{ old('instagram', $setting->instagram) }}" placeholder="https://www.instagram.com/your-profile">
</div>

<div class="form-group">
    <label>Telegram URL</label>
    <input type="url" name="telegram" class="form-control" maxlength="500" value="{{ old('telegram', $setting->telegram) }}" placeholder="https://t.me/your-profile">
</div>

<div class="form-group">
    <label>LinkedIn URL</label>
    <input type="url" name="linkedin" class="form-control" maxlength="500" value="{{ old('linkedin', $setting->linkedin) }}" placeholder="https://www.linkedin.com/company/your-page">
</div>

<small class="form-text text-muted">Use full profile URLs including https://. Leave a field empty to hide that icon on the frontend.</small>
