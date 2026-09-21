@props([
    'image',
    'alt' => '',
    'sizes' => '100vw',
    'loading' => 'lazy',
    'decoding' => 'async',
])

@php
    $image = ltrim((string) $image, '/');
    $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $base = pathinfo($image, PATHINFO_DIRNAME);
    $filename = pathinfo($image, PATHINFO_FILENAME);
    $sourcePath = public_path($image);
    $sourceDimensions = is_file($sourcePath) ? @getimagesize($sourcePath) : false;
    $variants = [];

    if ($extension === 'webp') {
        foreach ([480, 768, 1280] as $width) {
            $variant = ($base === '.' ? '' : $base . '/') . $filename . '-' . $width . '.webp';
            if (is_file(public_path($variant))) {
                $variants[] = asset($variant) . ' ' . $width . 'w';
            }
        }
        if ($sourceDimensions) {
            $variants[] = asset($image) . ' ' . $sourceDimensions[0] . 'w';
        }
    }
@endphp

<picture>
    @if($variants)
        <source type="image/webp" srcset="{{ implode(', ', $variants) }}" sizes="{{ $sizes }}">
    @endif
    <img src="{{ asset($image) }}" alt="{{ $alt }}" loading="{{ $loading }}" decoding="{{ $decoding }}" {{ $attributes }}>
</picture>
