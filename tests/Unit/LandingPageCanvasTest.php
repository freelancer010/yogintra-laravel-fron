<?php

namespace Tests\Unit;

use App\Support\LandingPageCanvas;
use PHPUnit\Framework\TestCase;

class LandingPageCanvasTest extends TestCase
{
    public function test_it_removes_only_the_legacy_trainer_location_row(): void
    {
        $html = '<main><article class="classic-trainer-card"><div class="classic-trainer-card__body">'
            . '<span class="qualification">RYT 500</span>'
            . '<span><i class="fa fa-map-marker" aria-hidden="true"></i> Andheri, Mumbai</span>'
            . '<ul><li>Teacher training</li></ul>'
            . '</div></article></main>';

        $cleaned = LandingPageCanvas::withoutTrainerLocations($html);

        self::assertStringNotContainsString('fa-map-marker', $cleaned);
        self::assertStringNotContainsString('Andheri, Mumbai', $cleaned);
        self::assertStringContainsString('<span class="qualification">RYT 500</span>', $cleaned);
        self::assertStringContainsString('<li>Teacher training</li>', $cleaned);
    }

    public function test_it_leaves_canvas_without_a_location_unchanged(): void
    {
        $html = '<main><p>Existing production content &amp; formatting.</p></main>';

        self::assertSame($html, LandingPageCanvas::withoutTrainerLocations($html));
    }
}
