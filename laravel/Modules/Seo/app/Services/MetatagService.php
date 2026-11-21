<?php

declare(strict_types=1);

namespace Modules\Seo\Services;

use DateTimeInterface;
use Modules\Seo\Data\MetatagData;

class MetatagService
{
    /**
     * The metatag data.
     */
    protected MetatagData $metatagData;

    /**
     * Create a new metatag service instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->metatagData = new MetatagData;
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
}
