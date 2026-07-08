<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Database\Factories\MyLogFactory;
use Modules\Ptv\Models\MyLog as PtvMyLogModel;
use Modules\Ptv\Models\Profile;

/**
 * Modules\IndennitaResponsabilita\Models\MyLog.
 *
 * @property int $id
 * @property int|null $id_tbl
 * @property string|null $tbl
 * @property int|null $id_approvaz
 * @property string|null $note
 * @property string|null $obj
 * @property string|null $act
 * @property array<string, mixed>|null $data
 * @property string|null $datemod
 * @property string|null $handle
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $deleted_ip
 * @property string|null $created_ip
 * @property string|null $updated_ip
 * @method static MyLogFactory factory($count = null, $state = [])
 * @method static Builder|MyLog newModelQuery()
 * @method static Builder|MyLog newQuery()
 * @method static Builder|MyLog query()
 * @method static Builder|MyLog whereAct($value)
 * @method static Builder|MyLog whereCreatedAt($value)
 * @method static Builder|MyLog whereCreatedBy($value)
 * @method static Builder|MyLog whereCreatedIp($value)
 * @method static Builder|MyLog whereData($value)
 * @method static Builder|MyLog whereDatemod($value)
 * @method static Builder|MyLog whereDeletedAt($value)
 * @method static Builder|MyLog whereDeletedBy($value)
 * @method static Builder|MyLog whereDeletedIp($value)
 * @method static Builder|MyLog whereHandle($value)
 * @method static Builder|MyLog whereId($value)
 * @method static Builder|MyLog whereIdApprovaz($value)
 * @method static Builder|MyLog whereIdTbl($value)
 * @method static Builder|MyLog whereNote($value)
 * @method static Builder|MyLog whereObj($value)
 * @method static Builder|MyLog whereTbl($value)
 * @method static Builder|MyLog whereUpdatedAt($value)
 * @method static Builder|MyLog whereUpdatedBy($value)
 * @method static Builder|MyLog whereUpdatedIp($value)
 * @property string|null $post_type
 * @property int|null $post_id
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @method static Builder<static>|MyLog wherePostId($value)
 * @method static Builder<static>|MyLog wherePostType($value)
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class MyLog extends PtvMyLogModel
{
    protected $connection = 'indennita_responsabilita'; // this will use the specified database connection

    // -------------------------------------------------
}
