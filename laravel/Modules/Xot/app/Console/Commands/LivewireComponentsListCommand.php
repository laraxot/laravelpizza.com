<?php

declare(strict_types=1);

/**
 * get all registered livewire components.
 *
 * @see ---
 */

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;

class LivewireComponentsListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xot:livewire-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = ' rilevare tutti i componenti registrati di Livewire';

    /**
     * Create a new command instance.
     */

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Call to undefined method Livewire\LivewireManager::getComponents()
        // $registeredComponents = Livewire::getComponents();
        // Stampa o manipola l'array di componenti come desiderato
        // print_r($registeredComponents);
        // dddx(get_class_methods(app(ComponentRegistry::class)));
        // $manifest = app(\Livewire\LivewireComponentsFinder::class)->getManifest();
        // dddx($manifest);
        // dddx(get_class_methods(app(HandleComponents::class)));
        // Ottieni tutti i componenti registrati
        // $registeredComponents = LivewireManager::getAliases();
        // Stampa o manipola l'array di componenti come desiderato
        // print_r($registeredComponents);
        // dddx(get_class_methods(app(LivewireManager::class)));
    }
}
