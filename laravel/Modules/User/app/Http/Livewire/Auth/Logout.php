<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Auth;

use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

/**
 * Componente Livewire per la gestione del logout.
 *
 * Questo componente gestisce il processo di logout in modo sicuro:
 * - Emette eventi pre e post logout
 * - Gestisce gli errori in modo robusto
 * - Mantiene un log delle operazioni
 * - Invalida e rigenera la sessione
 */
class Logout extends Component
{
    use WithRateLimiting;

    /**
     * Esegui logout, invalidazione sessione e redirect.
     */
    public function mount(): ?RedirectResponse
    {
        try {
            // Rate limit
            $this->rateLimit(5);

            // Ottieni l'utente prima del logout per il logging
            $user = Auth::user();

            // Emetti evento pre-logout
            Event::dispatch('auth.logout.attempting', [$user]);

            // Esegui logout
            Auth::logout();

            // Invalida e rigenera la sessione
            session()->invalidate();
            session()->regenerateToken();

            // Emetti evento post-logout
            Event::dispatch('auth.logout.successful');

            // Log per audit
            if ($user) {
                Log::info('User logged out successfully', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                ]);
            }

            // Redirect alla pagina di login
            return redirect()->route('login');
        } catch (\Exception $e) {
            Log::error('Logout failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            session()->flash('error', __('Si è verificato un errore durante il logout'));

            return redirect()->back();
        }
    }

    /**
     * Renderizza il componente.
     */
    public function render(): View
    {
        /** @var view-string $viewName */
        $viewName = 'user::livewire.auth.logout';

        return view($viewName);
    }
}
