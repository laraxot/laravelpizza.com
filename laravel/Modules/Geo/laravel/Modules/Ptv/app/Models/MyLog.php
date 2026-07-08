<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Ptv\Database\Factories\MyLogFactory;

use function Safe\unserialize;

/**
 * Modules\Ptv\Models\MyLog.
 *
 * @method static MyLogFactory factory($count = null, $state = [])
 * @method static Builder|MyLog newModelQuery()
 * @method static Builder|MyLog newQuery()
 * @method static Builder|MyLog query()
 *
 * @property int $id
 * @property int|null $id_tbl
 * @property string|null $tbl
 * @property int|null $id_approvaz
 * @property string|null $note
 * @property string|null $obj
 * @property string|null $act
 * @property array<array-key, mixed>|null $data
 * @property string|null $datemod
 * @property string|null $handle
 * @property string|null $post_type
 * @property int|null $post_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static Builder|MyLog whereAct($value)
 * @method static Builder|MyLog whereCreatedAt($value)
 * @method static Builder|MyLog whereCreatedBy($value)
 * @method static Builder|MyLog whereData($value)
 * @method static Builder|MyLog whereDatemod($value)
 * @method static Builder|MyLog whereHandle($value)
 * @method static Builder|MyLog whereId($value)
 * @method static Builder|MyLog whereIdApprovaz($value)
 * @method static Builder|MyLog whereIdTbl($value)
 * @method static Builder|MyLog whereNote($value)
 * @method static Builder|MyLog whereObj($value)
 * @method static Builder|MyLog wherePostId($value)
 * @method static Builder|MyLog wherePostType($value)
 * @method static Builder|MyLog whereTbl($value)
 * @method static Builder|MyLog whereUpdatedAt($value)
 * @method static Builder|MyLog whereUpdatedBy($value)
 *
 * @property Profile|null $creator
 * @property Profile|null $updater
 * @property-read Profile|null $deleter
 *
 * @mixin \Eloquent
 */
class MyLog extends BaseModel
{
    protected $table = 'mylog';

    // public $timestamps= false;
    protected $fillable = [
        'id',
        'id_tbl',
        'tbl',
        'id_approvaz',
        'note',
        'obj',
        'act',
        'data',
        'datemod',
        'handle',
    ];

    public function casts(): array
    {
        return [
            'data' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function _data(): mixed
    {
        // echo '<pre>';print_r($obj);echo '</pre>';die();
        $data = $this->getAttribute('data');
        if (is_string($data)) {
            return unserialize($data);
        }

        return $data;
    }
}
