<?php

test('login responses prevent search indexing', function () {
    $this->get('/login')
        ->assertOk()
        ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet')
        ->assertSee('<meta name="robots" content="noindex, nofollow, noarchive, nosnippet">', false)
        ->assertDontSee('pagead2.googlesyndication.com', false);
});

test('admin redirects remain excluded from search indexing', function () {
    $this->get('/admin')
        ->assertRedirect('/login')
        ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet');
});

test('configured admin allowlist blocks an unapproved login ip', function () {
    config()->set('security.admin_allowed_ips', ['203.0.113.10']);

    $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.20'])
        ->get('/login')
        ->assertForbidden();
});

test('configured admin allowlist accepts approved addresses and cidr ranges', function () {
    config()->set('security.admin_allowed_ips', ['203.0.113.10', '198.51.100.0/24']);

    $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.20'])
        ->get('/login')
        ->assertOk();
});
