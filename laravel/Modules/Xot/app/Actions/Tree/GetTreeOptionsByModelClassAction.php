<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Tree;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Spatie\QueueableAction\QueueableAction;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

class GetTreeOptionsByModelClassAction
{
    use QueueableAction;

    /** @var array<int|string, string> */
    public array $options = [];

    /**
     * @param  class-string<HasRecursiveRelationshipsContract>  $class
     * @return array<int|string, string>
     */
    public function execute(string $class, Model|callable|null $_where = null): array
    {
        /** @var HasRecursiveRelationshipsContract $model */
        $model = new $class;

        /** @var Collection<int, HasRecursiveRelationshipsContract> $collection */
        // @phpstan-ignore generics.notSubtype
        $collection = $model->newQuery()->get();
        $rows = $collection->toTree();

        foreach ($rows as $row) {
            /** @var HasRecursiveRelationshipsContract $row */
            $key = $row->getKey();
            $this->options[is_string($key) ? $key : ((string) $key)] = is_string($row)
                ? $row
                : (string) $row->getLabel();
            $this->parse($row);
        }

        return $this->options;
    }

    public function parse(HasRecursiveRelationshipsContract $model): void
    {
        foreach ($model->children as $child) {
            /** @var HasRecursiveRelationshipsContract $child */
            $key = $child->getKey();
            $this->options[is_string($key) ? $key : ((string) $key)] =
                Str::repeat('---', $child->depth).'   '.$child->getLabel();
        }
    }
}
