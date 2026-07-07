<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Webmozart\Assert\Assert;

/**
 * Risolve la class-string del modello dalla relazione Filament (RelationManager / ManageRelatedRecords).
 */
trait HasRelationshipModelClass
{
    /**
     * @return class-string<Model>
     */
    public function getModelClass(): string
    {
        $relationship = $this->getRelationship();
        if ($relationship instanceof Relation) {
            $modelClass = $relationship->getModel()::class;
            Assert::subclassOf($modelClass, Model::class);

            /* @var class-string<Model> $modelClass */
            return $modelClass;
        }

        throw new \Exception('No model found in '.class_basename(self::class).'::'.__FUNCTION__);
    }
}
