<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Illuminate\Support\Facades\Auth;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

abstract class BaseAuthWidget extends XotBaseWidget
{
    /** @var array<string, mixed>|null */
    public ?array $data = [];

    /**
     * @return array<string, mixed>
     */
    abstract public function getFormSchema(): array;

    public function mount(): void
    {
        if (Auth::check()) {
            redirect()->intended(route('dashboard'));
        }
    }

    /**
     * Restituisce i dati per la view.
     * In Filament v3/Xot, il form va gestito tramite getFormSchema().
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'form' => $this->getFormSchema(),
        ];
    }
}
