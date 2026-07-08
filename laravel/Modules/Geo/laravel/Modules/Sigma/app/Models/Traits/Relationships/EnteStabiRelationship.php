<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Relationships;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Sigma\Models\Repart;

trait EnteStabiRelationship
{
    /**
     * @return HasMany<Repart, static>
     */
    public function reparts(): HasMany
    {
        // @phpstan-ignore-next-line - Template type TDeclaringModel on HasMany is not covariant
        return $this->hasMany(Repart::class, 'stabi', 'stabi')->where('ente', $this->ente);
    }
}
