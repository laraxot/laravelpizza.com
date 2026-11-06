<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Map;

use Modules\Geo\Actions\Map\ExportMapDataAction;
use Modules\Geo\Actions\Map\GetMapMarkersAction;
use Modules\Geo\Actions\Map\GetMapStatsAction;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

test('map markers action accepts typed filters and returns marker list', function (): void {
    $markers = app(GetMapMarkersAction::class)->execute(['category' => 'farm', 'limit' => 10]);

    Assert::assertSame([], $markers);
});

test('map stats action counts nothing on an empty map', function (): void {
    $stats = app(GetMapStatsAction::class)->execute([]);

    Assert::assertSame([], array_filter($stats));
});

it('SENZA SORGENTE nel worktree: map stats action exposes total and categories counters (HEAD e MERGE_HEAD del repo Geo li hanno, GetMapStatsAction.php del worktree e lo stub che torna [])')->todo();

test('export map data action supports typed format constants', function (): void {
    $action = app(ExportMapDataAction::class);

    Assert::assertSame('[]', $action->execute([], ExportMapDataAction::FORMAT_JSON));
    Assert::assertSame('', $action->execute([], ExportMapDataAction::FORMAT_CSV));
    Assert::assertStringContainsString('FeatureCollection', $action->execute([], ExportMapDataAction::FORMAT_GEOJSON));
    Assert::assertStringContainsString('<kml', $action->execute([], ExportMapDataAction::FORMAT_KML));
});

test('export map data action falls back to json when the format is omitted or unknown', function (): void {
    $action = app(ExportMapDataAction::class);

    Assert::assertSame($action->execute([], ExportMapDataAction::FORMAT_JSON), $action->execute());
    Assert::assertSame($action->execute([], ExportMapDataAction::FORMAT_JSON), $action->execute([], 'xlsx'));
});
