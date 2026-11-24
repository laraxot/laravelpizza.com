<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Models;

use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\Models\ResolveTenantModelInstanceAction;
use Modules\Tenant\Tests\TestCase;
use Nwidart\Modules\Facades\Module;

uses(TestCase::class);

describe('ResolveTenantModelInstanceAction', function (): void {
    it('throws for unknown model name', function (): void {
        // Nessun morph_map e nessun modulo abilitato: ResolveTenantModelClassAction non trova il nome.
        $this->mockService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => null]);
        });
        Module::shouldReceive('allEnabled')->andReturn([]);

        expect(fn () => app(ResolveTenantModelInstanceAction::class)->execute('unknown-model'))
            ->toThrow(\Exception::class, 'model unknown');
    });
});
