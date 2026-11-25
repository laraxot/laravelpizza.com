<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Enums\GenderEnum;
use Modules\Xot\Enums\YesNoEnum;
use Modules\Xot\Models\Traits\HasDynamicFillable;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;

uses(XotBaseTestCase::class);

/*
 * HasDynamicFillable aggiunge a $fillable i valori dei casi degli enum dichiarati dal modello.
 * Il consumatore reale (TechPlanner Client) vive in un altro progetto che condivide Xot: qui
 * il trait si esercita su un modello anonimo, come ammette la regola no-phpstan-probe-models.
 */

it('aggiunge in coda a fillable i valori degli enum dichiarati', function (): void {
    $model = new class extends Model
    {
        use HasDynamicFillable;

        protected $fillable = [
            'name',
        ];

        /**
         * @return list<class-string<UnitEnum>>
         */
        protected function getDynamicFillableEnums(): array
        {
            return [
                YesNoEnum::class,
                GenderEnum::class,
            ];
        }
    };

    Assert::assertSame(
        [
            'name',
            'yes',
            'no',
            'f',
            'm',
        ],
        $model->getFillable(),
    );
});

it('non duplica un campo gia presente in fillable', function (): void {
    $model = new class extends Model
    {
        use HasDynamicFillable;

        protected $fillable = [
            'name',
            'yes',
        ];

        /**
         * @return list<class-string<UnitEnum>>
         */
        protected function getDynamicFillableEnums(): array
        {
            return [
                YesNoEnum::class,
            ];
        }
    };

    Assert::assertSame(
        [
            'name',
            'yes',
            'no',
        ],
        $model->getFillable(),
    );
});

it('lascia fillable invariato se il modello non dichiara enum', function (): void {
    $model = new class extends Model
    {
        use HasDynamicFillable;

        protected $fillable = [
            'name',
            'email',
        ];
    };

    Assert::assertSame(
        [
            'name',
            'email',
        ],
        $model->getFillable(),
    );
});
