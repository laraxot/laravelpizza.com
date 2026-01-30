<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenant\Models\TenantDomain;

/**
 * @extends Factory<TenantDomain>
 */
class TenantDomainFactory extends Factory
{
    protected $model = TenantDomain::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => ['example.com', 'test.com', 'demo.org', 'sample.net', 'example.it'][array_rand(['example.com', 'test.com', 'demo.org', 'sample.net', 'example.it'])],
            'domain' => ['example.com', 'test.com', 'demo.org', 'sample.net', 'example.it'][array_rand(['example.com', 'test.com', 'demo.org', 'sample.net', 'example.it'])],
            'is_primary' => (bool) random_int(0, 1),
            'status' => ['active', 'pending', 'inactive', 'verified', 'unverified'][array_rand(['active', 'pending', 'inactive', 'verified', 'unverified'])],
            'verification_token' => (string) random_int(1000000000000000, 9999999999999999),
            'verified_at' => \Carbon\Carbon::now()->subDays(random_int(0, 30)),
        ];
    }
}
