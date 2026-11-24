<?php

declare(strict_types=1);

use Modules\Cms\Actions\SaveHeadernavConfigAction;
use Modules\Cms\Datas\HeadernavData;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

test('SaveHeadernavConfigAction can be instantiated', function () {
    Assert::assertTrue((new ReflectionClass(SaveHeadernavConfigAction::class))->isInstantiable());
});

test('SaveHeadernavConfigAction saves headernav data in the appearance tenant config', function () {
    $data = HeadernavData::from(['background_color' => '#ffffff', 'class' => 'sticky']);

    // Il salvataggio reale scriverebbe la config del tenant su disco: si verifica solo il contratto.
    $save = Mockery::mock(SaveTenantConfigAction::class);
    $save->shouldReceive('execute')
        ->once()
        ->with('appearance', ['headernav' => $data->toArray()]);
    app()->instance(SaveTenantConfigAction::class, $save);

    (new SaveHeadernavConfigAction)->execute($data);
})->group('CMS-HEADERNAV-SAVE-INV-1');
