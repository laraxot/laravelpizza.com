<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\In;
use Modules\Rating\Contracts\RatingsFormCallerContract;
use Modules\Rating\Datas\RatingData;
use Modules\Rating\Enums\RuleEnum;
use Modules\Rating\Models\BaseRating;
use Modules\Rating\Models\Contracts\RatingContract;
use Modules\Rating\Models\Rating;
use Modules\Rating\Tests\Fixtures\RatingsHostStub;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

require_once __DIR__.'/../Fixtures/RatingsHostStub.php';

afterEach(function (): void {
    \Mockery::close();
});

/**
 * Story Rating/5.99 + 5.147 — Fieldset Select|Textarea sempre visibili, columnSpan(2).
 */

/**
 * @param  list<Rating>  $children
 */
function makeRatingWithChildren(array $children): Rating
{
    $parent = new Rating;
    $parent->forceFill([
        'id' => 1,
        'title' => 'Criterio con figli',
        'is_readonly' => false,
        'rule' => RuleEnum::ZeroFive,
    ]);
    $parent->setRelation('children', collect($children));

    return $parent;
}

function makeChildRating(int $id, string $title): Rating
{
    $child = new Rating;
    $child->forceFill(['id' => $id, 'title' => $title]);

    return $child;
}

/**
 * @return array<int, Component>
 */
function schemaChildren(Component $component): array
{
    $prop = new \ReflectionProperty($component::class, 'childComponents');
    $prop->setAccessible(true);

    /** @var array<string, mixed> $stored */
    $stored = $prop->getValue($component);

    /** @var array<int, Component> $children */
    $children = $stored['default'];

    return $children;
}

/**
 * @return EloquentCollection<int, BaseRating>
 */
function ratingsCollection(BaseRating ...$ratings): EloquentCollection
{
    return new EloquentCollection(array_values($ratings));
}

describe('HasRatingsTrait — opzione "altro" (Rating/5.99 + 5.147 Fieldset)', function (): void {
    test('con figli lo schema e un Fieldset con Select e Textarea', function (): void {
        $host = new RatingsHostStub;
        $parent = makeRatingWithChildren([
            makeChildRating(10, 'Ottimo'),
            makeChildRating(11, 'Scarso'),
        ]);

        $schema = $host->getRatingsFormSchema(null, ratingsCollection($parent));
        $component = $schema['ratings.1.pivot.value'];

        Assert::assertInstanceOf(Fieldset::class, $component);

        $children = schemaChildren($component);
        Assert::assertCount(2, $children);
        Assert::assertInstanceOf(Select::class, $children[0]);
        Assert::assertInstanceOf(Textarea::class, $children[1]);
    });

    test('Fieldset: columns(2) interno e columnSpan(2) nel form parent', function (): void {
        $host = new RatingsHostStub;
        $parent = makeRatingWithChildren([makeChildRating(10, 'Ottimo')]);

        $schema = $host->getRatingsFormSchema(null, ratingsCollection($parent));
        /** @var Fieldset $fieldset */
        $fieldset = $schema['ratings.1.pivot.value'];

        Assert::assertSame(['lg' => 2], $fieldset->getColumns());
        // columnSpan(2) → lg=2; default resta 1 (docs Filament: sotto lg stack a 1 col)
        Assert::assertSame(['default' => 1, 'lg' => 2], $fieldset->getColumnSpan());
    });

    test('le opzioni del Select includono i figli piu la chiave "other" per "altro"', function (): void {
        $host = new RatingsHostStub;
        $parent = makeRatingWithChildren([
            makeChildRating(10, 'Ottimo'),
            makeChildRating(11, 'Scarso'),
        ]);

        $schema = $host->getRatingsFormSchema(null, ratingsCollection($parent));
        /** @var Fieldset $fieldset */
        $fieldset = $schema['ratings.1.pivot.value'];
        /** @var Select $select */
        $select = schemaChildren($fieldset)[0];

        Assert::assertSame(
            [10 => 'Ottimo', 11 => 'Scarso', 'other' => 'Altro'],
            $select->getOptions(),
        );
        Assert::assertSame('Scegli…', $select->getPlaceholder());
    });

    test('la chiave "altro" non e mai la stringa vuota, per non collassare con "blank" lato JS Filament', function (): void {
        // Bug reale segnalato dall'utente 2026-09-16: con chiave '', la Textarea non
        // diventava mai obbligatoria dopo aver scelto "altro". Causa verificata nel
        // sorgente vendor: vendor/filament/support/resources/js/utilities/select.js
        // dichiara blank(value) => value === null || value === '' || ... e lo usa per
        // decidere lo stato "nessuna scelta" — con chiave '' il widget non distingue mai
        // "altro scelto" da "niente scelto", quindi lo stato che arriva al server collassa
        // su null e selectIsOther() non ritorna mai true. Guardia esplicita: se qualcuno
        // in futuro riporta la costante a '' (e' gia' successo due volte oggi), questo
        // test si accorge prima che arrivi un altro bug report identico.
        $host = new RatingsHostStub;
        $parent = makeRatingWithChildren([makeChildRating(10, 'Ottimo')]);

        $schema = $host->getRatingsFormSchema(null, ratingsCollection($parent));
        /** @var Fieldset $fieldset */
        $fieldset = $schema['ratings.1.pivot.value'];
        /** @var Select $select */
        $select = schemaChildren($fieldset)[0];

        $otherKey = array_search('Altro', $select->getOptions(), true);

        Assert::assertNotSame('', $otherKey);
        Assert::assertNotFalse($otherKey);
        Assert::assertSame('other', $otherKey);
    });

    test('il campo Select mantiene il nome ratings.{id}.pivot.value, la Textarea usa .pivot.note', function (): void {
        $host = new RatingsHostStub;
        $parent = makeRatingWithChildren([makeChildRating(10, 'Ottimo')]);

        $schema = $host->getRatingsFormSchema(null, ratingsCollection($parent));
        /** @var Fieldset $fieldset */
        $fieldset = $schema['ratings.1.pivot.value'];
        /** @var Select $select */
        /** @var Textarea $note */
        [$select, $note] = schemaChildren($fieldset);

        Assert::assertSame('ratings.1.pivot.value', $select->getName());
        Assert::assertSame('ratings.1.pivot.note', $note->getName());
    });

    test('senza figli il campo resta un TextInput numerico, non un Fieldset', function (): void {
        $host = new RatingsHostStub;
        $parent = makeRatingWithChildren([]);

        $schema = $host->getRatingsFormSchema(null, ratingsCollection($parent));
        $component = $schema['ratings.1.pivot.value'];

        Assert::assertInstanceOf(TextInput::class, $component);
    });

    test('readonly resta un TextEntry anche con figli', function (): void {
        $host = new RatingsHostStub;
        $parent = makeRatingWithChildren([makeChildRating(10, 'Ottimo')]);
        $parent->forceFill(['is_readonly' => true]);

        $schema = $host->getRatingsFormSchema(null, ratingsCollection($parent));
        $component = $schema['ratings.1.pivot.value'];

        Assert::assertInstanceOf(TextEntry::class, $component);
    });

    test('ratingFieldName accetta una colonna pivot esplicita restando retrocompatibile', function (): void {
        $rating = makeChildRating(7, 'Prova');

        Assert::assertSame('ratings.7.pivot.value', RatingData::ratingFieldName($rating));
        Assert::assertSame('ratings.7.pivot.value', RatingData::ratingFieldName($rating, 'value'));
        Assert::assertSame('ratings.7.pivot.note', RatingData::ratingFieldName($rating, 'note'));
    });

    test('la Textarea e required solo quando Get sul Select restituisce other', function (): void {
        // Bug utente 2026-09-16: i test precedenti verificavano solo instanceof Closure
        // su isRequired — la Closure poteva essere sbagliata e Pest restava verde.
        // Qui si valuta il comportamento: true su 'other', false su null/id figlio.
        // La Closure riceve Get($select Component), non un path stringa (statePath `data.`).
        $host = new RatingsHostStub;
        $parent = makeRatingWithChildren([makeChildRating(10, 'Ottimo')]);

        $schema = $host->getRatingsFormSchema(null, ratingsCollection($parent));
        /** @var Fieldset $fieldset */
        $fieldset = $schema['ratings.1.pivot.value'];
        /** @var Select $select */
        /** @var Textarea $note */
        [$select, $note] = schemaChildren($fieldset);

        Assert::assertTrue($note->isVisible());
        Assert::assertTrue($select->isRequired());

        $prop = new \ReflectionProperty(Textarea::class, 'isRequired');
        $prop->setAccessible(true);
        /** @var \Closure $required */
        $required = $prop->getValue($note);
        Assert::assertInstanceOf(\Closure::class, $required);

        $stubGet = static function (mixed $selectValue) use ($select): Get {
            return new class($select, $selectValue) extends Get
            {
                public function __construct(
                    private readonly Component $select,
                    private readonly mixed $selectValue,
                ) {
                    parent::__construct($select);
                }

                public function __invoke(string|Component $path = '', bool $isAbsolute = false): mixed
                {
                    return $path === $this->select ? $this->selectValue : null;
                }
            };
        };

        Assert::assertTrue($required($stubGet('other')));
        Assert::assertFalse($required($stubGet(null)));
        Assert::assertFalse($required($stubGet(10)));
        Assert::assertFalse($required($stubGet('10')));
        Assert::assertFalse($required($stubGet('')));
    });

    test('il Select con figli valida in(keys) e non RuleEnum numeric', function (): void {
        // Root cause 5.152: ->rules(RuleEnum::ZeroFive) = numeric|min:0|max:5
        // rifiutava la sentinella 'other' prima che la note potesse essere required.
        $host = new RatingsHostStub;
        $parent = makeRatingWithChildren([
            makeChildRating(10, 'Ottimo'),
            makeChildRating(11, 'Scarso'),
        ]);
        $parent->forceFill(['rule' => RuleEnum::ZeroFive]);

        $schema = $host->getRatingsFormSchema(null, ratingsCollection($parent));
        /** @var Fieldset $fieldset */
        $fieldset = $schema['ratings.1.pivot.value'];
        /** @var Select $select */
        [$select] = schemaChildren($fieldset);

        $rulesProp = new \ReflectionProperty(Select::class, 'rules');
        $rulesProp->setAccessible(true);
        /** @var list<array{0: mixed, 1: mixed}> $stored */
        $stored = $rulesProp->getValue($select);

        $ruleObjects = array_map(static fn (array $pair): mixed => $pair[0], $stored);
        $ruleStrings = array_values(array_filter(
            $ruleObjects,
            static fn (mixed $rule): bool => is_string($rule),
        ));

        foreach ($ruleStrings as $ruleString) {
            Assert::assertStringNotContainsString('numeric', $ruleString);
        }

        $inRules = array_values(array_filter(
            $ruleObjects,
            static fn (mixed $rule): bool => $rule instanceof In,
        ));
        Assert::assertCount(1, $inRules);

        $validatorOther = Validator::make(
            ['v' => 'other'],
            ['v' => [$inRules[0]]],
        );
        Assert::assertTrue($validatorOther->passes());

        $validatorChild = Validator::make(
            ['v' => '10'],
            ['v' => [$inRules[0]]],
        );
        Assert::assertTrue($validatorChild->passes());

        $validatorGarbage = Validator::make(
            ['v' => '999'],
            ['v' => [$inRules[0]]],
        );
        Assert::assertTrue($validatorGarbage->fails());
    });

    test('il Select e sempre obbligatorio, indipendentemente da rating->rule', function (): void {
        // Istruzione diretta dell'utente 2026-09-16: "il select deve essere obbligatorio".
        // Prima si affidava solo a ->rules((string) $rating->rule->value): nessun caso di
        // RuleEnum contiene letteralmente "required" (verificato leggendo l'enum), quindi
        // un rating con RuleEnum::Null (stringa vuota) o un rule futuro senza "required"
        // avrebbe lasciato il Select scegliibile-o-no senza alcun vincolo. ->required()
        // esplicito lo rende obbligatorio a prescindere dal contenuto di rule.
        $host = new RatingsHostStub;
        $parent = makeRatingWithChildren([makeChildRating(10, 'Ottimo')]);
        $parent->forceFill(['rule' => RuleEnum::Null]);

        $schema = $host->getRatingsFormSchema(null, ratingsCollection($parent));
        /** @var Fieldset $fieldset */
        $fieldset = $schema['ratings.1.pivot.value'];
        /** @var Select $select */
        [$select] = schemaChildren($fieldset);

        Assert::assertTrue($select->isRequired());
    });

    test('il Fieldset restituito riceve la decorazione host via label, una sola volta', function (): void {
        $caller = new class implements RatingsFormCallerContract
        {
            /** @var array<int, class-string> */
            public array $decorated = [];

            public function decorateRatingField(RatingContract $rating, Component $component): Component
            {
                $this->decorated[] = $component::class;

                return $component instanceof Fieldset ? $component->label('Ruolo') : $component;
            }

            public function recalculateRatingFields(Set $set, Get $get, Collection $readonlyRatings): void {}
        };

        $host = new RatingsHostStub;
        $parent = makeRatingWithChildren([makeChildRating(10, 'Ottimo')]);

        $schema = $host->getRatingsFormSchema($caller, ratingsCollection($parent));
        /** @var Fieldset $fieldset */
        $fieldset = $schema['ratings.1.pivot.value'];

        Assert::assertSame('Ruolo', $fieldset->getLabel());
        Assert::assertSame([Fieldset::class], $caller->decorated);
    });

    test('Select e Textarea hanno un validationAttribute leggibile, non il path tecnico', function (): void {
        // Segnalato dall'utente 2026-09-16: senza scelta nel Select, il messaggio di
        // validazione mostrava "Il campo ratings.52.pivot.value è obbligatorio" — corretto
        // nella regola, illeggibile nel testo. hiddenLabel() (necessario per non mostrare
        // un'etichetta visibile duplicata: la legenda sta sul Fieldset, D-1) fa cadere
        // Filament sul fallback tecnico per il nome di validazione. validationAttribute()
        // e' un'API distinta da label() — non rende nulla in UI, serve solo
        // all'interpolazione dei messaggi — quindi impostarla nel trait non viola D-1
        // (che vieta solo ->label() sui componenti).
        $host = new RatingsHostStub;
        $parent = makeRatingWithChildren([makeChildRating(10, 'Ottimo')]);
        $parent->forceFill(['title' => 'Ruolo']);

        $schema = $host->getRatingsFormSchema(null, ratingsCollection($parent));
        /** @var Fieldset $fieldset */
        $fieldset = $schema['ratings.1.pivot.value'];
        /** @var Select $select */
        /** @var Textarea $note */
        [$select, $note] = schemaChildren($fieldset);

        Assert::assertSame('Ruolo', $select->getValidationAttribute());
        Assert::assertNotSame('ratings.1.pivot.value', $select->getValidationAttribute());
        Assert::assertSame('Nota (Ruolo)', $note->getValidationAttribute());
        Assert::assertNotSame('ratings.1.pivot.note', $note->getValidationAttribute());
    });

    test('selectIsOther distingue "altro" ("other") da "nessuna scelta" (null) e da un id figlio', function (): void {
        $method = new \ReflectionMethod(RatingsHostStub::class, 'selectIsOther');
        $method->setAccessible(true);

        Assert::assertTrue($method->invoke(null, 'other'));
        Assert::assertFalse($method->invoke(null, ''));
        Assert::assertFalse($method->invoke(null, null));
        Assert::assertFalse($method->invoke(null, 10));
        Assert::assertFalse($method->invoke(null, '10'));
        Assert::assertFalse($method->invoke(null, 'altro'));
    });
});
