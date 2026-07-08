<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Relationships;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * SchedaRelationship - Relazioni Eloquent per Scheda.
 *
 * Responsabilità: Aggregazione relazioni (delegation cascade).
 * Include CommonRelationship + relazioni specifiche dominio Scheda.
 *
 * @see CommonRelationship
 */
trait SchedaRelationship
{
    // ⚡ DELEGATION CASCADE
    use CommonRelationship; // Relazioni comuni (delegato qui da SchedaTrait)
    use EnteMatrAnnoRelationship; // Relazioni ente+matr+anno
    use EnteMatrDateRangeRelationship; // Relazioni con date range
    use EnteMatrRelationship; // Relazioni ente+matr
    use EnteStabiRelationship; // Relazioni ente+stabi
    use TquRelationship; // Relazioni TQU

    /**
     * @phpstan-ignore-next-line missingType.generics
     */
    public function categoriaPropro(): HasOne
    {
        $class = static::class;

        $categoriaProproClass = Str::of($class)
            ->beforeLast('\Models\\')
            ->append('\Models\CategoriaPropro')
            ->toString();

        /** @var class-string<Model> $categoriaProproClass */
        // @phpstan-ignore-next-line argument.type,argument.templateType - Dynamic class name construction
        return $this->hasOne($categoriaProproClass, 'anno', 'anno')->whereRaw('find_in_set("'
        .$this->propro
        .'",lista_propro)');
    }

    /**
     * @phpstan-ignore-next-line missingType.generics
     */
    public function stabiDirigente(): HasOne
    {
        $class = static::class;

        $stabiDirigenteClass = Str::of($class)
            ->beforeLast('\Models\\')
            ->append('\Models\StabiDirigente')
            ->toString();

        /** @var class-string<Model> $stabiDirigenteClass */
        // @phpstan-ignore-next-line argument.type,argument.templateType - Dynamic class name construction
        return $this->hasOne($stabiDirigenteClass, 'stabi', 'stabi')
            ->where('repar', $this->repar)
            ->where('anno', $this->anno);
    }

    /*
     * public function stabiDirigente(): HasOne
     * {
     * $row = $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')
     * ->where('repar', $this->repar)
     * ->where('anno', $this->anno);
     * if ($row->first() === null) {
     * // $params = getRouteParameters();
     * // extract($params);
     * $tmp = StabiDirigente::firstOrCreate(['stabi' => $this->stabi, 'repar' => $this->repar, 'anno' => $this->anno]);
     * $row = $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')
     * ->where('repar', $this->repar)
     * ->where('anno', $this->anno);
     * }
     *
     * return $row;
     * }
     */
    /**
     * @phpstan-ignore-next-line missingType.generics
     */
    public function valutatore(): BelongsTo
    {
        $class = static::class;

        $stabiDirigenteClass = Str::of($class)
            ->beforeLast('\Models\\')
            ->append('\Models\StabiDirigente')
            ->toString();

        /** @var class-string<Model> $stabiDirigenteClass */
        // @phpstan-ignore-next-line argument.type,argument.templateType - Dynamic class name construction
        return $this->belongsTo($stabiDirigenteClass);
    }
}
