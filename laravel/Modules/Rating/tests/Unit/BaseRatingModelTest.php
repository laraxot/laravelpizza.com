<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Builder;
use Mockery;
use Modules\Rating\Enums\RuleEnum;
use Modules\Rating\Models\BaseRating;
use Modules\Rating\Models\Rating;
use Modules\Rating\Models\RatingMorph;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

describe('BaseRating (via Rating)', function (): void {
    test('getSlugOptions genera slug dal titolo', function (): void {
        $options = (new Rating)->getSlugOptions();

        Assert::assertSame(['title'], $options->generateSlugFrom);
        Assert::assertSame('slug', $options->slugField);
    });

    test('registerMediaConversions non solleva eccezioni', function (): void {
        $rating = new Rating;

        $rating->registerMediaConversions(null);

        Assert::assertSame(Rating::class, $rating::class);
    });

    // La relazione morphTo verso il model valutato non vive su `Rating`: vive su
    // `BaseRatingMorph::model()`, ed e' gia' verificata in `RatingMorphModelTest`
    // («espone le relazioni rating user profile model»), con le stesse asserzioni su
    // `model_type` e `model_id`. Qui restava un test su `Rating::linkedTo()`, metodo
    // che oggi non esiste piu' su nessuna classe: chiedeva un'API inesistente, quindi
    // si corregge il test — non si reintroduce il metodo per farlo passare.

    test('casts include extra_attributes rule e boolean', function (): void {
        $rating = new Rating([
            'rule' => RuleEnum::ZeroFive,
            'is_disabled' => '1',
            'is_readonly' => '0',
        ]);

        Assert::assertInstanceOf(RuleEnum::class, $rating->rule);
        Assert::assertSame(RuleEnum::ZeroFive, $rating->rule);
        Assert::assertTrue($rating->is_disabled);
        Assert::assertFalse($rating->is_readonly);
    });

    test('scopeWithExtraAttributes filtra per chiave singola con valore', function (): void {
        /** @var Builder<BaseRating>&Mockery\MockInterface $builder */
        $builder = Mockery::mock(Builder::class);
        $builder->shouldReceive('where')
            ->once()
            ->with('extra_attributes->anno', 2024)
            ->andReturnSelf();

        $result = (new Rating)->scopeWithExtraAttributes($builder, 'anno', 2024);

        Assert::assertSame($builder, $result);
    });

    test('scopeWithExtraAttributes filtra per array di attributi', function (): void {
        /** @var Builder<BaseRating>&Mockery\MockInterface $builder */
        $builder = Mockery::mock(Builder::class);
        $builder->shouldReceive('where')
            ->once()
            ->with('extra_attributes->anno', 2024)
            ->andReturnSelf();
        $builder->shouldReceive('where')
            ->once()
            ->with('extra_attributes->tipo', 'foo')
            ->andReturnSelf();

        $result = (new Rating)->scopeWithExtraAttributes($builder, [
            'anno' => 2024,
            'tipo' => 'foo',
        ]);

        Assert::assertSame($builder, $result);
    });

    test('scopeWithExtraAttributes senza value su stringa lascia il builder', function (): void {
        /** @var Builder<BaseRating>&Mockery\MockInterface $builder */
        $builder = Mockery::mock(Builder::class);
        $builder->shouldNotReceive('where');

        $result = (new Rating)->scopeWithExtraAttributes($builder, 'anno');

        Assert::assertSame($builder, $result);
    });

    test('getValueHtml restituisce stringa per valori non Importo', function (): void {
        $rating = new Rating([
            'title' => 'Punteggio',
            'txt' => 'Voto',
        ]);
        $pivot = new RatingMorph;
        $pivot->setRawAttributes(['value' => 42]);
        $rating->setRelation('pivot', $pivot);
        $rating->setRelation('children', collect());

        Assert::assertSame('42', $rating->getValueHtml());
    });

    test('getValueHtml restituisce Money quando txt contiene Importo', function (): void {
        $rating = new Rating([
            'txt' => 'Importo mensile',
        ]);
        $pivot = new RatingMorph;
        $pivot->setRawAttributes(['value' => 12.5]);
        $rating->setRelation('pivot', $pivot);
        $rating->setRelation('children', collect());

        $result = $rating->getValueHtml();

        Assert::assertInstanceOf(Money::class, $result);
        Assert::assertSame('1250', $result->getAmount());
    });

    test('getNoteHtml restituisce note pivot quando ci sono figli caricati', function (): void {
        $rating = new Rating(['txt' => 'Criterio']);
        $pivot = new RatingMorph;
        $pivot->setRawAttributes(['value' => 1, 'note' => 'scelta utente']);
        $rating->setRelation('pivot', $pivot);
        $rating->setRelation('children', collect([new Rating(['title' => 'Figlio'])]));

        Assert::assertSame('scelta utente', $rating->getNoteHtml());
    });

    test('getTxtHtml rende HTML RichEditor e decodifica entita doppie', function (): void {
        $plain = new Rating(['title' => 'Solo titolo']);
        Assert::assertSame('Solo titolo', $plain->getTxtHtml());

        $html = new Rating(['txt' => '<p><strong>Obiettivo</strong></p>']);
        Assert::assertSame('<p><strong>Obiettivo</strong></p>', $html->getTxtHtml());

        $encoded = new Rating(['txt' => '&lt;p&gt;Obiettivo&lt;/p&gt;']);
        Assert::assertSame('<p>Obiettivo</p>', $encoded->getTxtHtml());
    });
});
