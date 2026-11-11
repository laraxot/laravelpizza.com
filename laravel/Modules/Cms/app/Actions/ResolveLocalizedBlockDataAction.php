<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Mcamara\LaravelLocalization\LaravelLocalization as LaravelLocalizationManager;
use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_match;

final class ResolveLocalizedBlockDataAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function execute(array $data): array
    {
        /** @var array<string, mixed> $res */
        $res = $this->walkArray($data);

        return $res;
    }

    /**
     * @template TKey of array-key
     *
     * @param  array<TKey, mixed>  $value
     * @return array<TKey, mixed>
     */
    private function walkArray(array $value): array
    {
        /** @var array<TKey, mixed> $resolved */
        $resolved = [];

        foreach ($value as $key => $item) {
            $keyStr = (string) $key;
            if ($this->isPublicUrlKey($keyStr) && is_string($item)) {
                $resolved[$key] = $this->localizeUrl($item);

                continue;
            }

            if (is_array($item)) {
                /* @var array<array-key, mixed> $item */
                $resolved[$key] = $this->walkArray($item);

                continue;
            }

            $resolved[$key] = $item;
        }

        return $resolved;
    }

    private function isPublicUrlKey(string $key): bool
    {
        /** @var list<string> $urlKeys */
        static $urlKeys = [
            'url',
            'link',
            'href',
            'action_url',
            'callback_url',
            'redirect_url',
            'base_url',
            'path',
        ];

        return in_array($key, $urlKeys, true);
    }

    private function localizeUrl(string $url): string
    {
        if ($url === '' || ! str_starts_with($url, '/')) {
            return $url;
        }

        if (
            str_starts_with($url, '//')
            || str_starts_with($url, '/#')
            || preg_match('#^/(it|en|es|fr|de|pt|zh|ja|ar|hi|ru|id)(/|$)#', $url) === 1
        ) {
            return $url;
        }

        $localization = app(LaravelLocalizationManager::class);
        $locale = $localization->getCurrentLocale();

        /** @var string|null $localizedUrl */
        $localizedUrl = $localization->getLocalizedURL($locale, $url);

        return $localizedUrl ?? $url;
    }
}
