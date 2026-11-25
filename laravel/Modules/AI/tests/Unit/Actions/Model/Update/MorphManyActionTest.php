<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Model\Update\MorphManyAction;
use Modules\Xot\Actions\Model\UpdateAction;
use Modules\Xot\Datas\RelationData;
use Modules\Xot\Tests\Fixtures\MorphManyRelationSpy;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

function morphManyRelationSpy(): MorphManyRelationSpy
{
    return new MorphManyRelationSpy;
}

function morphManyParent(MorphManyRelationSpy $relation): Model
{
    // Niente costruttore con argomenti: Eloquent istanzia il model senza parametri durante il boot.
    $parent = new class extends Model
    {
        public ?object $relation = null;

        public function comments(): object
        {
            return $this->relation ?? throw new LogicException('relation spy not set');
        }
    };
    $parent->relation = $relation;

    return $parent;
}

/**
 * @param  array<string, array<string, mixed>>  $rows
 */
function morphManyPayload(array $rows): RelationData
{
    $relationData = new RelationData;
    $relationData->name = 'comments';
    $relationData->related = new class extends Model
    {
        protected $table = 'comments';
    };
    $relationData->data = $rows;

    return $relationData;
}

/**
 * Regressione: il cleanup PHPStan aveva tolto `$models` mentre `saveMany($models)` lo usava ancora,
 * quindi le righe del form non venivano mai (ri)associate al padre.
 */
it('passes the rows updated by UpdateAction to saveMany', function (): void {
    app()->instance(UpdateAction::class, new class extends UpdateAction
    {
        public function execute(Model $model, array $data, array $rules): Model
        {
            return $model->newInstance()->forceFill($data);
        }
    });
    $relation = morphManyRelationSpy();

    app(MorphManyAction::class)->execute(
        morphManyParent($relation),
        morphManyPayload([
            'first' => ['id' => 1, 'body' => 'a'],
            'second' => ['id' => 2, 'body' => 'b'],
        ]),
    );

    expect($relation->calls)->toBe(1)
        ->and(array_map(static fn (Model $row): mixed => $row->getAttribute('body'), $relation->saved))->toBe(['a', 'b'])
        ->and(array_map(static fn (Model $row): mixed => $row->getKey(), $relation->saved))->toBe([1, 2]);
});

it('does not update anything when the payload is empty', function (): void {
    $relation = morphManyRelationSpy();

    app(MorphManyAction::class)->execute(morphManyParent($relation), morphManyPayload([]));

    expect($relation->saved)->toBe([]);
});
