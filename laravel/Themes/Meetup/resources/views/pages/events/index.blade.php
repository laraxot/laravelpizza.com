<?php

declare(strict_types=1);

use function Laravel\Folio\name;
use Livewire\Volt\Component;

name('events.index');

new class extends Component
{
    public string $slug = 'events';
};

?>

<x-layouts.app>
    @volt('events.index')
    <div>
        <x-page side="content" slug="events" />
    </div>
    @endvolt
</x-layouts.app>
