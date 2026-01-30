<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TenantSetting;

/**
 * @extends Factory<TenantSetting>
 */
class TenantSettingFactory extends Factory
{
    protected $model = TenantSetting::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'key' => ['email', 'phone', 'address', 'timezone', 'locale', 'currency', 'notifications', 'theme'][array_rand(['email', 'phone', 'address', 'timezone', 'locale', 'currency', 'notifications', 'theme'])],
            'value' => ['enabled', 'disabled', 'test@example.com', '+1234567890', 'Main Street 123', 'Europe/Rome', 'it', 'EUR'][array_rand(['enabled', 'disabled', 'test@example.com', '+1234567890', 'Main Street 123', 'Europe/Rome', 'it', 'EUR'])],
            'type' => ['string', 'integer', 'boolean', 'array', 'json'][array_rand(['string', 'integer', 'boolean', 'array', 'json'])],
        ];
    }
}
