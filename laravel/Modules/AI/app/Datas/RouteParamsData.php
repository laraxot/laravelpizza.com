<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Spatie\LaravelData\Data;

/**
 * Parametri condivisi dalle Route Actions (BuildActionUrlAction,
 * BuildNestedRouteNameAction, IsAdminRouteAction).
 *
 * Sostituisce il precedente `array $params` con chiavi magiche
 * ('act', 'row', 'query', 'n', 'in_admin').
 */
class RouteParamsData extends Data
{
    public ?string $act = null;

    public ?object $row = null;

    /** @var array<string, mixed>|null */
    public ?array $query = null;

    public ?int $n = null;

    public ?bool $in_admin = null;
}
