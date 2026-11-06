<?php

declare(strict_types=1);

use Modules\Cms\Actions\GetViewThemeByViewAction;
use PHPUnit\Framework\Assert;

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
