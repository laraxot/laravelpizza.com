<?php

declare(strict_types=1);

namespace Modules\User\Adapters\Socialite;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Laravel\Socialite\Contracts\User;
use Modules\User\Enums\NameSearchEnum;

/**
 * Classe che risolve e normalizza i campi del nome utente da dati di provider Socialite.
 */
final readonly class UserNameFieldsResolver
{
    public ?string $name;

    public ?string $firstName;

    public ?string $lastName;

    public function __construct(User $user)
    {
        $this->name = $this->resolveName($user);
        $this->firstName = $this->resolveName($user);
        $this->lastName = $this->resolveSurname($user);
    }

    public static function make(User $user): self
    {
        return new self($user);
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
        $nameSection = $this->determineNameField($idpUser, $searchMethod);

        return $nameSection->toString();
    }

    private function determineNameField(User $idpUser, NameSearchEnum $searchMethod): Stringable
    {
        $name = $idpUser->getName();
        if (is_string($name) && ! empty($name)) {
            $nameSection = $this->resolveNameFieldByNameAttributeAnalysis($name, $searchMethod);
            if ($nameSection->isNotEmpty()) {
                return $nameSection;
            }
        }

        $raw = $this->getRawUserData($idpUser);
        $nameField = '';
        if (isset($raw['name']) && is_string($raw['name']) && ! empty($raw['name'])) {
            $nameField = $raw['name'];
        }

        if (! empty($nameField)) {
            $nameSection = $this->resolveNameFieldByNameAttributeAnalysis($nameField, $searchMethod);
            if ($nameSection->isNotEmpty() && ! filter_var($nameSection->toString(), FILTER_VALIDATE_EMAIL)) {
                return $nameSection;
            }
        }

        // Fallback to email analysis if name is empty or looks like an email
        return $this->analyzeEmailForNameSection($idpUser, $searchMethod);
    }

    private function analyzeEmailForNameSection(User $idpUser, NameSearchEnum $searchMethod): Stringable
    {
        $email = $idpUser->getEmail();
        if (! is_string($email) || empty($email)) {
            return Str::of('');
        }

        $emailPart = Str::of($email)
            ->trim()
            ->before('@');

        return $searchMethod->applyTo($emailPart, '.')->trim()->title();
    }

    /**
     * @return array<string, mixed>
     */
    private function getRawUserData(User $idpUser): array
    {
        /** @var array<string, mixed> $raw */
        $raw = [];
        try {
            $reflection = new \ReflectionClass($idpUser);
            if ($reflection->hasMethod('getRaw')) {
                $method = $reflection->getMethod('getRaw');
                $method->setAccessible(true);
                $rawValue = $method->invoke($idpUser);
                if (is_array($rawValue)) {
                    foreach ($rawValue as $key => $value) {
                        $raw[(string) $key] = $value;
                    }
                }
            } elseif ($reflection->hasProperty('user')) {
                $property = $reflection->getProperty('user');
                $property->setAccessible(true);
                $userData = $property->getValue($idpUser);
                if (is_array($userData)) {
                    foreach ($userData as $key => $value) {
                        $raw[(string) $key] = $value;
                    }
                }
            }
        } catch (\ReflectionException $e) {
            // Fallback silenzioso
        }

        return $raw;
    }

    private function resolveNameFieldByNameAttributeAnalysis(string $nameField, NameSearchEnum $searchMethod): Stringable
    {
        if (empty($nameField)) {
            return Str::of('');
        }

        return $searchMethod->applyTo(Str::of($nameField)->trim(), ' ')->trim();
    }
}
