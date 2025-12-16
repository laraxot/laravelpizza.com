<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class VoltServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $livewirePathRaw = config('livewire.view_path', resource_path('views/livewire'));
        $pagesPath = resource_path('views/pages');
        
        /** @var string $livewirePath */
        $livewirePath = is_string($livewirePathRaw) ? $livewirePathRaw : resource_path('views/livewire');
        
        $paths = [];
        if (is_dir($livewirePath)) {
            $paths[] = $livewirePath;
        }
        if (is_dir($pagesPath)) {
            $paths[] = $pagesPath;
        }
        
        if (!empty($paths)) {
            Volt::mount($paths);
        }
    }
}
