<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\View;

use Modules\Cms\View\Components\AppLayout;
use Modules\Cms\View\Components\GuestLayout;
use Modules\Cms\View\Components\Metatags;

test('AppLayout component can be instantiated', function () {
    $component = new AppLayout();
    expect($component)->toBeInstanceOf(AppLayout::class);
});

test('GuestLayout component can be instantiated', function () {
    $component = new GuestLayout();
    expect($component)->toBeInstanceOf(GuestLayout::class);
});

test('Metatags component can be instantiated', function () {
    $component = new Metatags();
    expect($component)->toBeInstanceOf(Metatags::class);
});
