<?php

declare(strict_types=1);

namespace Modules\Job\Actions;

use Exception;
use Spatie\QueueableAction\QueueableAction;

class GetTaskFrequenciesAction
{
    use QueueableAction;

    /**
     * @return array<int|string, mixed>
     */
    public function execute(): array
    {
        $res = config('totem.frequencies');
        if (\is_array($res)) {
            /** @var array<int|string, mixed> */
            return $res;
        }

        throw new Exception('['.__LINE__.']['.class_basename($this).']');
    }
}
