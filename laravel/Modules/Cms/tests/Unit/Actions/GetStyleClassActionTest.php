<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Modules\Cms\Actions\GetStyleClassAction;
use PHPUnit\Framework\Assert;

test('GetStyleClassAction can be executed', function () {
    Assert::assertTrue(class_exists(GetStyleClassAction::class));
});

test('GetStyleClassAction handles exceptions gracefully', function () {
    $action = new GetStyleClassAction;

    // Senza la view del tema (e la relativa config `<tema>::<view>.class`) l'action lancia una Exception.
    expect(fn () => $action->execute())->toThrow(Exception::class);
});

test('GetStyleClassAction with mocked config', function () {
    Config::set('adm_theme::components.some_component.class', 'mocked-class');
    Config::set('pub_theme::components.some_component.class', 'mocked-class');

    $action = new GetStyleClassAction;

    Assert::assertSame('mocked-class', $action->execute('some_component'));
});
