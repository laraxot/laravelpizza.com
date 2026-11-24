<?php

declare(strict_types=1);

use Modules\Cms\Actions\GetViewThemeByViewAction;
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
test('GetViewThemeByViewAction can be executed', function () {
    $action = new GetViewThemeByViewAction;

    Assert::assertContains($action->execute(), ['', 'pub_theme::', 'adm_theme::']);
});

test('GetViewThemeByViewAction returns string when executed with empty view', function () {
    $action = new GetViewThemeByViewAction;

    $result = $action->execute();

    // Nessuna view risolvibile: si ritorna la view originale (vuota) oppure il namespace del tema.
    Assert::assertContains($result, ['', 'pub_theme::', 'adm_theme::']);
});

test('GetViewThemeByViewAction returns string when executed with view', function () {
    $action = new GetViewThemeByViewAction;

    $result = $action->execute('test::view');

    // Se il tema non ridefinisce la view si ritorna l'originale, altrimenti quella del tema.
    Assert::assertContains($result, ['test::view', 'pub_theme::view', 'adm_theme::view']);
});

test('GetViewThemeByViewAction returns original view when view does not exist', function () {
    $action = new GetViewThemeByViewAction;

    $view = 'nonexistent::view';
    $result = $action->execute($view);

    Assert::assertSame($view, $result);
});
