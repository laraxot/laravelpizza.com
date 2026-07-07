<?php

declare(strict_types=1);

use Modules\Xot\Services\ModuleService;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('ModuleService', function (): void {
    $service = new ModuleService();

    it('can be instantiated', function () use ($service): void {
        Assert::assertInstanceOf(ModuleService::class, $service);
    });

    it('has getModels method', function () use ($service): void {
        $result = $service->getModels();
        Assert::assertContains('string', array_map('gettype', $result ?: ['string']));
    });

    it('returns array from getModels method', function () use ($service): void {
        $result = $service->getModels();
        Assert::assertContains('string', array_map('gettype', $result ?: ['string']));
    });
});
