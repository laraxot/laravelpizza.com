<?php

declare(strict_types=1);

namespace Modules\Xot\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromIterator;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Lang\Actions\TransCollectionAction;

/**
 * @implements WithMapping<mixed>
 */
class LazyCollectionExport implements FromIterator, ShouldQueue, WithHeadings, WithMapping
{
    use Exportable;

    /** @var array<int, string> */
    public array $headings = [];

    public ?string $transKey;

    /** @var array<int, string> */
    public array $fields = [];

    /**
     * @param LazyCollection<int, mixed> $collection
     * @param array<int, string>         $fields
     */
    public function __construct(
        public LazyCollection $collection,
        ?string $transKey = null,
        array $fields = [],
    ) {
        $this->transKey = $transKey;
        $this->fields = $fields;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function map(mixed $row): array
    {
        $rowArray = $this->normalizeRow($row);

        if (empty($this->fields)) {
            return $rowArray;
        }

        return collect($this->fields)
            ->mapWithKeys(function (string $key) use ($rowArray): array {
                return [$key => $rowArray[$key] ?? null];
            })
            ->toArray();
    }

    /**
     * @return Collection<int, string>
     */
    public function getHead(): Collection
    {
        if (! empty($this->fields)) {
            return collect($this->fields)->values();
        }

        $head = $this->collection->first();
        $headArray = $this->normalizeRow($head);

        return collect(array_keys($headArray))
            ->map(static fn (int|string $key): string => (string) $key)
            ->values();
    }

    /**
     * @return array<int|string, string>
     */
    public function headings(): array
    {
        $headings = $this->getHead();
        $transKey = $this->transKey;
        $headingCollection = collect();

        foreach ($headings as $heading) {
            $headingCollection->put((string) $heading, $heading);
        }

        $translated = app(TransCollectionAction::class)->execute($headingCollection, $transKey);

        $result = [];
        foreach ($translated->all() as $key => $value) {
            if (! is_string($value)) {
                continue;
            }
            $result[is_int($key) ? $key : (string) $key] = $value;
        }

        return $result;
    }

    /**
     * @return LazyCollection<int, mixed>
     */
    public function collection(): LazyCollection
    {
        return $this->collection;
    }

    /**
     * @return \Iterator<int, mixed>
     */
    public function iterator(): \Iterator
    {
        return new \ArrayIterator(iterator_to_array($this->collection->getIterator(), false));
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
            return $row->toArray();
        }

        if (is_array($row)) {
            return $row;
        }

        if ($row instanceof \Traversable) {
            return iterator_to_array($row);
        }

        return (array) $row;
    }
}
