<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Ptv\Database\Factories\StabiDirigenteFactory;

/**
 * Undocumented interface.
 *
 * @property int $id
 * @property int|null $stabi
 * @property int|null $repar
 * @property string|null $nome_stabi
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $nome_diri
 * @property string|null $nome_diri_plus
 * @property string|null $budget
 * @property int|null $valutatore_id
 * @property int|null $anno
 * @property string|null $post_type
 * @property int|null $post_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property mixed $repart
 *
 * @method static StabiDirigenteFactory factory(...$parameters)
 * @method static Builder<Model> newModelQuery()
 * @method static Builder<Model> newQuery()
 * @method static Builder<Model> query()
 * @method static Builder<Model> whereAnno($value)
 * @method static Builder<Model> whereBudget($value)
 * @method static Builder<Model> whereCreatedAt($value)
 * @method static Builder<Model> whereCreatedBy($value)
 * @method static Builder<Model> whereEnte($value)
 * @method static Builder<Model> whereId($value)
 * @method static Builder<Model> whereMatr($value)
 * @method static Builder<Model> whereNomeDiri($value)
 * @method static Builder<Model> whereNomeDiriPlus($value)
 * @method static Builder<Model> whereNomeStabi($value)
 * @method static Builder<Model> wherePostId($value)
 * @method static Builder<Model> wherePostType($value)
 * @method static Builder<Model> whereRepar($value)
 * @method static Builder<Model> whereStabi($value)
 * @method static Builder<Model> whereUpdatedAt($value)
 * @method static Builder<Model> whereUpdatedBy($value)
 * @method static Builder<Model> whereValutatoreId($value)
 */
interface StabiDirigenteContract
{
    /**
     * @return HasMany<Model, Model>
     */
    public function schede(): HasMany;
}
