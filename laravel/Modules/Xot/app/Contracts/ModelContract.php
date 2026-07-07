<?php

/**
 * @see https://github.com/buyersclub/laravel-eloquent-model-interface/blob/master/src/EloquentModelInterface.php
 */

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * Modules\Xot\Contracts\ModelContract.
 *
 * @property int         $id
 * @property int|null    $user_id
 * @property string|null $post_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $title
 * @property bool        $is_reclamed
 * @property bool        $table_enable
 * @property Pivot|null  $pivot
 * @property string      $tennant_name
 *
 * @method string                                                          getRouteKey()
 * @method string                                                          getRouteKeyName()
 * @method string                                                          getTable()
 * @method mixed                                                           with(array<int, string> $array)
 * @method list<string>                                                    getFillable()
 * @method mixed                                                           fill(array<string, mixed> $array)
 * @method mixed                                                           getConnection()
 * @method mixed                                                           update(array<string, mixed> $params)
 * @method mixed                                                           delete()
 * @method mixed                                                           detach(mixed $params)
 * @method mixed                                                           attach(mixed $params)
 * @method array<string, mixed>                                            treeLabel()
 * @method array<string, mixed>                                            treeSons()
 * @method array<string, mixed>                                            toArray()
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo<Model, Model> user()
 * @method mixed                                                           getAttributeValue(string $key)
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface ModelContract
{
}
