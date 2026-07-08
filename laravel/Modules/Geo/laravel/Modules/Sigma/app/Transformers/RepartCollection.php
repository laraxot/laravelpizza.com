<?php

declare(strict_types=1);

namespace Modules\Sigma\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RepartCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    #[\Override]
    public function toArray($request): array
    {
        // return parent::toArray($request);
        return [
            'data' => $this->collection, // non si puo' cambiare il nome della var data
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
