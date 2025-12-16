<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\OauthPersonalAccessClient;
use Webmozart\Assert\Assert;

/**
 * OauthPersonalAccessClient Factory.
 *
 * @extends Factory<OauthPersonalAccessClient>
 */
class OauthPersonalAccessClientFactory extends Factory
{
    protected $model = OauthPersonalAccessClient::class;

    public function definition(): array
    {
        /** @phpstan-ignore-next-line - Factory method returns proper object */

        /** @phpstan-ignore-next-line - Method exists on Eloquent model */
        $clientId = $client->getKey();
        Assert::notNull($clientId);

        return [
            'client_id' => $clientId,
        ];
    }
}
