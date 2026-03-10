<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Tests\TestCase;
use Modules\Xot\Services\ModuleService;

uses(TestCase::class);

describe('ModuleService', function () {
    beforeEach(function () {
        $this->service = new ModuleService();
    });

    it('can be instantiated', function () {
        expect($this->service)->toBeInstanceOf(ModuleService::class);
    });

    it('has getModels method', function () {
        expect(method_exists($this->service, 'getModels'))->toBeTrue();
    });

    it('returns array from getModels method', function () {
        $result = $this->service->getModels();
        expect($result)->toBeArray();
    });
});
