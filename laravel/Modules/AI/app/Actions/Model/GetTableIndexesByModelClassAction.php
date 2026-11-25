<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model;

use Doctrine\DBAL\Schema\Index;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * @see docs/contracts/get-table-indexes-by-model-class-action.md
 *
 * @contract docs/contracts/get-table-indexes-by-model-class-action.md
 */
class GetTableIndexesByModelClassAction
{
    use QueueableAction;

    /**
     * @return array<Index>
     */
    public function execute(string $modelClass): array
    {
        Assert::isInstanceOf($model = app($modelClass), Model::class);
        $table = $model->getTable();
        // Doctrine vuole una `non-empty-string`. Un model senza tabella e' un difetto di
        // configurazione: meglio dirlo qui, con il nome della classe, che lasciare che
        // Doctrine fallisca piu' a valle con un messaggio che non la nomina.
        Assert::stringNotEmpty($table, sprintf('Il model %s non dichiara una tabella.', $modelClass));

        $formManager = app(GetSchemaManagerByModelClassAction::class)->execute($modelClass);

        return $formManager->introspectTableIndexesByUnquotedName($table);
    }
}
