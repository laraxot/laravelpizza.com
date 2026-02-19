# Social Share Component

## Principio fondamentale

**NO pacchetti Composer per logica semplice.**

I link di condivisione social sono semplici URL con parametri query — puro PHP in meno di 10 righe. Nessun pacchetto serve. Si usa `XotBaseWidget` per il widget Filament e un componente Blade per la UI.

```php
// TUTTO quello che serve — PHP nativo, zero dipendenze
$url   = urlencode(LaravelLocalization::localizeUrl('/events/' . $event->slug));
$title = urlencode($event->title);

$shareUrls = [
    'facebook'  => "https://www.facebook.com/sharer/sharer.php?u={$url}",
    'twitter'   => "https://twitter.com/intent/tweet?text={$title}&url={$url}",
    'linkedin'  => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
    'whatsapp'  => "https://wa.me/?text={$title}+{$url}",
    'telegram'  => "https://t.me/share/url?url={$url}&text={$title}",
];
```

## Architettura

### Filament Widget (Seo Module)

```php
// Modules/Seo/app/Filament/Widgets/SocialShareWidget.php
namespace Modules\Seo\Filament\Widgets;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class SocialShareWidget extends XotBaseWidget
{
    protected static string $view = 'seo::widgets.social-share';

    public ?string $url   = null;
    public ?string $title = null;

    public function getShareUrls(): array
    {
        $encodedUrl   = urlencode($this->url ?? LaravelLocalization::localizeUrl(request()->path()));
        $encodedTitle = urlencode($this->title ?? '');

        return [
            'facebook'  => "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}",
            'twitter'   => "https://twitter.com/intent/tweet?text={$encodedTitle}&url={$encodedUrl}",
            'linkedin'  => "https://www.linkedin.com/sharing/share-offsite/?url={$encodedUrl}",
            'whatsapp'  => "https://wa.me/?text={$encodedTitle}+{$encodedUrl}",
            'telegram'  => "https://t.me/share/url?url={$encodedUrl}&text={$encodedTitle}",
        ];
    }
}
```

### Vista Widget

```blade
{{-- Modules/Seo/resources/views/widgets/social-share.blade.php --}}
<div class="flex flex-wrap gap-3">
    @foreach($this->getShareUrls() as $service => $url)
        <a href="{{ $url }}"
           target="_blank"
           rel="noopener noreferrer"
           class="inline-flex items-center justify-center w-10 h-10 rounded-full text-white transition-opacity hover:opacity-80"
           aria-label="{{ __('pub_theme::event.actions.share_event.label') }} {{ ucfirst($service) }}">
            <x-filament::icon :icon="'meetup-' . $service" class="w-5 h-5" />
        </a>
    @endforeach
</div>
```

### Uso in Volt/Blade

```blade
@livewire('seo.social-share-widget', [
    'url'   => LaravelLocalization::localizeUrl('/events/' . $event->slug),
    'title' => $event->title,
])
```

### Uso inline (senza widget) — nei blocchi Blade semplici

```blade
{{-- Direttamente nel template, senza widget --}}
@php
    $shareUrl   = urlencode(LaravelLocalization::localizeUrl('/events/' . $event->slug));
    $shareTitle = urlencode($event->title);
@endphp

<div class="flex gap-3">
    <a href="https://twitter.com/intent/tweet?text={{ $shareTitle }}&url={{ $shareUrl }}"
       target="_blank" rel="noopener noreferrer"
       class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
        Twitter
    </a>
    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}"
       target="_blank" rel="noopener noreferrer"
       class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-medium">
        LinkedIn
    </a>
    <a href="https://wa.me/?text={{ $shareTitle }}+{{ $shareUrl }}"
       target="_blank" rel="noopener noreferrer"
       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
        WhatsApp
    </a>
</div>
```

## Open Graph Meta Tags

Open Graph NON richiede pacchetti. Si aggiungono direttamente nel layout:

```blade
{{-- Themes/Meetup/resources/views/layouts/app.blade.php --}}
@if(isset($openGraph))
    <meta property="og:title"       content="{{ $openGraph['title'] }}">
    <meta property="og:description" content="{{ $openGraph['description'] ?? '' }}">
    <meta property="og:image"       content="{{ $openGraph['image'] ?? '' }}">
    <meta property="og:url"         content="{{ $openGraph['url'] ?? url()->current() }}">
    <meta property="og:type"        content="{{ $openGraph['type'] ?? 'website' }}">
    <meta name="twitter:card"       content="summary_large_image">
    <meta name="twitter:title"      content="{{ $openGraph['title'] }}">
    <meta name="twitter:description" content="{{ $openGraph['description'] ?? '' }}">
    <meta name="twitter:image"      content="{{ $openGraph['image'] ?? '' }}">
@endif
```

## Anti-pattern vietato

```bash
# ❌ MAI fare questo per logica semplice
composer require kudashevs/laravel-share-buttons
composer require spatie/laravel-feed
```

**Regola**: Prima di installare un pacchetto Composer, chiedi: _si può fare in meno di 20 righe di PHP nativo?_ Se sì → **non installare il pacchetto**.

I link social sono stringhe URL con `urlencode()`. Non serve libreria.

## Chiavi di traduzione

Struttura corretta in `Themes/Meetup/lang/{locale}/event.php`:

```php
'actions' => [
    'share_event' => [
        'label'       => 'Condividi evento',
        'tooltip'     => 'Condividi questo evento sui social o via link',
        'helper_text' => '',
        'description' => 'Avvia il processo di condivisione dell\'evento',
        'icon'        => 'heroicon-o-share',
        'color'       => 'primary',
    ],
],
```

## Riferimenti

- [LaravelLocalization](../../../Modules/Lang/docs/laravel-localization-mcamara.md)
- [XotBaseWidget](../../../Modules/Xot/docs/xotbase-extension-rules.md)
- [SVG Icons](../../../Modules/Meetup/docs/svg-icons-no-hardcoded-blade.md)

---

## Implementazione Completa - Widget Avanzato

### SocialShareWidget.php - Versione Produzione

```php
<?php

declare(strict_types=1);

namespace Modules\Seo\Filament\Widgets;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class SocialShareWidget extends XotBaseWidget
{
    protected static string $view = 'seo::widgets.social-share';

    public ?string $url = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $image = null;
    public array $enabledServices = ['facebook', 'twitter', 'linkedin', 'whatsapp', 'telegram', 'email', 'copy'];

    /**
     * Inizializza il widget con dati condivisibili
     */
    public function mount(array $data = []): void
    {
        $this->url = $data['url'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->image = $data['image'] ?? null;
        
        if (!empty($data['services'])) {
            $this->enabledServices = $data['services'];
        }
    }

    /**
     * Genera tutte le URL di condivisione
     *
     * @return array<string, array{url: string, label: string, color: string, icon: string}>
     */
    public function getShareUrls(): array
    {
        $url = $this->getEncodedUrl();
        $title = $this->getEncodedTitle();
        $description = $this->getEncodedDescription();

        $services = [
            'facebook' => [
                'url' => "https://www.facebook.com/sharer/sharer.php?u={$url}",
                'label' => __('seo::widgets.social_share.services.facebook'),
                'color' => 'bg-[#1877F2]',
                'icon' => 'heroicon-o-facebook',
            ],
            'twitter' => [
                'url' => "https://twitter.com/intent/tweet?text={$title}&url={$url}",
                'label' => __('seo::widgets.social_share.services.twitter'),
                'color' => 'bg-black dark:bg-white dark:text-black',
                'icon' => 'heroicon-o-x-mark', // X (Twitter)
            ],
            'linkedin' => [
                'url' => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
                'label' => __('seo::widgets.social_share.services.linkedin'),
                'color' => 'bg-[#0A66C2]',
                'icon' => 'heroicon-o-linkedin',
            ],
            'whatsapp' => [
                'url' => "https://wa.me/?text={$title}+{$url}",
                'label' => __('seo::widgets.social_share.services.whatsapp'),
                'color' => 'bg-[#25D366]',
                'icon' => 'heroicon-o-whatsapp',
            ],
            'telegram' => [
                'url' => "https://t.me/share/url?url={$url}&text={$title}",
                'label' => __('seo::widgets.social_share.services.telegram'),
                'color' => 'bg-[#26A5E4]',
                'icon' => 'heroicon-o-paper-airplane',
            ],
            'reddit' => [
                'url' => "https://www.reddit.com/submit?url={$url}&title={$title}",
                'label' => __('seo::widgets.social_share.services.reddit'),
                'color' => 'bg-[#FF4500]',
                'icon' => 'heroicon-o-reddit',
            ],
            'email' => [
                'url' => "mailto:?subject={$title}&body={$description}%0A%0A{$url}",
                'label' => __('seo::widgets.social_share.services.email'),
                'color' => 'bg-slate-600 dark:bg-slate-500',
                'icon' => 'heroicon-o-envelope',
            ],
            'copy' => [
                'url' => $this->getRawUrl(),
                'label' => __('seo::widgets.social_share.services.copy'),
                'color' => 'bg-slate-500 dark:bg-slate-400',
                'icon' => 'heroicon-o-clipboard-document',
            ],
        ];

        // Filtra solo i servizi abilitati
        return array_intersect_key($services, array_flip($this->enabledServices));
    }

    protected function getEncodedUrl(): string
    {
        return urlencode($this->url ?? LaravelLocalization::localizeUrl(request()->path()));
    }

    protected function getRawUrl(): string
    {
        return $this->url ?? LaravelLocalization::localizeUrl(request()->path());
    }

    protected function getEncodedTitle(): string
    {
        return urlencode($this->title ?? config('app.name'));
    }

    protected function getEncodedDescription(): string
    {
        return urlencode($this->description ?? '');
    }

    /**
     * Dati per Open Graph
     */
    public function getOpenGraphData(): array
    {
        return [
            'title' => $this->title ?? config('app.name'),
            'description' => $this->description ?? '',
            'image' => $this->image ?? asset('images/og-default.jpg'),
            'url' => $this->getRawUrl(),
            'type' => 'article',
        ];
    }
}
```

### Vista Blade Completa - social-share.blade.php

```blade
{{-- Modules/Seo/resources/views/widgets/social-share.blade.php --}}
@php
    $shareUrls = $this->getShareUrls();
@endphp

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">
        {{ __('seo::widgets.social_share.title') }}
    </h3>
    
    <div class="flex flex-wrap gap-3" x-data="{ copied: false, copiedService: null }">
        @foreach($shareUrls as $service => $data)
            @if($service === 'copy')
                {{-- Bottone Copy to Clipboard --}}
                <button
                    type="button"
                    @click="
                        navigator.clipboard.writeText('{{ $data['url'] }}').then(() => {
                            copied = true;
                            copiedService = '{{ $service }}';
                            setTimeout(() => { copied = false; copiedService = null; }, 2000);
                        });
                    "
                    class="group relative inline-flex items-center justify-center w-11 h-11 rounded-full {{ $data['color'] }} text-white transition-all duration-200 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500"
                    :aria-label="copied && copiedService === '{{ $service }}' ? '{{ __('seo::widgets.social_share.copied') }}' : '{{ $data['label'] }}'"
                >
                    {{-- Icona cambia quando copiato --}}
                    <span x-show="!(copied && copiedService === '{{ $service }}')">
                        <x-filament::icon :icon="$data['icon']" class="w-5 h-5" />
                    </span>
                    <span x-show="copied && copiedService === '{{ $service }}'" x-cloak>
                        <x-filament::icon icon="heroicon-o-check" class="w-5 h-5" />
                    </span>
                    
                    {{-- Tooltip --}}
                    <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-slate-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                        <span x-text="copied && copiedService === '{{ $service }}' ? '{{ __('seo::widgets.social_share.copied') }}' : '{{ $data['label'] }}'"></span>
                    </span>
                </button>
            @elseif($service === 'email')
                {{-- Link Email (mailto) --}}
                <a href="{{ $data['url'] }}"
                   class="group relative inline-flex items-center justify-center w-11 h-11 rounded-full {{ $data['color'] }} text-white transition-all duration-200 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500"
                   aria-label="{{ $data['label'] }}">
                    <x-filament::icon :icon="$data['icon']" class="w-5 h-5" />
                    
                    <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-slate-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                        {{ $data['label'] }}
                    </span>
                </a>
            @else
                {{-- Link Social (target _blank) --}}
                <a href="{{ $data['url'] }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="group relative inline-flex items-center justify-center w-11 h-11 rounded-full {{ $data['color'] }} text-white transition-all duration-200 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500"
                   aria-label="{{ $data['label'] }}">
                    <x-filament::icon :icon="$data['icon']" class="w-5 h-5" />
                    
                    <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-slate-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                        {{ $data['label'] }}
                    </span>
                </a>
            @endif
        @endforeach
    </div>
    
    {{-- URL visibile per debugging/copy manuale --}}
    <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
        <p class="text-xs text-slate-500 dark:text-slate-400 truncate" title="{{ $this->getRawUrl() }}">
            {{ $this->getRawUrl() }}
        </p>
    </div>
</div>
```

---

## Integrazione Volt - Event Detail Completa

### Volt Component con Share Integration

```php
<?php

use Livewire\Volt\Component;
use Modules\Meetup\Models\Event;
use Modules\Seo\Filament\Widgets\SocialShareWidget;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

new class extends Component {
    public ?Event $event = null;
    
    // Proprietà per il widget di share
    public array $shareData = [];
    
    public function mount(): void
    {
        if ($this->event) {
            $this->initShareData();
        }
    }
    
    protected function initShareData(): void
    {
        $this->shareData = [
            'url' => LaravelLocalization::localizeUrl('/events/' . $this->event->slug),
            'title' => $this->event->title,
            'description' => Str::limit($this->event->description, 160),
            'image' => $this->event->cover_image ?? asset('images/og-default.jpg'),
            'services' => ['facebook', 'twitter', 'linkedin', 'whatsapp', 'copy'],
        ];
    }
    
    /**
     * Dati per Open Graph meta tags
     */
    public function getViewData(): array
    {
        return [
            'openGraph' => [
                'title' => $this->event?->title ?? config('app.name'),
                'description' => Str::limit($this->event?->description, 160) ?? '',
                'image' => $this->event?->cover_image ?? asset('images/og-default.jpg'),
                'url' => $this->event 
                    ? LaravelLocalization::localizeUrl('/events/' . $this->event->slug)
                    : url()->current(),
                'type' => 'event',
            ],
        ];
    }
};
?>

{{-- Template --}}
<div>
    {{-- Share Widget nell'aside --}}
    <aside class="lg:w-80 space-y-6">
        @if(!empty($this->shareData))
            <livewire:seo.social-share-widget :data="$this->shareData" />
        @endif
        
        {{-- Altri widget sidebar... --}}
    </aside>
</div>
```

---

## Chiavi di Traduzione Complete

### seo::widgets.social_share

```php
// Modules/Seo/lang/it/widgets.php
return [
    'social_share' => [
        'title' => 'Condividi',
        'copied' => 'Link copiato!',
        'services' => [
            'facebook' => 'Condividi su Facebook',
            'twitter' => 'Condividi su X (Twitter)',
            'linkedin' => 'Condividi su LinkedIn',
            'whatsapp' => 'Condividi su WhatsApp',
            'telegram' => 'Condividi su Telegram',
            'reddit' => 'Condividi su Reddit',
            'email' => 'Invia via email',
            'copy' => 'Copia link',
        ],
    ],
];
```

---

## Testing & Verifica

### Test Manuale Checklist

- [ ] Tutti i link social si aprono correttamente
- [ ] Copy to clipboard funziona (verificare con incolla)
- [ ] Tooltip appaiono al hover
- [ ] Icona cambia su "copiato" (check verde)
- [ ] Colori brand sono corretti per ogni social
- [ ] Responsive: bottoni si adattano su mobile
- [ ] Dark mode: colori visibili
- [ ] URL generate sono complete (con locale)
- [ ] Open Graph meta tags presenti in sorgente pagina

### Test Automatico

```php
<?php

use Modules\Seo\Filament\Widgets\SocialShareWidget;

it('generates correct share URLs', function () {
    $widget = new SocialShareWidget();
    $widget->mount([
        'url' => 'https://example.com/events/test',
        'title' => 'Test Event',
    ]);
    
    $urls = $widget->getShareUrls();
    
    expect($urls)->toHaveKey('facebook');
    expect($urls['facebook']['url'])->toContain('facebook.com/sharer');
    expect($urls['facebook']['url'])->toContain(urlencode('https://example.com/events/test'));
});

it('encodes special characters in URLs', function () {
    $widget = new SocialShareWidget();
    $widget->mount([
        'url' => 'https://example.com/events/test-event-with-spaces',
        'title' => 'Event with & special chars',
    ]);
    
    $urls = $widget->getShareUrls();
    
    // Verifica che & sia encodato
    expect($urls['twitter']['url'])->not->toContain('&');
    expect($urls['twitter']['url'])->toContain('%26');
});
```

---

## Edge Cases & Soluzioni

### URL Troppo Lunghi

```php
public function getShareUrls(): array
{
    $title = $this->title ?? '';
    
    // Twitter ha limite ~280 chars per il testo completo
    // Tronca il titolo se necessario
    if (strlen($title) > 100) {
        $title = substr($title, 0, 97) . '...';
    }
    
    $encodedTitle = urlencode($title);
    // ... resto implementazione
}
```

### Titoli con Emoji

```php
// urlencode gestisce correttamente gli emoji
$title = '🎉 Laravel Pizza Party 2026!';
$encoded = urlencode($title); // %F0%9F%8E%89+Laravel+Pizza+Party+2026%21
```

### URL con Parametri Query

```php
$url = 'https://example.com/events/1?ref=newsletter&utm_source=email';
// urlencode encoda anche i parametri interni
$encoded = urlencode($url); // sicuro per share
```

### Fallback quando JavaScript è disabilitato

```blade
{{-- Link diretto funziona sempre --}}
<a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
   target="_blank">
   Share on Facebook
</a>
```

---

## Performance Optimization

### Lazy Loading del Widget

```php
class SocialShareWidget extends XotBaseWidget
{
    // Carica solo quando visibile
    protected static bool $isLazy = true;
    
    // Cache risultati per 5 minuti
    protected int $cacheTtl = 300;
    
    public function getShareUrls(): array
    {
        return cache()->remember(
            "social_share_urls_{$this->getCacheKey()}",
            $this->cacheTtl,
            fn() => $this->generateShareUrls()
        );
    }
}
```

### Prefetch DNS

```blade
{{-- In layout <head> --}}
<link rel="dns-prefetch" href="//www.facebook.com">
<link rel="dns-prefetch" href="//twitter.com">
<link rel="dns-prefetch" href="//www.linkedin.com">
<link rel="dns-prefetch" href="//wa.me">
<link rel="dns-prefetch" href="//t.me">
```

---

## Accessibilità (a11y)

- Ogni bottone ha `aria-label` descrittivo
- Tooltip testuali per utenti mouse
- Focus rings visibili per tastiera
- Colori con contrasto WCAG AA
- `x-cloak` nasconde stato copiato durante init

---

**Versione documento**: 2.0  
**Ultimo aggiornamento**: 2026-02-19  
**Stato**: Produzione-ready
