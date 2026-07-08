<?php

declare(strict_types=1);

namespace Modules\Sigma\Transformers;

/*
 * https://medium.com/@dinotedesco/using-laravel-5-5-resources-to-create-your-own-json-api-formatted-api-2c6af5e4d0e8
 * https://jsonapi.org/
 **/
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;
use JsonSerializable;

class RepartResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<int, mixed>|Arrayable<string, mixed>|JsonSerializable
     */
    #[\Override]
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        /** @var array<int, mixed>|Arrayable<string, mixed>|JsonSerializable $result */
        $result = parent::toArray($request);

        return $result;
    }
}
