<?php

declare(strict_types=1);

?>
<x-filament::dropdown >
    <x-slot name="trigger" class="ml-4">
        <button @class([
            'flex flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 items-center justify-center',
            'dark:bg-gray-900' => config('filament.dark_mode'),
        ]) aria-label="{{ __('filament::layout.buttons.user_menu.label') }}">
            @svg('heroicon-o-users', 'w-4 h-4')
        </button>
    </x-slot>
    
    <x-filament::dropdown.list>
        @foreach ($teams as $team)
        <x-filament::dropdown.list.item wire:click="switchTeam({{ $team['id'] }})" :icon="$this->user->current_team_id==$team['id'] ? 'heroicon-o-check-circle' : ''">
            {{ $team['name'] }}
        </x-filament::dropdown.list.item>
        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>
