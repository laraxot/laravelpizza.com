<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Trend\Adapters;

/**
 * Kind B (no-services-rule): Strategy/Adapter interface, relocated as a
 * plain class subtree — not force-fit into QueueableAction.
 *
 * @see docs/contracts/abstract-adapter.md
 *
 * @contract docs/contracts/abstract-adapter.md
 */
abstract class AbstractAdapter
{
    abstract public function format(string $column, string $interval): string;
}
