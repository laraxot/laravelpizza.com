<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\MultipleRecordsFoundException;
use Illuminate\Support\Carbon;
use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\Cms\Models\Page.
 *
 * @property string|null                         $id
 * @property array<array-key, mixed>|null        $title
 * @property string|null                         $slug
 * @property array<array-key, mixed>|null        $middleware
 * @property string|null                         $content
 * @property string|null                         $description
 * @property string|null                         $layout
 * @property array<array-key, mixed>|null        $blocks
 * @property array<array-key, mixed>|null        $content_blocks
 * @property array<array-key, mixed>|null        $sidebar_blocks
 * @property array<array-key, mixed>|null        $footer_blocks
 * @property Carbon|null                         $created_at
 * @property Carbon|null                         $updated_at
 * @property string|null                         $created_by
 * @property string|null                         $updated_by
 * @property ProfileContract|null                $creator
 * @property array<int|string, mixed>            $translatable_columns_from
 * @property array<string, array<string, mixed>> $translations
 * @property ProfileContract|null                $updater
 *
 * @method static Builder<static>|Page                               newModelQuery()
 * @method static Builder<static>|Page                               newQuery()
 * @method static Builder<static>|Page                               query()
 * @method static Builder<static>|Page                               whereBlocks($value)
 * @method static Builder<static>|Page                               whereContent($value)
 * @method static Builder<static>|Page                               whereContentBlocks($value)
 * @method static Builder<static>|Page                               whereCreatedAt($value)
 * @method static Builder<static>|Page                               whereCreatedBy($value)
 * @method static Builder<static>|Page                               whereDescription($value)
 * @method static Builder<static>|Page                               whereFooterBlocks($value)
 * @method static Builder<static>|Page                               whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereJsonContainsLocales(string $column, array<int|string, mixed> $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereLocales(string $column, array<int|string, mixed> $locales)
 * @method static Builder<static>|Page                               whereMiddleware($value)
 * @method static Builder<static>|Page                               whereSidebarBlocks($value)
 * @method static Builder<static>|Page                               whereSlug($value)
 * @method static Builder<static>|Page                               whereTitle($value)
 * @method static Builder<static>|Page                               whereUpdatedAt($value)
 * @method static Builder<static>|Page                               whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class Page extends BaseModelLang
{
    use HasBlocks;
    use SushiToJsons;

    /** @var list<string> */
    public array $translatable = [
        'title',
        // 'description',
        'blocks',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];

    /** @var list<string> */
    protected $fillable = [
        'content',
        'description',
        'layout',
        'slug',
        'title',
        'middleware',
        'blocks',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];

    /** @var array<string, string> */
    protected array $schema = [
        'id' => 'integer',
        'title' => 'json',
        'slug' => 'string',
        'middleware' => 'json',
        'content' => 'string',
        'description' => 'string',
        'layout' => 'string',
        'blocks' => 'json',
        'content_blocks' => 'json',
        'sidebar_blocks' => 'json',
        'footer_blocks' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        $rows = $this->getSushiRows();

        return $rows;
    }

    public static function findUniqueBySlug(string $slug): ?self
    {
        try {
            return self::query()->where('slug', $slug)->sole();
        } catch (MultipleRecordsFoundException $e) {
            throw new \RuntimeException(sprintf("Page slug duplication detected for slug='%s': %d CMS pages found (expected 1). Check database / CMS JSON for duplicate '%s'.", $slug, $e->getCount(), $slug), previous: $e);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * Middleware dichiarati dal JSON della pagina, o `[]` se la pagina non esiste o non ne dichiara.
     *
     * @return list<string>
     *
     * @throws \UnexpectedValueException se il campo e' dichiarato ma non e' una lista di stringhe (DCP-283, C-03)
     */
    public static function getMiddlewareBySlug(string $slug): array
    {
        $page = self::findUniqueBySlug($slug);

        return $page instanceof self ? $page->declaredMiddleware() : [];
    }

    /**
     * Un campo `middleware` illeggibile NON equivale a "nessun middleware": renderebbe pubblica una pagina protetta.
     * Esempi misurati: la stringa `"auth"` al posto della lista il cast `array` la legge come null; `array_filter(is_string)`
     * toglieva le voci non stringa. Solo `null`, assente o `[]` sono una pagina pubblica.
     *
     * @return list<string>
     *
     * @throws \UnexpectedValueException
     */
    public function declaredMiddleware(): array
    {
        $middleware = $this->middleware;

        if ($middleware === null) {
            if (null !== ($this->getAttributes()['middleware'] ?? null)) {
                throw new \UnexpectedValueException(sprintf("Il campo 'middleware' della pagina '%s' e' dichiarato ma non e' una lista JSON.", (string) $this->slug));
            }

            return [];
        }

        if (! array_is_list($middleware)) {
            throw new \UnexpectedValueException(sprintf("Il campo 'middleware' della pagina '%s' non e' una lista.", (string) $this->slug));
        }

        $declared = [];
        foreach ($middleware as $entry) {
            if (! \is_string($entry) || trim($entry) === '') {
                throw new \UnexpectedValueException(sprintf("Il campo 'middleware' della pagina '%s' contiene una voce che non e' una stringa non vuota.", (string) $this->slug));
            }
            $declared[] = $entry;
        }

        return $declared;
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            // 'images' => 'array',
            'date' => 'datetime',
            'published_at' => 'datetime',
            'active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'content_blocks' => 'array',
            'sidebar_blocks' => 'array',
            'footer_blocks' => 'array',
            'middleware' => 'array',
            'layout' => 'string',
        ];
    }
}
