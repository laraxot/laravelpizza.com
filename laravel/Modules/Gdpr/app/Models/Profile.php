<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
use Modules\Gdpr\Database\Factories\ProfileFactory;
use Modules\User\Models\BaseProfile;
use Modules\User\Models\Device;
use Modules\User\Models\DeviceProfile;
use Modules\User\Models\DeviceUser;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\SchemalessAttributes\SchemalessAttributes;

/**
 * Modules\Gdpr\Models\Profile.
 *
 * @property string                                                    $id
 * @property string|null                                               $post_type
 * @property string|null                                               $bio
 * @property Carbon|null                                               $created_at
 * @property Carbon|null                                               $updated_at
 * @property string|null                                               $created_by
 * @property string|null                                               $updated_by
 * @property string|null                                               $deleted_by
 * @property string|null                                               $first_name
 * @property string|null                                               $surname
 * @property string|null                                               $email
 * @property string|null                                               $phone
 * @property string|null                                               $address
 * @property string|null                                               $user_id
 * @property string|null                                               $last_name
 * @property string|null                                               $tax_code
 * @property string|null                                               $vat_number
 * @property Carbon|null                                               $deleted_at
 * @property SchemalessAttributes                                      $extra
 * @property string                                                    $avatar
 * @property ProfileContract|null                                      $creator
 * @property Collection<int, DeviceUser>                               $deviceUsers
 * @property int|null                                                  $device_users_count
 * @property DeviceProfile|null                                        $pivot
 * @property Collection<int, Device>                                   $devices
 * @property int|null                                                  $devices_count
 * @property string|null                                               $full_name
 * @property MediaCollection<int, Media>                               $media
 * @property int|null                                                  $media_count
 * @property Collection<int, DeviceUser>                               $mobileDeviceUsers
 * @property int|null                                                  $mobile_device_users_count
 * @property Collection<int, Device>                                   $mobileDevices
 * @property int|null                                                  $mobile_devices_count
 * @property DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property int|null                                                  $notifications_count
 * @property Collection<int, Permission>                               $permissions
 * @property int|null                                                  $permissions_count
 * @property Collection<int, Role>                                     $roles
 * @property int|null                                                  $roles_count
 * @property ProfileContract|null                                      $updater
 * @property User|null                                                 $user
 * @property string|null                                               $user_name
 *
 * @method static ProfileFactory          factory($count = null, $state = [])
 * @method static Builder<static>|Profile newModelQuery()
 * @method static Builder<static>|Profile newQuery()
 * @method static Builder<static>|Profile permission($permissions, $without = false)
 * @method static Builder<static>|Profile query()
 * @method static Builder<static>|Profile role($roles, $guard = null, $without = false)
 * @method static Builder<static>|Profile whereAddress($value)
 * @method static Builder<static>|Profile whereBio($value)
 * @method static Builder<static>|Profile whereCreatedAt($value)
 * @method static Builder<static>|Profile whereCreatedBy($value)
 * @method static Builder<static>|Profile whereDeletedAt($value)
 * @method static Builder<static>|Profile whereDeletedBy($value)
 * @method static Builder<static>|Profile whereEmail($value)
 * @method static Builder<static>|Profile whereFirstName($value)
 * @method static Builder<static>|Profile whereId($value)
 * @method static Builder<static>|Profile whereLastName($value)
 * @method static Builder<static>|Profile wherePhone($value)
 * @method static Builder<static>|Profile wherePostType($value)
 * @method static Builder<static>|Profile whereSurname($value)
 * @method static Builder<static>|Profile whereTaxCode($value)
 * @method static Builder<static>|Profile whereUpdatedAt($value)
 * @method static Builder<static>|Profile whereUpdatedBy($value)
 * @method static Builder<static>|Profile whereUserId($value)
 * @method static Builder<static>|Profile whereVatNumber($value)
 * @method static Builder<static>|Profile withExtraAttributes()
 * @method static Builder<static>|Profile withoutPermission($permissions)
 * @method static Builder<static>|Profile withoutRole($roles, $guard = null)
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class Profile extends BaseProfile
{
    /** @var string */
    protected $connection = 'gdpr';
}
