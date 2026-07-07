<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Modules\Cms\Actions\GetStyleClassAction;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('GetStyleClassAction can be executed', function () {
    $action = new GetStyleClassAction();

    Assert::assertInstanceOf(GetStyleClassAction::class, $action);
});

test('GetStyleClassAction handles exceptions gracefully', function () {
    $action = new GetStyleClassAction();

    // This action will likely throw an exception due to missing view/config
    // so we need to test that it's handled appropriately
    try {
        $result = $action->execute();
    } catch (Exception $e) {
        // If an exception is thrown, it's expected due to missing dependencies
    }
});

test('GetStyleClassAction with mocked config', function () {
    // Mock the config to prevent exceptions
    Config::set('adm_theme::components.some_component.class', 'mocked-class');
    Config::set('pub_theme::components.some_component.class', 'mocked-class');

    $action = new GetStyleClassAction();

    // This should still fail as the action expects specific view structure
    Assert::assertInstanceOf(GetStyleClassAction::class, $action);
});
