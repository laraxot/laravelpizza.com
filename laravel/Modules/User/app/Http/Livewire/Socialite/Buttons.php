<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Socialite;

use Illuminate\View\View;
use Livewire\Component;

class Buttons extends Component
{
    /**
     * Renders the Livewire component for socialite login buttons.
     *
     * @return View the view to be rendered
     */
    public function render(): View
    {
        // $providers = FilamentSocialite::getProviderButtons();
        // Fetch the list of socialite providers from the configuration file.
        $providers = config('filament-socialite.providers');

        // If the providers configuration is not an array, initialize it as an empty array.
        if (! is_array($providers)) {
            $providers = [];
        }

        /** @var view-string $viewName */
        $viewName = 'user::livewire.socialite.buttons';

        // Return the view with the list of providers.
        return view($viewName, [
            'providers' => $providers,
        ]);
    }
}
