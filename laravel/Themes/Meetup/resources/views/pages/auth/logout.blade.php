<?php

use Modules\User\Models\User;
use Illuminate\Auth\Events\Login;
use function Laravel\Folio\{middleware, name};
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;


name('logout');


new class extends Component
{


    public function logout(): never
    {
        dd('a');
        app(LogoutUserAction::class)->execute(auth()->user());
    }
}

?>

<h1 wire:init="logout">goodbye</h1>
