<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

class GetSicureArrayByModelAction
{
    use QueueableAction;

    /**
     * @return array<string, mixed>
     */
    public function execute(Model $model): array
    {
        try {
            return $model->attributesToArray();
            // @phpstan-ignore-next-line
        } catch (\Throwable $e) {
            $data = [];
            foreach ($model->getAttributes() as $key => $value) {
                try {
                    $data[$key] = $model->$key;
                    // @phpstan-ignore-next-line
                } catch (\Throwable $e) {
                }
            }

            return $data;
        }
    }
}
