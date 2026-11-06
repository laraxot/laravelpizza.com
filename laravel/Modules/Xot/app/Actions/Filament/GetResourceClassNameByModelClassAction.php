<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use LogicException;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Risolve la Resource canonica registrata nel pannello corrente per un model.
 *
 * Perché: `XotBaseResource::getFormClass()` e `getTableClass()` compongono i FQCN
 * `{Resource}\Schemas\{Model}Form` e `{Resource}\Tables\{Plural}Table`. Quando la
 * Resource su cui gira `static::` non ospita quelle classi (tipico dei moduli che
 * estendono una `Base{Model}Resource` di un altro modulo), il fallback deve partire
 * dalla Resource canonica del model, non da `static::class`.
 *
 * Consumer: `Modules\Xot\Filament\Resources\XotBaseResource`.
 */
class GetResourceClassNameByModelClassAction
{
    use QueueableAction;

    /**
     * @param  class-string<Model>  $modelClass
     * @return class-string<XotBaseResource>
     */
    public function execute(string $modelClass): string
    {
        Assert::subclassOf($modelClass, Model::class);

        $resourceClass = Filament::getModelResource($modelClass);

        if ($resourceClass === null) {
            throw new LogicException(
                sprintf(
                    '[%s] Nessuna Filament Resource registrata nel pannello corrente per il model [%s].',
                    class_basename($this),
                    $modelClass
                )
            );
        }

        Assert::subclassOf($resourceClass, XotBaseResource::class);

        return $resourceClass;
    }
}
