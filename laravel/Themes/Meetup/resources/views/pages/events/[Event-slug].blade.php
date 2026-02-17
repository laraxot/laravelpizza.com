<?php

declare(strict_types=1);

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Meetup\Models\Event;

name('events.show');

new class extends Component
{
    public Event $event;

    public function mount(Event $event): void
    {
        $this->event = $event;
    }
};

?>

<x-layouts.app>
    @volt('events.show')
    <div class="py-12 bg-slate-900 min-h-screen">
        <x-blocks.events.detail :event="$event" />
    </div>
    @endvolt
</x-layouts.app>
