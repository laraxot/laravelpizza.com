<?php
declare(strict_types=1);
use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $container0;
    public string $slug0;
    public array $data = [];
    
    public string $pageSlug = '';

    public function mount(): void
    {
        $this->pageSlug = $this->container0 . '.view';
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
        <x-page 
            side="content" 
            :slug="$this->pageSlug" 
            :data="$this->data"
            :container0="$this->container0"
            :slug0="$this->slug0"
        />
    </div>
    @endvolt
</x-layouts.app>
