<?php

use App\Models\Service;

it('builds the public service slug used below a service category', function () {
    expect(Service::publicServiceSlug('week-3-days-basic-yoga-class'))
        ->toBe('week-3-days-basic-yoga')
        ->and(Service::publicServiceSlug('hatha-yoga'))
        ->toBe('hatha-yoga');
});
