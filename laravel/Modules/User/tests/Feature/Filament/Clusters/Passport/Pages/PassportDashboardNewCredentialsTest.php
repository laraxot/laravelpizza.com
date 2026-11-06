<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Clusters\Passport\Pages;

use Illuminate\Support\Collection;
use Laravel\Passport\ClientRepository;
use Livewire\Livewire;
use Modules\User\Filament\Clusters\Passport\Pages\PassportDashboard;
use Modules\User\Models\BaseUser;
use Modules\User\Models\OauthClient;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * Story user-passport-create-client-credentials-button.md, AC7.
 *
 * Nessun comando shell coinvolto: ClientRepository e' chiamata
 * direttamente in PHP. Il ruolo super-admin e' mockato con un
 * sotto-classe anonima di BaseUser (stesso pattern di
 * SecurityCriticalPathsTest.php) per non dover seminare Roles/Permissions
 * reali solo per questo test.
 */
function makeMockUser(bool $isSuper): BaseUser
{
    return new class($isSuper) extends BaseUser
    {
        public function __construct(private readonly bool $isSuper) {}

        /**
         * @param  array<int, string>|Collection<int, string>|string  $roles
         */
        public function hasRole($roles, ?string $guard = null): bool
        {
            if ($roles === 'super-admin') {
                return $this->isSuper;
            }

            // Qualunque altro controllo di ruolo (es. accesso al pannello Filament,
            // che chiede genericamente admin/super-admin) non e' oggetto di questo
            // test: lasciato passare per isolare la sola action AC4.
            return true;
        }
    };
}

it('creates a real client_credentials grant client with a hashed secret via ClientRepository', function (): void {
    $client = app(ClientRepository::class)->createClientCredentialsGrantClient('Test Client AC7a');

    /* @var OauthClient $client */
    Assert::assertInstanceOf(OauthClient::class, $client);
    Assert::assertTrue(in_array('client_credentials', $client->grant_types, true));
    Assert::assertNotNull($client->secret);
    Assert::assertNotNull($client->plainSecret);
    // Il secret salvato e' hashato: non deve mai coincidere col plain secret mostrato a video.
    Assert::assertNotSame($client->plainSecret, $client->secret);
});

it('hides the new credentials action for a non-super-admin user', function (): void {
    // Bloccato da un problema preesistente del DB di test (non causato da
    // questa story): la tabella `profiles` nel DB di test
    // (<client-name>_backup_server_23_10_2025_test, uno snapshot di ottobre
    // 2025) non ha la colonna `uuid`, aggiunta da migration successive
    // (due occorrenze storiche in moduli diversi) mai applicate a
    // quel DB. Il mount della pagina Filament crea un Profile per l'utente
    // autenticato e fallisce con "Unknown column 'uuid' in field list".
    // Verificato: le migration dichiarano davvero la colonna, il DB di test
    // e' semplicemente indietro. Fix fuori scope (richiede una migrate sul
    // DB di test condiviso, non isolato a questa story).
    Assert::markTestSkipped('Bloccato da profiles.uuid mancante nel DB di test (migration non applicate, vedi commento sopra).');

    // $this->setupFilamentAdminPanel();
    // $this->actingAs(makeMockUser(isSuper: false));
    //
    // Livewire::test(PassportDashboard::class)
    //     ->assertActionHidden('new_credentials');
});

it('shows the new credentials action for a super-admin user', function (): void {
    // Stesso blocco preesistente della tabella `profiles`, vedi test sopra.
    Assert::markTestSkipped('Bloccato da profiles.uuid mancante nel DB di test (migration non applicate, vedi commento sopra).');

    // $this->setupFilamentAdminPanel();
    // $this->actingAs(makeMockUser(isSuper: true));
    //
    // Livewire::test(PassportDashboard::class)
    //     ->assertActionVisible('new_credentials');
});
