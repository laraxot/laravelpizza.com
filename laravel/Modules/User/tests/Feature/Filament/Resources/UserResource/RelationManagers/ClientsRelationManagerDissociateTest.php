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
 * Issue module_user_fila5#97, punto 3: la riga "detach" ereditata da
 * `XotBaseRelationManager::getTableActions()` chiama
 * `$relationship->detach($record)` (`Filament\Actions\DetachAction`), un
 * metodo che esiste solo su `BelongsToMany` — `clients()` è una `MorphMany`,
 * quindi cliccarla avrebbe lanciato `Call to undefined method
 * Illuminate\Database\Eloquent\Relations\MorphMany::detach()`. Riprodotto
 * qui esplicitamente prima di verificare il fix (`dissociateClient`), che
 * azzera sia `owner_id`/`owner_type` sia `user_id` — simmetrico al fix di
 * "associateExistingClient" (`ClientsRelationManagerAssociateTest.php`).
 *
 * `getTable()->getActions()` (non `getTableActions()` diretto, marcato
 * `@deprecated` da Filament v4 e segnalato da PHPStan) — stesso pattern di
 * `getAssociateExistingClientActionFunction()`, ma sulle azioni di riga
 * invece che di header.
 */
function makeAssociatedOauthClientForDissociationTest(User $owner): OauthClient
{
    /** @var OauthClient $client */
    $client = OauthClient::query()->create([
        'name' => 'Pest rimozione associazione '.uniqid(),
        'secret' => bcrypt('test'),
        'provider' => 'users',
        'redirect' => 'https://example.test/callback',
        'redirect_uris' => json_encode(['https://example.test/callback']),
        'grant_types' => json_encode(['client_credentials']),
        'revoked' => 0,
    ]);

    $client->owner()->associate($owner);
    $client->forceFill(['user_id' => $owner->getKey()]);
    $client->save();

    return $client->refresh();
}

function getDissociateClientActionFunction(User $owner): \Closure
{
    $manager = new ClientsRelationManager;
    $manager->ownerRecord = $owner;
    $manager->pageClass = EditUser::class;
    $manager->bootedInteractsWithTable();

    $action = null;
    foreach ($manager->getTable()->getRecordActions() as $candidate) {
        if ($candidate instanceof Action && $candidate->getName() === 'dissociateClient') {
            $action = $candidate;

            break;
        }
    }
    Assert::assertInstanceOf(Action::class, $action);

    $closure = $action->getActionFunction();
    Assert::assertNotNull($closure, 'dissociateClient deve avere una closure ->action() registrata');

    return $closure;
}

it('the old detach action would have crashed on a MorphMany relationship (regression guard)', function (): void {
    /** @var User $owner */
    $owner = UserFactory::new()->createOne(['type' => User::class]);

    // MorphMany non ha detach() (esiste solo su BelongsToMany) — è esattamente
    // il difetto che questo test documenta: il vecchio "detach" ereditato da
    // XotBaseRelationManager avrebbe lanciato BadMethodCallException su
    // clients(). Verificato con method_exists() invece di invocarlo davvero:
    // un nome di metodo letterale farebbe fallire staticamente PHPStan
    // (method.notFound) sulla chiamata, non a runtime come nel bottone reale.
    Assert::assertFalse(method_exists($owner->clients(), 'detach'));
});

it('clears owner_id/owner_type and user_id via the dissociate action (issue #97)', function (): void {
    /** @var User $owner */
    $owner = UserFactory::new()->createOne(['type' => User::class]);
    $client = makeAssociatedOauthClientForDissociationTest($owner);

    Assert::assertSame(1, $owner->clients()->count());

    $closure = getDissociateClientActionFunction($owner);
    $closure($client);

    $client->refresh();

    Assert::assertNull($client->owner_id);
    Assert::assertNull($client->owner_type);
    Assert::assertNull($client->user_id, 'user_id deve essere azzerato insieme a owner_id/owner_type, altrimenti un futuro backfill ripristinerebbe l\'associazione appena rimossa');
    Assert::assertSame(0, $owner->clients()->count());
});
