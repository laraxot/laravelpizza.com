<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Spatie\LaravelData\Data;

/**
 * Class AuthData - Gestisce la configurazione dell'autenticazione per il framework Laraxot.
 * Utilizzato esclusivamente nell'ambito dell'architettura Filament-first.
 */
class AuthData extends Data
{
    /**
     * @param  string  $guard  Guard predefinita
     * @param  array  $guards  Guards disponibili
     * @param  array  $providers  Provider di autenticazione
     * @param  bool  $verify_email  Se richiedere verifica email
     * @param  int  $password_reset_timeout  Password reset timeout in minuti
     * @param  array  $throttle  Configurazione throttling
     * @param  array  $social  Provider social abilitati
     */
    public function __construct(
        public readonly string $guard = 'web',
        public readonly array $guards = ['web', 'api'],
        public readonly array $providers = ['users' => ['driver' => 'eloquent', 'model' => '']],
        public readonly bool $verify_email = true,
        public readonly int $password_reset_timeout = 60,
        public readonly array $throttle = [
            'enabled' => true,
            'decay_minutes' => 1,
            'max_attempts' => 5,
        ],
        public readonly array $social = [
            'google' => false,
            'facebook' => false,
            'twitter' => false,
            'github' => false,
        ],
    ) {}

    /**
     * Create a new instance of AuthData with default values.
     */
    public static function make(): static
    {
        return new static;
    }
}
