<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Modules\Sigma\Models\Traits\Concerns\HasEnteMatrRelationHelpers;
use Modules\Sigma\Models\Traits\Relationships\EnteMatrAnnoRelationship;
use Modules\Sigma\Models\Traits\Relationships\EnteMatrDateRangeRelationship;
use Modules\Sigma\Models\Traits\Relationships\EnteMatrRelationship;

use function Safe\date;

// use Laravel\Scout\Searchable;
// ----- models------
// use Modules\IndennitaCondizioniLavoro\Models\IndennitaResponsabilita;
// ------ ext models---

// ----- services -----

// ------ traits ---

trait RelationshipTrait
{
    use HasEnteMatrRelationHelpers;
    use EnteMatrAnnoRelationship;
    use EnteMatrDateRangeRelationship;
    use EnteMatrRelationship;

    
    /**
     * @return \Illuminate\Support\Collection<int, \Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio>
     */
    public function getIndennitaTipoDettaglioAllAttribute(): Collection
    {
        $anno = is_numeric($this->anno) ? (int) $this->anno : (int) date('Y');

        return IndennitaTipoDettaglio::whereRaw('? between dal and al', [$anno])->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\Modules\IndennitaCondizioniLavoro\Models\StabiDirigente, $this>
     */
    public function stabiDirigente(): HasOne
    {
        return $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')->where('repar', $this->repar);
    }

   
}
