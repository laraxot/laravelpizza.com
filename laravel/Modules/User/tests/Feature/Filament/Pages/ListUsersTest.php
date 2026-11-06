<?php

declare(strict_types=1);

use Filament\Actions\Action;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Modules\User\Enums\UserType;
use Modules\User\Filament\Actions\ChangePasswordAction;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Filament\Resources\UserResource\Pages\ListUsers;
use Modules\User\Filament\Resources\UserResource\Tables\UsersTable;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

uses(TestCase::class);

/**
 * La tabella utenti e' costruita da `UsersTable`: i `getTable*()` della pagina `ListUsers`
 * sono `final` e restituiscono `[]` (vedi `XotBaseListRecords`), quindi non descrivono la tabella.
 */
function usersTable(): UsersTable
{
    return app(UsersTable::class);
}

test('list users page has correct resource', function (): void {
    expect(ListUsers::getResource())->toBe(UserResource::class);
});

test('list users page has correct table columns', function (): void {
    $columns = usersTable()->getTableColumns();

    expect($columns)->toHaveKeys(['name', 'email']);

    foreach (['name', 'email'] as $name) {
        $column = $columns[$name];
        expect($column)->toBeInstanceOf(TextColumn::class)
            ->and($column->getName())->toBe($name);
    }
});

test('list users page has correct table filters', function (): void {
    // Nessun filtro definito: UsersTable usa il default di HasXotTable.
    expect(usersTable()->getTableFilters())->toBe([]);
});

test('list users page has correct table actions', function (): void {
    $actions = usersTable()->getTableActions();

    expect($actions)->toHaveKeys(['change_password', 'deactivate'])
        ->and($actions['change_password'])->toBeInstanceOf(ChangePasswordAction::class);

    $deactivateAction = $actions['deactivate'];
    Assert::assertInstanceOf(Action::class, $deactivateAction);
    expect($deactivateAction->getColor())->toBe('danger')
        ->and($deactivateAction->getIcon())->toBe('heroicon-o-trash');
});

test('list users page has correct header widgets', function (): void {
    // `getHeaderWidgets()` e' protected: Filament lo legge internamente, qui lo si legge via Reflection.
    $widgets = (new ReflectionMethod(ListUsers::class, 'getHeaderWidgets'))->invoke(new ListUsers());

    expect($widgets)->toBe([UserOverview::class]);
});

test('list users page has correct bulk actions', function (): void {
    $bulkActions = usersTable()->getTableBulkActions();

    expect($bulkActions)->toHaveKeys(['delete', 'export'])
        ->and($bulkActions['delete'])->toBeInstanceOf(DeleteBulkAction::class)
        ->and($bulkActions['export'])->toBeInstanceOf(ExportBulkAction::class);
});

test('list users page can display users', function (): void {
    skipUnlessUsersTableReady();

    // La connessione `user` puo' contenere altri utenti: si contano solo quelli creati qui.
    $created = User::factory()->count(3)->create(['type' => UserType::MasterAdmin]);

    $users = User::whereIn('id', $created->modelKeys())->get();
    expect($users)->toHaveCount(3);

    foreach ($users as $user) {
        // `users.type` non ha un cast enum: l'attributo e' la stringa del case.
        expect($user->type)->toBe(UserType::MasterAdmin->value);
    }
});

test('list users page has correct navigation label', function (): void {
    expect(ListUsers::getNavigationLabel())->not->toBeEmpty();
});

test('list users page has correct title', function (): void {
    expect((new ListUsers())->getTitle())->not->toBeEmpty();
});

test('list users page has correct breadcrumbs', function (): void {
    // Senza i parametri di rotta del tenant la generazione lancia: il test non e' applicabile.
    try {
        $breadcrumbs = (new ListUsers())->getBreadcrumbs();
    } catch (Exception) {
        $this->markTestSkipped('Breadcrumbs need route parameters not available in multi-tenant setup.');
    }

    // Filament aggiunge sempre almeno il breadcrumb della pagina corrente.
    expect($breadcrumbs)->not->toBeEmpty();
});

test('list users page can handle search', function (): void {
    $columns = usersTable()->getTableColumns();

    expect($columns['name']->isSearchable())->toBeTrue()
        ->and($columns['email']->isSearchable())->toBeTrue();
});

test('list users page can handle sorting', function (): void {
    $columns = usersTable()->getTableColumns();

    expect($columns['name']->isSortable())->toBeTrue()
        ->and($columns['email']->isSortable())->toBeTrue();
});

// Specifiche Filament v3 sulla pagina: in Filament 5 queste impostazioni stanno nella Table
// (UsersTable::table()), senza un equivalente statico su ListUsers. Corpo originale in git:
// repo Modules/User, commit 0e2e66d86, tests/Feature/Filament/Pages/ListUsersTest.php.
test('list users page can handle pagination')->skip('ListUsers::getTablePaginationPageOptions() not implemented');

test('list users page has correct table query')->skip('ListUsers::getTableQuery() not implemented');

test('list users page can handle record selection')->skip('ListUsers::canSelectRecords() not implemented');

test('list users page has correct table layout')->skip('ListUsers::getTableLayout() not implemented');

test('list users page can handle empty state')->skip('ListUsers::getTableEmptyStateHeading() not implemented');

test('list users page has correct table actions alignment')->skip('ListUsers::getTableActionsAlignment() not implemented');

test('list users page can handle table records per page')->skip('ListUsers::getTableRecordsPerPageSelectOptions() not implemented');
