<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Laravel\Socialite\Contracts\User;
use Modules\User\Datas\SocialiteNameFieldsData;
use Modules\User\Enums\NameSearchEnum;
use Spatie\QueueableAction\QueueableAction;

final class ResolveUserNameFieldsFromSocialiteAction
{
    use QueueableAction;

    public function execute(User $oauthUser): SocialiteNameFieldsData
    {
        $name = $this->resolveName($oauthUser);
        $lastName = $this->resolveSurname($oauthUser);

        return new SocialiteNameFieldsData(
            name: $name,
            firstName: $name,
            lastName: $lastName,
        );
    }

    private function resolveName(User $idpUser): string
    {
        return $this->resolveNameFields($idpUser, NameSearchEnum::Name);
    }

    private function resolveSurname(User $idpUser): string
    {
        return $this->resolveNameFields($idpUser, NameSearchEnum::Surname);
    }

    private function resolveNameFields(User $idpUser, NameSearchEnum $searchMethod): string
    {
        return $this->determineNameField($idpUser, $searchMethod)->toString();
    }

    private function determineNameField(User $idpUser, NameSearchEnum $searchMethod): Stringable
    {
        $name = $idpUser->getName();
        if (is_string($name) && $name !== '') {
            $nameSection = $this->resolveNameFieldByNameAttributeAnalysis($name, $searchMethod);
            if ($nameSection->isNotEmpty()) {
                return $nameSection;
            }
        }

        $rawName = $this->extractRawNameField($idpUser);
        if ($rawName !== '') {
            $nameSection = $this->resolveNameFieldByNameAttributeAnalysis($rawName, $searchMethod);
            if ($nameSection->isNotEmpty() && ! filter_var($nameSection->toString(), FILTER_VALIDATE_EMAIL)) {
                return $nameSection;
            }
        }

        return $this->analyzeEmailForNameSection($idpUser, $searchMethod);
    }

    private function extractRawNameField(User $idpUser): string
    {
        $raw = $this->getRawUserData($idpUser);
        $nameField = $raw['name'] ?? null;

        return is_string($nameField) && $nameField !== '' ? $nameField : '';
    }

    private function analyzeEmailForNameSection(User $idpUser, NameSearchEnum $searchMethod): Stringable
    {
        $email = $idpUser->getEmail();
        if (! is_string($email) || $email === '') {
            return Str::of('');
        }

        $emailPart = Str::of($email)->trim()->before('@');

        return $searchMethod->applyTo($emailPart, '.')->trim()->title();
    }

    /**
     * @return array<string, mixed>
     */
    private function getRawUserData(User $idpUser): array
    {
        /** @var \ReflectionClass<User> $reflection */
        $reflection = new \ReflectionClass($idpUser);

        if ($reflection->hasMethod('getRaw')) {
            return $this->rawDataFromReflectionMethod($reflection, $idpUser, 'getRaw');
        }

        if ($reflection->hasProperty('user')) {
            return $this->rawDataFromReflectionProperty($reflection, $idpUser, 'user');
        }

        return [];
    }

    /**
     * @param  \ReflectionClass<User>  $reflection
     * @return array<string, mixed>
     */
    private function rawDataFromReflectionMethod(\ReflectionClass $reflection, User $idpUser, string $method): array
    {
        $callable = $reflection->getMethod($method);
        $callable->setAccessible(true);
        $rawValue = $callable->invoke($idpUser);

        return is_array($rawValue) ? $this->normalizeRawUserArray($rawValue) : [];
    }

    /**
     * @param  \ReflectionClass<User>  $reflection
     * @return array<string, mixed>
     */
    private function rawDataFromReflectionProperty(\ReflectionClass $reflection, User $idpUser, string $property): array
    {
        $propertyReflection = $reflection->getProperty($property);
        $propertyReflection->setAccessible(true);
        $userData = $propertyReflection->getValue($idpUser);

        return is_array($userData) ? $this->normalizeRawUserArray($userData) : [];
    }

    /**
     * @param  array<int|string, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalizeRawUserArray(array $data): array
    {
        $raw = [];
        foreach ($data as $key => $value) {
            $raw[(string) $key] = $value;
        }

        return $raw;
    }

    private function resolveNameFieldByNameAttributeAnalysis(string $nameField, NameSearchEnum $searchMethod): Stringable
    {
        if ($nameField === '') {
            return Str::of('');
        }

        return $searchMethod->applyTo(Str::of($nameField)->trim(), ' ')->trim();
    }
}
