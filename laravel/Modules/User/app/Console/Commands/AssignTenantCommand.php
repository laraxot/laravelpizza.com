<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Symfony\Component\Console\Input\InputOption;

class AssignTenantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'user:assign-tenant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign a tenant to user';

    /**
     * Create a new command instance.
     */

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = text('email ?');
        $user_class = XotData::make()->getUserClass();
        /** @var UserContract */
        $user = XotData::make()->getUserByEmail($email);
        $xot = XotData::make();
        $tenantClass = $xot->getTenantClass();

        /** @var array<int|string, string>|Collection<int|string, string> */
        $opts = $tenantClass::all()->pluck('name', 'id')->toArray();

        $rows = multiselect(
            label: 'What tenant',
            options: $opts,
            required: true,
            scroll: 10,
            // validate: function (array $values) {
            //  return ! \in_array(\count($values), [1, 2], false)
            //    ? 'A maximum of two'
            //  : null;
            // }
        );

        $user->tenants()->sync($rows);
        /*
         * foreach ($rows as $row) {
         * $role = Role::firstOrCreate(['name' => $row]);
         * $user->assignRole($role);
         * }
         */
        $this->info(implode(', ', $rows).' assigned to '.$email);
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
