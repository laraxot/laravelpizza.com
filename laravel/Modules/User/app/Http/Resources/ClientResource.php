<?php

declare(strict_types=1);

namespace Modules\User\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Models\OauthClient as Client;
use Modules\User\Models\User;

/**
 * @property User|null $owner
 *
 * @mixin Client
 */
final class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[\Override]
    public function toArray(Request $request): array
    {
        /** @var Client $client */
        $client = $this->resource;

        return [
            'id' => $client->id,
            'name' => $client->name,
            'owner' => $this->when(
                $client->owner !== null,
                fn (): OwnerResource => new OwnerResource($client->owner)
            ),
        ];
    }
}
