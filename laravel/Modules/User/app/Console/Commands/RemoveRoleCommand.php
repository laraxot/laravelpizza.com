<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

use Modules\User\Models\Role;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Symfony\Component\Console\Input\InputOption;

class RemoveRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'user:remove-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove a role to user';

    /**
     * Create a new command instance.
     */

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = text('email ?');
        /**
         * @var UserContract $user
         */
        $user = XotData::make()->getUserByEmail($email);
        /** @var Collection<int, Role> $roles */
        $roles = $user->roles()->get();
        /** @var array<string, string> $opts */
        $opts = $roles->pluck('name', 'name')->toArray();

        $rows = multiselect(
            label: 'What roles',
            options: $opts,
            required: true,
            scroll: 10,
            // validate: function (array $values) {
            //  return ! \in_array(\count($values), [1, 2], false)
            //    ? 'A maximum of two'
            //  : null;
            // }
        );

        foreach ($rows as $row) {
            // $role = Role::firstOrCreate(['name' => $row]);
            // $user->assignRole($role);
            $user->removeRole($row);
        }

        $this->info(implode(', ', $rows).' dessigned to '.$email);
    }

    /**
     * Get the console command arguments.
     */
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
