<?php

$adminAllowedIps = array_values(array_filter(array_map(
    'trim',
    explode(',', (string) env('ADMIN_ALLOWED_IPS', ''))
)));

return [
    /*
    |--------------------------------------------------------------------------
    | Administration IP allowlist
    |--------------------------------------------------------------------------
    |
    | Supply comma-separated IP addresses or CIDR ranges in ADMIN_ALLOWED_IPS.
    | Leave it empty when administrators connect from changing/mobile IPs.
    |
    */
    'admin_allowed_ips' => $adminAllowedIps,
];
