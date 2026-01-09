<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

use Modules\User\Models\Role;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputOption;

class AssignModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'user:assign-module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign or revoke modules to/from user';

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

        if (! $user) {
            $this->error("User with email '{$email}' not found.");

            return;
        }

        // Get all available modules
        $modules_opts = array_keys(Module::all());
        $modules_opts = array_combine($modules_opts, $modules_opts);

        // Get user's current module roles
        // $userModuleRoles = $this->getUserModuleRoles($user);
        $userModuleRoles = $user->getModules();
        $currentModules = array_keys($userModuleRoles);

        // Show current modules as default selected
        $this->info("Current modules for {$email}: ".implode(', ', $currentModules));

        $selectedModules = multiselect(
            label: 'Select modules (checked = assigned, unchecked = will be revoked)',
            options: $modules_opts,
            default: $currentModules, // Show current modules as checked
            required: false, // Allow empty selection
            scroll: 10,
        );

        // Determine modules to assign and revoke
        $modulesToAssign = array_diff($selectedModules, $currentModules);
        $modulesToRevoke = array_diff($currentModules, $selectedModules);

        // Assign new modules
        foreach ($modulesToAssign as $module) {
            $module_low = Str::lower(is_string($module) ? $module : ((string) $module));
            $role_name = $module_low.'::admin';

            // Create or get the role with the web guard
            $role = Role::firstOrCreate(['name' => $role_name], []);

            // Assign the role to the user
            $user->assignRole($role);

            $this->info("✓ Assigned module: {$module}");
        }

        // Revoke unchecked modules
        foreach ($modulesToRevoke as $module) {
            $module_low = Str::lower(is_string($module) ? $module : ((string) $module));
            $role_name = $module_low.'::admin';

            // Revoke the role from the user
            $user->removeRole($role_name);

            $this->warn("✗ Revoked module: {$module}");
        }

        // Summary
        if (empty($modulesToAssign) && empty($modulesToRevoke)) {
            $this->info('No changes made to user modules.');
        } else {
            $this->info("Module assignment updated for {$email}");
        }
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

    /*
     * Get user's current module roles.
     *
     * @return array<string, string>

    private function getUserModuleRoles(UserContract $user): array
    {
        $moduleRoles = [];

        //@var Collection<int, Role> $roles
        $roles = $user->roles()->get();
        foreach ($roles as $role) {
            if (Str::endsWith($role->name, '::admin')) {
                $moduleName = Str::before($role->name, '::admin');
                $moduleRoles[$moduleName] = $role->name;
            }
        }

        return $moduleRoles;
    }
        */
}
