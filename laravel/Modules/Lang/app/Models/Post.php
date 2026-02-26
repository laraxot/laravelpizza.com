<?php

declare(strict_types=1);

namespace Modules\Lang\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Lang\Database\Factories\PostFactory;
// --- traits ---
use Modules\Xot\Contracts\ProfileContract;
// use Laravel\Scout\Searchable;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Traits\Updater;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Modules\Lang\Models\Post.
 *
 * @property string                       $id
 * @property int|null                     $user_id
 * @property string|null                  $post_type
 * @property int|null                     $post_id
 * @property string|null                  $lang
 * @property string|null                  $title
 * @property string|null                  $subtitle
 * @property string|null                  $guid
 * @property string|null                  $txt
 * @property string|null                  $image_src
 * @property string|null                  $image_alt
 * @property string|null                  $image_title
 * @property string|null                  $meta_description
 * @property string|null                  $meta_keywords
 * @property int|null                     $author_id
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property int|null                     $category_id
 * @property string|null                  $image
 * @property string|null                  $content
 * @property int|null                     $published
 * @property string|null                  $created_by
 * @property string|null                  $updated_by
 * @property string|null                  $url
 * @property array<array-key, mixed>|null $url_lang
 * @property array<array-key, mixed>|null $image_resize_src
 * @property string|null                  $linked_count
 * @property string|null                  $related_count
 * @property string|null                  $relatedrev_count
 * @property string|null                  $linkable_type
 * @property int|null                     $views_count
 * @property ProfileContract|null         $creator
 * @property Model|\Eloquent|null         $linkable
 * @property ProfileContract|null         $updater
 * @method static Builder<static>|Post newModelQuery()
 * @method static Builder<static>|Post newQuery()
 * @method static Builder<static>|Post query()
 * @method static Builder<static>|Post whereAuthorId($value)
 * @method static Builder<static>|Post whereCategoryId($value)
 * @method static Builder<static>|Post whereContent($value)
 * @method static Builder<static>|Post whereCreatedAt($value)
 * @method static Builder<static>|Post whereCreatedBy($value)
 * @method static Builder<static>|Post whereGuid($value)
 * @method static Builder<static>|Post whereId($value)
 * @method static Builder<static>|Post whereImage($value)
 * @method static Builder<static>|Post whereImageAlt($value)
 * @method static Builder<static>|Post whereImageResizeSrc($value)
 * @method static Builder<static>|Post whereImageSrc($value)
 * @method static Builder<static>|Post whereImageTitle($value)
 * @method static Builder<static>|Post whereLang($value)
 * @method static Builder<static>|Post whereLinkableType($value)
 * @method static Builder<static>|Post whereLinkedCount($value)
 * @method static Builder<static>|Post whereMetaDescription($value)
 * @method static Builder<static>|Post whereMetaKeywords($value)
 * @method static Builder<static>|Post wherePostId($value)
 * @method static Builder<static>|Post wherePostType($value)
 * @method static Builder<static>|Post wherePublished($value)
 * @method static Builder<static>|Post whereRelatedCount($value)
 * @method static Builder<static>|Post whereRelatedrevCount($value)
 * @method static Builder<static>|Post whereSubtitle($value)
 * @method static Builder<static>|Post whereTitle($value)
 * @method static Builder<static>|Post whereTxt($value)
 * @method static Builder<static>|Post whereUpdatedAt($value)
 * @method static Builder<static>|Post whereUpdatedBy($value)
 * @method static Builder<static>|Post whereUrl($value)
 * @method static Builder<static>|Post whereUrlLang($value)
 * @method static Builder<static>|Post whereUserId($value)
 * @method static Builder<static>|Post whereViewsCount($value)
 * @property ProfileContract|null $deleter
 * @method static PostFactory factory($count = null, $state = [])
 * @property string|null $excerpt
 * @property string|null $slug
 * @property string|null $status
 * @property Carbon|null $published_at
 * @property string|null $locale
 * @property string|null $category
 * @property string|null $meta_title
 * @method static Builder<static>|Post whereCategory($value)
 * @method static Builder<static>|Post whereExcerpt($value)
 * @method static Builder<static>|Post whereLocale($value)
 * @method static Builder<static>|Post whereMetaTitle($value)
 * @method static Builder<static>|Post wherePublishedAt($value)
 * @method static Builder<static>|Post whereSlug($value)
 * @method static Builder<static>|Post whereStatus($value)
 * @mixin Eloquent
 */
class Post extends BaseModel
{
    use HasSlug;
    use HasXotFactory;

    // use Cachable;
    use Updater;

    /*
     * public function getUrlAttribute($value) {
     *
     * }
     */

    final public const SEARCHABLE_FIELDS = ['title', 'guid', 'txt'];

    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @see  https://laravel-news.com/6-eloquent-secrets
     *
     * @var bool
     */
    public static $snakeAttributes = true;

    /** @var bool */
    public $incrementing = true;

    /** @var int */
    protected $perPage = 30;

    // use Searchable;
    /** @var string */
    protected $connection = 'lang';

    /** @var list<string> */
    protected $fillable = [
        'id',
        'user_id',
        'post_id',
        'lang',
        'guid',
        'title',
        'subtitle',
        'post_type',
        'txt',
        // ------ IMAGE ---------
        'image_src',
        'image_alt',
        'image_title',
        // ------ SEO FIELDS -----
        'meta_description',
        'meta_keywords', // seo
        'author_id',
        // ------ BUFFER ----
        'url',
        'url_lang', // buffer
        'image_resize_src', // buffer
    ];

    /** @var list<string> */
    protected $appends = [];

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string */
    protected $keyType = 'string';

    /*
     * public function getRouteKeyName() {
     * return inAdmin() ? 'guid' : 'post_id';
     * }
     */

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('guid');
    }

    // -------- relationship ------
    public function linkable(): MorphTo
    {
        return $this->morphTo('post');
    }

    /* deprecated
     * public function archive() {
     * $lang = $this->lang;
     * $post_type = $this->post_type;
     * $obj = $this->getLinkedModel();
     * $table = $obj->getTable();
     * $post_table = with(new Post())->getTable();
     * $rows = $obj->join($post_table, $post_table.'.post_id', $table.'.post_id')
     * ->where('lang', $lang)
     * ->where($post_table.'.post_type', $post_type)
     * ->where($post_table.'.guid', '!=', $post_type)
     * ->orderBy($table.'.updated_at', 'desc')
     * ->with('post')
     * ;
     *
     * return $rows;
     * }
     */

    // end function
    // -------------- MUTATORS ------------------

    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = $value;
        $this->attributes['guid'] = Str::slug($value);
    }

    /**
     * Undocumented function.
     */
    public function getTitleAttribute(?string $value): ?string
    {
        if (null !== $value) {
            return $value;
        }

        if (! empty($this->attributes['post_type'])) {
            // Assicuriamoci che i valori siano stringhe prima della concatenazione
            $postType = isset($this->attributes['post_type']) && is_string($this->attributes['post_type'])
                ? $this->attributes['post_type']
                : '';
            $postId = isset($this->attributes['post_id']) && is_scalar($this->attributes['post_id'])
                ? ((string) $this->attributes['post_id'])
                : '';
            $value = $postType.' '.$postId;
        } else {
            // Assicuriamoci che post_type e post_id siano stringhe
            $postType = is_string($this->post_type) ? $this->post_type : '';
            $postId = is_scalar($this->post_id) ? ((string) $this->post_id) : '';
            $value = $postType.' '.$postId;
        }

        $this->title = $value;

        if (null !== $this->getKey()) {
            $this->update([
                'title' => $value,
            ]);
        }

        return $value;
    }

    /**
     * ---.
     */
    public function getGuidAttribute(?string $value): ?string
    {
        if (\is_string($value) && '' !== $value && ! str_contains($value, ' ')) {
            return $value;
        }
        $value = $this->title;
        if ('' === $value) {
            // Assicuriamoci che i valori siano stringhe prima della concatenazione
            $postType = isset($this->attributes['post_type']) && is_string($this->attributes['post_type'])
                ? $this->attributes['post_type']
                : '';
            $postId = isset($this->attributes['post_id']) && is_scalar($this->attributes['post_id'])
                ? ((string) $this->attributes['post_id'])
                : '';
            $value = $postType.' '.$postId;
        }
        if (null === $value) {
            $value = 'u-'.random_int(1, 1000);
        }
        $value = Str::slug($value);
        $this->guid = $value;

        if (null !== $this->getKey()) {
            $this->update([
                'guid' => $value,
            ]);
        }

        return $value;
    }

    public function getTxtAttribute(?string $value): ?string
    {
        return $value ?? '';
    }

    public function toSearchableArray(): array
    {
        return $this->only(self::SEARCHABLE_FIELDS);
    }

    /**
     * @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'image_resize_src' => 'array',
            'url_lang' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }
}

// end class
