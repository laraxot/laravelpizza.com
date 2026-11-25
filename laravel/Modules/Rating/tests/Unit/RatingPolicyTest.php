<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Mockery;
use Modules\Rating\Models\Policies\RatingMorphPolicy;
use Modules\Rating\Models\Policies\RatingPolicy;
use Modules\Rating\Models\Rating;
use Modules\Rating\Models\RatingMorph;
use Modules\Rating\Tests\Fixtures\RatedModelStub;
use Modules\Rating\Tests\TestCase;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

mutates(RatingPolicy::class);
mutates(RatingMorphPolicy::class);

/**
 * Utente finto che conosce solo i ruoli: le policy di Rating non toccano il database,
 * interrogano `hasRole()` e confrontano `id` con `user_id` del morph.
 *
 * @param  list<string>  $ruoli
 * @return Mockery\MockInterface&UserContract
 */
function ratingFakeUser(array $ruoli, ?string $userId = null): UserContract
{
    /** @var Mockery\MockInterface&UserContract $user */
    $user = Mockery::mock(UserContract::class);
    $user->shouldReceive('hasRole')
        ->andReturnUsing(static function (array|string $richiesti) use ($ruoli): bool {
            /** @var list<string> $richiestiNormalizzati */
            $richiestiNormalizzati = is_array($richiesti) ? $richiesti : [$richiesti];

            return array_intersect($richiestiNormalizzati, $ruoli) !== [];
        });
    $user->shouldReceive('getAttribute')
        ->with('id')
        ->andReturn($userId);
    $user->shouldReceive('getAttribute')
        ->with('profile')
        ->andReturn(null);

    // Le policy leggono `$user->id` e `$user->profile` come proprieta', non via
    // getAttribute(): un mock di interfaccia non ha il __get di Eloquent, quindi
    // le due espressioni sopra non bastano e senza queste assegnazioni PHP solleva
    // "Undefined property".
    $user->id = $userId;
    $user->profile = null;

    return $user;
}

describe('RatingPolicy', function (): void {
    test('viewAny e view aprono a chi valuta', function (): void {
        /** @var list<string> $ruoli */
        $ruoli = ['super-admin', 'admin', 'hr-manager', 'evaluator'];

        foreach ($ruoli as $ruolo) {
            $policy = new RatingPolicy;
            $user = ratingFakeUser([$ruolo]);

            Assert::assertTrue($policy->viewAny($user));
            Assert::assertTrue($policy->view($user, new Rating));
        }
    });

    test('create e update escludono evaluator', function (): void {
        $policy = new RatingPolicy;
        $evaluator = ratingFakeUser(['evaluator']);

        Assert::assertFalse($policy->create($evaluator));
        Assert::assertFalse($policy->update($evaluator, new Rating));
    });

    test('delete è riservato ad admin e super-admin', function (): void {
        /** @var list<array{0: string, 1: bool}> $casi */
        $casi = [
            ['super-admin', true],
            ['admin', true],
            ['hr-manager', false],
            ['evaluator', false],
        ];

        foreach ($casi as [$ruolo, $atteso]) {
            Assert::assertSame($atteso, (new RatingPolicy)->delete(ratingFakeUser([$ruolo]), new Rating));
        }
    });

    test('restore e forceDelete sono solo del super-admin', function (): void {
        /** @var list<array{0: string, 1: bool}> $casi */
        $casi = [
            ['super-admin', true],
            ['admin', false],
        ];

        foreach ($casi as [$ruolo, $atteso]) {
            $policy = new RatingPolicy;
            $user = ratingFakeUser([$ruolo]);

            Assert::assertSame($atteso, $policy->restore($user, new Rating));
            Assert::assertSame($atteso, $policy->forceDelete($user, new Rating));
        }
    });

    test('un ruolo sconosciuto non passa da nessuna parte', function (): void {
        $policy = new RatingPolicy;
        $estraneo = ratingFakeUser(['ospite']);

        Assert::assertFalse($policy->viewAny($estraneo));
        Assert::assertFalse($policy->create($estraneo));
        Assert::assertFalse($policy->delete($estraneo, new Rating));
    });
});

describe('RatingMorphPolicy', function (): void {
    test('view passa per chi gestisce, senza guardare il morph', function (): void {
        /** @var list<string> $ruoli */
        $ruoli = ['super-admin', 'admin', 'hr-manager'];

        foreach ($ruoli as $ruolo) {
            Assert::assertTrue((new RatingMorphPolicy)->view(ratingFakeUser([$ruolo]), new RatingMorph));
        }
    });

    test('un evaluator vede solo il proprio morph', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'u-1';

        Assert::assertTrue($policy->view(ratingFakeUser(['evaluator'], 'u-1'), $morph));
        Assert::assertFalse($policy->view(ratingFakeUser(['evaluator'], 'u-2'), $morph));
    });

    test('update segue la stessa regola di proprietà di view', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'u-1';

        Assert::assertTrue($policy->update(ratingFakeUser(['evaluator'], 'u-1'), $morph));
        Assert::assertFalse($policy->update(ratingFakeUser(['evaluator'], 'u-2'), $morph));
        Assert::assertTrue($policy->update(ratingFakeUser(['admin']), $morph));
    });

    test('viewAny e create aprono anche a evaluator', function (): void {
        $policy = new RatingMorphPolicy;
        $evaluator = ratingFakeUser(['evaluator']);

        Assert::assertTrue($policy->viewAny($evaluator));
        Assert::assertTrue($policy->create($evaluator));
    });

    test('delete consente admin e evaluator proprietario', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'u-1';

        Assert::assertTrue($policy->delete(ratingFakeUser(['admin']), $morph));
        Assert::assertTrue($policy->delete(ratingFakeUser(['evaluator'], 'u-1'), $morph));
        Assert::assertFalse($policy->delete(ratingFakeUser(['evaluator'], 'u-2'), $morph));
        Assert::assertFalse($policy->delete(ratingFakeUser(['hr-manager']), $morph));
    });

    test('restore e forceDelete solo super-admin', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;

        Assert::assertTrue($policy->restore(ratingFakeUser(['super-admin']), $morph));
        Assert::assertTrue($policy->forceDelete(ratingFakeUser(['super-admin']), $morph));
        Assert::assertFalse($policy->restore(ratingFakeUser(['admin']), $morph));
        Assert::assertFalse($policy->forceDelete(ratingFakeUser(['admin']), $morph));
    });

    test('view passa se l utente è owner del modello valutato', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'u-2';

        $ratedModel = new class extends Model
        {
            protected $table = 'rated_stub';
        };
        // `setAttribute()` invece di `$ratedModel->user_id = ...`: su un model anonimo
        // l'assegnazione magica non e' una proprieta' dichiarata, e a level max PHPStan
        // la rifiuta. `isOwner()` legge comunque l'attributo con `isset()`.
        $ratedModel->setAttribute('user_id', 'u-1');
        $morph->setRelation('model', $ratedModel);

        $user = ratingFakeUser(['evaluator'], 'u-1');
        // `profile` e' tipizzata `ProfileContract|null` sul contratto: uno `stdClass` non
        // la soddisfa. Basta un profilo qualunque purche' truthy — la policy lo usa solo
        // come guardia prima di `isOwner()`.
        /** @var Mockery\MockInterface&ProfileContract $profilo */
        $profilo = Mockery::mock(ProfileContract::class);
        $user->profile = $profilo;

        Assert::assertTrue($policy->view($user, $morph));
    });

    test('view fallisce se profile presente ma modello valutato assente', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'altro';
        $morph->setRelation('model', null);

        $user = ratingFakeUser(['evaluator'], 'u-1');
        /** @var Mockery\MockInterface&ProfileContract $profilo */
        $profilo = Mockery::mock(ProfileContract::class);
        $user->profile = $profilo;

        Assert::assertFalse($policy->view($user, $morph));
    });

    test('view passa se matr del modello coincide col profilo', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'altro';

        $ratedModel = new RatedModelStub;
        $ratedModel->setAttribute('matr', 42);
        $morph->setRelation('model', $ratedModel);

        $user = ratingFakeUser(['evaluator'], 'u-1');
        /** @var Mockery\MockInterface&ProfileContract $profilo */
        $profilo = Mockery::mock(ProfileContract::class);
        $profilo->matr = 42;
        $user->profile = $profilo;

        Assert::assertTrue($policy->view($user, $morph));
        Assert::assertTrue($policy->update($user, $morph));
    });

    test('isOwner restituisce false se né user_id né matr coincidono', function (): void {
        $policy = new RatingMorphPolicy;
        $morph = new RatingMorph;
        $morph->user_id = 'altro';

        $ratedModel = new RatedModelStub;
        $ratedModel->setAttribute('user_id', 'altro-owner');
        $ratedModel->setAttribute('matr', 99);
        $morph->setRelation('model', $ratedModel);

        $user = ratingFakeUser(['evaluator'], 'u-1');
        /** @var Mockery\MockInterface&ProfileContract $profilo */
        $profilo = Mockery::mock(ProfileContract::class);
        $profilo->matr = 42;
        $user->profile = $profilo;

        Assert::assertFalse($policy->view($user, $morph));
        Assert::assertFalse($policy->update($user, $morph));
    });
});
