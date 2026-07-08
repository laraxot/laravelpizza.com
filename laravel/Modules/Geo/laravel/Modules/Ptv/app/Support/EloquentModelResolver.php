<?php

declare(strict_types=1);

namespace Modules\Ptv\Support;

use Illuminate\Database\Eloquent\Model;
use Webmozart\Assert\Assert;

/**
 * Risolve istanze e classi Eloquent partendo da class-string dinamiche.
 */
final class EloquentModelResolver
{
    /**
     * @template T of Model
     *
     * @param  class-string<T>  $class
     * @return T
     */
    public static function newInstance(string $class): Model
    {
        Assert::subclassOf($class, Model::class);

        return new $class;
    }

    /**
     * @param  class-string<Model>  $baseClass
     * @return class-string<Model>
     */
    public static function siblingClass(string $baseClass, string $suffix): string
    {
        $relatedClass = $baseClass.$suffix;
        Assert::subclassOf($relatedClass, Model::class);

        /** @var class-string<Model> $relatedClass */
        return $relatedClass;
    }
}
