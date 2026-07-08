<?php

declare(strict_types=1);

namespace Modules\Ptv\Tests\Unit\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Modules\Progressioni\Models\CriteriEsclusione;
use Modules\Progressioni\Models\CriteriOption;
use Modules\Progressioni\Models\Scheda;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Ptv\Tests\TestCase;
use ReflectionMethod;

uses(TestCase::class);

describe('BaseScheda criteri per anno', function (): void {
    it('risolve le classi Criteri del modulo concreto', function (): void {
        $resolveEsclusione = new ReflectionMethod(Scheda::class, 'resolveCriteriEsclusioneModelClass');
        $resolveEsclusione->setAccessible(true);
        $resolveOption = new ReflectionMethod(Scheda::class, 'resolveCriteriOptionModelClass');
        $resolveOption->setAccessible(true);

        expect($resolveEsclusione->invoke(null))->toBe(CriteriEsclusione::class);
        expect($resolveOption->invoke(null))->toBe(CriteriOption::class);
    });

    it('parsa i tipi list int date delle criteri options', function (): void {
        $parseCollection = new ReflectionMethod(Scheda::class, 'parseCriteriOptionsCollection');
        $parseCollection->setAccessible(true);

        $rows = new EloquentCollection([
            new CriteriOption(['name' => 'lista_propro', 'type' => 'list', 'value' => '714,704']),
            new CriteriOption(['name' => 'min_gg_anno', 'type' => 'int', 'value' => '120']),
            new CriteriOption(['name' => 'data_presenza_al', 'type' => 'date', 'value' => '2026-12-31']),
            new CriteriOption(['name' => 'data_invalida', 'type' => 'date', 'value' => 'not-a-date']),
        ]);

        /** @var Collection<string, mixed> $parsed */
        $parsed = $parseCollection->invoke(null, $rows);

        expect($parsed->get('lista_propro'))->toBe(['714', '704']);
        expect($parsed->get('min_gg_anno'))->toBe(120);
        expect($parsed->get('data_presenza_al'))->toBeInstanceOf(Carbon::class);
        expect($parsed->get('data_invalida'))->toBeNull();
    });
});
