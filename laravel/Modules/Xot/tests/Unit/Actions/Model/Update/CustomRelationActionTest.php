<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Model\Update\CustomRelationAction;
use Modules\Xot\Actions\Model\UpdateAction;
use Modules\Xot\Datas\RelationData;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('updates every row of the payload on the related model', function (): void {
    $updateSpy = new class extends UpdateAction
    {
        /** @var list<array<string, mixed>> */
        public array $rows = [];

        /** @var list<Model> */
        public array $targets = [];

        public function execute(Model $model, array $data, array $rules): Model
        {
            $this->targets[] = $model;
            $this->rows[] = $data;

            return $model;
        }
    };
    app()->instance(UpdateAction::class, $updateSpy);

    $related = new class extends Model
    {
        protected $table = 'custom_related';
    };
    $relationData = new RelationData;
    $relationData->name = 'custom';
    $relationData->related = $related;
    $relationData->data = [
        'first' => ['id' => 1, 'title' => 'a'],
        'second' => ['id' => 2, 'title' => 'b'],
    ];

    app(CustomRelationAction::class)->execute(new class extends Model {}, $relationData);

    expect($updateSpy->rows)->toBe([['id' => 1, 'title' => 'a'], ['id' => 2, 'title' => 'b']])
        ->and($updateSpy->targets)->toBe([$related, $related]);
});
