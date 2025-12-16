<?php

/**
 * @see https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 */

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Support\Arr;
use League\Csv\Reader;
use League\Csv\Writer;
use Modules\Tenant\Services\TenantService;
use Sushi\Sushi;
use Stringable;
use Webmozart\Assert\Assert;

trait SushiToCsv
{
    use Sushi;

    public function getSushiRows(): array
    {
        // return CSV::fromFile(__DIR__.'/roles.csv')->toArray();
        // load the CSV document from a file path
        $csv = Reader::createFromPath($this->getCsvPath(), 'r');
        // $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        // returns all the records as
        $records = $csv->getRecords(); // an Iterator object containing arrays
        // $records = $csv->getRecordsAsObject(MyDTO::class); // an Iterator object containing MyDTO objects
        $rows = iterator_to_array($records);

        return array_values($rows);
    }

    public function getCsvPath(): string
    {
        $tbl = $this->getTable();
        if (! is_string($tbl)) {
            throw new \RuntimeException('Table name must be a string');
        }
        $file = $tbl.'.csv';

        return TenantService::filePath($file);
    }

    public function getCsvHeader(): array
    {
        $reader = Reader::createFromPath($this->getCsvPath(), 'r');
        $reader->setHeaderOffset(0);

        return $reader->getHeader();
    }

    /**
     * bootUpdater function.
     */
    protected static function bootSushiToCsv(): void
    {
        /*
         * During a model create Eloquent will also update the updated_at field so
         * need to have the updated_by field here as well.
         */
        static::creating(
            /**
             * @param self $model
             */
            function ($model): void {
                Assert::isInstanceOf($model, self::class);
                /** @var int $maxId */
                $maxId = $model->max('id') ?? 0;
                $model->id = $maxId + 1;
                $model->updated_at = now();
                $authId = authId();
                /** @var int|null $authIdInt */
                $authIdInt = $authId !== null ? (int) $authId : null;
                $model->updated_by = $authIdInt;
                $model->created_at = now();
                $model->created_by = $authIdInt;

                $data = $model->toArray();
                $csvPath = $model->getCsvPath();
                $writer = Writer::createFromPath($csvPath, 'a+');
                $header = $model->getCsvHeader();

                /** @var array<string, float|int|string|null> $item */
                $item = [];
                foreach ($header as $name) {
                    if (! is_string($name)) {
                        continue;
                    }
                    $value = $data[$name] ?? null;
                    $item[$name] = is_scalar($value) || $value === null ? $value : (string) $value;
                }

                $writer->insertOne($item);
            }
        );
        /*
         * updating.
         */
        static::updating(
            /**
             * @param self $model
             */
            function ($model): void {
                Assert::isInstanceOf($model, self::class);
                $rows = $model->getSushiRows();
                /** @var array<int|string, array<string, mixed>> $rowsByKey */
                $rowsByKey = Arr::keyBy($rows, 'id');
                $id = $model->getKey();
                Assert::notNull($id);
                Assert::scalar($id);
                /** @var int|string $idKey */
                $idKey = is_numeric($id) && is_string($id) ? (int) $id : $id;
                $model->updated_at = now();
                $authId = authId();
                /** @var int|null $authIdInt */
                $authIdInt = $authId !== null ? (int) $authId : null;
                $model->updated_by = $authIdInt;
                /** @var array<string, mixed> $existingRow */
                $existingRow = $rowsByKey[$idKey] ?? [];
                /** @var array<string, mixed> $new */
                $new = array_merge($existingRow, $model->toArray());
                Assert::keyExists($rowsByKey, $idKey);
                $rowsByKey[$idKey] = $new;
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
                        $cleanRow[(string) $key] = is_scalar($normalizedValue) || $normalizedValue === null ? $normalizedValue : (string) $normalizedValue;
                    }
                    $dataArray[] = $cleanRow;
                }
                // $header=$model->getCsvHeader();
                $header = array_keys($new);
                $csvPath = $model->getCsvPath();
                $writer = Writer::createFromPath($csvPath, 'w+');
                $writer->insertOne($header);
                $writer->insertAll($dataArray);
            }
        );
        // -------------------------------------------------------------------------------------
        /*
         * Deleting a model is slightly different than creating or deleting.
         * For deletes we need to save the model first with the deleted_by field
         */

        static::deleting(
            /**
             * @param self $model
             */
            function ($model): void {
                Assert::isInstanceOf($model, self::class);
                $rows = $model->getSushiRows();
                /** @var array<int|string, array<string, mixed>> $rowsByKey */
                $rowsByKey = Arr::keyBy($rows, 'id');
                $id = $model->getKey();
                Assert::notNull($id);
                Assert::scalar($id);
                /** @var int|string $idKey */
                $idKey = is_numeric($id) && is_string($id) ? (int) $id : $id;
                Assert::keyExists($rowsByKey, $idKey);
                unset($rowsByKey[$idKey]);
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
                        $cleanRow[(string) $key] = is_scalar($normalizedValue) || $normalizedValue === null ? $normalizedValue : (string) $normalizedValue;
                    }
                    $dataArray[] = $cleanRow;
                }
                $header = $model->getCsvHeader();
                $csvPath = $model->getCsvPath();
                $writer = Writer::createFromPath($csvPath, 'w+');
                $writer->insertOne($header);
                $writer->insertAll($dataArray);
            }
        );

        // ----------------------
    }
}
