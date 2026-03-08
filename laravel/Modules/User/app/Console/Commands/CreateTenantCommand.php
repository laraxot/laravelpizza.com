<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\text;

use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;

class CreateTenantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:tenant-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a tenant';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $modelClass = XotData::make()->getTenantClass();

        $name = text(
            label: 'What is name of tenant?',
            placeholder: 'E.g. Tabacchi belli',
            // default: $user->name,
            // hint: 'This will be displayed on your profile.'
        );

        $modelClass::create([
            'name' => $name,
        ]);

        $map = static fn (Model $row) => $row->toArray();

        $rows = $modelClass::get()->map($map);

        if (\count($rows) > 0) {
            $first = $rows[0];
            Assert::isArray($first);
            $headers = array_keys($first);

            // @var mixed newLine(;
            // @var mixed table($headers, $rows;
            // @var mixed newLine(;
        }
        // @var mixed newLine(;
        // @var mixed warn('⚡ No Tenants ['.$modelClass.']';
        // @var mixed newLine(;
    }
}
