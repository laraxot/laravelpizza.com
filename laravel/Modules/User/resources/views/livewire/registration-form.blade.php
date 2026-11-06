<?php

declare(strict_types=1);
?>
<div>
    <form wire:submit="register">
        {{ $this->form }}
    </form>
    
    <div class="text-sm text-center text-gray-600 mt-6">
        {{ __('user::registration.already_registered') }} <a href="{{ route('login') }}" class="text-blue-800 hover:underline">{{ __('user::login.actions.login.label') }}</a>
    </div>
</div>
