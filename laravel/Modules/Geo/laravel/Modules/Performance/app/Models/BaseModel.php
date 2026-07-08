<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Model;
// ---------- traits
use Modules\Xot\Traits\Updater;

abstract class BaseModel extends Model
{
    use Updater;

    protected $connection = 'performance';

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'stabi' => 'integer',
            'anno' => 'integer',
            'tot_budget_assegnato' => 'decimal:2',
            'tot_budget_assegnato_min_punteggio' => 'decimal:2',
            'tot_quota_effettiva' => 'decimal:2',
            'tot_quota_effettiva_min_punteggio' => 'decimal:2',
            'tot_resti' => 'decimal:2',
            'tot_resti_min_punteggio' => 'decimal:2',
            'delta' => 'decimal:2',
            'delta_min_punteggio' => 'decimal:2',
            'n_diritto' => 'integer',
            'n_diritto_excellence' => 'float',
        ];
    }

    /** @var bool */
    public $timestamps = true;
}
