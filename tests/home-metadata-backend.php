<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$settings = Illuminate\Support\Facades\DB::table('application_setting')->where('app_id', 1)->first();
$html = file_get_contents('http://127.0.0.1:8000/');

$read = static function (string $pattern) use ($html): string {
    preg_match($pattern, $html, $match);
    return html_entity_decode($match[1] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
};

$actual = [
    'title' => $read('#<title>(.*?)</title>#s'),
    'description' => $read('#<meta name="description" content="([^"]*)"#'),
    'keywords' => $read('#<meta name="keywords" content="([^"]*)"#'),
];
$expected = [
    'title' => (string) $settings->app_meta_title,
    'description' => (string) $settings->app_meta_description,
    'keywords' => (string) $settings->app_keywords,
];

if ($actual !== $expected) {
    fwrite(STDERR, "Homepage metadata does not match Application Settings.\n" . json_encode(compact('expected', 'actual'), JSON_PRETTY_PRINT) . "\n");
    exit(1);
}

echo "PASS: homepage title, description and keywords exactly match Application Settings.\n";
