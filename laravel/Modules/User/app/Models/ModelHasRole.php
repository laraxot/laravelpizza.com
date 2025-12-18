<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\User\Database\Factories\ModelHasRoleFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\User\Models\ModelHasRole.
 *
 * @property string      $id
 * @property string      $role_id
 * @property string      $model_type
 * @property string      $model_id
 * @property int|null    $team_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 *
 * @method static ModelHasRoleFactory  factory($count = null, $state = [])
 * @method static Builder|ModelHasRole newModelQuery()
 * @method static Builder|ModelHasRole newQuery()
 * @method static Builder|ModelHasRole query()
 * @method static Builder|ModelHasRole whereCreatedAt($value)
 * @method static Builder|ModelHasRole whereCreatedBy($value)
 * @method static Builder|ModelHasRole whereId($value)
 * @method static Builder|ModelHasRole whereModelId($value)
 * @method static Builder|ModelHasRole whereModelType($value)
 * @method static Builder|ModelHasRole whereRoleId($value)
 * @method static Builder|ModelHasRole whereTeamId($value)
 * @method static Builder|ModelHasRole whereUpdatedAt($value)
 * @method static Builder|ModelHasRole whereUpdatedBy($value)
 *
 * @property string $uuid (DC2Type:guid)
 *
 * @method static Builder|ModelHasRole whereUuid($value)
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @mixin IdeHelperModelHasRole
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class ModelHasRole extends BaseMorphPivot
{
    /** @var string */
    protected $table = 'model_has_role';

    /** @var list<string> */
    protected $fillable = [
        'id',
        // 'uuid',
        'role_id',
        'model_type',
        'model_id',
        'team_id',
    ];

    /**
     * Create a new instance and dynamically assign table name from config.
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $table = config('permission.table_names.model_has_roles', 'model_has_role');
        if (\is_string($table)) {
            $this->setTable($table);
        }
    }

    /** @return array<string, string> */
    #[\Override]
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'role_id' => 'string',
            'model_type' => 'string',
            'model_id' => 'string',
            'team_id' => 'string',
            // 'uuid' => 'string',

            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }
}
