<?php

declare(strict_types=1);

namespace Modules\Seo\Adapters;

use DateTimeInterface;
use Modules\Seo\Actions\Metatag\GetMetatagDataAction;
use Modules\Seo\Actions\Metatag\MergeMetatagDataAction;
use Modules\Seo\Actions\Metatag\ReplaceMetatagDataAction;
use Modules\Seo\Contracts\MetatagDataContract;

/**
 * Facade adapter: delega ogni setter a QueueableAction, mantiene la stessa API dell'ex MetatagService (rimosso).
 */
final class MetatagFacadeAdapter
{
    public function get(): MetatagDataContract
    {
        return app(GetMetatagDataAction::class)->execute();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function set(array $data): void
    {
        app(ReplaceMetatagDataAction::class)->execute($data);
    }

    public function setTitle(string $title): void
    {
        app(MergeMetatagDataAction::class)->execute(['title' => $title]);
    }

    public function setDescription(string $description): void
    {
        app(MergeMetatagDataAction::class)->execute(['description' => $description]);
    }

    public function setKeywords(string $keywords): void
    {
        app(MergeMetatagDataAction::class)->execute(['keywords' => $keywords]);
    }

    /**
     * @param  array<string, string>  $colors
     */
    public function setColors(array $colors): void
    {
        app(MergeMetatagDataAction::class)->execute(['colors' => $colors]);
    }

    public function setRobots(string $robots): void
    {
        app(MergeMetatagDataAction::class)->execute(['robots' => $robots]);
    }

    public function setCanonical(string $canonical): void
    {
        app(MergeMetatagDataAction::class)->execute(['canonical' => $canonical]);
    }

    public function setImage(string $image): void
    {
        app(MergeMetatagDataAction::class)->execute(['image' => $image]);
    }

    public function setLocale(string $locale): void
    {
        app(MergeMetatagDataAction::class)->execute(['locale' => $locale]);
    }

    public function setType(string $type): void
    {
        app(MergeMetatagDataAction::class)->execute(['type' => $type]);
    }

    public function setSiteName(string $siteName): void
    {
        app(MergeMetatagDataAction::class)->execute(['site_name' => $siteName]);
    }

    public function setUrl(string $url): void
    {
        app(MergeMetatagDataAction::class)->execute(['url' => $url]);
    }

    public function setAuthor(string $author): void
    {
        app(MergeMetatagDataAction::class)->execute(['author' => $author]);
    }

    public function setPublishedTime(DateTimeInterface $time): void
    {
        app(MergeMetatagDataAction::class)->execute(['published_time' => $time]);
    }

    public function setModifiedTime(DateTimeInterface $time): void
    {
        app(MergeMetatagDataAction::class)->execute(['modified_time' => $time]);
    }
}
