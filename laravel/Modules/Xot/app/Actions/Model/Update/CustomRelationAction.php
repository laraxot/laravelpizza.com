<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Model\UpdateAction;
use Modules\Xot\Datas\RelationData as RelationDTO;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class CustomRelationAction
{
    use QueueableAction;

    /**
     * Aggiorna i record correlati di una CustomRelation dal payload del form.
     *
     * La relazione custom non ha un'operazione di associazione (save/attach/sync): resta solo
     * l'aggiornamento dei campi di ogni riga, quindi il risultato di UpdateAction non serve.
     */
    public function execute(Model $model, RelationDTO $relationDTO): void
    {
        // Assert::isInstanceOf($rows = $relationDTO->rows, BelongsToMany::class);
        // dddx(['model' => $model, 'relationDTO' => $relationDTO]);
        $related = $relationDTO->related;
        $keyName = $relationDTO->related->getKeyName();
        foreach ($relationDTO->data as $data) {
            Assert::isArray($data);
            /** @var array<string, mixed> $data PHPStan: ensure correct type */
            if (\in_array($keyName, array_keys($data), false)) {
                app(UpdateAction::class)->execute($related, $data, []);
            } else {
                throw new \LogicException('Update\CustomRelationAction: rows without primary key not implemented, relation ['.$relationDTO->name.']');
            }
        }
    }
}
