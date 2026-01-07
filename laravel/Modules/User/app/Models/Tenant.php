<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Media\Models\Media;
use Modules\User\Database\Factories\TenantFactory;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * Modules\User\Models\Tenant.
 *
 * @method static TenantFactory  factory($count = null, $state = [])
 * @method static Builder|Tenant newModelQuery()
 * @method static Builder|Tenant newQuery()
 * @method static Builder|Tenant query()
 *
 * @property EloquentCollection<int, Model&UserContract> $members
 * @property int|null                                    $members_count
 * @property ProfileContract|null                        $creator
 * @property ProfileContract|null                        $updater
 * @property MediaCollection<int, Media>                 $media
 * @property int|null                                    $media_count
 * @property TenantUser                                  $pivot
 * @property EloquentCollection<int, User>               $users
 * @property int|null                                    $users_count
 *
 * @mixin IdeHelperTenant
 *
 * @property string               $id
 * @property string               $name
 * @property string|null          $slug
 * @property string|null          $domain
 * @property string|null          $database
 * @property int                  $is_active
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property Carbon|null          $deleted_at
 * @property ProfileContract|null $deleter
 *
 * @method static Builder<static>|Tenant whereCreatedAt($value)
 * @method static Builder<static>|Tenant whereDatabase($value)
 * @method static Builder<static>|Tenant whereDeletedAt($value)
 * @method static Builder<static>|Tenant whereDomain($value)
 * @method static Builder<static>|Tenant whereId($value)
 * @method static Builder<static>|Tenant whereIsActive($value)
 * @method static Builder<static>|Tenant whereName($value)
 * @method static Builder<static>|Tenant whereSlug($value)
 * @method static Builder<static>|Tenant whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Tenant extends BaseTenant
{
}
