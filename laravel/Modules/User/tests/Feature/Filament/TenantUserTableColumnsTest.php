<?php

declare(strict_types=1);
use Modules\User\Filament\Resources\TenantUserResource\Pages\ListTenantUsers;
use Modules\User\Filament\Resources\TenantUserResource\Tables\TenantUsersTable;
use Modules\User\Tests\TestCase;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Webmozart\Assert\Assert;

uses(TestCase::class);

/*
 * Regressione: `Filament\Tables\Concerns\HasColumns::getTableColumns()` e'
 * deprecato e ritorna array vuoto. Quella dichiarazione soddisfa il metodo
 * astratto di HasXotTable, quindi una pagina di elenco che non reimplementa il
 * metodo mostrava una tabella senza nessuna colonna.
 */
describe('colonne elenco tenant user', function (): void {
    it('non lascia che sia lo stub deprecato di Filament a fornire le colonne', function (): void {
        $method = new ReflectionMethod(ListTenantUsers::class, 'getTableColumns');

        expect($method->getDeclaringClass()->getName())->toBe(XotBaseListRecords::class);
    });

    it('prende le colonne dalla classe Table della Resource', function (): void {
        $table = app(TenantUsersTable::class);
        Assert::isInstanceOf($table, XotBaseResourceTable::class);

        expect($table->getTableColumns())->not->toBeEmpty();
    });
});
