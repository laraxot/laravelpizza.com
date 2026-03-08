<?php

declare(strict_types=1);

use Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;


it('returns path using module_path helper in happy path', function (): void {
    config()->set('modules.paths.generator.config.path', 'config');

    $result = app(GetModulePathByGeneratorAction::class)->execute('Xot', 'config');

    expect($result)->toContain('/Modules/Xot/config');
});

it('returns module path for another existing generator directory', function (): void {
    config()->set('modules.paths.generator.lang.path', 'lang');

    $result = app(GetModulePathByGeneratorAction::class)->execute('Xot', 'lang');

    expect($result)->toContain('/Modules/Xot/lang');
});
