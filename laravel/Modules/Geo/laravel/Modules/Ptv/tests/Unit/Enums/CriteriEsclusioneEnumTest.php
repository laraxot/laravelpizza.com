<?php

declare(strict_types=1);

namespace Modules\Ptv\Tests\Unit\Enums;

use Modules\Ptv\Enums\CriteriEsclusioneEnum;
use Modules\Ptv\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('CriteriEsclusioneEnum', function (): void {
    it('uses EnumTrait and has a translation for every case', function (): void {
        Assert::assertContains('Modules\\Xot\\Traits\\EnumTrait', class_uses(CriteriEsclusioneEnum::class));

        foreach (CriteriEsclusioneEnum::cases() as $case) {
            $label = $case->getLabel();
            Assert::assertNotSame('', $label);
            Assert::assertFalse(str_starts_with($label, 'ptv::criteri_esclusione_enum.values.'));
        }
    });

    it('resolves known labels in italian', function (): void {
        Assert::assertSame('Giorni minimi anno', CriteriEsclusioneEnum::min_gg_anno->getLabel());
        Assert::assertSame(
            'Giorni minimi parametri integrativi (no ASZ)',
            CriteriEsclusioneEnum::min_gg_integ_params_no_asz->getLabel(),
        );
    });
});
