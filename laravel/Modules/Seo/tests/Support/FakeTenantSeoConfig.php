<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Support;

use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;

/**
 * Fa leggere a `SeoConfigData::make()` un file tenant finto: il contenitore risolve
 * GetTenantConfigArrayAction, quindi basta sostituirla. Nessun file scritto in `config/{tenant}`.
 */
final class FakeTenantSeoConfig
{
    /**
     * @param  array<string, mixed>  $config  contenuto di `config/{tenant}/seo.php`
     */
    public static function bind(array $config): void
    {
        app()->instance(GetTenantConfigArrayAction::class, new class($config) extends GetTenantConfigArrayAction
        {
            /**
             * @param  array<string, mixed>  $config
             */
            public function __construct(private readonly array $config) {}

            /**
             * @return array<string, mixed>
             */
            public function execute(string $name): array
            {
                return $name === 'seo' ? $this->config : [];
            }
        });
    }
}
