# Piano di Implementazione - Event Detail Alignment

## Obiettivo
Completare l'allineamento della pagina evento locale con la versione produzione di laravelpizza.com.

## Data Inizio
2026-02-18

---

## Sprint 1: Fix Critici (Priorità Alta)

### Issue 1: Attendees Avatars Non Funzionanti 🔴
**File**: `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`

**Problema**: Mostra "NaN" o placeholder vuoti invece degli avatar reali

**Analisi**: 
- `$this->event->attendees_count` potrebbe essere null
- Relazione `attendees()` non caricata o non esistente

**Implementazione**:
```php
// Nel Volt component, aggiungere/migliorare
public function getAttendees(): Collection
{
    if (!$this->event) {
        return collect();
    }
    
    return $this->event
        ->attendees()
        ->with('profile') // Eager load profile per avatar
        ->limit(6)
        ->get();
}

public function getAttendeesCount(): int
{
    return $this->event?->attendees_count ?? 0;
}
```

**Template fix**:
```blade
<div class="flex -space-x-2 overflow-hidden">
    @foreach($this->getAttendees() as $attendee)
        <img src="{{ $attendee->profile?->avatar_url ?? 'default-avatar.png' }}" 
             alt="{{ $attendee->name }}"
             class="inline-block h-8 w-8 rounded-full ring-2 ring-white">
    @endforeach
</div>
<span>{{ $this->getAttendeesCount() }} {{ __('pub_theme::event.people_joined.label') }}</span>
```

**Verifica Modello**:
```php
// Modules/Meetup/Models/Event.php
public function attendees(): BelongsToMany
{
    return $this->belongsToMany(
        User::class, 
        'event_attendee',
        'event_id',
        'user_id'
    )->withPivot('status', 'registered_at')
      ->wherePivot('status', 'confirmed');
}
```

---

### Issue 2: Copy Link Mancante 🔴
**File**: `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`

**Problema**: Bottone "Copia link" non presente nella sezione share

**Implementazione**:
```php
// Nel Volt component
public string $copiedMessage = '';

public function copyLink(): void
{
    if (!$this->event) return;
    
    $url = LaravelLocalization::localizeUrl('/events/' . $this->event->slug);
    
    $this->dispatch('copy-to-clipboard', ['text' => $url]);
    $this->copiedMessage = __('pub_theme::event.link_copied.label');
    
    // Reset message after 3s
    $this->dispatch('reset-copied-message', [], 3000);
}
```

**Template aggiunta**:
```blade
{{-- Aggiungere dopo i social buttons --}}
<button wire:click="copyLink" 
        type="button"
        class="flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 
               dark:bg-slate-700 dark:hover:bg-slate-600 rounded-lg transition-colors">
    <x-pub_theme::icons.clipboard class="w-5 h-5" />
    <span>{{ $copiedMessage ?: __('pub_theme::event.copy_link.label') }}</span>
</button>
```

**JavaScript per clipboard**:
```javascript
// Aggiungere al layout o component
window.addEventListener('copy-to-clipboard', (event) => {
    navigator.clipboard.writeText(event.detail.text).then(() => {
        console.log('Link copied to clipboard');
    });
});
```

---

## Sprint 2: Share Functionality (Priorità Media)

### Issue 3: Social Share Completo 🟡
**File**: 
- `Modules/Seo/Services/SocialShareService.php` (creare)
- `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`

**Implementazione Service**:
```php
<?php
namespace Modules\Seo\Services;

use Kudashevs\ShareButtons\ShareButtons;
use Illuminate\Database\Eloquent\Model;

class SocialShareService
{
    public function getUrls(Model $model, array $services = []): array
    {
        $url = $this->getShareableUrl($model);
        $title = $this->getShareableTitle($model);
        
        $shareButtons = new ShareButtons();
        
        $urls = [];
        
        foreach ($services as $service) {
            $urls[$service] = match($service) {
                'facebook' => $shareButtons->facebook($url)->getLink(),
                'twitter', 'x' => $shareButtons->twitter($url, $title)->getLink(),
                'linkedin' => $shareButtons->linkedin($url, $title)->getLink(),
                'whatsapp' => $shareButtons->whatsapp($url)->getLink(),
                'telegram' => $shareButtons->telegram($url, $title)->getLink(),
                default => null,
            };
        }
        
        return array_filter($urls);
    }
    
    protected function getShareableUrl(Model $model): string
    {
        // Assuming model has getPublicUrl or similar
        return $model->getPublicUrl ?? url()->current();
    }
    
    protected function getShareableTitle(Model $model): string
    {
        return $model->title ?? config('app.name');
    }
}
```

**Volt Component Integration**:
```php
public function getShareUrls(): array
{
    if (!$this->event) return [];
    
    $service = app(\Modules\Seo\Services\SocialShareService::class);
    
    return $service->getUrls($this->event, [
        'facebook', 'twitter', 'linkedin', 'whatsapp', 'telegram'
    ]);
}
```

---

### Issue 4: Open Graph Meta Tags 🟡
**File**: `Themes/Meetup/resources/views/layouts/app.blade.php`

**Implementazione**:
```blade
<head>
    {{-- Meta standard --}}
    <title>{{ $pageTitle ?? config('app.name') }}</title>
    <meta name="description" content="{{ $pageDescription ?? '' }}">
    
    {{-- Open Graph --}}
    @if(isset($openGraph))
        <meta property="og:title" content="{{ $openGraph['title'] }}">
        <meta property="og:description" content="{{ $openGraph['description'] }}">
        <meta property="og:image" content="{{ $openGraph['image'] }}">
        <meta property="og:url" content="{{ $openGraph['url'] }}">
        <meta property="og:type" content="{{ $openGraph['type'] ?? 'website' }}">
        <meta property="og:site_name" content="{{ config('app.name') }}">
        <meta property="og:locale" content="{{ app()->getLocale() }}">
        
        {{-- Twitter Card --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $openGraph['title'] }}">
        <meta name="twitter:description" content="{{ $openGraph['description'] }}">
        <meta name="twitter:image" content="{{ $openGraph['image'] }}">
    @endif
</head>
```

**Volt Component - Pass OG Data**:
```php
public function getViewData(): array
{
    return [
        'openGraph' => $this->getOpenGraphData(),
    ];
}

protected function getOpenGraphData(): array
{
    if (!$this->event) return [];
    
    return [
        'title' => $this->event->title,
        'description' => Str::limit($this->event->description, 160),
        'image' => $this->event->cover_image ?? asset('images/og-default.jpg'),
        'url' => LaravelLocalization::localizeUrl('/events/' . $this->event->slug),
        'type' => 'event',
    ];
}
```

---

## Sprint 3: Testing & QA

### Checklist Testing Manuale
- [ ] Event detail page loads without errors
- [ ] All event data displays correctly
- [ ] Attendees avatars load real user images
- [ ] "15 people joined" text shows correct number
- [ ] RSVP modal opens on button click
- [ ] Booking form validates name and email
- [ ] Submit booking creates database record
- [ ] Success message shown after booking
- [ ] Share buttons open correct social URLs
- [ ] Copy link copies event URL to clipboard
- [ ] "Copied!" message appears after copying
- [ ] Responsive design works on mobile/tablet
- [ ] Dark mode toggle works correctly
- [ ] Page passes Lighthouse audit (score > 90)

### Testing Tools
```bash
# Run PHPStan
./vendor/bin/phpstan analyze Themes/Meetup --level=9

# Run tests
php artisan test --filter=Event

# Lighthouse CI
lighthouse-ci http://127.0.0.1:8000/it/events/test-event
```

---

## Dependency Installation

### Required Packages
```bash
# Install kudashevs/laravel-share-buttons (run from laravel/ directory)
composer require kudashevs/laravel-share-buttons

# Update module dependencies
composer dump-autoload

# Clear caches
php artisan cache:clear
php artisan config:clear
```

### Translation Keys to Add
```php
// Themes/Meetup/lang/it/event.php
return [
    'link_copied' => [
        'label' => 'Link copiato!',
    ],
    'copy_link_error' => [
        'label' => 'Errore nella copia del link',
    ],
];
```

---

## Timeline

| Sprint | Durata | Issue | Stato |
|--------|--------|-------|-------|
| Sprint 1 | 1-2 giorni | Attendees fix + Copy link | 🔴 In Progress |
| Sprint 2 | 1 giorno | Share functionality | ⚪️ Da iniziare |
| Sprint 3 | 0.5 giorni | Testing & QA | ⚪️ Da iniziare |

**Totale stimato**: 2.5-3.5 giorni

---

## Risorse

- [Analisi Dettagliata Differenze](../event-detail-alignment-analysis.md)
- [Volt Component Pattern](../volt-component-pattern.md)
- [Social Share Docs](../social-share.md)
- [Seo Module - Social Share](../../modules/seo/docs/social-share-component.md)

---

**Creato**: 2026-02-18  
**Aggiornamento**: Ogni completamento sprint  
**Owner**: Cascade AI + Dev Team
