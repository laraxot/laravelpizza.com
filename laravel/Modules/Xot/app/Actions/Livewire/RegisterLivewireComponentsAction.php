<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Livewire;

use Livewire\Livewire;
use Modules\Xot\Actions\File\GetComponentsAction;
use Spatie\QueueableAction\QueueableAction;

class RegisterLivewireComponentsAction
{
    use QueueableAction;

    public function execute(string $path, string $namespace, string $prefix = ''): void
    {
        $comps = app(GetComponentsAction::class)->execute($path, $namespace.'\Http\Livewire', $prefix);

        foreach ($comps as $comp) {
            Livewire::component($comp->name, $comp->ns);
        }
    }
}
