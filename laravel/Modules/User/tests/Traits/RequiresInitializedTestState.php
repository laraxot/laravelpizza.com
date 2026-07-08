<?php

declare(strict_types=1);

namespace Modules\User\Tests\Traits;

use Filament\Actions\Action;
use Filament\Widgets\Widget;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Modules\User\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\User\Filament\Resources\UserResource\Pages\ListUsers;
use Modules\User\Filament\Widgets\LoginWidget;
use Modules\User\Models\Device;
use Modules\User\Models\Team;
use Modules\User\Models\Tenant;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;
use PragmaRX\Google2FA\Google2FA;

/**
 * Fail-fast accessors for nullable test fixtures declared on User TestCase.
 */
trait RequiresInitializedTestState
{
    public function freshUser(User $user): User
    {
        $fresh = $user->fresh();
        if (null === $fresh) {
            $this->fail('User model could not be refreshed.');
        }

        return $fresh;
    }

    public function requireUser(): User
    {
        $user = $this->user;
        if (null === $user) {
            $this->fail('User test property is not initialized.');
        }

        return $user;
    }

    public function requireOwner(): User
    {
        $owner = $this->owner;
        if (null === $owner) {
            $this->fail('Owner test property is not initialized.');
        }

        return $owner;
    }

    public function requireMember(): User
    {
        $member = $this->member;
        if (null === $member) {
            $this->fail('Member test property is not initialized.');
        }

        return $member;
    }

    public function requireAdmin(): User
    {
        $admin = $this->admin;
        if (null === $admin) {
            $this->fail('Admin test property is not initialized.');
        }

        return $admin;
    }

    public function requireBaseUser(): User
    {
        $baseUser = $this->baseUser;
        if (null === $baseUser) {
            $this->fail('BaseUser test property is not initialized.');
        }

        return $baseUser;
    }

    public function requireTeam(): Team
    {
        $team = $this->team;
        if (null === $team) {
            $this->fail('Team test property is not initialized.');
        }

        return $team;
    }

    public function requireTenant1(): Tenant
    {
        $tenant1 = $this->tenant1;
        if (null === $tenant1) {
            $this->fail('Tenant1 test property is not initialized.');
        }

        return $tenant1;
    }

    public function requireTenant2(): Tenant
    {
        $tenant2 = $this->tenant2;
        if (null === $tenant2) {
            $this->fail('Tenant2 test property is not initialized.');
        }

        return $tenant2;
    }

    public function requireGoogle2fa(): Google2FA
    {
        $google2fa = $this->google2fa;
        if (null === $google2fa) {
            $this->fail('Google2FA test property is not initialized.');
        }

        return $google2fa;
    }

    public function requireDevice(): Device
    {
        $device = $this->device;
        if (null === $device) {
            $this->fail('Device test property is not initialized.');
        }

        return $device;
    }

    public function requireCommand(): Command
    {
        $command = $this->command;
        if (null === $command) {
            $this->fail('Command test property is not initialized.');
        }

        return $command;
    }

    public function requireAction(): Action
    {
        $action = $this->action;
        if (null === $action) {
            $this->fail('Action test property is not initialized.');
        }

        return $action;
    }

    public function requireWidget(): Widget
    {
        if (null === $this->widget) {
            $this->fail('Widget test property is not initialized.');
        }

        return $this->widget;
    }

    public function requireLoginWidget(): LoginWidget
    {
        $widget = $this->requireWidget();
        Assert::assertInstanceOf(LoginWidget::class, $widget);

        return $widget;
    }

    public function requireCreateUserPage(): CreateUser
    {
        $createUserPage = $this->createUserPage;
        if (null === $createUserPage) {
            $this->fail('CreateUser page test property is not initialized.');
        }

        return $createUserPage;
    }

    public function requireListUsersPage(): ListUsers
    {
        $listUsersPage = $this->listUsersPage;
        if (null === $listUsersPage) {
            $this->fail('ListUsers page test property is not initialized.');
        }

        return $listUsersPage;
    }

    /**
     * @return Collection<int, User>
     */
    public function requireUsers(): Collection
    {
        $users = $this->users;
        if (null === $users) {
            $this->fail('Users test property is not initialized.');
        }

        return $users;
    }

    public function requireFreshUser(User $user): User
    {
        $fresh = $user->fresh();
        Assert::assertNotNull($fresh);

        return $fresh;
    }
}
