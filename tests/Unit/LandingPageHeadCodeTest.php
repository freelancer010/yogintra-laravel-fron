<?php

use App\Support\LandingPageHeadCode;

test('it wraps raw schema json as json ld without changing the saved value', function () {
    $raw = '{"@context":"https://schema.org","@type":"ExerciseGym","name":"YogIntra Borivali"}';

    $normalized = LandingPageHeadCode::normalize($raw);

    expect($normalized)
        ->toStartWith('<script type="application/ld+json">')
        ->toEndWith('</script>')
        ->toContain('"@type":"ExerciseGym"');
});

test('it leaves complete custom head tags unchanged', function () {
    $head = '<meta name="robots" content="index,follow">';

    expect(LandingPageHeadCode::normalize($head))->toBe($head);
});

test('it does not treat unrelated json as schema', function () {
    $json = '{"theme":"teal"}';

    expect(LandingPageHeadCode::normalize($json))->toBe($json);
});

test('it strips meta refresh redirects while preserving safe head tags', function () {
    $head = '<meta name="robots" content="index,follow">'
        . '<meta http-equiv="refresh" content="0;url=https://malicious.example">';

    expect(LandingPageHeadCode::normalize($head))
        ->toBe('<meta name="robots" content="index,follow">')
        ->not->toContain('malicious.example');
});

test('it strips redirect scripts while preserving analytics scripts', function () {
    $head = '<script src="https://analytics.example/tag.js" async></script>'
        . '<script>window.location.href = "https://malicious.example";</script>';

    expect(LandingPageHeadCode::normalize($head))
        ->toBe('<script src="https://analytics.example/tag.js" async></script>')
        ->not->toContain('malicious.example');
});

test('it detects redirect code before it is saved', function () {
    expect(LandingPageHeadCode::containsRedirect('<meta http-equiv="refresh" content="0;url=/away">'))->toBeTrue()
        ->and(LandingPageHeadCode::containsRedirect('<script>location.replace("/away")</script>'))->toBeTrue()
        ->and(LandingPageHeadCode::containsRedirect('<meta name="google-site-verification" content="abc">'))->toBeFalse();
});
