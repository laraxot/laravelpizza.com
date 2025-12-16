<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Session;
use Modules\Xot\Actions\Model\UpdateAction;
use Modules\Xot\Datas\RelationData as RelationDTO;
use RuntimeException;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class BelongsToManyAction
{
    use QueueableAction;

    public function execute(Model $_model, RelationDTO $relationDTO): void
    {
        Assert::isInstanceOf($rows = $relationDTO->rows, BelongsToMany::class);
        // dddx(['row' => $row, 'relation' => $relation]);
        if (
            \in_array('to', array_keys($relationDTO->data), false) ||
                \in_array('from', array_keys($relationDTO->data), false)
        ) {
            // $this->saveMultiselectTwoSides($row, $relation->name, $relation->data);
            $to = $relationDTO->data['to'] ?? [];

            // Assicura che $to sia un array di ID validi
            $to = is_iterable($to) ? iterator_to_array($to) : ((array) $to);
            Assert::allScalar($to, 'The "to" field must contain only scalar values.');

            $rows->sync($to);
            $status = 'collegati ['.implode(', ', $to).'] ';
            Session::flash('status', $status);

            return;
        }

        $models = [];
        $ids = [];
        $related = $relationDTO->related;
        $keyName = $relationDTO->related->getKeyName();

        // Itera sui dati della relazione
        foreach ($relationDTO->data as $data) {
            Assert::isArray($data, 'Each item in RelationDTO->data must be an array.');
            if (\array_key_exists($keyName, $data)) {
                // Aggiorna o crea il modello correlato
                /** @var array<string, mixed> $safeData */
                $safeData = $data;
                /** @var Model $res */
                $res = app(UpdateAction::class)->execute($related, $safeData, []);
                Assert::isInstanceOf($res, Model::class, 'UpdateAction must return an instance of Model.');

                $ids[] = $res->getKey();
                $models[] = $res;
            } else {
                throw new RuntimeException(sprintf('Key "%s" not found in relation data.', $keyName));
            }
        }

        // Sincronizza gli ID raccolti
        if (! empty($ids)) {
            try {
                // Assicura che $ids sia un array di valori scalari
                // $ids è già un array non vuoto a questo punto, quindi non serve verificare se è iterabile
                Assert::allScalar($ids, 'The "ids" array must contain only scalar values.');

                $rows->syncWithoutDetaching($ids);
            } catch (Exception $e) {
                throw new RuntimeException(sprintf('Error during syncWithoutDetaching: %s', $e->getMessage()));
            }
        }
    }
}
