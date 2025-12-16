<?php

declare(strict_types=1);

namespace Modules\Xot\Exports;

use Traversable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Lang\Actions\TransCollectionAction;

// use Staudenmeir\LaravelCte\Query\Builder as CteBuilder;

class QueryExport implements FromQuery, ShouldQueue, WithChunkReading, WithHeadings, WithMapping
{
    use Exportable;

    public array $headings = [];

    /** @var array<int, int|string> */
    public array $fields = [];

    public ?string $transKey = null;

    public QueryBuilder|EloquentBuilder $query;

    /**
     * @param array<int, int|string> $fields
     */
    public function __construct(QueryBuilder|EloquentBuilder $query, ?string $transKey = null, array $fields = [])
    {
        $this->query = $query;
        $this->transKey = $transKey;
        $this->fields = $fields;

        /*
         * $this->headings = collect($query->first())
         * ->keys()
         * ->map(
         * function ($item) use ($transKey) {
         * $t = $transKey.'.'.$item;
         * $trans = trans($t);
         * if ($trans != $t) {
         * return $trans;
         * }
         *
         * return $item;
         * }
         * )
         * ->toArray();
         */
    }

    /**
     * @return Collection<int, int|string>
     */
    public function getHead(): Collection
    {
        if (! empty($this->fields)) {
            return collect(array_values($this->fields))
                ->map(
                    static fn (mixed $heading): int|string => \is_int($heading) ? $heading : (string) $heading
                );
        }
        /**
         * @var Arrayable<(int|string), mixed>|iterable<(int|string), mixed>|null
         */
        $first = $this->query->first();
        if (null === $first) {
            /** @var Collection<int, int|string> $emptyCollection */
            $emptyCollection = collect([]);

            return $emptyCollection;
        }

        /** @var Collection<int, int|string> $result */
        $result = collect(array_keys($this->normalizeRow($first)))
            ->map(
                static fn (mixed $heading): int|string => \is_int($heading) ? $heading : (string) $heading
            );

        return $result;
    }

    public function headings(): array
    {
        /** @var Collection<int|string, mixed> $headingsWithKeys */
        $headingsWithKeys = $this->getHead()
            ->values()
            ->mapWithKeys(
                static function (int|string $value, int $key): array {
                    $stringKey = (string) $value;

                    return [$stringKey => $value];
                },
            );

        $translated = app(TransCollectionAction::class)->execute($headingsWithKeys, $this->transKey);

        return $translated->toArray();
    }

    /**
     * se si usa scout aggiungere |ScoutBuilder.
     */
    public function query(): QueryBuilder|EloquentBuilder|Relation
    {
        return $this->query;

        // ->orderBy('id');
    }

    public function chunkSize(): int
    {
        return 200;
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
            ->mapWithKeys(static function (mixed $field, int|string $_key) use ($rowArray): array {
                $keyString = \is_string($field) ? $field : (string) $field;

                return [$keyString => $rowArray[$keyString] ?? null];
            })
            ->toArray();
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

        if (\is_array($row)) {
            /* @var array<int|string, mixed> */
            return $row;
        }

        if ($row instanceof Traversable) {
            /* @var array<int|string, mixed> */
            return iterator_to_array($row);
        }

        return (array) $row;
    }
}
