<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Models\Scheda;
use Modules\Sigma\Models\Repart;

/**
 * Modules\Ptv\Models\StabiDirigente.
 *
 * @property string|null $nome_diri
 * @property string|null $nome_stabi
 * @property Repart|null $repart
 *
 * @method static \Modules\Ptv\Database\Factories\StabiDirigenteFactory factory($count = null, $state = [])
 * @method static Builder|StabiDirigente newModelQuery()
 * @method static Builder|StabiDirigente newQuery()
 * @method static Builder|StabiDirigente query()
 *
 * @property int $id
 * @property int|null $stabi
 * @property int|null $repar
 * @property int|null $ente
 * @property int|null $matr
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
 *
 * @method static Builder|StabiDirigente whereAnno($value)
 * @method static Builder|StabiDirigente whereBudget($value)
 * @method static Builder|StabiDirigente whereCreatedAt($value)
 * @method static Builder|StabiDirigente whereCreatedBy($value)
 * @method static Builder|StabiDirigente whereEnte($value)
 * @method static Builder|StabiDirigente whereId($value)
 * @method static Builder|StabiDirigente whereMatr($value)
 * @method static Builder|StabiDirigente whereNomeDiri($value)
 * @method static Builder|StabiDirigente whereNomeDiriPlus($value)
 * @method static Builder|StabiDirigente whereNomeStabi($value)
 * @method static Builder|StabiDirigente wherePostId($value)
 * @method static Builder|StabiDirigente wherePostType($value)
 * @method static Builder|StabiDirigente whereRepar($value)
 * @method static Builder|StabiDirigente whereStabi($value)
 * @method static Builder|StabiDirigente whereUpdatedAt($value)
 * @method static Builder|StabiDirigente whereUpdatedBy($value)
 * @method static Builder|StabiDirigente whereValutatoreId($value)
 *
 * @property Profile|null $creator
 * @property Profile|null $updater
 * @property int $n_diritto_excellence
 *
 * @method static Builder<static>|StabiDirigente whereNDirittoExcellence($value)
 *
 * @property-read Profile|null $deleter
 * @property-read Collection<int, Scheda> $benificiariProgressione
 * @property-read int|null $benificiari_progressione_count
 * @property-read Collection<int, Scheda> $schedas
 * @property-read int|null $schedas_count
 *
 * @mixin \Eloquent
 */
class StabiDirigente extends BaseStabiDirigente {}
