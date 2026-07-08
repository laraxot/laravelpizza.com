<?php

declare(strict_types=1);

namespace Modules\Progressioni\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

/**
 * Undocumented class.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 */
class ProgressioniResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    /**
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'ente' => $this->ente,
            'matr' => $this->matr,
        ];
    }
}
