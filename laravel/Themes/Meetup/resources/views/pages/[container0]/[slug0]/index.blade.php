<?php
declare(strict_types=1);
use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    // Volt popola automaticamente queste proprietà dalla route Folio
    public string $container0;
    public string $slug0;
    // $data è INDISPENSABILE per passare variabili ai componenti inclusi
    // page-content.blade.php fa: array_merge($block->data, $this->data)
    public array $data = [];
    
    public string $pageSlug = '';

    public function mount(): void
    {
        // Volt ha già popolato $this->container0 e $this->slug0 automaticamente
        // Lo slug per il JSON è container0.view (es. events.view)
        // Questo permette di caricare il JSON template per il dettaglio del container
        $this->pageSlug = $this->container0 . '.view';
        
        // Popolare $this->data per passare variabili ai componenti inclusi
        // page-content.blade.php fa: array_merge($block->data, $this->data)
        $this->data = [
            'container0' => $this->container0,
            'slug0' => $this->slug0,
        ];
    }
};

?>

<x-layouts.app>
    @volt('container0.view')
    <div>
        <x-page side="content" :slug="$this->pageSlug" :data="$this->data" />
    </div>
    @endvolt
</x-layouts.app>
