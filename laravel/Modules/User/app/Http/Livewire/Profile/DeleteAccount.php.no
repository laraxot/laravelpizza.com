<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Profile;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\User\Actions\User\DeleteUserAction;

class DeleteAccount extends Component
{
    public string $delete_confirm_password = '';

    public function render(): View
    {
        return view('user::livewire.profile.delete-account');
    }

    public function destroy(): void
    {
        $user = Auth::user();
        if (!$user) {
            $this->dispatch('toast', [
                'message' => 'Utente non trovato',
                'type' => 'error'
            ]);
            return;
        }

        $result = app(DeleteUserAction::class)->execute($user, $this->delete_confirm_password);

        if (!$result['success']) {
            $this->dispatch('toast', [
                'message' => $result['message'],
                'type' => 'error'
            ]);
            $this->reset(['delete_confirm_password']);
            return;
        }

        $this->redirect('/');
    }
}
