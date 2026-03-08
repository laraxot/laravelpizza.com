<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Wireable;
use Modules\Tenant\Services\TenantService;
use Modules\User\Contracts\TeamContract;
use Modules\User\Contracts\TenantContract;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

/**
 * Class Modules\Xot\Datas\XotData.
 * ----.
 */
class XotData extends Data implements Wireable
{
    use WireableData;

    public string $main_module = '';

    public string $param_name = 'noset';

    public string $adm_home = '01';

    public ?string $adm_theme = '';

    public string $primary_lang = 'it';

    public string $pub_theme = 'One';

    public string $search_action = 'it/videos';

    public bool $show_trans_key = false;

    public string $register_type = '0';

    public string $verification_type = '';

    public bool $login_verified = false;

    public bool $force_ssl = false;

    public bool $disable_frontend_dynamic_route = false;

    public bool $disable_admin_dynamic_route = false;

    public bool $disable_database_notifications = true;

    public bool $register_adm_theme = false;

    public bool $register_pub_theme = false;

    public bool $register_collective = false;

    public string $team_class = 'Modules\User\Models\Team';

    public string $tenant_class = 'Modules\User\Models\Tenant';

    public string $membership_class = 'Modules\User\Models\Membership';

    public string $tenant_pivot_class = 'Modules\User\Models\TenantUser';

    public ?string $super_admin = null;

    public string $video_player = 'html5';

    private static ?self $instance = null;

    private ?ProfileContract $profile = null;

    public static function make(): self
    {
        if (! self::$instance) {
            $data = TenantService::getConfig('xra');

            self::$instance = self::from($data);
        }

        return self::$instance;
    }

    public function isSuperAdmin(): bool
    {
        $profile = $this->getProfileModel();
        if ($profile->isSuperAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * @return class-string<Model&UserContract>
     */
    public function getUserClass(): string
    {
        $class = config('auth.providers.users.model');
        Assert::stringNotEmpty($class, 'check config auth');
        Assert::classExists($class, '['.$class.'] check config auth');
        Assert::implementsInterface(
            $class,
            UserContract::class,
            'class '.$class.' not implements UserContract['.__LINE__.']['.class_basename($this).']',
        );
        Assert::isAOf($class, Model::class, '['.__LINE__.']['.class_basename($this).']['.$class.']');

        return $class;
    }

    /**
     * @return class-string<Model&TeamContract>
     */
    public function getTeamClass(): string
    {
        Assert::classExists($this->team_class, '['.__LINE__.']['.class_basename($this).']');
        Assert::implementsInterface(
            $this->team_class,
            TeamContract::class,
            '['.__LINE__.']['.class_basename($this).']['.$this->team_class.']',
        );
        Assert::isAOf(
            $this->team_class,
            Model::class,
            '['.$this->team_class.']['.__LINE__.']['.class_basename($this).']',
        );

        return $this->team_class;
    }

    /**
     * @return class-string<Model&TenantContract>
     */
    public function getTenantClass(): string
    {
        Assert::implementsInterface(
            $this->tenant_class,
            TenantContract::class,
            '['.$this->tenant_class.']['.__LINE__.']['.class_basename($this).']',
        );
        Assert::isAOf(
            $this->tenant_class,
            Model::class,
            '['.$this->tenant_class.']['.__LINE__.']['.class_basename($this).']',
        );
        Assert::classExists(
            $this->tenant_class,
            '['.__LINE__.']['.class_basename($this).']['.$this->tenant_class.']',
        );

        return $this->tenant_class;
    }

    public function getTenantModel(): TenantContract
    {
        $class = Str::of($this->tenant_class)->toString();
        /** @var TenantContract $model */
        $model = new $class;

        return $model;
    }

    /**
     * @return class-string<Model>
     */
    public function getTenantPivotClass(): string
    {
        Assert::classExists($this->tenant_pivot_class, '['.__LINE__.']['.class_basename($this).']');

        return $this->tenant_pivot_class;
    }

    /**
     * @return class-string<Model>
     */
    public function getMembershipClass(): string
    {
        Assert::classExists($this->membership_class, '['.__LINE__.']['.class_basename($this).']');

        return $this->membership_class;
    }

    /**
     * @return class-string<Model&ProfileContract>
     */
    public function getProfileClass(): string
    {
        $class = 'Modules\\'.$this->main_module.'\Models\Profile';
        Assert::classExists($class, '['.$class.'] check main_module ['.$this->main_module.'] in xra.php');
        Assert::implementsInterface(
            $class,
            ProfileContract::class,
            'class '.$class.' not implements ProfileContract',
        );
        Assert::isAOf($class, Model::class, 'class '.$class.' not extends Model');

        return $class;
    }

    /**
     * @return class-string
     */
    public function getHomeControlerClass(): string
    {
        return 'Modules\\'.$this->main_module.'\Http\Controllers\HomeController';
    }

    public function getProfileModel(): ProfileContract
    {
        $profileClass = $this->getProfileClass();

        return $profileClass::make();
    }

    public function getProfileModelByUserId(string $user_id): ProfileContract
    {
        $profileClass = $this->getProfileClass();

        return $profileClass::query()->firstOrCreate(['user_id' => $user_id]);
    }

    public function getUserByEmail(string $email): UserContract
    {
        $userClass = $this->getUserClass();
        /** @var UserContract|null $user */
        $user = $userClass::query()->where('email', $email)->first();
        Assert::notNull($user, 'User not found by email: '.$email);

        return $user;
    }

    public function getProfileModelByEmail(string $email): ProfileContract
    {
        $user = $this->getUserByEmail($email);

        return $this->getProfileModelByUserId((string) $user->getKey());
    }

    public function getProfile(): ProfileContract
    {
        if (null !== $this->profile) {
            return $this->profile;
        }

        $user = Auth::user();
        if (null !== $user) {
            $this->profile = $this->getProfileModelByUserId((string) $user->getAuthIdentifier());

            return $this->profile;
        }

        return $this->getProfileModel();
    }

    public function update(array $data): void
    {
        foreach ($data as $k => $v) {
            $this->{$k} = $v;
        }
        // $this->save();
    }

    public function getPubThemeViewPath(string $key): string
    {
        $path0 = base_path('Themes/'.$this->pub_theme.'/resources/views/'.$key);

        return $path0;
    }

    public function getPubThemePublicPath(string $key): string
    {
        return public_path('themes/'.$this->pub_theme.'/'.$key);
    }

    public function getPubThemeAssetPath(string $key): string
    {
        return asset('themes/'.$this->pub_theme.'/'.$key);
    }

    public function getPubThemeMailLayoutPath(string $key): string
    {
        return base_path('Themes/'.$this->pub_theme.'/resources/mail-layouts/'.$key);
    }

    /**
     * @return class-string<Model&UserContract>
     */
    public function getUserClassByType(string $type): string
    {
        $user_class = $this->getUserClass();
        /** @var Model&UserContract $user */
        $user = new $user_class;
        $type_field = $user->getTypeField();
        /** @var class-string<Model&UserContract> $class */
        $class = $user_class::query()->where($type_field, $type)->first()?->getMorphClass() ?? $user_class;

        return $class;
    }

    public function getUserModelByType(string $type): UserContract
    {
        $class = $this->getUserClassByType($type);
        /** @var UserContract $model */
        $model = new $class;

        return $model;
    }

    /**
     * @return class-string<\Illuminate\Database\Eloquent\Model>
     */
    public function getUserChildTypeClass(): string
    {
        $user_class = $this->getUserClass();
        /** @var \Modules\User\Models\User $user */
        $user = new $user_class;

        return $user->getChildTypeClass();
    }

    /**
     * @return class-string
     */
    public function getUserChildTypeEnumClass(): string
    {
        $enum_class = $this->getUserChildTypeClass();
        if (! class_exists($enum_class)) {
            Log::error('User child type enum class not found: '.$enum_class);
        }

        return $enum_class;
    }

    public function getUserTypeEnumClass(): string
    {
        $user_class = $this->getUserClass();
        /** @var \Modules\User\Models\User $user */
        $user = new $user_class;

        return $user->getTypeEnumClass();
    }

    public function getProfileModelByType(string $type): ProfileContract
    {
        $profileClass = $this->getProfileClass();
        /** @var ProfileContract $model */
        $model = new $profileClass;

        return $model;
    }

    public function getMainModuleNamespace(): string
    {
        return 'Modules\\'.$this->main_module;
    }

    public function getForceSsl(): bool
    {
        if (! $this->force_ssl) {
            return false;
        }

        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function provides(): array
    {
        return [];
    }
}
