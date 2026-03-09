<?php

declare(strict_types=1);

namespace Modules\Cms\Support;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;
use Modules\Xot\Datas\MetatagData;

final class PageSchemaBuilder
{
    /**
     * @param  array<string, mixed>  $routeParameters
     * @return array<string, mixed>
     */
    public function build(
        MetatagData $meta,
        ?string $routeName,
        string $path,
        array $routeParameters = [],
        ?Authenticatable $user = null
    ): array {
        $pageType = $this->resolvePageType($routeName, $path, $routeParameters);

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => $pageType,
            'name' => $meta->getTitle(),
            'description' => $meta->getDescription(limit: 160),
            'url' => $meta->getCanonical(),
            'inLanguage' => app()->getLocale(),
        ];

        if ($pageType === 'ProfilePage' && $user !== null) {
            $fullName = trim((string) ($user->name ?? ''));
            if ($fullName === '') {
                $first = trim((string) ($user->first_name ?? ''));
                $last = trim((string) ($user->last_name ?? ''));
                $fullName = trim($first.' '.$last);
            }
            if ($fullName === '') {
                $fullName = 'Profile';
            }

            $schema['mainEntity'] = [
                '@type' => 'Person',
                'name' => $fullName,
            ];
        }

        if (
            $pageType === 'ItemPage'
            && ($routeName === 'container0.view' || Str::contains($path, '/events/'))
            && isset($routeParameters['slug0'])
            && is_string($routeParameters['slug0'])
            && $routeParameters['slug0'] !== ''
        ) {
            $schema['mainEntity'] = [
                '@type' => 'Event',
                'url' => url('/events/'.$routeParameters['slug0']),
            ];
        }

        return $schema;
    }

    /**
     * @param  array<string, mixed>  $routeParameters
     */
    private function resolvePageType(?string $routeName, string $path, array $routeParameters): string
    {
        if ($routeName !== null && Str::startsWith($routeName, 'profile.')) {
            return 'ProfilePage';
        }

        if (
            $routeName === 'container0.index'
            && (($routeParameters['container0'] ?? null) === 'events' || Str::contains($path, '/events'))
        ) {
            return 'CollectionPage';
        }

        if (
            $routeName === 'container0.view'
            && (($routeParameters['container0'] ?? null) === 'events' || Str::contains($path, '/events/'))
        ) {
            return 'ItemPage';
        }

        if ($routeName === 'home' || $path === '/' || $path === '') {
            return 'WebPage';
        }

        if (Str::contains($path, '/about')) {
            return 'AboutPage';
        }

        if (Str::contains($path, '/contact')) {
            return 'ContactPage';
        }

        if (
            ($routeName !== null && Str::startsWith($routeName, 'auth.'))
            || Str::contains($path, '/auth/')
            || Str::contains($path, '/login')
            || Str::contains($path, '/register')
            || Str::contains($path, '/password')
            || Str::contains($path, '/verify')
        ) {
            return 'WebPage';
        }

        return 'WebPage';
    }
}
