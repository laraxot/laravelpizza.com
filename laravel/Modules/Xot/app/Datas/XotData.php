<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use ArrayAccess;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Wireable;
use Modules\Tenant\Services\TenantService;
use Modules\User\Contracts\TeamContract;
use Modules\User\Contracts\TenantContract;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use RuntimeException;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

use function Safe\realpath;

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

    public ?string $adm_theme = ''; // ' => 'AdminLTE',

    // public bool $enable_ads;//' => '1',
    public string $primary_lang = 'it';

    public string $pub_theme;

    // ' => 'One',
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

    public string $team_class = 'Modules\User\Models\Team'; // = Team::class;

    public string $tenant_class = 'Modules\User\Models\Tenant'; // = Team::class;

    public string $membership_class = 'Modules\User\Models\Membership'; // = Membership::class;

    public string $tenant_pivot_class = 'Modules\User\Models\TenantUser'; // = Membership::class;

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

    public function getUserByEmail(string $email): UserContract
    {
        $user_class = $this->getUserClass();
        $userInstance = new $user_class;
        if (! in_array('email', $userInstance->getFillable(), true)) {
            throw new Exception("Attribute 'email' not found in model ".$userInstance::class);
        }
        $user = $user_class::firstOrCreate(['email' => $email]);
        /*
         * if (! $user) {
         * throw new \Exception('user not found for email '.$email);
         * }
         */
        Assert::implementsInterface($user, UserContract::class, '['.__LINE__.']['.class_basename($this).']');

        return $user;
    }

    /**
     * @return class-string<Model&TeamContract>
     */
    public function getTeamClass(): string
    {
        Assert::classExists($this->team_class, '['.__LINE__.']['.class_basename($this).']');
        // Assert::isInstanceOf($team_class, Model::class, '['.__LINE__.']['.class_basename($this).']');
        Assert::isAOf(
            $this->team_class,
            Model::class,
            '['.__LINE__.']['.class_basename($this).']['.$this->team_class.']',
        );
        Assert::implementsInterface(
            $this->team_class,
            TeamContract::class,
            '['.$this->team_class.']['.__LINE__.']['.class_basename($this).']',
        );

        return $this->team_class;
    }

    /**
     * Undocumented function.
     *
     * @return class-string<Model&TenantContract>
     */
    public function getTenantClass(): string
    {
        Assert::classExists(
            $this->tenant_class,
            '['.$this->tenant_class.']['.__LINE__.']['.class_basename($this).']',
        );
        // Assert::isInstanceOf($class, Model::class, '['.__LINE__.']['.class_basename($this).']');
        // Assert::isAOf($class, Model::class, '['.__LINE__.']['.class_basename($this).']['.$class.']');
        Assert::implementsInterface(
            $this->tenant_class,
            TenantContract::class,
            '['.$this->tenant_class.']['.__LINE__.']['.class_basename($this).']',
        );
        Assert::isAOf(
            $this->tenant_class,
            Model::class,
            '['.__LINE__.']['.class_basename($this).']['.$this->tenant_class.']',
        );

        return $this->tenant_class;
    }

    /**
     * @return class-string
     */
    public function getTenantResourceClass(): string
    {
        $class = Str::of($this->tenant_class)
            ->replace('\Models\\', '\Filament\Resources\\')
            ->append('Resource')
            ->toString();
        Assert::classExists($class, '['.$class.']['.__LINE__.']['.class_basename($this).']');

        return $class;
    }

    public function getTenantPivotClass(): string
    {
        Assert::classExists($this->tenant_pivot_class, '['.__LINE__.']['.class_basename($this).']');

        return $this->tenant_pivot_class;
    }

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

        // Verifica che la classe esista
        Assert::classExists($class, '['.$class.']['.__LINE__.']['.class_basename($this).']');

        // Verifica che sia un Model e implementi ProfileContract
        Assert::isAOf($class, Model::class, '['.__LINE__.']['.class_basename($this).']['.$class.']');
        Assert::implementsInterface(
            $class,
            ProfileContract::class,
            '['.__LINE__.']['.class_basename($this).']['.$class.']',
        );

        /** @var class-string<Model&ProfileContract> */
        return $class;
    }

    public function getHomeController(): string
    {
        return 'Modules\\'.$this->main_module.'\Http\Controllers\HomeController';
    }

    public function getProfileModelByUserId(string $user_id): ProfileContract
    {
        $profileClass = $this->getProfileClass();
        /** @var Model&ProfileContract $profile */
        $profile = app($profileClass);

        Assert::isInstanceOf($profile, Model::class);
        Assert::isArray($profile->getFillable(), 'getFillable() must return array');

        if (! in_array('user_id', $profile->getFillable(), true)) {
            throw new Exception('add user_id to fillable on class '.$profileClass);
        }

        /** @var ProfileContract */
        $res = $profile->firstOrCreate(['user_id' => $user_id]);
        Assert::implementsInterface($res, ProfileContract::class);

        return $res;
    }

    public function getProfileByEmail(string $email): ProfileContract
    {
        $user = $this->getUserByEmail($email);

        return $this->getProfileModelByUserId((string) $user->id);
    }

    /**
     * Verifica se l'utente autenticato è un super amministratore.
     */
    public function iAmSuperAdmin(): bool
    {
        $user = Auth::user();
        if ($user === null) {
            return false;
        }

        if (! method_exists($user, 'hasRole')) {
            return false;
        }

        // Utilizziamo un'asserzione per garantire che hasRole restituisca un booleano
        $result = $user->hasRole('super-admin');

        return $result === true;
    }

    public function getProfileModel(): ProfileContract
    {
        if ($this->profile !== null) {
            return $this->profile;
        }

        $user_id = (string) authId();
        $this->profile = $this->getProfileModelByUserId((string) $user_id);
        Assert::implementsInterface(
            $this->profile,
            ProfileContract::class,
            '['.__LINE__.']['.class_basename($this).']',
        );

        return $this->profile;
    }

    /**
     * Update the XotData instance.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(array $data): self
    {
        foreach ($data as $k => $v) {
            $this->{$k} = $v;
        }

        // $this->save();
        return $this;
    }

    public function save(): void
    {
        dddx('wip');
    }

    public function getPubThemeViewPath(string $key = ''): string
    {
        $path0 = base_path('Themes/'.$this->pub_theme.'/resources/views/'.$key);

        try {
            return realpath($path0);
        } catch (Exception $e) {
            throw new Exception('realpath not find dir['.$path0.']'.PHP_EOL.'['.$e->getMessage().']');
        }
    }

    public function getPubThemePublicPath(string $key = ''): string
    {
        return base_path('themes/'.$this->pub_theme.'/'.$key);
    }

    public function getPubThemePublicAsset(string $key = ''): string
    {
        return asset('themes/'.$this->pub_theme.'/'.$key);
    }

    /**
     * @return class-string<Model&UserContract>
     */
    public function getUserClassByType(string $type): string
    {
        $user_class = $this->getUserClass();
        $userInstance = app($user_class);

        if (! is_object($userInstance) || ! method_exists($userInstance, 'getChildTypes')) {
            throw new Exception('getChildTypes method not found in class '.$user_class);
        }

        $types = $userInstance->getChildTypes();
        if (! is_array($types) && ! ($types instanceof ArrayAccess)) {
            throw new Exception('getChildTypes must return array or ArrayAccess');
        }
        $class = Arr::get($types, $type);
        if (is_null($class)) {
            throw new Exception('type '.$type.' not found in class '.$user_class);
        }

        Assert::classExists($class, '['.__LINE__.']['.class_basename($this).']');
        Assert::isAOf($class, Model::class, '['.__LINE__.']['.class_basename($this).']['.$class.']');
        Assert::implementsInterface(
            $class,
            UserContract::class,
            '['.__LINE__.']['.class_basename($this).']['.$class.']',
        );

        return $class;
    }

    public function getUserResourceClassByType(string $type): string
    {
        $class = $this->getUserClassByType($type);

        // Extract the module name from the class namespace
        $moduleName = Str::before(Str::after($class, 'Modules\\'), '\\');

        // Build the resource class path
        $resourceClass = Str::of($class)
            ->replace('\\Models\\', '\\Filament\\Resources\\')
            ->append('Resource')
            ->toString();

        // If the class doesn't exist, try the alternative path (app/Filament/Resources)
        if (! class_exists($resourceClass)) {
            $resourceClass =
                'Modules\\'.$moduleName.'\\app\\Filament\\Resources\\'.class_basename($class).'Resource';
        }

        if (! class_exists($resourceClass)) {
            throw new RuntimeException("Resource class not found for type: {$type}. Tried: {$resourceClass}");
        }

        return $resourceClass;
    }

    /**
     * Get user child types.
     *
     * @return array<int, mixed>
     */
    public function getUserChildTypes(): array
    {
        $enum_class = $this->getUserChildTypeClass();

        if (! enum_exists($enum_class)) {
            return [];
        }

        return $enum_class::cases();
        // $userInstance = app($user_class);
        // return $userInstance->getChildTypes();
    }

    public function getUserChildTypeClass(): string
    {
        $user_class = $this->getUserClass();
        $user_instance = app($user_class);

        if (! is_object($user_instance) || ! method_exists($user_instance, 'getCasts')) {
            throw new Exception('getCasts method not found in class '.$user_class);
        }

        $castsResult = $user_instance->getCasts();
        if (! is_array($castsResult) && ! ($castsResult instanceof ArrayAccess)) {
            throw new Exception('getCasts must return array or ArrayAccess');
        }

        // $enum_class = Arr::get($user_class::casts(),'type',null);
        $enum_class = Arr::get($castsResult, 'type', null);
        if ($enum_class === null) {
            $enum_class = Str::of($user_class)
                ->replace('\\Models\\', '\\Enums\\')
                ->append('TypeEnum')
                ->toString();
        }
        Assert::stringNotEmpty($enum_class, 'enum_class is empty');

        return $enum_class;

        // $userInstance = app($user_class);
        // return $userInstance->getChildTypes();
    }

    /**
     * Get the project namespace dynamically.
     */
    public function getProjectNamespace(): string
    {
        return 'Modules\\'.$this->main_module;
    }

    public function forceSSL(): bool
    {
        if (! $this->force_ssl) {
            return false;
        }
        if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] === 'localhost') {
            return false;
        }
        if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] === '127.0.0.1') {
            return false;
        }
        // AWS ELB
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            return true;
        }

        // if(isset($_SERVER['SERVER_NAME']) && Str::endsWith($_SERVER['SERVER_NAME'],'.local')){
        //    return false;
        // }
        // if(isset($_SERVER['REQUEST_SCHEME']) && 'https' == $_SERVER['REQUEST_SCHEME']){
        //    return false;
        // }
        return true;
    }
}
