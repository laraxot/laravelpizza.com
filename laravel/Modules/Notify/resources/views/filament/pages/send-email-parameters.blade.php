<?php

declare(strict_types=1);

?>
<x-filament::page>
    <form wire:submit="sendEmail">
        {{ // @var mixed emailForm }}

        <x-filament::actions :actions="// @var mixed getEmailFormActions(

        <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="sendEmail" />
    </form>
</x-filament::page>
