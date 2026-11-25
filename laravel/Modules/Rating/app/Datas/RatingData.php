<?php

declare(strict_types=1);

namespace Modules\Rating\Datas;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Modules\Rating\Enums\SupportedLocale;
use Modules\Rating\Filament\Concerns\DecoratesRatingFormFields;
use Modules\Rating\Models\BaseRating;
use Modules\Rating\Models\Contracts\RatingContract;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

/**
 * DTO per un rating.
 *
 * ATTENZIONE — questa classe porta **due concetti** con lo stesso nome. Le proprietà del
 * costruttore descrivono un blocco di UI (titolo, descrizione, locale, immagine) e sono
 * usate da `RatingBlockTest`; i metodi statici descrivono invece l'**entità** `ratings`
 * (path form/export, label, colonne della tabella). Non è un accostamento voluto: è il
 * nome `RatingData` che era già occupato quando è servito il secondo concetto.
 * La separazione corretta — `RatingBlockData` per il blocco, `RatingData` per l'entità,
 * come `SchedaData` sta a `schede` — è tracciata come lavoro a sé.
 *
 * `getXlsFields($where, $ratingClass)` = catalogo export **solo rating**.
 * `$ratingClass` e' **obbligatorio**: nessun backtrace-resolve. IR Rating usa
 * connection `indennita_responsabilita` (subclass), non risolvibile in modo
 * affidabile da `debug_backtrace` nella call chain reale — l'export Filament
 * asincrono (`XotBaseExporter::resolveColumns()`) ricostruisce lo stack dopo
 * la deserializzazione del job, senza il frame originale del Resource.
 * Canon: `docs/bmad/stories/5.234-ratingdata-ratingclass-required-revert-backtrace.story.md`.
 *
 * @see Modules/Rating/docs/wiki/rules/rating-contract-over-baserating.md
 */
class RatingData extends Data
{
    public function __construct(
        public readonly string $title = '',
        public readonly string $description = '',
        public readonly bool $disabled = false,
        public readonly int $position = 0,
        public readonly SupportedLocale $locale = SupportedLocale::IT,
        public readonly ?string $image_url = null,
        public readonly ?int $parent_id = null,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        $title = $data['title'] ?? '';
        $description = $data['description'] ?? '';
        $locale = $data['locale'] ?? 'it';
        $imageUrl = $data['image_url'] ?? null;

        return new self(
            title: is_scalar($title) ? (string) $title : '',
            description: is_scalar($description) ? (string) $description : '',
            disabled: (bool) ($data['disabled'] ?? false),
            position: is_numeric($data['position'] ?? null) ? (int) $data['position'] : 0,
            locale: SupportedLocale::fromString(is_string($locale) ? $locale : 'it'),
            image_url: is_string($imageUrl) ? $imageUrl : null,
            parent_id: is_numeric($data['parent_id'] ?? null) ? (int) $data['parent_id'] : null,
        );
    }

    /**
     * Percorso `data_get` del campo pivot di un rating sull'host
     * (es. `ratings_by_id.52.pivot.value`).
     *
     * @see Modules/Rating/docs/wiki/rules/rating-contract-over-baserating.md
     */
    public static function ratingValuePath(RatingContract $rating, string $field = 'value'): string
    {
        return 'ratings_by_id.'.$rating->id.'.pivot.'.$field;
    }

    /**
     * Percorso `data_get` del valore leggibile in export XLS/XLSX
     * (`xls_export_value`: txt del figlio se Select, altrimenti pivot.value).
     *
     * @see BaseRating::getXlsExportValueAttribute()
     */
    public static function ratingXlsValuePath(RatingContract $rating): string
    {
        return 'ratings_by_id.'.$rating->id.'.xls_export_value';
    }

    /**
     * Il nome del campo di form che corrisponde a una riga di `ratings`.
     *
     * Convenzione unica, condivisa fra chi costruisce lo schema, chi legge lo stato e chi
     * salva le pivot: se cambia, cambia in un posto solo. `$pivotColumn` resta `'value'`
     * per compatibilita: ogni chiamata esistente continua a puntare li; `'note'` e' la
     * sola altra colonna pivot generata oggi (vedi `buildRatingComponent()` nel trait).
     *
     * @see Modules/Rating/docs/wiki/rules/rating-contract-over-baserating.md
     */
    public static function ratingFieldName(RatingContract $rating, string $pivotColumn = 'value'): string
    {
        return 'ratings.'.$rating->id.'.pivot.'.$pivotColumn;
    }

    /**
     * Testo etichetta form per un criterio: `txt` se presente, altrimenti `title`.
     *
     * Diverso da {@see BaseRating::getLabel()} (albero / solo `title`). Il metodo
     * non chiama `->label()` Filament: restituisce solo la stringa, l'host (o
     * {@see DecoratesRatingFormFields}) la applica.
     *
     * Sede: funzione pura di `$rating`, nessuna dipendenza dall'host — per questo
     * qui e non in `HasRatingsTrait` (trait per gli host, non per l'entità rating).
     * Canon: `docs/bmad/architecture/rating-entity-helpers-home-in-ratingdata.md`.
     *
     * @see Modules/Rating/docs/wiki/rules/rating-contract-over-baserating.md
     */
    public static function formFieldLabel(RatingContract $rating): string
    {
        // `txt` vuoto (non null) su alcuni criteri: `??` non ripiegava sul titolo e
        // l'intestazione XLS diventava "Rating {id}".
        $txt = strip_tags((string) ($rating->txt ?? ''));

        return $txt !== '' ? $txt : strip_tags((string) ($rating->title ?? ''));
    }

    /**
     * Catalogo colonne XLS/XLSX **solo rating** (path => label).
     *
     * `$ratingClass` obbligatorio: ogni modulo host ha la sua subclass
     * (connection propria) e la firma non deve mentire con un default che
     * esplode a runtime dai call site statici reali (Resource Filament).
     *
     * @param  array<string, mixed>  $where
     * @param  class-string<BaseRating>  $ratingClass
     * @return array<string, string>
     */
    public static function getXlsFields(array $where, string $ratingClass): array
    {
        Assert::implementsInterface($ratingClass, RatingContract::class);

        /** @var EloquentCollection<int, BaseRating> $ratings */
        $ratings = $ratingClass::withExtraAttributes($where)->ordered()->get();
        $ratings = $ratings
            ->reject(static fn (RatingContract $rating): bool => $rating->parent_id !== null)
            ->values();
        $ratings->loadMissing('children');

        return self::criteriaToXlsFields($ratings);
    }

    /**
     * @param  iterable<int, RatingContract>  $ratings
     * @return array<string, string>
     *
     * @see Modules/Rating/docs/wiki/rules/rating-contract-over-baserating.md
     */
    public static function criteriaToXlsFields(iterable $ratings): array
    {
        if ($ratings instanceof EloquentCollection) {
            $ratings->loadMissing('children');
        }

        $fields = [];

        foreach ($ratings as $rating) {
            if ($rating->parent_id !== null) {
                continue;
            }

            $label = self::formFieldLabel($rating);
            if ($label === '') {
                $label = 'Rating '.$rating->id;
            }

            $fields[self::ratingXlsValuePath($rating)] = $label;

            $children = $rating->relationLoaded('children')
                ? $rating->children
                : Collection::make();

            if ($children->isNotEmpty()) {
                $fields[self::ratingValuePath($rating, 'note')] = (string) __(
                    'rating::fields.note_for',
                    ['label' => $label],
                );
            }
        }

        return $fields;
    }

    /**
     * Le colonne di `ratings`, dichiarate una volta sola.
     *
     * `$migration` a `null` significa «tabella nuova, aggiungile tutte»; passandolo,
     * si aggiungono solo quelle che mancano. Una lista, due usi: la stessa colonna
     * dichiarata in due posti prima o poi non concorda (era successo: `txt` era
     * `text()` in creazione e `string()` nel guard di update).
     */
    public static function updateColumns(Blueprint $table, ?XotBaseMigration $migration = null): void
    {
        $missing = static fn (string $column): bool => ! $migration instanceof XotBaseMigration
            || ! $migration->hasColumn($column);

        if ($missing('title')) {
            $table->string('title')->nullable();
        }
        if ($missing('slug')) {
            $table->string('slug')->nullable()->index();
        }
        if ($missing('color')) {
            $table->string('color')->nullable();
        }
        if ($missing('icon')) {
            $table->string('icon')->nullable();
        }
        if ($missing('rule')) {
            $table->string('rule')->nullable();
        }
        if ($missing('txt')) {
            $table->text('txt')->nullable();
        }
        if ($missing('extra_attributes')) {
            $table->schemalessAttributes('extra_attributes');
        }
        if ($missing('is_disabled')) {
            $table->boolean('is_disabled')->nullable();
        }
        if ($missing('is_readonly')) {
            $table->boolean('is_readonly')->nullable();
        }
        if ($missing('order_column')) {
            $table->unsignedInteger('order_column')->nullable()->index();
        }
        if ($missing('parent_id')) {
            $table->unsignedBigInteger('parent_id')->nullable();
        }
    }
}
