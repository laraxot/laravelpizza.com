<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
use Modules\Ptv\Database\Factories\ProfileFactory;
use Modules\User\Models\BaseProfile as UserBaseProfile;
use Modules\User\Models\Device;
use Modules\User\Models\DeviceUser;
use Modules\User\Models\Membership;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\Team;
use Modules\Xot\Contracts\UserContract;
use Override;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\SchemalessAttributes\SchemalessAttributes;

/**
 * Modules\Ptv\Models\Profile.
 *
 * @property int $id
 * @property string|null $post_type
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $first_name
 * @property string|null $last_name
 * @property Carbon|null $created_at
 * @property string|null $email
 * @property string|null $bio
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property string|null $phone
 * @property string|null $address
 * @property int|null $user_id
 * @property int|null $valutatore_id
 * @property string|null $premise
 * @property string|null $premise_short
 * @property string|null $locality
 * @property string|null $locality_short
 * @property string|null $postal_town
 * @property string|null $postal_town_short
 * @property string|null $administrative_area_level_3
 * @property string|null $administrative_area_level_3_short
 * @property string|null $administrative_area_level_2
 * @property string|null $administrative_area_level_2_short
 * @property string|null $administrative_area_level_1
 * @property string|null $administrative_area_level_1_short
 * @property string|null $country
 * @property string|null $country_short
 * @property string|null $street_number
 * @property string|null $street_number_short
 * @property string|null $route
 * @property string|null $route_short
 * @property string|null $postal_code
 * @property string|null $postal_code_short
 * @property string|null $googleplace_url
 * @property string|null $googleplace_url_short
 * @property string|null $point_of_interest
 * @property string|null $point_of_interest_short
 * @property string|null $political
 * @property string|null $political_short
 * @property string|null $campground
 * @property string|null $campground_short
 * @property Collection<int, Permission> $permissions
 * @property int|null $permissions_count
 * @property Collection<int, Role> $roles
 * @property int|null $roles_count
 * @property UserContract|null $user
 *
 * @method static ProfileFactory factory($count = null, $state = [])
 * @method static Builder|Profile newModelQuery()
 * @method static Builder|Profile newQuery()
 * @method static Builder|Profile permission($permissions)
 * @method static Builder|Profile query()
 * @method static Builder|Profile role($roles, $guard = null)
 * @method static Builder|Profile whereAddress($value)
 * @method static Builder|Profile whereAdministrativeAreaLevel1($value)
 * @method static Builder|Profile whereAdministrativeAreaLevel1Short($value)
 * @method static Builder|Profile whereAdministrativeAreaLevel2($value)
 * @method static Builder|Profile whereAdministrativeAreaLevel2Short($value)
 * @method static Builder|Profile whereAdministrativeAreaLevel3($value)
 * @method static Builder|Profile whereAdministrativeAreaLevel3Short($value)
 * @method static Builder|Profile whereBio($value)
 * @method static Builder|Profile whereCampground($value)
 * @method static Builder|Profile whereCampgroundShort($value)
 * @method static Builder|Profile whereCountry($value)
 * @method static Builder|Profile whereCountryShort($value)
 * @method static Builder|Profile whereCreatedAt($value)
 * @method static Builder|Profile whereCreatedBy($value)
 * @method static Builder|Profile whereDeletedBy($value)
 * @method static Builder|Profile whereEmail($value)
 * @method static Builder|Profile whereEnte($value)
 * @method static Builder|Profile whereFirstName($value)
 * @method static Builder|Profile whereGoogleplaceUrl($value)
 * @method static Builder|Profile whereGoogleplaceUrlShort($value)
 * @method static Builder|Profile whereId($value)
 * @method static Builder|Profile whereLastName($value)
 * @method static Builder|Profile whereLocality($value)
 * @method static Builder|Profile whereLocalityShort($value)
 * @method static Builder|Profile whereMatr($value)
 * @method static Builder|Profile wherePhone($value)
 * @method static Builder|Profile wherePointOfInterest($value)
 * @method static Builder|Profile wherePointOfInterestShort($value)
 * @method static Builder|Profile wherePolitical($value)
 * @method static Builder|Profile wherePoliticalShort($value)
 * @method static Builder|Profile wherePostType($value)
 * @method static Builder|Profile wherePostalCode($value)
 * @method static Builder|Profile wherePostalCodeShort($value)
 * @method static Builder|Profile wherePostalTown($value)
 * @method static Builder|Profile wherePostalTownShort($value)
 * @method static Builder|Profile wherePremise($value)
 * @method static Builder|Profile wherePremiseShort($value)
 * @method static Builder|Profile whereRoute($value)
 * @method static Builder|Profile whereRouteShort($value)
 * @method static Builder|Profile whereStreetNumber($value)
 * @method static Builder|Profile whereStreetNumberShort($value)
 * @method static Builder|Profile whereUpdatedAt($value)
 * @method static Builder|Profile whereUpdatedBy($value)
 * @method static Builder|Profile whereUserId($value)
 *
 * @property string|null $firstname
 * @property string|null $surname
 * @property SchemalessAttributes $extra
 * @property string $avatar
 * @property Collection<int, DeviceUser> $deviceUsers
 * @property int|null $device_users_count
 * @property DeviceUser $pivot
 * @property Collection<int, Device> $devices
 * @property int|null $devices_count
 * @property string|null $full_name
 * @property MediaCollection<int, Media> $media
 * @property int|null $media_count
 * @property Collection<int, DeviceUser> $mobileDeviceUsers
 * @property int|null $mobile_device_users_count
 * @property Collection<int, Device> $mobileDevices
 * @property int|null $mobile_devices_count
 * @property DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property int|null $notifications_count
 * @property Membership $membership
 * @property Collection<int, Team> $teams
 * @property int|null $teams_count
 * @property string|null $user_name
 *
 * @method static Builder|Profile whereFirstname($value)
 * @method static Builder|Profile whereSurname($value)
 * @method static Builder|Profile withExtraAttributes()
 * @method static Builder|Profile withoutPermission($permissions)
 * @method static Builder|Profile withoutRole($roles, $guard = null)
 *
 * @property Carbon|null $deleted_at
 *
 * @method static Builder|Profile whereDeletedAt($value)
 *
 * @property Profile|null $creator
 * @property Profile|null $updater
 *
 * @method static Builder|Profile whereExtra($value)
 *
 * @property-read Profile|null $deleter
 *
 * @method static Builder<static>|Profile byUuid(string $uuid)
 * @method static Builder<static>|Profile childrenWith(array<int, string> $relations)
 * @method static Builder<static>|Profile childrenWithCount(array<int, string> $relations)
 *
 * @mixin \Eloquent
 */
// @see Modules/Xot/docs/spatie-schemaless-attributes.md
class Profile extends UserBaseProfile
{
    /** @var string */
    protected $connection = 'ptv';

    /** @var list<string> */
    protected $fillable = [
        'first_name',
        'last_name',
        'ente',
        'matr',
        'user_id',
    ];

    #[Override]
    public function casts(): array
    {
        return [
            'user_id' => 'string',
            'data' => 'array',
            'extra' => \Spatie\SchemalessAttributes\Casts\SchemalessAttributes::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
