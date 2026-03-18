<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models\Policies;

use Modules\Cms\Models\Policies\MenuPolicy;
use Modules\Cms\Models\Policies\PagePolicy;
use Modules\Cms\Models\Policies\SectionPolicy;

test('PagePolicy can be instantiated', function () {
    $policy = new PagePolicy();

    expect($policy)->toBeInstanceOf(PagePolicy::class);
});

test('MenuPolicy can be instantiated', function () {
    $policy = new MenuPolicy();

    expect($policy)->toBeInstanceOf(MenuPolicy::class);
});

test('SectionPolicy can be instantiated', function () {
    $policy = new SectionPolicy();

    expect($policy)->toBeInstanceOf(SectionPolicy::class);
});
