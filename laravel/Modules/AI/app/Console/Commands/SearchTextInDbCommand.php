<?php

declare(strict_types=1);

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use function Safe\json_encode;

class SearchTextInDbCommand extends Command
{
    protected $signature = 'db:search-text {search : The text to search for} {--tables=* : Optional specific tables to search in}';

    protected $description = 'Search for text in all database tables or specific tables';

    public function handle(): int
    {
        $searchString = $this->argument('search');
        if (! is_string($searchString)) {
            $this->error('Search string must be a valid string');

            return Command::FAILURE;
        }

        $specificTables = $this->option('tables');
        $databaseName = DB::getDatabaseName();
        $tableProp = 'Tables_in_'.$databaseName;

        // Get tables either from specific option or all tables
        if (empty($specificTables) || ! is_array($specificTables)) {
            $tables = collect(DB::select('SHOW TABLES'));
        } else {
            $tables = collect($specificTables);
        }

        foreach ($tables as $table) {
            // Get table name with proper type checking
            $tableName = null;
            if (is_object($table)) {
                // Usa isset() invece di property_exists per oggetti stdClass
                if (isset($table->$tableProp) && is_string($table->$tableProp)) {
                    $tableName = $table->$tableProp;
                }
            } elseif (is_string($table)) {
                $tableName = $table;
            }

            if (! is_string($tableName)) {
                $this->warn('Invalid table name format');

                continue;
            }

            if (! Schema::hasTable($tableName)) {
                $this->warn(sprintf('Table %s does not exist', $tableName));

                continue;
            }

            $this->info(sprintf('Searching in table: %s', $tableName));

            /** @var array<string>|false $columns */
            $columns = Schema::getColumnListing($tableName);
            if (! is_array($columns)) {
                continue;
            }

            foreach ($columns as $column) {
                if (! is_string($column)) {
                    continue;
                }

                /** @var string|null $columnType */
                $columnType = Schema::getColumnType($tableName, $column);
                if (! is_string($columnType)) {
                    continue;
                }

                // Search only in string-like columns
                if (! in_array($columnType, ['string', 'text'])) {
                    continue;
                }

                // SECURITY NOTE: $tableName comes from SHOW TABLES metadata (not raw user input)
                // and is validated by Schema::hasTable() at line 57. $column comes from Schema::getColumnListing()
                // which returns actual column names — never interpolated. The search string is bound as a
                // parameter by Laravel's Query Builder, so there is NO interpolation into the SQL string.
                // addslashes() above would be redundant (and breaks LIKE % wildcard matching) because the
                // value is escaped server-side via parameter binding.
                $results = DB::table($tableName)
                    ->select('*')
                    ->where($column, 'LIKE', '%'.$searchString.'%')
                    ->get();

                if ($results->isNotEmpty()) {
                    $this->info("Found in column: {$column}");
                    foreach ($results as $result) {
                        $this->table(
                            ['Column', 'Value'],
                            collect((array) $result)
                                ->map(fn (mixed $value, int|string $key) => [
                                    (string) $key,
                                    is_scalar($value) ? (string) $value : json_encode($value),
                                ])
                                ->toArray()
                        );
                        $this->newLine();
                    }
                }
            }
        }

        return Command::SUCCESS;
    }
}
