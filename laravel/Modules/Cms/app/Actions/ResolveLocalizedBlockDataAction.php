<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use function Safe\preg_match;

final class ResolveLocalizedBlockDataAction
{
    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public function execute(array $data): array
    {
        /** @var array<string, mixed> $resolved */
        $resolved = $this->walk($data);

        return $resolved;
    }

    private function walk(mixed $value): mixed
    {
        if (! is_array($value)) {
            return $value;
        }

        $resolved = [];

        foreach ($value as $key => $item) {
            $keyStr = (string) $key;
            if ($this->isPublicUrlKey($keyStr) && is_string($item)) {
                $resolved[$key] = $this->localizeUrl($item);

                continue;
            }

            $resolved[$key] = $this->walk($item);
        }

        return $resolved;
    }

    private function isPublicUrlKey(string $key): bool
    {
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
        if ('' === $url || ! str_starts_with($url, '/')) {
            return $url;
        }

        if (
            str_starts_with($url, '//')
            || str_starts_with($url, '/#')
            || 1 === preg_match('#^/(it|en|es|fr|de|pt|zh|ja|ar|hi|ru|id)(/|$)#', $url)
        ) {
            return $url;
        }

        $locale = LaravelLocalization::getCurrentLocale();

        /** @var string|null $localizedUrl */
        $localizedUrl = LaravelLocalization::getLocalizedURL($locale, $url);

        return $localizedUrl ?? $url;
    }
}
