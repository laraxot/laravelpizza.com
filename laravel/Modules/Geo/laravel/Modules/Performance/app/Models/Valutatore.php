<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Performance\Models\Valutatore.
 *
 * @property int $id
 * @property string $nome_diri Nome del dirigente
 * @property string $ente Codice ente
 * @property string $matr Matricola
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Valutatore newModelQuery()
 * @method static Builder|Valutatore newQuery()
 * @method static Builder|Valutatore query()
 * @mixin \Eloquent
 */
class Valutatore extends Model
{
    protected $table = 'valutatori';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nome_diri',
        'ente',
        'matr',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
