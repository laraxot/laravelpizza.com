<?php

declare(strict_types=1);

namespace Modules\DbForge\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;
use Webmozart\Assert\Assert;

class SearchStringInDatabaseCommand extends Command
{
    protected $signature = 'db:search {search} {--table=*}';

    protected $description = 'Search for a string in database tables';

    public function handle(): int
    {
        $searchArg = $this->argument('search');
        $searchString = is_string($searchArg) ? $searchArg : '';
        $specificTables = $this->option('table');

        /** @var array<array{Tables_in_database: string}> $tables */
        $tables = DB::select('SHOW TABLES');
        Assert::isArray($tables);

        foreach ($tables as $table) {
            Assert::isArray($table);
            $tableName = (string) current($table);

            if (! empty($specificTables) && is_array($specificTables) && ! in_array($tableName, $specificTables, true)) {
                continue;
            }

            $this->searchInTable($tableName, $searchString);
        }

        return Command::SUCCESS;
    }

    private function searchInTable(string $tableName, string $searchString): void
    {
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        Assert::isArray($columns);

        $query = DB::table($tableName);
        foreach ($columns as $column) {
            $query->orWhere($column, 'LIKE', "%{$searchString}%");
        }

        $results = $query->get();
        if ($results->isNotEmpty()) {
            $this->info("Found matches in table: {$tableName}");
            $this->table(['Column', 'Value'], $this->formatResults($results));
        }
    }

    /**
     * @param  Collection<int, stdClass>  $results
     * @return array<int, array{string, string}>
     */
    private function formatResults(Collection $results): array
    {
        $formatted = [];
        $searchArg = $this->argument('search');
        $searchString = is_string($searchArg) ? $searchArg : '';

        foreach ($results as $row) {
            foreach ((array) $row as $column => $value) {
                if (is_string($value) && str_contains($value, $searchString)) {
                    $formatted[] = [$column, $value];
                }
            }
        }

        return $formatted;
    }
}
