<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Mockery;
use Modules\Rating\Models\Policies\RatingMorphPolicy;
use Modules\Rating\Models\Policies\RatingPolicy;
use Modules\Rating\Models\Rating;
use Modules\Rating\Models\RatingMorph;
use Modules\Rating\Tests\Fixtures\OwnedModelStub;
use Modules\Rating\Tests\TestCase;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

// Aggancia i test alle due policy: senza `covers()` la mutation testing di Pest associa
// i test ai sorgenti per convenzione di nome, e un file che non si chiama
// `RatingPolicyTest` non viene eseguito contro i mutanti di `RatingPolicy`.
covers(RatingPolicy::class, RatingMorphPolicy::class);

/**
 * Utente con **un solo** ruolo. Serve un ruolo per volta: è l'unico modo di dimostrare
 * che ogni voce dell'array di una policy conta davvero. Un test che passa `evaluator`
 * e basta lascia sopravvivere la mutazione che toglie `hr-manager` dall'elenco.
 *
 * @return Mockery\MockInterface&UserContract
 */
function ratingRoleUser(string $ruolo, ?string $userId = null, bool $conProfilo = false): UserContract
{
    /** @var Mockery\MockInterface&UserContract $user */
    $user = Mockery::mock(UserContract::class);
    $user->shouldReceive('hasRole')
        ->andReturnUsing(static function (array|string $richiesti) use ($ruolo): bool {
            $elenco = is_array($richiesti) ? $richiesti : [$richiesti];

            return in_array($ruolo, $elenco, true);
        });

    // Le policy leggono `id` e `profile` come proprietà: un mock di interfaccia non ha
    // il `__get` di Eloquent, quindi vanno assegnate.
    $user->id = $userId;
    $user->profile = null;

    if ($conProfilo) {
        /** @var Mockery\MockInterface&ProfileContract $profilo */
        $profilo = Mockery::mock(ProfileContract::class);
        $profilo->matr = 1;
        $user->profile = $profilo;
    }

    return $user;
}

describe('RatingPolicy — ogni ruolo dell elenco pesa', function (): void {
    test('create ammette super-admin, admin e hr-manager, uno per uno', function (): void {
        $policy = new RatingPolicy;

        foreach (['super-admin', 'admin', 'hr-manager'] as $ruolo) {
            Assert::assertTrue(
                $policy->create(ratingRoleUser($ruolo)),
                sprintf('il ruolo %s deve poter creare un rating', $ruolo),
            );
        }
    });

    test('create nega evaluator, che non è nell elenco', function (): void {
        Assert::assertFalse((new RatingPolicy)->create(ratingRoleUser('evaluator')));
    });

    test('update ammette super-admin, admin e hr-manager, uno per uno', function (): void {
        $policy = new RatingPolicy;

        foreach (['super-admin', 'admin', 'hr-manager'] as $ruolo) {
            Assert::assertTrue(
                $policy->update(ratingRoleUser($ruolo), new Rating),
                sprintf('il ruolo %s deve poter aggiornare un rating', $ruolo),
            );
        }
    });

    test('update nega evaluator, che non è nell elenco', function (): void {
        Assert::assertFalse((new RatingPolicy)->update(ratingRoleUser('evaluator'), new Rating));
    });
});

describe('RatingMorphPolicy — ogni ruolo dell elenco pesa', function (): void {
    test('viewAny ammette i quattro ruoli, uno per uno', function (): void {
        $policy = new RatingMorphPolicy;

        foreach (['super-admin', 'admin', 'hr-manager', 'evaluator'] as $ruolo) {
            Assert::assertTrue(
                $policy->viewAny(ratingRoleUser($ruolo)),
                sprintf('il ruolo %s deve poter elencare i morph', $ruolo),
            );
        }
    });

    test('viewAny nega un ruolo estraneo', function (): void {
        Assert::assertFalse((new RatingMorphPolicy)->viewAny(ratingRoleUser('dipendente')));
    });

    test('create ammette i quattro ruoli, uno per uno', function (): void {
        $policy = new RatingMorphPolicy;

        foreach (['super-admin', 'admin', 'hr-manager', 'evaluator'] as $ruolo) {
            Assert::assertTrue(
                $policy->create(ratingRoleUser($ruolo)),
                sprintf('il ruolo %s deve poter creare un morph', $ruolo),
            );
        }
    });

    test('create nega un ruolo estraneo', function (): void {
        Assert::assertFalse((new RatingMorphPolicy)->create(ratingRoleUser('dipendente')));
    });

    test('update ammette super-admin, admin e hr-manager senza guardare il proprietario', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'altro-utente';

        foreach (['super-admin', 'admin', 'hr-manager'] as $ruolo) {
            Assert::assertTrue(
                $policy->update(ratingRoleUser($ruolo), $morph),
                sprintf('il ruolo %s deve poter aggiornare un morph altrui', $ruolo),
            );
        }
    });

    test('delete ammette solo super-admin e admin, non hr-manager', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'altro-utente';

        foreach (['super-admin', 'admin'] as $ruolo) {
            Assert::assertTrue(
                $policy->delete(ratingRoleUser($ruolo), $morph),
                sprintf('il ruolo %s deve poter cancellare un morph', $ruolo),
            );
        }

        Assert::assertFalse(
            $policy->delete(ratingRoleUser('hr-manager'), $morph),
            'hr-manager non è nell elenco di delete: se lo diventa, questo test va aggiornato di proposito',
        );
    });
});

describe('RatingMorphPolicy::isOwner — i due rami di proprietà', function (): void {
    test('senza modello valutato la proprietà non si può stabilire', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'altro-utente';
        $morph->setRelation('model', null);

        Assert::assertFalse($policy->view(ratingRoleUser('dipendente', 'u-1', true), $morph));
    });

    test('la matricola coincidente rende proprietario', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'altro-utente';
        $morph->setRelation('model', new OwnedModelStub(['matr' => 1]));

        Assert::assertTrue($policy->view(ratingRoleUser('dipendente', 'u-1', true), $morph));
    });

    test('la matricola diversa non rende proprietario', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'altro-utente';
        $morph->setRelation('model', new OwnedModelStub(['matr' => 999]));

        Assert::assertFalse($policy->view(ratingRoleUser('dipendente', 'u-1', true), $morph));
    });

    test('la matricola sul modello non basta senza profilo utente', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'altro-utente';
        $morph->setRelation('model', new OwnedModelStub(['matr' => 1]));

        // Utente senza profilo: `isset($ratedModel->matr) && $user->profile` deve restare
        // una congiunzione. Se diventasse una disgiunzione, questo test passerebbe a true.
        Assert::assertFalse($policy->view(ratingRoleUser('dipendente', 'u-1'), $morph));
    });

    test('user_id coincidente rende proprietario anche senza matricola', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'altro-utente';
        $morph->setRelation('model', new OwnedModelStub(['user_id' => 'u-1']));

        Assert::assertTrue($policy->view(ratingRoleUser('dipendente', 'u-1', true), $morph));
    });
});
