<?php

declare(strict_types=1);

namespace Modules\User\Models\Passport;

use Laravel\Passport\Client as PassportClient;

/**
 * Custom Passport Client model to fix compatibility issues with Laravel 12.
 */
class Client extends PassportClient
{
    /**
     * Initialize the trait.
     * Overriding to match Laravel 12 HasUuids trait signature (removing : void).
     */
    public function initializeHasUniqueStringIds(): void
    {
        // @phpstan-ignore-next-line method_exists check per compatibilità versioni Laravel
        if (method_exists(parent::class, 'initializeHasUniqueStringIds')) {
            parent::initializeHasUniqueStringIds();
        }
    }
}
