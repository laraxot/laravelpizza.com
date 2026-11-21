<?php

declare(strict_types=1);

namespace Modules\Seo\Interfaces;

use DateTimeInterface;

interface MetatagDataInterface
{
    /**
     * Get the title.
     */
    public function getTitle(): string;

    /**
     * Get the description.
     */
    public function getDescription(): string;

    /**
     * Get the keywords.
     */
    public function getKeywords(): string;

    /**
     * Get the colors.
     *
     * @return array<string, string>
     */
    public function getColors(): array;

    /**
     * Get the robots.
     */
    public function getRobots(): string;

    /**
     * Get the canonical URL.
     */
    public function getCanonical(): ?string;

    /**
     * Get the image URL.
     */
    public function getImage(): ?string;

    /**
     * Get the locale.
     */
    public function getLocale(): string;

    /**
     * Get the type.
     */
    public function getType(): string;

    /**
     * Get the site name.
     */
    public function getSiteName(): string;

    /**
     * Get the URL.
     */
    public function getUrl(): ?string;

    /**
     * Get the author.
     */
    public function getAuthor(): ?string;

    /**
     * Get the published time.
     */
    public function getPublishedTime(): ?DateTimeInterface;

    /**
     * Get the modified time.
     */
    public function getModifiedTime(): ?DateTimeInterface;

    /**
     * Get extra metadata.
     *
     * @param  string  $key  The metadata key
     * @param  array<string, mixed>|string|int|float|bool|null  $default  Default value
     * @return array<string, mixed>|string|int|float|bool|null The metadata value or default
     */
    public function get(string $key, array|string|int|float|bool|null $default = null): array|string|int|float|bool|null;

    /**
     * Check if the metadata has a specific key.
     */
    public function has(string $key): bool;
}
