<?php

declare(strict_types=1);

namespace Modules\Seo\Adapters;

use DateTimeInterface;
use Modules\Seo\Datas\MetatagData;
use Modules\Seo\Facades\Metatag;
use Webmozart\Assert\Assert;

/**
 * Metatag facade coordinator.
 *
 * Stateful accumulator for the current request's SEO metadata, exposed through
 * the {@see Metatag} facade. It is intentionally an Adapter
 * (facade coordinator) and not a QueueableAction: it holds mutable, per-request
 * state built up by successive setter calls, whereas Actions expose a single
 * stateless `execute()` entrypoint. See Xot canonical doc
 * "queueable-action-trait-mandatory" — Facade coordinators live in app/Adapters/.
 */
class MetatagManager
{
    /**
     * The metatag data.
     */
    protected MetatagData $metatagData;

    /**
     * Create a new metatag manager instance.
     */
    public function __construct()
    {
        $this->metatagData = new MetatagData();
    }

    /**
     * Get the metatag data.
     */
    public function get(): MetatagData
    {
        return $this->metatagData;
    }

    /**
     * Set the metatag data.
     *
     * @param  array<string, mixed>  $data
     */
    public function set(array $data): void
    {
        $this->metatagData = new MetatagData($data);
    }

    /**
     * Set the title.
     */
    public function setTitle(string $title): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['title' => $title]));
    }

    /**
     * Set the description.
     */
    public function setDescription(string $description): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['description' => $description]));
    }

    /**
     * Set the keywords.
     */
    public function setKeywords(string $keywords): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['keywords' => $keywords]));
    }

    /**
     * Set the colors.
     *
     * @param  array<string, string>  $colors
     */
    public function setColors(array $colors): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['colors' => $colors]));
    }

    /**
     * Set the robots.
     */
    public function setRobots(string $robots): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['robots' => $robots]));
    }

    /**
     * Set the canonical URL.
     */
    public function setCanonical(string $canonical): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['canonical' => $canonical]));
    }

    /**
     * Set the image URL.
     */
    public function setImage(string $image): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['image' => $image]));
    }

    /**
     * Set the locale.
     */
    public function setLocale(string $locale): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['locale' => $locale]));
    }

    /**
     * Set the type.
     */
    public function setType(string $type): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['type' => $type]));
    }

    /**
     * Set the site name.
     */
    public function setSiteName(string $siteName): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['site_name' => $siteName]));
    }

    /**
     * Set the URL.
     */
    public function setUrl(string $url): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['url' => $url]));
    }

    /**
     * Set the author.
     */
    public function setAuthor(string $author): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['author' => $author]));
    }

    /**
     * Set the published time.
     */
    public function setPublishedTime(DateTimeInterface $time): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['published_time' => $time]));
    }

    /**
     * Set the modified time.
     */
    public function setModifiedTime(DateTimeInterface $time): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['modified_time' => $time]));
    }

    /**
     * Set a meta field.
     */
    public function setMeta(string $key, mixed $value): void
    {
        $this->set(array_merge($this->metatagData->toArray(), [$key => $value]));
    }

    /**
     * Get a meta field.
     */
    public function getMeta(string $key): mixed
    {
        $data = $this->metatagData->toArray();

        return $data[$key] ?? null;
    }

    /**
     * Get the title.
     */
    public function getTitle(): string
    {
        $title = $this->metatagData->toArray()['title'] ?? '';
        Assert::string($title);

        return $title;
    }

    /**
     * Set Open Graph title.
     */
    public function setOgTitle(string $title): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['og_title' => $title]));
    }

    /**
     * Set Open Graph description.
     */
    public function setOgDescription(string $description): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['og_description' => $description]));
    }

    /**
     * Set Open Graph image.
     */
    public function setOgImage(string $image): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['og_image' => $image]));
    }

    /**
     * Set Open Graph type.
     */
    public function setOgType(string $type): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['og_type' => $type]));
    }

    /**
     * Set Twitter card type.
     */
    public function setTwitterCard(string $card): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['twitter_card' => $card]));
    }

    /**
     * Set Twitter title.
     */
    public function setTwitterTitle(string $title): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['twitter_title' => $title]));
    }

    /**
     * Set Twitter description.
     */
    public function setTwitterDescription(string $description): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['twitter_description' => $description]));
    }

    /**
     * Set Twitter image.
     */
    public function setTwitterImage(string $image): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['twitter_image' => $image]));
    }

    /**
     * Set section.
     */
    public function setSection(string $section): void
    {
        $this->set(array_merge($this->metatagData->toArray(), ['section' => $section]));
    }
}
