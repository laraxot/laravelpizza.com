<?php

declare(strict_types=1);

namespace Modules\Seo\Facades;

use DateTimeInterface;
use Illuminate\Support\Facades\Facade;
use Modules\Seo\Data\MetatagData;
use Modules\Seo\Services\MetatagService;

/**
 * @method static MetatagData get()
 * @method static void set(array<string, mixed> $data)
 * @method static void setTitle(string $title)
 * @method static void setDescription(string $description)
 * @method static void setKeywords(string $keywords)
 * @method static void setColors(array<string, string> $colors)
 * @method static void setRobots(string $robots)
 * @method static void setCanonical(string $canonical)
 * @method static void setImage(string $image)
 * @method static void setLocale(string $locale)
 * @method static void setType(string $type)
 * @method static void setSiteName(string $siteName)
 * @method static void setUrl(string $url)
 * @method static void setAuthor(string $author)
 * @method static void setPublishedTime(DateTimeInterface $time)
 * @method static void setModifiedTime(DateTimeInterface $time)
 *
 * @see \Modules\Seo\Services\MetatagService
 */
class Metatag extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return MetatagService::class;
    }
}
