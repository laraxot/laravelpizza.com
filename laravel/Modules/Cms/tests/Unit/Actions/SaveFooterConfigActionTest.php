<?php

declare(strict_types=1);

use Modules\Cms\Actions\SaveFooterConfigAction;
use Modules\Cms\Datas\FooterData;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

test('SaveFooterConfigAction can be executed', function () {
    Assert::assertTrue((new ReflectionClass(SaveFooterConfigAction::class))->isInstantiable());
});

test('SaveFooterConfigAction can execute with FooterData', function () {
    $action = new SaveFooterConfigAction;

    // Create FooterData using the from method with valid properties
    $footerData = FooterData::from([
        'background_color' => '#ffffff',
        'background' => 'bg-light',
        'overlay_color' => '#000000',
    ]);

    Assert::assertSame('#ffffff', $footerData->background_color);
    $action->execute($footerData);
});
