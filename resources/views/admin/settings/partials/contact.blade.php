<div class="form-group">
    <label for="app_address">Street Address</label>
    <textarea id="app_address" name="app_address" class="form-control" rows="3" maxlength="500" autocomplete="street-address">{{ old('app_address', $setting->app_address) }}</textarea>
    <small class="form-text text-muted">Visible in the site footer and used as the LocalBusiness street address.</small>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="app_address_locality">City / Locality</label>
        <input id="app_address_locality" type="text" name="app_address_locality" class="form-control" maxlength="120" autocomplete="address-level2" value="{{ old('app_address_locality', $setting->app_address_locality) }}">
    </div>
    <div class="form-group col-md-6">
        <label for="app_address_region">State / Region</label>
        <input id="app_address_region" type="text" name="app_address_region" class="form-control" maxlength="120" autocomplete="address-level1" value="{{ old('app_address_region', $setting->app_address_region) }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="app_postal_code">Postal Code</label>
        <input id="app_postal_code" type="text" name="app_postal_code" class="form-control" maxlength="20" autocomplete="postal-code" value="{{ old('app_postal_code', $setting->app_postal_code) }}">
    </div>
    <div class="form-group col-md-6">
        <label for="app_address_country">Country Code</label>
        <input id="app_address_country" type="text" name="app_address_country" class="form-control text-uppercase" maxlength="2" pattern="[A-Za-z]{2}" autocomplete="country" value="{{ old('app_address_country', $setting->app_address_country ?: 'IN') }}">
        <small class="form-text text-muted">Use the two-letter code, for example IN.</small>
    </div>
</div>

<div class="form-group">
    <label for="app_mobile">Phone Number</label>
    <input id="app_mobile" type="tel" name="app_mobile" class="form-control" maxlength="30" autocomplete="tel" value="{{ old('app_mobile', $setting->app_mobile) }}">
</div>

<div class="form-group">
    <label for="app_email">Email Address</label>
    <input id="app_email" type="email" name="app_email" class="form-control" maxlength="255" autocomplete="email" value="{{ old('app_email', $setting->app_email) }}">
</div>

<div class="form-group">
    <label for="map_iframe">Map Embed Code</label>
    <textarea id="map_iframe" name="map_iframe" class="form-control" rows="4" maxlength="5000">{{ old('map_iframe', $setting->map_iframe) }}</textarea>
</div>
