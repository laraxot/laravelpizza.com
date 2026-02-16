<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Nwidart\Modules\Contracts\RepositoryInterface;
use Illuminate\Console\Command;
use Modules\User\Models\Role;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

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

    public function __construct(
        private readonly RepositoryInterface $moduleRepository,
        private readonly Role $roleModel,
    ) {
        parent::__construct();
    }

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
        /** @var array<string, mixed> $allModules */
        $allModules = $this->moduleRepository->all();
        
        // Ensure $allModules is an array for PHPStan
        if (! is_array($allModules)) {
            $this->error('Unable to retrieve modules.');
            return;
        }
        
        $moduleKeys = array_map('strval', array_keys($allModules));
        /** @var array<int|string, string> $modulesOpts */
        $modulesOpts = array_combine($moduleKeys, $moduleKeys);

        // Get user's current module roles
        // $userModuleRoles = $this->getUserModuleRoles($user);
        $userModuleRoles = $user->getModules();
        $currentModules = is_array($userModuleRoles) ? array_keys($userModuleRoles) : [];

        // Show current modules as default selected
        $this->info('Current modules for '.$email.': '.implode(', ', $currentModules));

        $selectedModules = multiselect(
            label: 'Select modules (checked = assigned, unchecked = will be revoked)',
            options: $modulesOpts,
            default: $currentModules, // Show current modules as checked
            required: false, // Allow empty selection
            scroll: 10,
        );

        // Determine modules to assign and revoke
        $modulesToAssign = array_diff($selectedModules, $currentModules);
        $modulesToRevoke = array_diff($currentModules, $selectedModules);

        // Assign new modules
        foreach ($modulesToAssign as $module) {
            $module_low = strtolower(is_string($module) ? $module : ((string) $module));
            $role_name = $module_low.'::admin';

            // Create or get the role with the web guard
            $role = $this->roleModel->firstOrCreate(['name' => $role_name], []);

            // Assign the role to the user
            $user->assignRole($role);

            $this->info("✓ Assigned module: {$module}");
        }

        // Revoke unchecked modules
        foreach ($modulesToRevoke as $module) {
            $module_low = strtolower(is_string($module) ? $module : ((string) $module));
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

    /*
     * Get the console command options.
     */
    // protected function getOptions(): array
    // {
    //    return [
    //        ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
    //    ];
    // }

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
            if (strtolower(is_string($role->name) ? $role->name : ((string) $role->name)) === strtolower(is_string($moduleName) ? $moduleName : ((string) $moduleName)).'::admin') { // Corrected Str::endsWith and Str::before
                $moduleName = str_before($role->name, '::admin');
                $moduleRoles[$moduleName] = $role->name;
            }
        }

        return $moduleRoles;
    }
        */
}
