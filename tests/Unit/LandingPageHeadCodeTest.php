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
