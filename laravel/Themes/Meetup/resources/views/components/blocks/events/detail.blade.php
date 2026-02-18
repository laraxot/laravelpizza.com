<?php
declare(strict_types=1);

/**
 * Event detail block - Volt Component
 * 
 * Pattern semplice: carica Event da slug0 se non passato come prop
 * Accesso diretto: $this->event->title, etc.
 */

use Livewire\Volt\Component;
use Modules\Meetup\Models\Event;

new class extends Component {
    /** Event passato come prop dal CMS resolver */
    public ?Event $event = null;
    
    /** Container0 dalla route */
    public string $container0 = '';
    
    /** Slug dalla route */
    public string $slug0 = '';

    public function mount(): void
    {
        if ($this->event === null && $this->slug0 !== '') {
            $this->event = Event::where('slug', $this->slug0)->first();
        }
    }
}; ?>
