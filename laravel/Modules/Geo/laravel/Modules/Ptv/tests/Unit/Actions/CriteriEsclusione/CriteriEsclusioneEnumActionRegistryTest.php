<?php

declare(strict_types=1);

namespace Modules\Ptv\Tests\Unit\Actions\CriteriEsclusione;

use Illuminate\Support\Str;
use Modules\Ptv\Enums\CriteriEsclusioneEnum;
use Modules\Ptv\Tests\TestCase;

uses(TestCase::class);

describe('registry action criteri esclusione', function (): void {
    it('ogni caso CriteriEsclusioneEnum ha una action Modules\\Ptv\\Actions\\CriteriEsclusione', function (): void {
        foreach (CriteriEsclusioneEnum::cases() as $case) {
            $actionClass = '\\Modules\\Ptv\\Actions\\CriteriEsclusione\\'.Str::studly($case->value);

            expect(class_exists($actionClass))
                ->toBeTrue("Action mancante per criterio `{$case->value}` → `{$actionClass}`");
        }
    });
});
