<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Scopes;

/**
 * SchedaScope - Query Scopes per Scheda.
 *
 * Responsabilità: Aggregazione scopes (delegation cascade).
 * Include CommonScope per scope generici.
 *
 * @see CommonScope
 */
trait SchedaScope
{
    // ⚡ DELEGATION: Scope comuni delegati qui da SchedaTrait
    use CommonScope;

    // Add scheda-specific scopes here if needed
}
