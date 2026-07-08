<?php

declare(strict_types=1);

namespace Modules\Progressioni\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class CedDiffImport implements ToCollection
{
    /** @var array<int, mixed> */
    protected array $columns = [];

    /**
     * @param Collection<int, array<int, mixed>|Collection<int, mixed>> $rows
     */
    public function collection(Collection $rows): void
    {
        $firstRow = $rows->first();

        if ($firstRow instanceof Collection) {
            $this->columns = array_values($firstRow->toArray());

            return;
        }

        if (is_array($firstRow)) {
            $this->columns = array_values($firstRow);

            return;
        }

        $this->columns = [];
    }

    /**
     * @return array<int, array{name: string, type: string}>
     */
    public function getColumns(): array
    {
        return array_map(static function ($column): array {
            $name = Str::of((string) $column)->slug('_')->toString();

            return [
                'name' => $name,
                'type' => 'string',
            ];
        }, $this->columns);
    }
}