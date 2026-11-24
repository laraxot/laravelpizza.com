<?php

declare(strict_types=1);

use Illuminate\Support\Facades\View;
use Modules\Cms\Actions\View\GetCmsViewAction;
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
test('GetCmsViewAction can be instantiated', function () {
    Assert::assertSame(GetCmsViewAction::class, (new GetCmsViewAction)::class);

});

test('GetCmsViewAction execute method with existing view', function () {
    // Mock that a view exists
    View::shouldReceive('exists')
        ->with('ui::empty')
        ->andReturn(true);

    $action = new GetCmsViewAction;
    $result = $action->execute('ui::empty');
    Assert::assertSame('ui::empty', $result);
});

test('GetCmsViewAction execute method throws exception for non-existing view', function () {
    // Mock that a view doesn't exist
    View::shouldReceive('exists')
        ->with('non.existing.view')
        ->andReturn(false);

    $action = new GetCmsViewAction;

    expect(fn () => $action->execute('non.existing.view'))
        ->toThrow(Exception::class, 'View not found: non.existing.view');
});
