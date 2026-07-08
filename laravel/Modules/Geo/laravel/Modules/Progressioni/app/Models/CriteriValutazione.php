<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\CriteriValutazioneFactory;
use Modules\Ptv\Models\Profile;
use Modules\Xot\Traits\Updater;

/**
 * Modules\Progressioni\Models\CriteriValutazione.
 *
 * @property int $id
 * @property int $parent_id
 * @property string|null $name
 * @property string|null $label
 * @property string|null $descr
 * @property string|null $post_type
 * @property int|null $posizione
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static CriteriValutazioneFactory factory($count = null, $state = [])
 * @method static Builder|CriteriValutazione newModelQuery()
 * @method static Builder|CriteriValutazione newQuery()
 * @method static Builder|CriteriValutazione query()
 * @method static Builder|CriteriValutazione whereAnno($value)
 * @method static Builder|CriteriValutazione whereCreatedAt($value)
 * @method static Builder|CriteriValutazione whereCreatedBy($value)
 * @method static Builder|CriteriValutazione whereDescr($value)
 * @method static Builder|CriteriValutazione whereId($value)
 * @method static Builder|CriteriValutazione whereLabel($value)
 * @method static Builder|CriteriValutazione whereName($value)
 * @method static Builder|CriteriValutazione whereParentId($value)
 * @method static Builder|CriteriValutazione wherePosizione($value)
 * @method static Builder|CriteriValutazione wherePostType($value)
 * @method static Builder|CriteriValutazione whereUpdatedAt($value)
 * @method static Builder|CriteriValutazione whereUpdatedBy($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class CriteriValutazione extends BaseModel
{
    protected $fillable = ['id', 'parent_id', 'name', 'label', 'descr', 'post_type', 'posizione', 'anno'];

    protected $table = 'criteri_valutazione';

    // use Updater;
    // protected $connection = 'performance'; // this will use the specified database connection
    // public $timestamps= false;
    /*
    protected $dates = [
        'created_at',
        'updated_at',
        ];
    */
}
