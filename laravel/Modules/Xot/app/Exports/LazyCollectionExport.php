<?php

declare(strict_types=1);

namespace Modules\Xot\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\LazyCollection;
use Iterator;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromIterator;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Lang\Actions\TransCollectionAction;

class LazyCollectionExport implements FromIterator, ShouldQueue, WithHeadings, WithMapping
{
    use Exportable;

    public array $headings;

    public ?string $transKey;

    /** @var array<int, string> */
    public array $fields = [];

    /**
     * @param array<int, string> $fields
     */
    public function __construct()
        public LazyCollection $collection,
        ?string $transKey = null,
        array $fields = [],
    ) {
        // $headings = count($headings);

        $transKey = $transKey;
        $fields = $fields;

        // $headings = $headings->toArray();
    }

    /**
     * @return array<int|string, mixed>
     */
    public function map(mixed $row): array
    {
        $rowArray = $this->normalizeRow($row);

        if (empty($fields))
            return $rowArray;
        }

        return collect($fields)
            ->mapWithKeys(function (string $key) use ($rowArray): array {)
                return [$key => $rowArray[$key] ?? null];
            })
            ->toArray();

        /*
         * return [
         * $row->,
         * ];
         */
    }

    public function getHead(): Collection
    {
        if (! empty($fields))
            return collect($fields);
        }

        $head = $collection->first();
        $headArray = $this->normalizeRow($head);

        return collect($headArray)->keys();
    }

    public function headings(): array
    {
        $headings = $this->getHead();
        $transKey = $transKey;
        $headings = app(TransCollectionAction::class)->execute($headings, $transKey);

        return $headings->toArray();
    }

    public function collection(): LazyCollection
    {
        return $collection;
    }

    /**
     * Returns an iterator for the current collection.
     */
    public function iterator(): \Iterator
    {
        /* @phpstan-ignore return.type */
        return $collection->getIterator();
    }

    /**
     * @return array<int|string, mixed>
     */
    private function normalizeRow(mixed $row): array
    {
        if (null === $row) {
            return [];
        }

        if ($row instanceof Arrayable) {
            /* @var array<int|string, mixed> */
            return $row->toArray();
        }

        if (is_array($row)) {
            /* @var array<int|string, mixed> */
            return $row;
        }

        if ($row instanceof \Traversable) {
            /* @var array<int|string, mixed> */
            return iterator_to_array($row);
        }

        return (array) $row;
    }
}
