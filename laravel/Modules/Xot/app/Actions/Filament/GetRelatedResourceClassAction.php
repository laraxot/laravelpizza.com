<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Spatie\QueueableAction\QueueableAction;

/**
 * Risolve la XotBaseResource del model MOSTRATO da una pagina
 * XotBaseManageRelatedRecords (il model della relazione, mai quello della
 * Resource proprietaria della pagina).
 *
 * Perche' non riusa GetResourceClassNameByModelClassAction: quella usa
 * Filament::getModelResource(), scoped al pannello corrente — verificato dal
 * vivo che torna NULL per model di un altro modulo, e per QuestionChart
 * risolverebbe una Resource diversa da quella che la pagina dichiara
 * esplicitamente in $relatedResource.
 *
 * Perche' non riusa XotBaseRelationManager::getResourceClass(): quel metodo
 * deriva la Resource dal namespace del RelationManager stesso, che per
 * convenzione vive dentro {RelatedResource}\RelationManagers\. Una pagina
 * XotBaseManageRelatedRecords vive invece dentro {OwnerResource}\Pages\:
 * applicare la stessa risalita di namespace risolverebbe la Resource
 * proprietaria, non quella della relazione.
 *
 * @see Modules/Xot/docs/app/Actions/Filament/GetRelatedResourceClassAction.php.md
 * @see Modules/Xot/docs/stories/xotbasemanagerelatedrecords-convention-over-configuration.story.md
 */
class GetRelatedResourceClassAction
{
    use QueueableAction;

    /**
     * @return class-string<XotBaseResource>|null
     */
    public function execute(object $page): ?string
    {
        if (method_exists($page, 'getRelatedResource')) {
            /** @var class-string<XotBaseResource>|null $relatedResource */
            $relatedResource = $page::getRelatedResource();
            if ($relatedResource !== null) {
                return $relatedResource;
            }
        }

        if (! method_exists($page, 'getModelClass')) {
            return null;
        }

        /** @var class-string<Model> $modelClass */
        $modelClass = $page->getModelClass();
        $moduleName = Str::between($modelClass, 'Modules\\', '\Models\\');
        $modelName = class_basename($modelClass);
        $guess = 'Modules\\'.$moduleName.'\Filament\Resources\\'.$modelName.'Resource';

        if (class_exists($guess) && is_subclass_of($guess, XotBaseResource::class)) {
            /** @var class-string<XotBaseResource> $guess */
            return $guess;
        }

        return null;
    }
}
