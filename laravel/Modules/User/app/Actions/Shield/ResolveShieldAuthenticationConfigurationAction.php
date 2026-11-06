<?php

declare(strict_types=1);

namespace Modules\User\Actions\Shield;

use Spatie\Permission\Traits\HasRoles;
use Spatie\QueueableAction\QueueableAction;

use function Safe\class_uses;

/**
 * Action per risolvere la configurazione autenticazione Filament Shield.
 *
 * Raggruppa: getFilamentAuthGuard, getAuthProviderFQCN, isAuthProviderConfigured
 */
class ResolveShieldAuthenticationConfigurationAction
{
    use QueueableAction;

    /**
     * Execute the action to resolve shield authentication configuration.
     *
     * @return array{
     *     auth_guard: string,
     *     auth_provider_fqcn: string,
     *     auth_provider_configured: bool,
     * }
     */
    public function execute(): array
    {
        return [
            'auth_guard' => $this->getFilamentAuthGuard(),
            'auth_provider_fqcn' => $this->getAuthProviderFQCN(),
            'auth_provider_configured' => $this->isAuthProviderConfigured(),
        ];
    }

    private function getFilamentAuthGuard(): string
    {
        return 'web';
    }

    private function getAuthProviderFQCN(): string
    {
        $fqcn = config('filament-shield.auth_provider_model.fqcn');

        return is_string($fqcn) ? $fqcn : 'Illuminate\Foundation\Auth\User';
    }

    private function isAuthProviderConfigured(): bool
    {
        $fqcn = $this->getAuthProviderFQCN();

        if (! class_exists($fqcn)) {
            return false;
        }

        $classUses = class_uses($fqcn);

        if ($classUses === []) {
            return false;
        }

        return \in_array(HasRoles::class, $classUses, strict: true);
    }
}
