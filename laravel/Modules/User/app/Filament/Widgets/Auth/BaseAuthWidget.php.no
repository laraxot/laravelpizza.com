<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

abstract class BaseAuthWidget extends Widget
{
    public ?array $data = [];

    public function mount(): void
    {
        if (Auth::check()) {
            redirect()->intended(route('dashboard'));
        }
    }

    /**
     * Restituisce i dati per la view.
     * In Filament v3/Xot, il form va gestito tramite getFormSchema().
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'form' => $this->getFormSchema(),
        ];
    }
}
