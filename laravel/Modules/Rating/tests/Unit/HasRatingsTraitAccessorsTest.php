<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Modules\Rating\Enums\RuleEnum;
use Modules\Rating\Models\Rating;
use Modules\Rating\Tests\Fixtures\Models\RatingsHost;
use Modules\Rating\Tests\Fixtures\RatingsHostStub;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

require_once __DIR__.'/../Fixtures/RatingsHostStub.php';

/*
 * Le relazioni (`myRatings`, `ratingObjectives`, `syncRatingsWhere`) usano `RatingsHost`, che vive in
 * `Tests\Fixtures\Models\`: `Rating::getClassName()` risolve il Rating del modulo del chiamante e senza
 * `Models\` nel namespace lancia RuntimeException (voluto, story 5.90).
 *
 * @see Modules/Rating/docs/testing-and-coverage.md
 */

afterEach(function (): void {
    Mockery::close();
});

describe('HasRatingsTrait accessors', function (): void {
    test('getRatingsAvgAttribute normalizza null a zero', function (): void {
        $host = new RatingsHostStub;
        $host->setRawAttributes(['ratings_avg' => null]);

        Assert::assertSame(0.0, $host->getRatingsAvgAttribute(null));
    });

    test('getRatingsAvgAttribute restituisce il valore esistente', function (): void {
        $host = new RatingsHostStub;

        Assert::assertSame(4.5, $host->getRatingsAvgAttribute(4.5));
    });

    test('getRatingsCountAttribute normalizza null a zero', function (): void {
        $host = new RatingsHostStub;

        Assert::assertSame(0, $host->getRatingsCountAttribute(null));
    });

    test('getRatingsCountAttribute restituisce il conteggio esistente', function (): void {
        $host = new RatingsHostStub;

        Assert::assertSame(12, $host->getRatingsCountAttribute(12));
    });

    test('getMyRatingAttribute pluck da myRatings', function (): void {
        $host = new RatingsHostStub;
        $host->setRelation('myRatings', new Collection);

        Assert::assertCount(0, $host->getMyRatingAttribute());
    });

    test('ratingAvgHtml compone markup con medie', function (): void {
        $host = new RatingsHostStub;
        $host->setRawAttributes([
            'title' => 'Prova',
            'ratings_avg' => 3.5,
            'ratings_count' => 2,
        ]);

        $html = $host->ratingAvgHtml();

        Assert::assertStringContainsString('rateit', $html);
        Assert::assertStringContainsString('3.5', $html);
        Assert::assertStringContainsString('Vota Prova', $html);
    });

    test('getRatingsRules prefixa le regole dei rating collegati', function (): void {
        $host = new RatingsHostStub;
        $host->setRelation('ratings', new Collection([
            (object) ['id' => 1, 'rule' => RuleEnum::ZeroFive, 'title' => 'Voto'],
        ]));

        $rules = $host->getRatingsRules('r_', '_x');

        Assert::assertArrayHasKey('r_1_x', $rules);
        Assert::assertStringContainsString('numeric', $rules['r_1_x']);
        Assert::assertStringStartsWith('nullable|', $rules['r_1_x']);
    });

    test('getRatingsRules con regola stringa non enum', function (): void {
        $host = new RatingsHostStub;
        $host->setRelation('ratings', new Collection([
            (object) ['id' => 3, 'rule' => 'required|string', 'title' => 'Nota'],
        ]));

        $rules = $host->getRatingsRules('f_', '');

        Assert::assertSame('required|string', $rules['f_3']);
    });

    test('getRatingsValidationAttributes mappa titoli con prefix', function (): void {
        $host = new RatingsHostStub;
        $host->setRelation('ratings', new Collection([
            (object) ['id' => 2, 'title' => 'Qualità'],
        ]));

        $attrs = $host->getRatingsValidationAttributes('fld_', '_suffix');

        Assert::assertSame('Qualità', $attrs['fld_2_suffix']);
    });
});

describe('HasRatingsTrait relazioni e sync', function (): void {
    test('ratings delega a morphToManyX sul modello Rating', function (): void {
        /** @var MorphToMany<Rating, RatingsHost, MorphPivot, 'pivot'>&Mockery\MockInterface $relation */
        $relation = Mockery::mock(MorphToMany::class);

        $host = new RatingsHost;
        $host->forcedMorph = $relation;

        Assert::assertSame($relation, $host->ratings());
    });

    test('myRatings filtra il pivot per Auth::id', function (): void {
        Auth::shouldReceive('id')->andReturn(42);

        /** @var MorphToMany<Rating, RatingsHost, MorphPivot, 'pivot'>&Mockery\MockInterface $relation */
        $relation = Mockery::mock(MorphToMany::class);
        $relation->shouldReceive('wherePivot')->once()->with('user_id', 42)->andReturnSelf();

        $host = new RatingsHost;
        $host->forcedMorph = $relation;

        Assert::assertSame($relation, $host->myRatings());
    });

    test('ratingObjectives costruisce hasMany con aggregati', function (): void {
        Auth::shouldReceive('id')->andReturn(7);

        /** @var HasMany<MorphPivot, RatingsHost>&Mockery\MockInterface $hasMany */
        $hasMany = Mockery::mock(HasMany::class);
        $hasMany->shouldReceive('selectRaw')->once()->andReturnSelf();
        $hasMany->shouldReceive('leftJoin')
            ->once()
            ->withArgs(function (string $table, callable $join): bool {
                Assert::assertSame('rating_morph', $table);
                $clause = Mockery::mock(JoinClause::class);
                $clause->shouldReceive('on')->once()->with('rating_morph.rating_id', 'ratings.id')->andReturnSelf();
                $clause->shouldReceive('whereColumn')->once()->with('rating_morph.post_type', 'ratings.related_type')->andReturnSelf();
                $clause->shouldReceive('where')->once()->with('rating_morph.post_id', 99)->andReturnSelf();
                $join($clause);

                return true;
            })
            ->andReturnSelf();
        $hasMany->shouldReceive('groupBy')->once()->with('ratings.id')->andReturnSelf();
        $hasMany->shouldReceive('with')->once()->with('post')->andReturnSelf();

        $host = new RatingsHost;
        $host->forcedHasMany = $hasMany;
        $host->setRawAttributes(['id' => 99]);

        Assert::assertSame($hasMany, $host->ratingObjectives());
    });

    test('scopeWithRating applica leftJoin su rating_morph', function (): void {
        /** @var Builder<RatingsHost>&Mockery\MockInterface $query */
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('leftJoin')
            ->once()
            ->withArgs(function (string $table, callable $join): bool {
                Assert::assertSame('rating_morph', $table);
                $clause = Mockery::mock(JoinClause::class);
                $clause->shouldReceive('on')->once()->andReturnSelf();

                $join($clause);

                return true;
            })
            ->andReturnSelf();

        $host = new RatingsHost;

        Assert::assertSame($query, $host->scopeWithRating($query));
    });

    test('getRatingsWhere applica filtri su extra_attributes', function (): void {
        /** @var MorphToMany<Rating, RatingsHost, MorphPivot, 'pivot'>&Mockery\MockInterface $relation */
        $relation = Mockery::mock(MorphToMany::class);
        $relation->shouldReceive('where')
            ->once()
            ->with('extra_attributes->anno', 2024)
            ->andReturnSelf();
        $relation->shouldReceive('get')->once()->andReturn(collect([
            (new Rating)->forceFill(['id' => 1]),
        ]));

        $host = new RatingsHost;
        $host->forcedMorph = $relation;

        $result = $host->getRatingsWhere(['anno' => 2024]);

        Assert::assertCount(1, $result);
        $first = $result->first();
        Assert::assertNotNull($first);
        Assert::assertSame(1, $first->id);
    });

    test('syncRatingsWhere senza match non chiama sync', function (): void {
        config([
            'database.connections.rating' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => false,
            ],
        ]);
        DB::purge('rating');
        DB::reconnect('rating');

        Schema::connection('rating')->create('ratings', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('extra_attributes')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('color')->nullable();
            $table->text('txt')->nullable();
            $table->string('rule')->nullable();
            $table->boolean('is_disabled')->nullable();
            $table->boolean('is_readonly')->nullable();
            $table->integer('order_column')->nullable();
            $table->timestamps();
        });

        /** @var MorphToMany<Rating, RatingsHost, MorphPivot, 'pivot'>&Mockery\MockInterface $relation */
        $relation = Mockery::mock(MorphToMany::class);
        $relation->shouldNotReceive('sync');
        $relation->shouldNotReceive('syncWithoutDetaching');

        $host = new RatingsHost;
        $host->forcedMorph = $relation;
        $host->setRelation('ratings', collect([]));

        $result = $host->syncRatingsWhere(['anno' => 2099]);

        Assert::assertCount(0, $result);
    });

    test('syncRatingsWhere sincronizza gli id trovati', function (): void {
        config([
            'database.connections.rating' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => false,
            ],
        ]);
        DB::purge('rating');
        DB::reconnect('rating');

        Schema::connection('rating')->create('ratings', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('extra_attributes')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('color')->nullable();
            $table->text('txt')->nullable();
            $table->string('rule')->nullable();
            $table->boolean('is_disabled')->nullable();
            $table->boolean('is_readonly')->nullable();
            $table->integer('order_column')->nullable();
            $table->timestamps();
        });

        $rating = new Rating;
        $rating->forceFill([
            'title' => 'Anno',
            'slug' => 'anno',
            'extra_attributes' => ['tipo' => 'sync-test'],
        ]);
        $rating->save();

        /** @var MorphToMany<Rating, RatingsHost, MorphPivot, 'pivot'>&Mockery\MockInterface $relation */
        $relation = Mockery::mock(MorphToMany::class);
        // syncWithoutDetaching, non sync: sync() stacca le pivot alias/FQCN legacy (commento in
        // HasRatingsTrait::syncRatingsWhere()). Dopo la sync la relazione caricata viene
        // dimenticata e `$this->ratings` la ricarica dalla relazione.
        $relation->shouldNotReceive('sync');
        $relation->shouldReceive('syncWithoutDetaching')->once()->with([$rating->id])->andReturn([
            'attached' => [$rating->id],
            'detached' => [],
            'updated' => [],
        ]);
        $relation->shouldReceive('getResults')->once()->andReturn(new EloquentCollection([$rating]));

        $host = new RatingsHost;
        $host->forcedMorph = $relation;
        $host->setRelation('ratings', collect([$rating]));

        $result = $host->syncRatingsWhere(['tipo' => 'sync-test']);

        Assert::assertCount(1, $result);
        $first = $result->first();
        Assert::assertNotNull($first);
        Assert::assertSame($rating->id, $first->id);
    });
});
