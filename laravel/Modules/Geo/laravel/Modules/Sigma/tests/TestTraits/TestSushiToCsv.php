<?php

declare(strict_types=1);

namespace Modules\Sigma\Tests\TestTraits;

use Illuminate\Support\Facades\File;
use League\Csv\Reader;
use League\Csv\Writer;
use RuntimeException;
use Sushi\Sushi;

trait TestSushiToCsv
{
    use Sushi;

    protected static ?string $testCsvPath = null;

    /**
     * Indicates if the model should use the Sushi cache.
     *
     * @var bool
     */
    protected static $sushiCache = false;

    /**
     * Get the rows for the Sushi model.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    public static function setTestCsvPath(string $path): void
    {
        self::$testCsvPath = $path;

        // Ensure the directory exists
        $dir = dirname($path);
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        // Initialize with header if file doesn't exist
        if (! File::exists($path)) {
            File::put($path, "id,name,endpoint,description,is_active,created_at,updated_at,created_by,updated_by\n");
        }
    }

    public function getSushiRows(): array
    {
        if (self::$testCsvPath === null) {
            throw new RuntimeException('Test CSV path not set. Call setTestCsvPath() first.');
        }

        if (! File::exists(self::$testCsvPath)) {
            return [];
        }

        $csv = Reader::createFromPath(self::$testCsvPath, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        $rows = iterator_to_array($records);

        return array_values($rows);
    }

    public function getCsvPath(): string
    {
        if (self::$testCsvPath === null) {
            throw new RuntimeException('Test CSV path not set. Call setTestCsvPath() first.');
        }

        return self::$testCsvPath;
    }

    public function getCsvHeader(): array
    {
        if (! File::exists($this->getCsvPath())) {
            return ['id', 'name', 'endpoint', 'description', 'is_active', 'created_at', 'updated_at', 'created_by', 'updated_by'];
        }

        $reader = Reader::createFromPath($this->getCsvPath(), 'r');
        $reader->setHeaderOffset(0);

        return $reader->getHeader();
    }

    protected static function bootSushiToCsv(): void
    {
        static::creating(static function ($model): void {
            $model->id = (int) $model->max('id') + 1;
            $model->updated_at = now();
            $model->updated_by = 1; // Test user ID
            $model->created_at = now();
            $model->created_by = 1; // Test user ID

            $data = $model->toArray();
            $path = $model->getCsvPath();
            $header = $model->getCsvHeader();

            $item = [];
            foreach ($header as $name) {
                $value = $data[$name] ?? null;
                $item[$name] = $value;
            }

            $writer = Writer::createFromPath($path, 'a+');
            $writer->insertOne($item);
        });

        static::updating(static function ($model): void {
            $rows = $model->getSushiRows();
            $rows = array_column($rows, null, 'id');
            $id = $model->getKey();

            $model->updated_at = now();
            $model->updated_by = 1; // Test user ID

            $new = array_merge($rows[$id] ?? [], $model->toArray());
            $rows[$id] = $new;

            $writer = Writer::createFromPath($model->getCsvPath(), 'w+');
            $writer->insertOne($model->getCsvHeader());
            $writer->insertAll($rows);
        });
    }
}
