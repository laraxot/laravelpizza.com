<?php

declare(strict_types=1);

?>
<div>
    <form wire:submit="register">
        {{ $form }}
    </form>
    
    <div class="text-sm text-center text-gray-600 mt-6">
        Hai già un account? <a href="{{ route('login') }}" class="text-blue-800 hover:underline">Accedi</a>
    </div>
</div>
