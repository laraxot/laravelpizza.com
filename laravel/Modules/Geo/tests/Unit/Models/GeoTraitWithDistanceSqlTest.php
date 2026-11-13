<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Modules\Geo\Models\Address;
use Modules\Geo\Tests\TestCase;

uses(TestCase::class);

it('adds the distance expression without duplicating the select star when columns exist', function () {
    $query = Address::query()
        ->select('addresses.*')
        ->selectSub('select 1', 'extra_column')
        ->withDistance(45.6, 13.7);

    $sql = $query->toSql();

    // `clients.*, <sub>, *, 6371...` e' syntax error su MariaDB: con colonne
    // gia' selezionate l'espressione va appesa senza `*` (regressione log).
    expect($sql)->toContain('AS distance')
        ->and($sql)->not->toContain('*, 6371')
        ->and($sql)->toContain('order by')
        ->and($sql)->toContain('distance')
        // NULL (record senza coordinate) vanno in coda: in MySQL `ORDER BY
        // distance ASC` mette i NULL primi e la lista apparirebbe non ordinata.
        ->and($sql)->toContain('distance IS NULL');
});

it('keeps the select star when the query has no columns yet', function () {
    $sql = Address::query()->withDistance(45.6, 13.7)->toSql();

    expect($sql)->toMatch('/select \*,?\s+6371 \* acos\(/i');
});
