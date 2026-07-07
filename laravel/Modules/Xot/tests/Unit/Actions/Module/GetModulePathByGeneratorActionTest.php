<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;
use PHPUnit\Framework\Assert;

it('returns path using module_path helper in happy path', function (): void {
    config()->set('modules.paths.generator.config.path', 'config');

    $result = app(GetModulePathByGeneratorAction::class)->execute('Xot', 'config');

    Assert::assertStringContainsString((string) '/Modules/Xot/config', (string) $result);
});

it('returns module path for another existing generator directory', function (): void {
    config()->set('modules.paths.generator.lang.path', 'lang');

    $result = app(GetModulePathByGeneratorAction::class)->execute('Xot', 'lang');

    Assert::assertStringContainsString((string) '/Modules/Xot/lang', (string) $result);
});
