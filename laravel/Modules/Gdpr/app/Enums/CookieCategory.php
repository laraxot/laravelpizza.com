<?php

declare(strict_types=1);

namespace Modules\Gdpr\Enums;

/**
 * Categorie di cookie del banner. Solo `Necessary` non richiede consenso (cookie tecnici, art. 122 c. 1 D.Lgs. 196/2003).
 * I valori coincidono con le categorie di `statikbe/laravel-cookie-consent` (valore del cookie: analytics = 2, marketing = 3, entrambi = true).
 */
enum CookieCategory: string
{
    case Necessary = 'necessary';
    case Analytics = 'analytics';
    case Marketing = 'marketing';

    public function requiresConsent(): bool
    {
        return $this !== self::Necessary;
    }
}
