<?php

declare(strict_types=1);

namespace Modules\Cms\Support;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;
use Modules\Cms\Actions\ResolvePageAction;
use Modules\User\Models\User;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Datas\MetatagData;

final class PageSchemaBuilder
{
    /**
     * @param array<string, mixed> $routeParameters
     *
     * @return array<string, mixed>
     */
    public function build(
        MetatagData $meta,
        ?string $routeName,
        string $path,
        array $routeParameters = [],
        ?Authenticatable $user = null,
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

        if ('ProfilePage' === $pageType) {
            $personSchema = $this->resolveProfileMainEntity($routeParameters, $user);
            if (null !== $personSchema) {
                $schema['mainEntity'] = $personSchema;
            }
        }

        if (
            'ItemPage' === $pageType
            && 'container0.view' === $routeName
            && isset($routeParameters['container0'], $routeParameters['slug0'])
            && is_string($routeParameters['container0'])
            && is_string($routeParameters['slug0'])
            && '' !== $routeParameters['slug0']
        ) {
            $container0 = $routeParameters['container0'];
            $slug0 = $routeParameters['slug0'];

            if ('events' === $container0 || Str::contains($path, '/events/')) {
                $schema['mainEntity'] = [
                    '@type' => 'Event',
                    'url' => url('/events/'.$slug0),
                ];
            } else {
                $mainEntity = $this->resolvePredictOrGenericMainEntity($container0, $slug0);
                if (null !== $mainEntity) {
                    $schema['mainEntity'] = $mainEntity;
                }
            }
        }

        return $schema;
    }

    /**
     * @param array<string, mixed> $routeParameters
     */
    private function resolvePageType(?string $routeName, string $path, array $routeParameters): string
    {
        if (null !== $routeName && Str::startsWith($routeName, 'profile.')) {
            return 'ProfilePage';
        }

        if (
            'container0.view' === $routeName
            && (($routeParameters['container0'] ?? null) === 'profile' || Str::contains($path, '/profile/'))
        ) {
            return 'ProfilePage';
        }

        if (
            'container0.index' === $routeName
            && (($routeParameters['container0'] ?? null) === 'events' || Str::contains($path, '/events'))
        ) {
            return 'CollectionPage';
        }

        if (
            'container0.view' === $routeName
            && (($routeParameters['container0'] ?? null) === 'events' || Str::contains($path, '/events/'))
        ) {
            return 'ItemPage';
        }

        if (
            'container0.view' === $routeName
            && (($routeParameters['container0'] ?? null) === 'predicts' || Str::contains($path, '/predicts/'))
        ) {
            return 'ItemPage';
        }

        if (
            'container0.view' === $routeName
            && (($routeParameters['container0'] ?? null) === 'predicts' || Str::contains($path, '/predicts/'))
        ) {
            return 'ItemPage';
        }

        if ('home' === $routeName || '/' === $path || '' === $path) {
            return 'WebPage';
        }

        if (Str::contains($path, '/about')) {
            return 'AboutPage';
        }

        if (Str::contains($path, '/contact')) {
            return 'ContactPage';
        }

        if (
            (null !== $routeName && Str::startsWith($routeName, 'auth.'))
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

    /**
     * @param array<string, mixed> $routeParameters
     *
     * @return array<string, mixed>|null
     */
    private function resolveProfileMainEntity(array $routeParameters, ?Authenticatable $user): ?array
    {
        $publicUser = null;

        $publicIdentifier = $routeParameters['id'] ?? $routeParameters['slug0'] ?? null;

        if (is_string($publicIdentifier) && '' !== $publicIdentifier) {
            $publicUser = User::query()
                ->with('profile')
                ->find($publicIdentifier);
        }

        if (! $publicUser instanceof User && $user instanceof User) {
            $publicUser = $user->loadMissing('profile');
        }

        if (! $publicUser instanceof User) {
            if (isset($routeParameters['slug0']) && is_string($routeParameters['slug0']) && '' !== $routeParameters['slug0']) {
                return [
                    '@type' => 'Person',
                    'identifier' => $routeParameters['slug0'],
                    'url' => url('/profile/'.$routeParameters['slug0']),
                ];
            }

            return null;
        }

        $profile = $publicUser->profile;
        $profileFirstName = '';
        $profileLastName = '';
        $profileEmail = '';
        $profileBio = '';
        $profileImage = null;

        if ($profile instanceof ProfileContract) {
            $profileFirstName = $this->readNullableStringProperty($profile, 'first_name');
            $profileLastName = $this->readNullableStringProperty($profile, 'last_name');
            $profileEmail = $this->readNullableStringProperty($profile, 'email');
            $profileBio = $this->readNullableStringProperty($profile, 'bio');

            $avatarUrl = $profile->getAvatarUrl();
            if (is_string($avatarUrl) && '' !== $avatarUrl) {
                $profileImage = $avatarUrl;
            }
        }

        $name = trim((string) ($publicUser->name ?? ''));

        if ('' === $name) {
            $firstName = trim((string) ($publicUser->first_name ?? $profileFirstName));
            $lastName = trim((string) ($publicUser->last_name ?? $profileLastName));
            $name = trim($firstName.' '.$lastName);
        }

        if ('' === $name) {
            $name = 'Profile';
        }

        $schema = [
            '@type' => 'Person',
            'name' => $name,
            'url' => url('/profile/'.(string) $publicUser->getKey()),
        ];

        if (is_string($publicIdentifier) && '' !== $publicIdentifier) {
            $schema['identifier'] = $publicIdentifier;
        }

        $givenName = trim((string) ($publicUser->first_name ?? $profileFirstName));
        $familyName = trim((string) ($publicUser->last_name ?? $profileLastName));
        $email = trim((string) ($publicUser->email ?? $profileEmail));
        $description = trim((string) $profileBio);
        $image = $profileImage;

        if ('' !== $givenName) {
            $schema['givenName'] = $givenName;
        }

        if ('' !== $familyName) {
            $schema['familyName'] = $familyName;
        }

        if ('' !== $email) {
            $schema['email'] = $email;
        }

        if ('' !== $description) {
            $schema['description'] = $description;
        }

        if (null !== $image) {
            $schema['image'] = $image;
        }

        return $schema;
    }

    private function readNullableStringProperty(object $object, string $property): string
    {
        if (! isset($object->{$property})) {
            return '';
        }

        $value = $object->{$property};

        return is_string($value) ? trim($value) : '';
    }

    /**
     * Resolve mainEntity for predicts or other container0 types.
     *
     * @return array<string, mixed>|null
     */
    private function resolvePredictOrGenericMainEntity(string $container0, string $slug0): ?array
    {
        try {
            $resolved = app(ResolvePageAction::class)->execute($container0, $slug0);
            if (null === $resolved->item) {
                return null;
            }

            $item = $resolved->item;
            $title = $this->extractItemTitle($item);
            $locale = app()->getLocale();
            $url = url('/'.$locale.'/'.$container0.'/'.$slug0);

            if ('predicts' === $container0) {
                return [
                    '@type' => 'Question',
                    'name' => '' !== $title ? $title : 'Prediction Market',
                    'url' => $url,
                ];
            }

            return [
                '@type' => 'Thing',
                'name' => '' !== $title ? $title : 'Item',
                'url' => $url,
            ];
        } catch (\Throwable) {
            return null;
        }
    }

    private function extractItemTitle(object $item): string
    {
        $locale = app()->getLocale();
        $title = $item->title ?? $item->name ?? $item->subject ?? null;

        if (null === $title) {
            return '';
        }

        if (is_array($title)) {
            $val = $title[$locale] ?? $title['en'] ?? $title['it'] ?? reset($title);

            return is_string($val) ? trim($val) : '';
        }

        return trim((string) $title);
    }
}
