<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Modules\Sigma\Models\Contracts\EnteMatrFieldsContract;
use Modules\Sigma\Models\Traits\Concerns\HasEnteMatrRelationHelpers;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 *
 * Base del modulo Sigma: connessione `generale`, cast condivisi, integrazione legacy.
 */
abstract class BaseModel extends XotBaseModel implements EnteMatrFieldsContract
{
    use HasEnteMatrRelationHelpers;

    /**
     * Connessione database da utilizzare.
     * Utilizza la connessione 'generale' per compatibilità con sistemi esterni.
     *
     * @var string
     */
    protected $connection = 'generale';

    public function matrField(): string
    {
        return 'matr';
    }

    public function enteField(): string
    {
        return 'ente';
    }

    public function yearField(): string
    {
        return '';
    }

    /**
     * @return array<string, string>
     */
    #[\Override]
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            // Cast specifici per il modulo Sigma
            'anv2kd' => 'date',
            'anv2ka' => 'date',
            'anvist' => 'integer',
            'anvimp' => 'decimal:5',
            'anvqta' => 'decimal:2',
        ];
    }
}
