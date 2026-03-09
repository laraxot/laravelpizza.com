<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite\Utils;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Laravel\Socialite\Contracts\User;

/**
 * Classe che risolve e normalizza i campi del nome utente da dati di provider Socialite.
 */
final readonly class UserNameFieldsResolver
{
    private const NAME_SEARCH = 'before';

    private const SURNAME_SEARCH = 'after';

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
        return $this->resolveNameFields($idpUser, self::NAME_SEARCH);
    }

    private function resolveSurname(User $idpUser): string
    {
        return $this->resolveNameFields($idpUser, self::SURNAME_SEARCH);
    }

    /**
     * @param string $searchMethod use self constants (NAME_SEARCH, SURNAME_SEARCH)
     */
    private function resolveNameFields(User $idpUser, string $searchMethod): string
    {
        $this->validateSearchMethod($searchMethod);

        $nameSection = $this->determineNameField($idpUser, $searchMethod);

        return $nameSection->toString();
    }

    private function validateSearchMethod(string $searchMethod): void
    {
        if (! in_array($searchMethod, [self::NAME_SEARCH, self::SURNAME_SEARCH], strict: true)) {
            throw new \InvalidArgumentException('Metodo di ricerca non valido');
        }
    }

    private function determineNameField(User $idpUser, string $searchMethod): Stringable
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

    private function analyzeEmailForNameSection(User $idpUser, string $searchMethod): Stringable
    {
        $email = $idpUser->getEmail();
        if (! is_string($email) || empty($email)) {
            return Str::of('');
        }

        $emailPart = Str::of($email)
            ->trim()
            ->before('@');

        // Use conditional logic instead of dynamic method call for type safety
        if (self::NAME_SEARCH === $searchMethod) {
            return $emailPart->before('.')->trim()->title();
        }

        // self::SURNAME_SEARCH
        return $emailPart->after('.')->trim()->title();
    }

    private function getRawUserData(User $idpUser): array
    {
        $raw = [];
        try {
            $reflection = new \ReflectionClass($idpUser);
            if ($reflection->hasMethod('getRaw')) {
                $method = $reflection->getMethod('getRaw');
                $method->setAccessible(true);
                $rawValue = $method->invoke($idpUser);
                if (is_array($rawValue)) {
                    $raw = $rawValue;
                }
            } elseif ($reflection->hasProperty('user')) {
                $property = $reflection->getProperty('user');
                $property->setAccessible(true);
                $userData = $property->getValue($idpUser);
                if (is_array($userData)) {
                    $raw = $userData;
                }
            }
        } catch (\ReflectionException $e) {
            // Fallback silenzioso
        }

        return $raw;
    }

    private function resolveNameFieldByNameAttributeAnalysis(string $nameField, string $searchMethod): Stringable
    {
        if (empty($nameField)) {
            return Str::of('');
        }

        if (! in_array($searchMethod, [self::NAME_SEARCH, self::SURNAME_SEARCH], strict: true)) {
            throw new \InvalidArgumentException('Metodo di ricerca non valido');
        }

        return Str::of($nameField)
            ->trim()
            ->$searchMethod(' ')
            ->trim();
    }
}
