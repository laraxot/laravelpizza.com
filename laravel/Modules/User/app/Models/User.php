<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
use Modules\Media\Models\Media;
use Modules\User\Database\Factories\UserFactory;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * Class Modules\User\Models\User.
 *
 * @property string                                            $id
 * @property string|null                                       $name
 * @property string|null                                       $first_name
 * @property string|null                                       $last_name
 * @property string                                            $email
 * @property Carbon|null                                       $email_verified_at
 * @property string                                            $password
 * @property string|null                                       $remember_token
 * @property int|null                                          $current_team_id
 * @property string|null                                       $profile_photo_path
 * @property Carbon|null                                       $created_at
 * @property Carbon|null                                       $updated_at
 * @property Carbon|null                                       $deleted_at
 * @property Carbon|null                                       $password_expires_at
 * @property string|null                                       $lang
 * @property bool                                              $is_active
 * @property bool                                              $is_otp
 * @property string|null                                       $updated_by
 * @property string|null                                       $created_by
 * @property string|null                                       $deleted_by
 * @property Collection<int, AuthenticationLog>                $authentications
 * @property int|null                                          $authentications_count
 * @property Collection<int, OauthClient>                      $clients
 * @property int|null                                          $clients_count
 * @property TenantUser                                        $pivot
 * @property Collection<int, Device>                           $devices
 * @property int|null                                          $devices_count
 * @property string|null                                       $full_name
 * @property AuthenticationLog|null                            $latestAuthentication
 * @property DatabaseNotificationCollection<int, Notification> $notifications
 * @property int|null                                          $notifications_count
 * @property Collection<int, Team>                             $ownedTeams
 * @property int|null                                          $owned_teams_count
 * @property Collection<int, Permission>                       $permissions
 * @property int|null                                          $permissions_count
 * @property ProfileContract|null                              $profile
 * @property Collection<int, Role>                             $roles
 * @property int|null                                          $roles_count
 * @property Membership                                        $membership
 * @property Collection<int, Team>                             $teams
 * @property int|null                                          $teams_count
 * @property Collection<int, Tenant>                           $tenants
 * @property int|null                                          $tenants_count
 * @property Collection<int, OauthAccessToken>                 $tokens
 * @property int|null                                          $tokens_count
 *
 * @method static UserFactory          factory($count = null, $state = [])
 * @method static Builder|User         newModelQuery()
 * @method static Builder|User         newQuery()
 * @method static Builder|User         permission($permissions, $without = false)
 * @method static Builder|User         query()
 * @method static Builder|User         role($roles, $guard = null, $without = false)
 * @method static Builder|User         whereCreatedAt($value)
 * @method static Builder|User         whereCreatedBy($value)
 * @method static Builder|User         whereCurrentTeamId($value)
 * @method static Builder|User         whereDeletedAt($value)
 * @method static Builder|User         whereDeletedBy($value)
 * @method static Builder|User         whereEmail($value)
 * @method static Builder|User         whereEmailVerifiedAt($value)
 * @method static Builder|User         whereFirstName($value)
 * @method static Builder|User         whereId($value)
 * @method static Builder|User         whereIsActive($value)
 * @method static Builder|User         whereLang($value)
 * @method static Builder|User         whereLastName($value)
 * @method static Builder|User         whereName($value)
 * @method static Builder<static>|User whereNotNull($column, $boolean = 'and')
 * @method static Builder|User         wherePassword($value)
 * @method static Builder|User         whereProfilePhotoPath($value)
 * @method static Builder|User         whereRememberToken($value)
 * @method static Builder|User         whereUpdatedAt($value)
 * @method static Builder|User         whereUpdatedBy($value)
 * @method static Builder|User         withoutPermission($permissions)
 * @method static Builder|User         withoutRole($roles, $guard = null)
 *
 * @property string                         $last_name
 * @property Team|null                      $currentTeam
 * @property MediaCollection<int, Media>    $media
 * @property int|null                       $media_count
 * @property Collection<int, SocialiteUser> $socialiteUsers
 * @property int|null                       $socialite_users_count
 * @property Collection<int, Membership>    $teamUsers
 * @property int|null                       $team_users_count
 * @property Collection<int, User>          $all_team_users
 * @property string|null                    $phone
 * @property string|null                    $address
 * @property string|null                    $city
 * @property string|null                    $registration_number
 * @property string|null                    $status
 * @property string|null                    $state
 * @property string|null                    $moderation_data
 * @property string|null                    $certifications
 * @property string|null                    $type
 *
 * @method static Builder<static>|User whereAddress($value)
 * @method static Builder<static>|User whereCertifications($value)
 * @method static Builder<static>|User whereCity($value)
 * @method static Builder<static>|User whereIsOtp($value)
 * @method static Builder<static>|User whereModerationData($value)
 * @method static Builder<static>|User wherePasswordExpiresAt($value)
 * @method static Builder<static>|User wherePhone($value)
 * @method static Builder<static>|User whereRegistrationNumber($value)
 * @method static Builder<static>|User whereState($value)
 * @method static Builder<static>|User whereStatus($value)
 * @method static Builder<static>|User whereType($value)
 *
 * @mixin IdeHelperUser
 *
 * @property string|null $facebook_id
 *
 * @method static Builder<static>|User whereFacebookId($value)
 *
 * @property User|null $creator
 * @property User|null $updater
 * @property User|null $user
 *
 * @mixin \Eloquent
 */
class User extends BaseUser
{
    /** @var string */
    public $connection = 'user';

    /** @var array<string, class-string> */
    protected $childTypes = [
        'master_admin' => self::class,
        'backoffice_user' => self::class,
        'customer_user' => self::class,
        'system' => self::class,
        'technician' => self::class,
    ];

    #[\Override]
    public function canAccessSocialite(): bool
    {
        // return $this->role_id === Role::ROLE_ADMINISTRATOR;
        return true;
    }
}
