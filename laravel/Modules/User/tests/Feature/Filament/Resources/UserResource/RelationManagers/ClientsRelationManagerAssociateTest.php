<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\Action;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Filament\Resources\UserResource\Pages\EditUser;
use Modules\User\Filament\Resources\UserResource\RelationManagers\ClientsRelationManager;
use Modules\User\Models\OauthClient;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(TestCase::class);

/**
 * Issue module_user_fila5#97: l'azione "Associa client esistente" scriveva
 * solo `user_id`, mai `owner_id`/`owner_type` — il client associato non
 * ricompariva mai in questa stessa tab (che legge da `clients()`,
 * `morphMany` su `owner`, non da `user_id`), e restava bloccato su
 * `Modules\Quaeris\Http\Controllers\Api\SurveyController::createContacts()`
 * (l'endpoint reale usato dagli script clienti), che legge solo
 * `$client->owner`. Riprodotto dal vivo dall'utente: bottone senza errori,
 * ma lista sempre vuota. Fix: `$client->owner()->associate($owner)` prima
 * del `save()`, `user_id` mantenuto per compatibilità con
 * `AssociatePassportClientToUser.php`.
 *
 * `getActionFunction()` (`Filament\Actions\Concerns\HasAction`) espone la
 * closure registrata da `->action(...)` senza dover passare dal ciclo di
 * vita Livewire completo (mount, form, validazione) — `$this` dentro la
 * closure resta legato all'istanza di `ClientsRelationManager` su cui è
 * stata definita, quindi basta impostare `ownerRecord` a mano.
 *
 * `bootedInteractsWithTable()` + `getTable()->getHeaderActions()` invece di
 * chiamare `getTableHeaderActions()` direttamente: quest'ultimo è marcato
 * `@deprecated` da Filament stesso (v4, `InteractsWithTable.php`) — PHPStan
 * lo segnala come errore su una chiamata diretta da codice applicativo,
 * anche se `XotBaseRelationManager`/`ClientsRelationManager` lo overridano
 * ancora (pattern legacy in tutto il progetto, non oggetto di questa
 * story). `bootedInteractsWithTable()` lo richiama comunque internamente
 * (`makeTable()`, non deprecato dal punto di vista del chiamante) — stesso
 * risultato, nessun avviso.
 */
function makeOrphanOauthClientForAssociationTest(): OauthClient
{
    /** @var OauthClient $client */
    $client = OauthClient::query()->create([
        'name' => 'Pest associazione client '.uniqid(),
        'secret' => bcrypt('test'),
        'provider' => 'users',
        'redirect' => 'https://example.test/callback',
        'redirect_uris' => json_encode(['https://example.test/callback']),
        'grant_types' => json_encode(['client_credentials']),
        'revoked' => 0,
    ]);

    return $client;
}

function getAssociateExistingClientActionFunction(User $owner): \Closure
{
    $manager = new ClientsRelationManager;
    $manager->ownerRecord = $owner;
    $manager->pageClass = EditUser::class;
    $manager->bootedInteractsWithTable();

    // Table::headerActions() reindicizza numericamente l'array (perde le
    // chiavi stringa di getTableHeaderActions()) — si cerca per nome.
    $action = null;
    foreach ($manager->getTable()->getHeaderActions() as $candidate) {
        if ($candidate instanceof Action && $candidate->getName() === 'associateExistingClient') {
            $action = $candidate;

            break;
        }
    }
    Assert::assertInstanceOf(Action::class, $action);

    $closure = $action->getActionFunction();
    Assert::assertNotNull($closure, 'associateExistingClient deve avere una closure ->action() registrata');

    return $closure;
}

it('associates owner_id/owner_type (not just user_id) via the associate action (issue #97)', function (): void {
    // 'type' esplicito su User::class: il default della factory ('customer_user')
    // e' un alias Parental risolto solo quando Modules/Quaeris e' bootstrappato
    // (child type registrato altrove) — qui, nel solo modulo User, resta non
    // risolvibile ("Class 'customer_user' not found") appena si tocca $client->owner
    // (rehydrata come User via lo stesso meccanismo Parental). Non e' oggetto di
    // questo test: serve solo un utente reale su cui associare il client.
    /** @var User $owner */
    $owner = UserFactory::new()->createOne(['type' => User::class]);

    $client = makeOrphanOauthClientForAssociationTest();

    Assert::assertNull($client->owner_id);
    Assert::assertNull($client->owner_type);
    Assert::assertSame(0, $owner->clients()->count());

    $closure = getAssociateExistingClientActionFunction($owner);

    $closure(['client_id' => $client->id]);

    $client->refresh();

    Assert::assertSame($owner->getKey(), $client->owner_id);
    Assert::assertSame($owner->getMorphClass(), $client->owner_type);
    Assert::assertSame($owner->getKey(), $client->user_id);
    Assert::assertSame(1, $owner->clients()->count());

    $resolvedOwner = $client->owner;
    Assert::assertInstanceOf(User::class, $resolvedOwner);
    Assert::assertSame($owner->getKey(), $resolvedOwner->getKey());
});

it('does nothing and shows an error when the client does not exist', function (): void {
    /** @var User $owner */
    $owner = UserFactory::new()->createOne();

    $closure = getAssociateExistingClientActionFunction($owner);

    $closure(['client_id' => 'non-existent-client-id']);

    Assert::assertSame(0, $owner->clients()->count());
});
