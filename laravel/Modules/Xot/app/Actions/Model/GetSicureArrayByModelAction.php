<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;
use ValueError;

class GetSicureArrayByModelAction
{
    use QueueableAction;

    /**
     * @return array<string, mixed>
     */
    public function execute(Model $model): array
    {
        try {
            /** @var array<string, mixed> */
            return $model->attributesToArray();
        } catch (ValueError $e) {
            /** @var array<string, mixed> $data */
            $data = [];
            foreach ($model->getAttributes() as $key => $value) {
                try {
                    $data[$key] = $model->$key;

                    /** @phpstan-ignore-next-line */
                } catch (ValueError $e) {
                }
            }

            return $data;
        }
    }
}
