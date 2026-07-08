<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Support\Arr;
use League\Csv\Reader;
use League\Csv\Writer;
use Modules\Tenant\Services\TenantService;
use RuntimeException;
use Stringable;
use Sushi\Sushi;
use Webmozart\Assert\Assert;

/** @phpstan-ignore trait.unused */
trait SushiToCsv
{
    use Sushi;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getSushiRows(): array
    {
        $csv = Reader::createFromPath($this->getCsvPath(), 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        $rows = iterator_to_array($records);

        $normalized = [];
        foreach (array_values($rows) as $row) {
            if (! is_array($row)) {
                continue;
            }

            $typedRow = [];
            foreach ($row as $key => $value) {
                $typedRow[(string) $key] = $value;
            }

            $normalized[] = $typedRow;
        }

        return $normalized;
    }

    public function getCsvPath(): string
    {
        $tbl = $this->getTable();
        if (! is_string($tbl)) {
            throw new RuntimeException('Table name must be a string');
        }

        return TenantService::filePath($tbl.'.csv');
    }

    /**
     * @return list<string>
     */
    public function getCsvHeader(): array
    {
        $reader = Reader::createFromPath($this->getCsvPath(), 'r');
        $reader->setHeaderOffset(0);

        return array_values($reader->getHeader());
    }

    protected static function bootSushiToCsv(): void
    {
        static::creating(static function ($model): void {
            Assert::isInstanceOf($model, self::class);
            self::handleCsvCreating($model);
        });

        static::updating(static function ($model): void {
            Assert::isInstanceOf($model, self::class);
            self::handleCsvUpdating($model);
        });

        static::deleting(static function ($model): void {
            Assert::isInstanceOf($model, self::class);
            self::handleCsvDeleting($model);
        });
    }

    /**
     * @param  self  $model
     */
    private static function handleCsvCreating(self $model): void
    {
        /** @var int $maxId */
        $maxId = $model->max('id') ?? 0;
        $model->id = $maxId + 1;
        $model->updated_at = now();
        $authIdInt = self::resolveAuthIdInt();
        $model->updated_by = $authIdInt;
        $model->created_at = now();
        $model->created_by = $authIdInt;

        $writer = Writer::createFromPath($model->getCsvPath(), 'a+');
        /** @var array<string, mixed> $modelData */
        $modelData = $model->toArray();
        $writer->insertOne(self::buildCsvItemFromData($modelData, $model->getCsvHeader()));
    }

    /**
     * @param  self  $model
     */
    private static function handleCsvUpdating(self $model): void
    {
        $rowsByKey = self::keyRowsById($model->getSushiRows());
        $idKey = self::resolveRowIdKey($model->getKey());
        $model->updated_at = now();
        $model->updated_by = self::resolveAuthIdInt();

        Assert::keyExists($rowsByKey, $idKey);
        /** @var array<string, mixed> $existingRow */
        $existingRow = $rowsByKey[$idKey] ?? [];
        /** @var array<string, mixed> $mergedRow */
        $mergedRow = array_merge($existingRow, $model->toArray());
        $rowsByKey[$idKey] = $mergedRow;

        /** @var array<int|string, array<string, mixed>> $typedRowsByKey */
        $typedRowsByKey = $rowsByKey;

        self::writeCsvFromRows($model, $typedRowsByKey, array_keys($mergedRow));
    }

    /**
     * @param  self  $model
     */
    private static function handleCsvDeleting(self $model): void
    {
        $rowsByKey = self::keyRowsById($model->getSushiRows());
        $idKey = self::resolveRowIdKey($model->getKey());
        Assert::keyExists($rowsByKey, $idKey);
        unset($rowsByKey[$idKey]);

        self::writeCsvFromRows($model, $rowsByKey, $model->getCsvHeader());
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     *
     * @return array<int|string, array<string, mixed>>
     */
    private static function keyRowsById(array $rows): array
    {
        /** @var array<int|string, array<string, mixed>> $rowsByKey */
        $rowsByKey = [];

        foreach (Arr::keyBy($rows, 'id') as $key => $row) {
            if (! is_array($row)) {
                continue;
            }

            /** @var array<string, mixed> $typedRow */
            $typedRow = $row;
            $rowsByKey[$key] = $typedRow;
        }

        return $rowsByKey;
    }

    private static function resolveAuthIdInt(): ?int
    {
        $authId = authId();

        return $authId !== null ? (int) $authId : null;
    }

    private static function resolveRowIdKey(mixed $id): int|string
    {
        Assert::notNull($id);
        if (is_int($id)) {
            return $id;
        }
        if (is_string($id)) {
            return is_numeric($id) ? (int) $id : $id;
        }
        Assert::scalar($id);

        return (string) $id;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $header
     *
     * @return array<string, float|int|string|null>
     */
    private static function buildCsvItemFromData(array $data, array $header): array
    {
        /** @var array<string, float|int|string|null> $item */
        $item = [];
        foreach ($header as $name) {
            if (! is_string($name)) {
                continue;
            }
            $value = $data[$name] ?? null;
            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            }
            $item[$name] = is_scalar($value) || $value === null ? $value : (string) $value;
        }

        return $item;
    }

    /**
     * @param  array<int|string, array<string, mixed>>  $rowsByKey
     * @param  list<string>  $header
     */
    private static function writeCsvFromRows(self $model, array $rowsByKey, array $header): void
    {
        $writer = Writer::createFromPath($model->getCsvPath(), 'w+');
        $writer->insertOne($header);
        $writer->insertAll(self::normalizeRowsForCsv($rowsByKey));
    }

    /**
     * @param  array<int|string, array<string, mixed>>  $rowsByKey
     *
     * @return list<array<string, float|int|string|Stringable|null>>
     */
    private static function normalizeRowsForCsv(array $rowsByKey): array
    {
        /** @var list<array<string, float|int|string|Stringable|null>> $dataArray */
        $dataArray = [];
        foreach ($rowsByKey as $row) {
            /** @var array<string, float|int|string|Stringable|null> $cleanRow */
            $cleanRow = [];
            foreach ($row as $key => $value) {
                if (! is_string($key) && ! is_int($key)) {
                    continue;
                }
                $normalizedValue = is_bool($value) ? ($value ? '1' : '0') : $value;
                $cleanRow[(string) $key] = is_scalar($normalizedValue) || $normalizedValue === null
                    ? $normalizedValue
                    : (string) $normalizedValue;
            }
            $dataArray[] = $cleanRow;
        }

        return $dataArray;
    }
}
