<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;
use Modules\Xot\Tests\Fixtures\Models\HasCommonScopesProbe;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('builds correct sql for scopeActive', function (): void {
    $sql = HasCommonScopesProbe::query()->active()->toSql();

    expect($sql)->toBe('select * from "has_common_scopes_probes" where "is_active" = ?');
});

it('builds correct sql for scopeInactive', function (): void {
    $query = HasCommonScopesProbe::query()->inactive();

    expect($query->toSql())->toBe('select * from "has_common_scopes_probes" where "is_active" = ?')
        ->and($query->getBindings())->toBe([false]);
});

it('builds correct sql for scopePublished', function (): void {
    $sql = HasCommonScopesProbe::query()->published()->toSql();

    expect($sql)->toBe('select * from "has_common_scopes_probes" where "published_at" is not null and "published_at" <= ?');
});

it('builds correct sql for scopeDraft', function (): void {
    $sql = HasCommonScopesProbe::query()->draft()->toSql();

    expect($sql)->toBe('select * from "has_common_scopes_probes" where ("published_at" is null or "published_at" > ?)');
});

it('builds correct sql for scopeCreatedAfter/Before and updatedAfter/createdBy', function (): void {
    $date = '2026-01-01';

    expect(HasCommonScopesProbe::query()->createdAfter($date)->getBindings())->toBe([$date])
        ->and(HasCommonScopesProbe::query()->createdBefore($date)->getBindings())->toBe([$date])
        ->and(HasCommonScopesProbe::query()->updatedAfter($date)->getBindings())->toBe([$date])
        ->and(HasCommonScopesProbe::query()->createdBy(42)->getBindings())->toBe([42]);
});

it('reports isPublished true when published_at is in the past', function (): void {
    $model = new HasCommonScopesProbe(['published_at' => Carbon::now()->subDay()]);

    expect($model->isPublished())->toBeTrue()
        ->and($model->isDraft())->toBeFalse();
});

it('reports isPublished false when published_at is null', function (): void {
    $model = new HasCommonScopesProbe(['published_at' => null]);

    expect($model->isPublished())->toBeFalse()
        ->and($model->isDraft())->toBeTrue();
});

it('reports isPublished false when published_at is in the future', function (): void {
    $model = new HasCommonScopesProbe(['published_at' => Carbon::now()->addDay()]);

    expect($model->isPublished())->toBeFalse()
        ->and($model->isDraft())->toBeTrue();
});

it('reports isActive correctly based on is_active flag', function (): void {
    $active = new HasCommonScopesProbe(['is_active' => true]);
    $inactive = new HasCommonScopesProbe(['is_active' => false]);
    $unset = new HasCommonScopesProbe();

    expect($active->isActive())->toBeTrue()
        ->and($inactive->isActive())->toBeFalse()
        ->and($unset->isActive())->toBeFalse();
});
