<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Math;

use Spatie\QueueableAction\QueueableAction;

class CheckPointInPolygonJsonAction
{
    use QueueableAction;

    public function __construct(
        private readonly IsPointInPolygonAction $isPointInPolygonAction = new IsPointInPolygonAction(),
    ) {
    }

    public function execute(float $lat, float $lng, ?string $polygon): bool
    {
        if (null === $polygon || '' === $polygon) {
            return false;
        }

        $original_data = json_decode($polygon, true, 512, JSON_THROW_ON_ERROR);
        if (! \is_array($original_data)) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        return $this->isPointInPolygonAction->execute($lat, $lng, $original_data);
    }
}
