<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Trend\Adapters;

/**
 * Kind B (no-services-rule): Strategy/Adapter interface, relocated as a
 * plain class subtree — not force-fit into QueueableAction.
<<<<<<< .merge_file_RLXO4Y
 *
 * @see docs/contracts/abstract-adapter.md
 *
=======
 * @see docs/contracts/abstract-adapter.md
>>>>>>> .merge_file_rzr4Qr
 * @contract docs/contracts/abstract-adapter.md
 */
abstract class AbstractAdapter
{
    abstract public function format(string $column, string $interval): string;
}
