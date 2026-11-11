<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Datas\MetatagData;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction;

final class BuildPageSchemaAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $routeParameters
     * @return array<string, mixed>
     */
    public function execute(
        MetatagData $meta,
        ?string $routeName,
        string $path,
        array $routeParameters = [],
        ?Authenticatable $user = null,
        ?string $name = null,
        ?string $description = null,
        ?string $canonical = null,
    ): array {
        $pageType = $this->resolvePageType($routeName, $path, $routeParameters);
        $description ??= $meta->getDescription(limit: 160);

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => $pageType,
            'name' => $name ?? $meta->getBrandName(),
            'url' => $canonical ?? $meta->getCanonical(),
            'inLanguage' => app()->getLocale(),
        ];

        if (trim($description) !== '') {
            $schema['description'] = $description;
        }

        if ($pageType === 'ProfilePage') {
            $personSchema = $this->resolveProfileMainEntity($routeParameters, $user);
            if ($personSchema !== null) {
                $schema['mainEntity'] = $personSchema;
            }
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
                'url' => $this->localizedUrl('/events/'.$routeParameters['slug0']),
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
            $routeName === 'container0.view'
            && (($routeParameters['container0'] ?? null) === 'profile' || Str::contains($path, '/profile/'))
        ) {
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

        if (
            $routeName === 'container0.view'
            && (($routeParameters['container0'] ?? null) === 'profile' || Str::contains($path, '/profile/'))
        ) {
            return 'ProfilePage';
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
            $routeName !== null && Str::startsWith($routeName, 'auth.')
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
     * @param  array<string, mixed>  $routeParameters
     * @return array<string, mixed>|null
     */
    private function resolveProfileMainEntity(array $routeParameters, ?Authenticatable $user): ?array
    {
        /** @var class-string<Model&Authenticatable> $userClass */
        $userClass = XotData::make()->getUserClass();
        $publicUser = null;

        $publicIdentifier = $routeParameters['id'] ?? $routeParameters['slug0'] ?? null;

        if (is_string($publicIdentifier) && $publicIdentifier !== '') {
            $publicUser = $userClass::query()
                ->with('profile')
                ->find($publicIdentifier);
        }

        if (! $publicUser instanceof Authenticatable && $user instanceof Authenticatable) {
            $publicUser = $user->loadMissing('profile');
        }

        if (! $publicUser instanceof Authenticatable) {
            if (isset($routeParameters['slug0']) && is_string($routeParameters['slug0']) && $routeParameters['slug0'] !== '') {
                return [
                    '@type' => 'Person',
                    'identifier' => $routeParameters['slug0'],
                    'url' => $this->localizedUrl('/profile/'.$routeParameters['slug0']),
                ];
            }

            return null;
        }

        $profile = null;
        if ($publicUser instanceof Model) {
            $profileAttr = $publicUser->getAttribute('profile');
            if ($profileAttr instanceof ProfileContract) {
                $profile = $profileAttr;
            }
        }
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
            if (is_string($avatarUrl) && $avatarUrl !== '') {
                $profileImage = $avatarUrl;
            }
        }

        $publicNameRaw = $publicUser instanceof Model ? $publicUser->getAttribute('name') : null;
        $publicFirstNameRaw = $publicUser instanceof Model ? $publicUser->getAttribute('first_name') : null;
        $publicLastNameRaw = $publicUser instanceof Model ? $publicUser->getAttribute('last_name') : null;
        $publicEmailRaw = $publicUser instanceof Model ? $publicUser->getAttribute('email') : null;

        /** @var string $publicName */
        $publicName = is_string($publicNameRaw) ? $publicNameRaw : '';
        /** @var string $publicFirstName */
        $publicFirstName = is_string($publicFirstNameRaw) ? $publicFirstNameRaw : '';
        /** @var string $publicLastName */
        $publicLastName = is_string($publicLastNameRaw) ? $publicLastNameRaw : '';
        /** @var string $publicEmail */
        $publicEmail = is_string($publicEmailRaw) ? $publicEmailRaw : '';

        $name = trim($publicName);

        if ($name === '') {
            $firstName = trim($publicFirstName) !== '' ? trim($publicFirstName) : $profileFirstName;
            $lastName = trim($publicLastName) !== '' ? trim($publicLastName) : $profileLastName;
            $name = trim($firstName.' '.$lastName);
        }

        if ($name === '') {
            $name = 'Profile';
        }

        $publicKey = $publicUser->getAuthIdentifier();
        /** @var int|string $publicKey */
        $publicKeyStr = is_int($publicKey) || is_string($publicKey) ? (string) $publicKey : '';

        $schema = [
            '@type' => 'Person',
            'name' => $name,
            'url' => $this->localizedUrl('/profile/'.$publicKeyStr),
        ];

        if (is_string($publicIdentifier) && $publicIdentifier !== '') {
            $schema['identifier'] = $publicIdentifier;
        }

        $givenName = trim($publicFirstName) !== '' ? trim($publicFirstName) : $profileFirstName;
        $familyName = trim($publicLastName) !== '' ? trim($publicLastName) : $profileLastName;
        $email = trim($publicEmail) !== '' ? trim($publicEmail) : trim($profileEmail);
        $description = $profileBio;
        $image = $profileImage;

        if ($givenName !== '') {
            $schema['givenName'] = $givenName;
        }

        if ($familyName !== '') {
            $schema['familyName'] = $familyName;
        }

        if ($email !== '') {
            $schema['email'] = $email;
        }

        if ($description !== '') {
            $schema['description'] = $description;
        }

        if ($image !== null) {
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

    private function localizedUrl(string $path): string
    {
        return url('/'.app()->getLocale().'/'.ltrim($path, '/'));
    }
}
