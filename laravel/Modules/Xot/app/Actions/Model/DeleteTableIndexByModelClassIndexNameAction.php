<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class DeleteTableIndexByModelClassIndexNameAction
{
    use QueueableAction;

    /**
     * Elimina l'indice indicato dalla tabella del model, sulla connessione del model.
     *
     * Passa dal Schema builder di Laravel: il getDoctrineSchemaManager() non e' piu' esposto
     * dalla connessione e Doctrine non quota gli identificatori in dropIndex().
     */
    public function execute(string $modelClass, string $indexName): void
    {
        Assert::isInstanceOf($model = app($modelClass), EloquentModel::class);
        $table = $model->getTable();
        Assert::stringNotEmpty($table);
        Assert::stringNotEmpty($indexName);

        Schema::connection($model->getConnectionName())->table(
            $table,
            static function (Blueprint $blueprint) use ($indexName): void {
                $blueprint->dropIndex($indexName);
            },
        );
    }
}
