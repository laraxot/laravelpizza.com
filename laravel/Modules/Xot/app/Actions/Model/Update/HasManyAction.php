<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InvalidArgumentException;
use Modules\Xot\Actions\Model\UpdateAction;
use Modules\Xot\Datas\HasManyUpdateData;
use Modules\Xot\Datas\RelationData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class HasManyAction
{
    use QueueableAction;

    /**
     * Execute the HasMany relation update.
     *
     * @throws InvalidArgumentException
     */
    public function execute(Model $model, RelationData $relationDTO): void
    {
        Assert::isInstanceOf($relation = $relationDTO->rows, HasMany::class);

        $updateData = new HasManyUpdateData(
            foreignKey: $relation->getForeignKeyName(),
            parentKey: $model->getAttribute($relation->getLocalKeyName()),
        );

        match (true) {
            $this->isDirectUpdate($relationDTO->data) => $this->handleDirectUpdate($relationDTO, $updateData),
            default => $this->handleBatchUpdate($relationDTO, $updateData),
        };
    }

    /**
     * Determine if the update is a direct update.
     *
     * @param  array<string, mixed>  $data
     */
    private function isDirectUpdate(array $data): bool
    {
        return isset($data['to']) || isset($data['from']);
    }

    private function handleDirectUpdate(RelationData $relationDTO, HasManyUpdateData $updateData): void
    {
        /** @var Builder $query */
        $query = $relationDTO->related->newQuery();

        $query->where($updateData->foreignKey, $updateData->parentKey)->update([$updateData->foreignKey => null]);

        $toIds = $relationDTO->data['to'] ?? [];
        if ($toIds) {
            $query
                ->whereIn($relationDTO->related->getKeyName(), $toIds)
                ->update([$updateData->foreignKey => $updateData->parentKey]);
        }
    }

    private function handleBatchUpdate(RelationData $relationDTO, HasManyUpdateData $updateData): void
    {
        $keyName = $relationDTO->related->getKeyName();
        $updatedIds = [];

        foreach ($relationDTO->data as $item) {
            Assert::isArray($item);
            if (! isset($item[$keyName])) {
                continue;
            }

            /** @var array<string, mixed> $itemData */
            $itemData = array_merge($item, [
                $updateData->foreignKey => $updateData->parentKey,
            ]);

            $result = app(UpdateAction::class)->execute($relationDTO->related, $itemData, []);

            if ($result instanceof Model) {
                $id = $result->getKey();
                if (is_int($id) || is_string($id)) {
                    $updatedIds[] = $id;
                }
            }
        }

        $this->cleanupOrphanedRecords($relationDTO, $updateData, $updatedIds);
    }

    /**
     * Clean up orphaned records after batch update.
     *
     * @param  array<int|string>  $updatedIds
     */
    private function cleanupOrphanedRecords(
        RelationData $relationDTO,
        HasManyUpdateData $updateData,
        array $updatedIds,
    ): void {
        if ($updatedIds) {
            $relationDTO
                ->related
                ->newQuery()
                ->where($updateData->foreignKey, $updateData->parentKey)
                ->whereNotIn($relationDTO->related->getKeyName(), $updatedIds)
                ->update([$updateData->foreignKey => null]);
        }
    }
}
