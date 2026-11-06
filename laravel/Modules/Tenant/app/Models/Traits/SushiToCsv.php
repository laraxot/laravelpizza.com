<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use League\Csv\Reader;
use League\Csv\Writer;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Stringable;
use Sushi\Sushi;
use Webmozart\Assert\Assert;

trait SushiToCsv
{
    use Sushi;
    use SushiConnectionByName;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getSushiRows(): array
    {
        $csv = Reader::from($this->getCsvPath(), 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        $rows = iterator_to_array($records);

        $normalized = [];
        foreach (array_values($rows) as $row) {
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
        return app(GetTenantFilePathAction::class)->execute($this->getTable().'.csv');
    }

    /**
     * @return list<string>
     */
    public function getCsvHeader(): array
    {
        $reader = Reader::from($this->getCsvPath(), 'r');
        $reader->setHeaderOffset(0);

        return array_values($reader->getHeader());
    }

    protected static function bootSushiToCsv(): void
    {
        static::creating(static function (Model $model): void {
            Assert::isInstanceOf($model, self::class);
            self::handleCsvCreating($model);
        });

        static::updating(static function (Model $model): void {
            Assert::isInstanceOf($model, self::class);
            self::handleCsvUpdating($model);
        });

        static::deleting(static function (Model $model): void {
            Assert::isInstanceOf($model, self::class);
            self::handleCsvDeleting($model);
        });
    }

    private static function handleCsvCreating(self $model): void
    {
        $maxId = $model->max('id');
        $maxIdInt = filter_var($maxId, FILTER_VALIDATE_INT);
        if ($maxIdInt === false) {
            $maxIdInt = 0;
        }
        $model->setAttribute('id', $maxIdInt + 1);
        $model->setAttribute('updated_at', now());
        $authIdInt = self::resolveAuthIdInt();
        $model->setAttribute('updated_by', $authIdInt);
        $model->setAttribute('created_at', now());
        $model->setAttribute('created_by', $authIdInt);

        $writer = Writer::from($model->getCsvPath(), 'a+');
        /** @var array<string, mixed> $modelData */
        $modelData = $model->toArray();
        $writer->insertOne(self::buildCsvItemFromData($modelData, $model->getCsvHeader()));
    }

    private static function handleCsvUpdating(self $model): void
    {
        $rowsByKey = self::keyRowsById($model->getSushiRows());
        $idKey = self::resolveRowIdKey($model->getKey());
        $model->setAttribute('updated_at', now());
        $model->setAttribute('updated_by', self::resolveAuthIdInt());

        Assert::keyExists($rowsByKey, $idKey);
        /** @var array<string, mixed> $existingRow */
        $existingRow = $rowsByKey[$idKey];
        /** @var array<string, mixed> $mergedRow */
        $mergedRow = array_merge($existingRow, $model->toArray());
        $rowsByKey[$idKey] = $mergedRow;

        /** @var array<int|string, array<string, mixed>> $typedRowsByKey */
        $typedRowsByKey = $rowsByKey;

        self::writeCsvFromRows($model, $typedRowsByKey, array_keys($mergedRow));
    }

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

    /**
     * @param  mixed  $id  Raw model key from Model::getKey() (int|string expected)
     */
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
            $item[$name] = self::csvValue($data[$name] ?? null);
        }

        return $item;
    }

    /**
     * @param  array<int|string, array<string, mixed>>  $rowsByKey
     * @param  list<string>  $header
     */
    private static function writeCsvFromRows(self $model, array $rowsByKey, array $header): void
    {
        $writer = Writer::from($model->getCsvPath(), 'w+');
        $writer->insertOne($header);
        $writer->insertAll(self::normalizeRowsForCsv($rowsByKey));
    }

    /**
     * @param  array<int|string, array<string, mixed>>  $rowsByKey
     * @return list<array<string, float|int|string|null>>
     */
    private static function normalizeRowsForCsv(array $rowsByKey): array
    {
        /** @var list<array<string, float|int|string|null>> $dataArray */
        $dataArray = [];
        foreach ($rowsByKey as $row) {
            /** @var array<string, float|int|string|null> $cleanRow */
            $cleanRow = [];
            foreach ($row as $key => $value) {
                $cleanRow[(string) $key] = self::csvValue($value);
            }
            $dataArray[] = $cleanRow;
        }

        return $dataArray;
    }

    /**
     * @param  mixed  $value  Arbitrary model attribute (scalar|Stringable|null expected)
     */
    private static function csvValue(mixed $value): float|int|string|null
    {
        if ($value === null) {
            return null;
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        if (is_int($value) || is_float($value) || is_string($value)) {
            return $value;
        }

        if ($value instanceof Stringable) {
            return $value->__toString();
        }

        return null;
    }
}
