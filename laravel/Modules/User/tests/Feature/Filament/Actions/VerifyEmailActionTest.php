<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Actions;

use Filament\Actions\Action;
use Modules\User\Filament\Resources\UserResource\Actions\VerifyEmailAction;
use Modules\User\Filament\Resources\UserResource\Tables\UsersTable;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var TestCase $this */
    $this->setupFilamentAdminPanel();

    $this->action = VerifyEmailAction::make();
});

describe('Verify Email Action', function (): void {
    test('verify email action has correct default name', function (): void {
        Assert::assertSame('verify_email', VerifyEmailAction::getDefaultName());
    });

    test('verify email action extends correct base class', function (): void {
        /** @var TestCase $this */
        $action = $this->requireAction();
        Assert::assertInstanceOf(Action::class, $action);
    });

    test('verify email action has correct icon', function (): void {
        /** @var TestCase $this */
        $action = $this->requireAction();
        Assert::assertSame('heroicon-o-check-badge', $action->getIcon());
    });

    test('verify email action has correct color', function (): void {
        /** @var TestCase $this */
        $action = $this->requireAction();
        Assert::assertSame('success', $action->getColor());
    });

    test('verify email action requires confirmation', function (): void {
        /** @var TestCase $this */
        $action = $this->requireAction();
        Assert::assertTrue($action->isConfirmationRequired());
    });

    test('verify email action marks email as verified without sending mail', function (): void {
        $source = (new \ReflectionClass(VerifyEmailAction::class))->getFileName();
        $content = is_string($source) ? file_get_contents($source) : '';

        Assert::assertStringContainsString((string) 'markEmailAsVerified', (string) $content);
        Assert::assertStringNotContainsString((string) 'Mail::', (string) $content);
        Assert::assertStringNotContainsString((string) 'Notification::send', (string) $content);
    });

    test('verify email action is only visible for unverified accounts', function (): void {
        $source = (new \ReflectionClass(VerifyEmailAction::class))->getFileName();
        $content = is_string($source) ? file_get_contents($source) : '';

        Assert::assertStringContainsString((string) 'hasVerifiedEmail', (string) $content);
    });

    test('verify email action uses translation keys', function (): void {
        /** @var TestCase $this */
        $action = $this->requireAction();
        Assert::assertNotEmpty($action->getLabel());
    });

    test('verify email action has correct setup method', function (): void {
        $reflection = new \ReflectionClass(VerifyEmailAction::class);

        Assert::assertTrue($reflection->hasMethod('setUp'));
        Assert::assertTrue($reflection->getMethod('setUp')->isProtected());
    });

    test('verify email action is wired into UsersTable row actions', function (): void {
        // Guardia di non-regressione: UsersTable.php e' la classe che
        // realmente costruisce la tabella (via XotBaseResource::table() ->
        // getTableClass()). Modules/User/app/Filament/Resources/UserResource/
        // Pages/{ListUsers,BaseListUsers}.php::getTableActions() NON e' mai
        // chiamato per la tabella (vedi docblock XotBaseListRecords) — un
        // primo tentativo aveva aggiunto l'azione li', restando invisibile
        // in produzione senza nessun errore.
        $table = app(UsersTable::class);
        $actions = $table->getTableActions();

        Assert::assertArrayHasKey('verify_email', $actions);
        Assert::assertInstanceOf(VerifyEmailAction::class, $actions['verify_email']);
    });
});
