<?php

declare(strict_types=1);

use Modules\Cms\Models\Policies\MenuPolicy;
use Modules\Cms\Models\Policies\PagePolicy;
use Modules\Cms\Models\Policies\SectionPolicy;
<<<<<<< HEAD
use PHPUnit\Framework\Assert;

=======
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
test('PagePolicy can be instantiated', function () {
    $policy = new PagePolicy;
    Assert::assertSame(PagePolicy::class, $policy::class);

});

test('MenuPolicy can be instantiated', function () {
    $policy = new MenuPolicy;
    Assert::assertSame(MenuPolicy::class, $policy::class);

});

test('SectionPolicy can be instantiated', function () {
    $policy = new SectionPolicy;
    Assert::assertSame(SectionPolicy::class, $policy::class);

});
