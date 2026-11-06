<?php

declare(strict_types=1);

use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Mockery\MockInterface;
use Modules\User\Filament\Actions\ChangePasswordAction;
use Modules\User\Filament\Actions\Header\AttachRoleAction;
use Modules\User\Filament\Resources\UserResource\Actions\VerifyEmailAction;
use Modules\User\Filament\Resources\UserResource\Tables\UsersTable;
use Modules\User\Models\Role;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

use function Safe\file_get_contents;

uses(TestCase::class);

/*
 * In Filament le Action non autorizzano da sole ("You must explicitly use authorize()"): senza `authorize()` chi vede la
 * tabella utenti cambia la password di un super-admin, cancella chiunque, si assegna il super-admin. Nessun database:
 * si legge la configurazione dell'azione (riflessione sull'istanza) e il sorgente dei closure, che servono un componente
 * Livewire montato. Il verdetto della policy e' in `Unit/Policies/UserActionsPolicyVerdictTest.php`.
 */

/**
 * @return array<mixed>
 */
function userActionsAuthorizationOf(Action $action): array
{
    $value = (new ReflectionObject($action))->getProperty('authorization')->getValue($action);

    return is_array($value) ? $value : [];
}

/**
 * @param  class-string  $class
 */
function userActionsSource(string $class): string
{
    $file = (new ReflectionClass($class))->getFileName();

    return $file === false ? '' : file_get_contents($file);
}

test('change_password chiede update sul record', function (): void {
    expect(userActionsAuthorizationOf(ChangePasswordAction::make()))
        ->toMatchArray(['type' => 'all', 'abilities' => ['update']]);
});

test('verify_email chiede update sul record', function (): void {
    expect(userActionsAuthorizationOf(VerifyEmailAction::make()))
        ->toMatchArray(['type' => 'all', 'abilities' => ['update']]);
});

test('deactivate chiede delete sul record e una conferma', function (): void {
    $deactivate = app(UsersTable::class)->getTableActions()['deactivate'];

    Assert::assertInstanceOf(Action::class, $deactivate);
    expect(userActionsAuthorizationOf($deactivate))->toMatchArray(['type' => 'all', 'abilities' => ['delete']])
        ->and($deactivate->isConfirmationRequired())->toBeTrue();
});

test('i closure delle azioni rivalidano con il Gate, cosi anche una chiamata Livewire diretta e protetta', function (): void {
    expect(userActionsSource(ChangePasswordAction::class))->toContain("Gate::authorize('update', \$record)")
        ->and(userActionsSource(VerifyEmailAction::class))->toContain("Gate::authorize('update', \$record)")
        ->and(userActionsSource(UsersTable::class))->toContain("Gate::authorize('delete', \$record)");
});

test('il Gate viene prima dell effetto: password, verifica e cancellazione', function (): void {
    $cases = [
        [ChangePasswordAction::class, "Gate::authorize('update', \$record)", '$record->update('],
        [VerifyEmailAction::class, "Gate::authorize('update', \$record)", '$record->markEmailAsVerified()'],
        [UsersTable::class, "Gate::authorize('delete', \$record)", '$record->delete()'],
    ];

    foreach ($cases as [$class, $gate, $effect]) {
        $source = userActionsSource($class);
        Assert::assertNotFalse(strpos($source, $gate), "{$class}: manca il Gate");
        Assert::assertLessThan(strpos($source, $effect), strpos($source, $gate), "{$class}: il Gate segue l'effetto");
    }
});

test('attachRole limita le opzioni ruolo: senza operatore autenticato esclude il super-admin', function (): void {
    $action = AttachRoleAction::make();
    $modify = (new ReflectionObject($action))->getProperty('modifyRecordSelectOptionsQueryUsing')->getValue($action);
    Assert::assertInstanceOf(Closure::class, $modify);

    /** @var MockInterface&Builder<Role> $query */
    $query = \Mockery::mock(Builder::class);
    $query->shouldReceive('qualifyColumn')->with('name')->andReturn('roles.name');
    $query->shouldReceive('where')->once()->with('roles.name', '!=', Role::SUPER_ADMIN)->andReturnSelf();

    expect($modify($query))->toBe($query);
});

test('attachRole rivalida sul server l id ricevuto, il form e controllato dal client', function (): void {
    expect(userActionsSource(AttachRoleAction::class))
        ->toContain('->recordSelect(')
        ->toContain('assertAssignable(')
        ->toContain('Role::restrictAssignableBy(Role::query(), Auth::user())')
        ->toContain('throw new AuthorizationException()');
});
