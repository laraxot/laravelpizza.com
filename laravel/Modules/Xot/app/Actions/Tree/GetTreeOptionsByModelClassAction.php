<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Tree;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Spatie\QueueableAction\QueueableAction;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection as TreeCollection;
use Webmozart\Assert\Assert;

class GetTreeOptionsByModelClassAction
{
    use QueueableAction;

    /** @var array<int|string, string> */
    public array $options = [];

    /**
     * @param  class-string<HasRecursiveRelationshipsContract<Model>>  $class
     * @return array<int|string, string>
     */
    public function execute(string $class, Model|callable|null $_where = null): array
    {
        $model = new $class;

        $collection = $model->newQuery()->get();
        Assert::isInstanceOf($collection, TreeCollection::class);
        $rows = $collection->toTree();

        foreach ($rows as $row) {
            if (! $row instanceof HasRecursiveRelationshipsContract) {
                continue;
            }
            $key = $row->getKey();
            $this->options[SafeStringCastAction::cast($key)] = $row->getLabel();
            $this->parse($row);
        }

        return $this->options;
    }

    /**
     * @param HasRecursiveRelationshipsContract<Model> $model
     */
    public function parse(HasRecursiveRelationshipsContract $model): void
    {
        foreach ($model->children as $child) {
            /** @var HasRecursiveRelationshipsContract<Model> $child */
            $key = $child->getKey();
            $this->options[SafeStringCastAction::cast($key)] =
                Str::repeat('---', $child->depth).'   '.$child->getLabel();
        }
    }
}
