<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Spatie\ModelStatus\Status;

/**
 * Modules\Xot\Contracts\ModelWithStatusContract.
 *
 * @property int                     $id
 * @property int|null                $user_id
 * @property string|null             $post_type
 * @property Carbon|null             $created_at
 * @property Carbon|null             $updated_at
 * @property string|null             $created_by
 * @property string|null             $updated_by
 * @property string|null             $title
 * @property PivotContract|null      $pivot
 * @property string                  $tennant_name
 * @property UserContract|null       $user
 * @property string                  $status
 * @property Collection<int, Status> $statuses
 * @property int|null                $statuses_count
 *
 * @method mixed                                                           getKey()
 * @method string                                                          getRouteKey()
 * @method string                                                          getRouteKeyName()
 * @method string                                                          getTable()
 * @method mixed                                                           with($array)
 * @method array<string, mixed>                                            getFillable()
 * @method mixed                                                           fill($array)
 * @method mixed                                                           getConnection()
 * @method mixed                                                           update($params)
 * @method mixed                                                           delete()
 * @method mixed                                                           detach($params)
 * @method mixed                                                           attach($params)
 * @method mixed                                                           save($params)
 * @method array<string, mixed>                                            treeLabel()
 * @method array<string, mixed>                                            treeSons()
 * @method array<string, mixed>                                            toArray()
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo<Model, Model> user()
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface ModelWithStatusContract
{
    /** @return MorphMany<Model, Model> */
    public function statuses(): MorphMany;

    public function status(): ?Status;

    public function setStatus(string $name, ?string $reason = null): self;
}
