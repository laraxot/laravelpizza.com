<?php

declare(strict_types=1);

use Modules\UI\Database\Factories\CategoryFactory;
use Modules\UI\Database\Factories\CollectionFactory;
use Modules\UI\Models\Category;
use Modules\UI\Models\Collection;

/*
 * Bootstrap Pest — modulo UI.
 * Ogni file test dichiara uses(\Modules\UI\Tests\TestCase::class).
 * Vietato expect()->extend() / uses()->in() qui (PHPStan method.internalClass).
 */

/**
 * @param  array<string, mixed>  $attributes
 */
function createCategory(array $attributes = []): Category
{
    return CategoryFactory::new()->createOne($attributes);
}

/**
 * @param  array<string, mixed>  $attributes
 */
function makeCategory(array $attributes = []): Category
{
    return CategoryFactory::new()->makeOne($attributes);
}

/**
 * @param  array<string, mixed>  $attributes
 */
function createCollection(array $attributes = []): Collection
{
    return CollectionFactory::new()->createOne($attributes);
}

/**
 * @param  array<string, mixed>  $attributes
 */
function makeCollection(array $attributes = []): Collection
{
    return CollectionFactory::new()->makeOne($attributes);
}
