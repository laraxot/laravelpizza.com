<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;

/**
 * PassportInstallCommand: Comando per installare e configurare Passport.
 *
 * Esegue i comandi necessari per installare Passport e configurare le chiavi.
 */
class PassportInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'user:passport:install
                            {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     */
    protected $description = 'Install and configure Laravel Passport for the User module';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Installing Laravel Passport...');

        // Esegui il comando standard di Passport per installare le chiavi
        $this->call('passport:install', [
            '--force' => $this->option('force'),
        ]);

        $this->info('Passport installed successfully!');
        $this->newLine();
        $this->info('Next steps:');
        $this->line('1. Configure your OAuth scopes in config/user/passport.php');
        $this->line('2. Create OAuth clients using the Filament admin panel');
        $this->line('3. Use the Passport actions to manage tokens programmatically');

        return Command::SUCCESS;
    }
}
