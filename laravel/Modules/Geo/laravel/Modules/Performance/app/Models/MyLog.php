<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Modules\Xot\Traits\Updater;
use function Safe\unserialize;

/**
 * Modules\Performance\Models\MyLog.
 *
 * @property int $id
 * @property int|null $id_tbl
 * @property string|null $tbl
 * @property int|null $id_approvaz
 * @property string|null $note
 * @property array<string, mixed>|null $data
 * @property string|null $datemod
 * @property string|null $handle
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @method static Builder|MyLog newModelQuery()
 * @method static Builder|MyLog newQuery()
 * @method static Builder|MyLog query()
 * @method static Builder|MyLog whereCreatedAt($value)
 * @method static Builder|MyLog whereCreatedBy($value)
 * @method static Builder|MyLog whereData($value)
 * @method static Builder|MyLog whereDatemod($value)
 * @method static Builder|MyLog whereHandle($value)
 * @method static Builder|MyLog whereId($value)
 * @method static Builder|MyLog whereIdApprovaz($value)
 * @method static Builder|MyLog whereIdTbl($value)
 * @method static Builder|MyLog whereNote($value)
 * @method static Builder|MyLog whereTbl($value)
 * @method static Builder|MyLog whereUpdatedAt($value)
 * @method static Builder|MyLog whereUpdatedBy($value)
 * @property string|null $obj
 * @property string|null $act
 * @property string|null $post_type
 * @property int|null $post_id
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @method static Builder<static>|MyLog whereAct($value)
 * @method static Builder<static>|MyLog whereObj($value)
 * @method static Builder<static>|MyLog wherePostId($value)
 * @method static Builder<static>|MyLog wherePostType($value)
 * @property int|null $model_id
 * @property string|null $model_type
 * @property-read Profile|null $deleter
 * @method static Builder<static>|MyLog whereModelId($value)
 * @method static Builder<static>|MyLog whereModelType($value)
 * @mixin \Eloquent
 */
class MyLog extends BaseModel
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'id_tbl',
        'tbl',
        'id_approvaz',
        'note',
        'data',
        'datemod',
        'handle',
        'act',
        'model_id',
        'model_type',
    ];

    /** @var string */
    protected $table = 'mylog';

    // use Updater;

    // protected $connection = 'performance'; // this will use the specified database connection
    // public $timestamps= false;
    /*
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    */

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }

    public function _data(): mixed
    {
        // echo '<pre>';print_r($obj);echo '</pre>';die();
        if (is_string($this->data)) {
            return unserialize($this->data);
        }

        return $this->data;
    }

    // -------------------------------------------------
}
