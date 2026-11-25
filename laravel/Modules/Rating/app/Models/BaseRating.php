<?php

declare(strict_types=1);

namespace Modules\Rating\Models;

use Cknow\Money\Money;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Rating\Database\Factories\RatingFactory;
use Modules\Rating\Enums\RuleEnum;
use Modules\Rating\Models\Contracts\RatingContract;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Modules\Rating\Models\BaseRating.
 *
 * Classe base astratta per tutti i modelli Rating nei vari moduli.
 * Fornisce casts, fillable, scope e media conversions condivisi (DRY).
 * Utilizza HasRecursiveRelationships per l'albero genitore-figlio (adjacency list):
 * children(), parent(), ancestors(), descendants() arrivano dal trait e non si riscrivono.
 *
 * @see https://github.com/spatie/laravel-schemaless-attributes
 * @see /Modules/Rating/docs/schemaless-attributes-errors.md
 *
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $extra_attributes
 * @property RuleEnum $rule
 *
 * @method static Builder|BaseRating newModelQuery()
 * @method static Builder|BaseRating newQuery()
 * @method static Builder|BaseRating query()
 * @method static Builder|BaseRating withExtraAttributes(array<string, mixed>|string $attributes = [], mixed $value = null)
 *
 * @property int $id
 * @property int $user_id
 * @property float $value
 * @property string|null $related_type
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $post_id
 * @property string|null $title
 * @property string|null $color
 * @property string|null $icon
 * @property string|null $txt
 * @property bool|null $is_disabled
 * @property bool|null $is_readonly
 * @property int|null $order_column
 * @property int|null $parent_id
 * @property Model|Eloquent $linkedTo
 * @property BaseRatingMorph $pivot
 * @property mixed $xls_export_value
 *
 * @method static Builder|BaseRating whereColor($value)
 * @method static Builder|BaseRating whereCreatedAt($value)
 * @method static Builder|BaseRating whereCreatedBy($value)
 * @method static Builder|BaseRating whereDeletedBy($value)
 * @method static Builder|BaseRating whereIcon($value)
 * @method static Builder|BaseRating whereId($value)
 * @method static Builder|BaseRating whereIsDisabled($value)
 * @method static Builder|BaseRating whereIsReadonly($value)
 * @method static Builder|BaseRating whereOrderColumn($value)
 * @method static Builder|BaseRating wherePostId($value)
 * @method static Builder|BaseRating whereRelatedType($value)
 * @method static Builder|BaseRating whereRule($value)
 * @method static Builder|BaseRating whereTitle($value)
 * @method static Builder|BaseRating whereTxt($value)
 * @method static Builder|BaseRating whereUpdatedAt($value)
 * @method static Builder|BaseRating whereUpdatedBy($value)
 *
 * @property MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property int|null $media_count
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @mixin Eloquent
 *
 * @method static RatingFactory factory($count = null, $state = [])
 *
 * @see Modules/Rating/docs/wiki/rules/rating-contract-over-baserating.md
 */
abstract class BaseRating extends BaseModel implements HasMedia, RatingContract, Sortable
{
    // The vendor trait is the single source of truth for adjacency-list behavior.
    use HasRecursiveRelationships;
    use HasSlug;
    use InteractsWithMedia;
    use SortableTrait;

    /**
     * Etichetta del nodo nell'albero.
     *
     * Richiesta da {@see HasRecursiveRelationshipsContract} e usata da
     * `GetTreeOptionsByModelClassAction` per costruire le opzioni indentate del `Select`
     * su `parent_id`. Per un criterio l'etichetta e' il titolo.
     *
     * @see Modules/Rating/docs/wiki/rules/rating-contract-over-baserating.md
     */
    public function getLabel(): string
    {
        $title = $this->getAttribute('title');

        if (is_string($title) && $title !== '') {
            return $title;
        }

        $key = $this->getKey();

        return '#'.(is_scalar($key) ? (string) $key : '');
    }

    /** @var list<string> */
    protected $fillable = [
        'id',
        'extra_attributes',
        'parent_id',
        'title',
        'color',
        'txt',
        'rule',
        'is_disabled',
        'is_readonly',
        'order_column',
        'slug',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Scope to query by extra attributes.
     *
     * @see https://github.com/spatie/laravel-schemaless-attributes
     * @see /Modules/Rating/docs/schemaless-attributes-errors.md
     *
     * @param  Builder<BaseRating>  $query
     * @param  array<string, mixed>|string  $attributes
     * @return Builder<BaseRating>
     */
    public function scopeWithExtraAttributes(Builder $query, array|string $attributes = [], mixed $value = null): Builder
    {
        if (is_string($attributes) && $value !== null) {
            // Single attribute with value: withExtraAttributes('anno', 2024)
            return $query->where("extra_attributes->{$attributes}", $value);
        }

        if (is_array($attributes)) {
            // Multiple attributes: withExtraAttributes(['anno' => 2024, 'type' => 'foo'])
            foreach ($attributes as $key => $val) {
                $query = $query->where("extra_attributes->{$key}", $val);
            }
        }

        return $query;
    }

    /**
     * @return MorphTo<Model, $this>
     *
     * @see Modules/Rating/docs/wiki/rules/rating-contract-over-baserating.md
     */
    public function linkedTo(): MorphTo
    {
        return $this->morphTo('model');
    }

    /**
     * Register the conversions that should be performed.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('300x300')
            ->width(300)
            ->height(300);
        $this->addMediaConversion('150x150')
            ->width(151)
            ->height(151);
        $this->addMediaConversion('50x50')
            ->width(150)
            ->height(150);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @see https://github.com/spatie/laravel-schemaless-attributes
     * @see /Modules/Rating/docs/schemaless-attributes-errors.md
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'extra_attributes' => SchemalessAttributes::class,
            'rule' => RuleEnum::class,
            'is_disabled' => 'boolean',
            'is_readonly' => 'boolean',
        ];
    }

    /**
     * Criterio RichEditor (`txt`) o titolo plain per PDF Html2Pdf.
     * RichEditor → HTML crudo (mai `{{ }}` in Blade); title → escapato.
     * Decodifica una volta se il DB ha entità HTML doppie (`&lt;p&gt;`).
     *
     * @see Modules/Rating/docs/wiki/rules/rating-contract-over-baserating.md
     */
    public function getTxtHtml(): string
    {
        $raw = $this->txt;
        if (! is_string($raw) || $raw === '') {
            return e((string) ($this->title ?? ''));
        }

        if (str_contains($raw, '&lt;') && ! str_contains($raw, '<')) {
            $raw = html_entity_decode($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        return $raw;
    }

    /**
     * Figlio selezionato quando `pivot.value` è l'id di un'opzione `children`.
     * Preferisce la relazione già caricata (export / test); altrimenti `find`.
     *
     * @see Modules/Rating/docs/wiki/rules/rating-contract-over-baserating.md
     */
    public function resolveSelectedChild(): ?self
    {
        if (! $this->hasChildRatings()) {
            return null;
        }

        $value = $this->pivot->value ?? null;
        if ($value === null || $value === '') {
            return null;
        }

        if ($this->relationLoaded('children')) {
            $child = $this->children->firstWhere('id', (int) $value);

            return $child instanceof self ? $child : null;
        }

        $class = Rating::getClassName();
        $found = $class::query()->find($value);

        return $found instanceof self ? $found : null;
    }

    /**
     * Valore per `data_get(..., 'ratings_by_id.{id}.xls_export_value')` in export XLS/XLSX.
     * Padre con figli → txt/title del figlio; foglia → pivot.value numerico.
     *
     * @see Modules/Rating/docs/wiki/rules/rating-contract-over-baserating.md
     */
    public function getXlsExportValueAttribute(): mixed
    {
        return $this->getXlsExportValue();
    }

    public function getXlsExportValue(): mixed
    {
        if ($this->hasChildRatings()) {
            $child = $this->resolveSelectedChild();
            if (! $child instanceof self) {
                return '';
            }

            $text = $child->txt ?? $child->title;

            return \is_string($text) && $text !== '' ? strip_tags($text) : '';
        }

        return $this->pivot->value ?? null;
    }

    /**
     * HTML o Money per il valore pivot (usato in PDF scheda IR).
     *
     * @see Modules/Rating/docs/wiki/rules/rating-contract-over-baserating.md
     */
    public function getValueHtml(): string|Money
    {
        if (Str::contains((string) ($this->txt ?? $this->title ?? ''), 'Importo')) {
            return money((int) round((float) $this->pivot->value * 100), 'EUR');
        }

        $child = $this->resolveSelectedChild();
        if ($child instanceof self) {
            return $child->getTxtHtml();
        }

        return strval($this->pivot->value);
    }

    /**
     * Nota pivot per PDF scheda quando il rating ha figli (criterio a scelta).
     *
     * @see Modules/Rating/docs/wiki/rules/rating-contract-over-baserating.md
     */
    public function getNoteHtml(): ?string
    {
        if (Str::contains((string) ($this->txt ?? $this->title ?? ''), 'Importo')) {
            return null;
        }

        if ($this->hasChildRatings()) {
            return $this->pivot->note;
        }

        return null;
    }

    /**
     * Preferisce la relazione già caricata (test / eager load) per evitare query.
     */
    private function hasChildRatings(): bool
    {
        if ($this->relationLoaded('children')) {
            return $this->children->isNotEmpty();
        }

        return $this->children()->exists();
    }
}
