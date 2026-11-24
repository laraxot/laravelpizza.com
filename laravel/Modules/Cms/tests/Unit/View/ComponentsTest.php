<?php

declare(strict_types=1);

<<<<<<< HEAD
=======
use Modules\Cms\Tests\TestCase;
>>>>>>> laraxot/dev
use Modules\Cms\View\Components\PageContent;
use Modules\Cms\View\Components\Section;
use PHPUnit\Framework\Assert;

<<<<<<< HEAD
=======
// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
/*
 * Smoke tests for Section and PageContent view components.
 *
 * Page component tests are in:
 *
 * @see \Modules\Cms\Tests\Unit\View\Components\PageComponentTest
 */
test('Section component can be instantiated', function () {
    $component = new Section('test-slug');

    Assert::assertSame('test-slug', $component->slug);
});

test('PageContent component can be instantiated', function () {
    $component = new PageContent('test-slug');

    Assert::assertSame('test-slug', $component->slug);
});
