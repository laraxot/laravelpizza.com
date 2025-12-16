<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use InvalidArgumentException;
use Modules\Xot\Datas\RelationData as RelationDTO;
use RuntimeException;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Class HasOneAction.
 *
 * Handles the update operation for HasOne relationships in Eloquent models.
 *
 * @template TModel of Model
 */
class HasOneAction
{
    use QueueableAction;

    /**
     * Execute the update operation for a HasOne relationship.
     *
     * @param  Model  $model  The parent model instance
     * @param  RelationDTO  $relationDTO  Data transfer object containing relationship information
     *
     * @throws InvalidArgumentException When relationship type is invalid
     * @throws RuntimeException When relationship data is invalid
     */
    public function execute(Model $model, RelationDTO $relationDTO): void
    {
        // Validate that the relationship is of type HasOne
        Assert::isInstanceOf(
            $relationDTO->rows,
            HasOne::class,
            sprintf('Expected HasOne relationship, got %s', get_debug_type($relationDTO->rows)),
        );

        /** @var HasOne $relation */
        $relation = $relationDTO->rows;

        // Validate that the relationship data is not empty
        if (empty($relationDTO->data)) {
            throw new RuntimeException('Relationship data cannot be empty');
        }

        // Check if the related model exists
        if ($relation->exists()) {
            $related = $model->{$relationDTO->name};
            if ($related instanceof Model) {
                $related->update($relationDTO->data);

                return;
            }
        }

        // If the related model does not exist, create a new one
        $relation->create($relationDTO->data);
    }
}
