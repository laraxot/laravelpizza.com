<?php

declare(strict_types=1);

namespace Modules\Sigma\Tests\TestModels;

use Illuminate\Support\Facades\File;
use League\Csv\Reader;
use League\Csv\Writer;
use Modules\Sigma\Models\WebService as BaseWebService;
use Modules\Sigma\Tests\TestTraits\TestSushiToCsv;

class TestWebService extends BaseWebService
{
    use TestSushiToCsv;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'endpoint',
        'description',
        'is_active',
    ];

    /**
     * Save the model to the database.
     *
     * @return bool
     */
    public function save(array $options = [])
    {
        // Get the CSV path
        $csvPath = $this->getCsvPath();

        // Read existing data
        $rows = [];
        if (File::exists($csvPath)) {
            $csv = Reader::createFromPath($csvPath, 'r');
            $csv->setHeaderOffset(0);
            $rows = iterator_to_array($csv->getRecords());
        } else {
            // Create the CSV file with headers if it doesn't exist
            File::put($csvPath, "id,name,endpoint,description,is_active,created_at,updated_at,created_by,updated_by\n");
        }

        // Set timestamps
        $now = now()->toDateTimeString();
        if (! $this->exists) {
            $this->created_at = $now;
            $this->updated_at = $now;
            $this->id = count($rows) > 0 ? max(array_column($rows, 'id')) + 1 : 1;
        } else {
            $this->updated_at = $now;
        }

        // Prepare the row data
        $rowData = [
            'id' => $this->id,
            'name' => $this->name,
            'endpoint' => $this->endpoint,
            'description' => $this->description ?? '',
            'is_active' => $this->is_active ? '1' : '0',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by ?? '1',
            'updated_by' => $this->updated_by ?? '1',
        ];

        // Add or update the row
        if (! $this->exists) {
            $rows[] = $rowData;
        } else {
            foreach ($rows as $key => $row) {
                if ((int) $row['id'] !== (int) $this->id) {
                    continue;
                }

                $rows[$key] = $rowData;
                break;
            }
        }

        // Write back to CSV
        $csv = Writer::createFromString('');
        $csv->insertOne(['id', 'name', 'endpoint', 'description', 'is_active', 'created_at', 'updated_at', 'created_by', 'updated_by']);

        foreach ($rows as $row) {
            $csv->insertOne($row);
        }

        File::put($csvPath, $csv->toString());

        $this->exists = true;

        return true;
    }

    /**
     * Get the first model matching the attributes or create it.
     *
     * @return static
     */
    public static function firstOrCreate(array $attributes, array $values = [])
    {
        $instance = new static($attributes + $values);
        $instance->save();

        return $instance;
    }
}
