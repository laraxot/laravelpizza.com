<?php

declare(strict_types=1);

use Livewire\Volt\Component;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['guest']);
name('register');

new class extends Component {
    // Logic is handled by the widget
};

?>

<x-layouts.guest>
    <x-slot name="title">
        {{ __('user::login.actions.register.label') }}
    </x-slot>
    
    @livewire(\Modules\User\Filament\Widgets\Auth\RegisterWidget::class)

</x-layouts.guest>
