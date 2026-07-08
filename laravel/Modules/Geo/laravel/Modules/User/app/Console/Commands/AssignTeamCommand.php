<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

use Modules\User\Models\BaseUser;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;

class AssignTeamCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $name = 'user:assign-team';

    /**
     * The console command description.
     */
    protected $description = 'Assign a team to user';

    /**
     * Create a new command instance.
     */

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $xot = XotData::make();
        $email = text('email ?');
        $user = XotData::make()->getUserByEmail($email);
        Assert::isInstanceOf($user, BaseUser::class);

        $teamClass = $xot->getTeamClass();

        /** @var array<int|string, string> $opts */
        $opts = $teamClass::pluck('name', 'id')->toArray();

        $rows = multiselect(
            label: 'What teams',
            options: $opts,
            required: true,
            scroll: 10,
            // validate: function (array $values) {
            //  return ! \in_array(\count($values), [1, 2], false)
            //    ? 'A maximum of two'
            //  : null;
            // }
        );

        $user->membershipTeams()->sync($rows);
        /*
         * foreach ($rows as $row) {
         * $role = Role::firstOrCreate(['name' => $row]);
         * $user->assignRole($role);
         * }
         */
        $this->info('Teams :'.implode(', ', $rows).' assigned to '.$email);

        $rows = $user->membershipTeams()->get()->toArray();

        if (\count($rows) > 0) {
            Assert::isArray($rows[0]);
            $headers = array_keys($rows[0]);

            $this->newLine();
            $this->table($headers, $rows);
            $this->newLine();
        } else {
            $this->newLine();
            $this->warn('⚡ No teams ['.$teamClass.']');
            $this->newLine();
        }
    }

    /*
     * Get the console command options.
     */
    // protected function getOptions(): array
    // {
    //    return [
    //        ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
    //    ];
    // }
}
