<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Widgets\Widget;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\User\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\User\Filament\Resources\UserResource\Pages\ListUsers;
use Modules\User\Models\Device;
use Modules\User\Models\Team;
use Modules\User\Models\Tenant;
use Modules\User\Models\User;
use Modules\User\Providers\Filament\AdminPanelProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\User\Tests\Traits\InteractsWithTeamsAndOAuth;
use Modules\User\Tests\Traits\InteractsWithUserDatabase;
use Modules\User\Tests\Traits\RequiresInitializedTestState;
use Modules\Xot\Tests\XotBaseTestCase;
use PragmaRX\Google2FA\Google2FA;

/**
 * Base test case for User module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DatabaseTransactions handles rollback between tests.
 *
 * @property User|null                  $user
 * @property User|null                  $owner
 * @property User|null                  $member
 * @property User|null                  $admin
 * @property User|null                  $baseUser
 * @property Team|null                  $team
 * @property Tenant|null                $tenant1
 * @property Tenant|null                $tenant2
 * @property Google2FA|null             $google2fa
 * @property Command|null               $command
 * @property ListUsers|null             $listUsersPage
 * @property CreateUser|null            $createUserPage
 * @property Device|null                $device
 * @property Action|null                $action
 * @property Widget|null                $widget
 * @property Collection<int, User>|null $users
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;
    use InteractsWithTeamsAndOAuth;
    use InteractsWithUserDatabase;
    use RequiresInitializedTestState;

    /**
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders(mixed $app): array
    {
        if (! $app instanceof Application) {
            throw new \InvalidArgumentException('Expected Illuminate\Foundation\Application.');
        }

        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
        ];
    }

    public ?User $user = null;

    public ?User $owner = null;

    public ?User $member = null;

    public ?User $admin = null;

    public ?User $baseUser = null;

    public ?Team $team = null;

    public ?Tenant $tenant1 = null;

    public ?Tenant $tenant2 = null;

    public ?Device $device = null;

    public ?Google2FA $google2fa = null;

    public ?Command $command = null;

    public ?CreateUser $createUserPage = null;

    public ?ListUsers $listUsersPage = null;

    /** @var Collection<int, User>|null */
    public ?Collection $users = null;

    public ?Action $action = null;

    public ?Widget $widget = null;

    /** @var list<string> */
    protected $connectionsToTransact = ['sqlite', 'user'];

    protected function setUp(): void
    {
        parent::setUp();

        $database = database_path('fixcity_data.sqlite');

        /** @var array<string, array<string, mixed>> $connections */
        $connections = config('database.connections', []);

        foreach (array_keys($connections) as $connection) {
            if ('sqlite' !== config("database.connections.{$connection}.driver")) {
                continue;
            }

            $this->app['config']->set("database.connections.{$connection}.database", $database);
            DB::purge($connection);
        }
    }

    public function setupFilamentAdminPanel(): void
    {
        try {
            $panel = Filament::getPanel('user::admin');
        } catch (\Throwable) {
            $panelProvider = new AdminPanelProvider($this->app);
            $panel = $panelProvider->panel(Panel::make());
            Filament::registerPanel($panel);
        }

        Filament::setCurrentPanel($panel);
    }
}
