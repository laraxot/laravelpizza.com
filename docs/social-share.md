# Social Share Component - Meetup Theme

## Overview

This document describes the **Social Share Component** implementation in the Meetup theme, following the Laraxot architectural principles.

## Research Summary

After studying 30+ resources on social sharing in Laravel, we've identified:

### Common Topics
1. **Social Share Buttons** - Simple URL templates (no packages needed!)
2. **Open Graph / Twitter Cards** - Meta tags for social previews
3. **RSS/Atom/JSON Feeds** - Content distribution
4. **Laravel Socialite** - OAuth (different from sharing!)

### Our Approach: Pure PHP/Blade
```php
// Less than 10 lines - NO packages!
$url = urlencode($url);
$facebook = "https://facebook.com/sharer/sharer.php?u={$url}";
$twitter = "https://twitter.com/intent/tweet?text={$title}&url={$url}";
```

## Architecture

The Meetup theme uses the **Seo Module's** social share services while providing its own **UI components** styled with Tailwind CSS.

```
┌─────────────────────────────────────┐
│           Meetup Theme              │
│  ┌─────────────────────────────┐   │
│  │  UI Components (Tailwind)   │   │
│  │  - share-buttons.blade.php  │   │
│  │  - share-modal.blade.php    │   │
│  └─────────────────────────────┘   │
└─────────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────┐
│            Seo Module               │
│  ┌─────────────────────────────┐   │
│  │  SocialShareWidget           │   │
│  │  - Pure PHP (NO packages!)  │   │
│  │  - Open Graph generation    │   │
│  │  - RSS feed generation      │   │
│  └─────────────────────────────┘   │
└─────────────────────────────────────┘
```

## UI Components

### 1. Share Buttons Inline

File: `Themes/Meetup/resources/views/components/ui/share-buttons.blade.php`

```blade
@props(['urls' => [], 'label' => null, 'size' => 'md'])

<div class="flex flex-wrap items-center gap-3 {{ $attributes->get('class') }}">
    @if($label)
        <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
            {{ $label }}
        </span>
    @endif
    
    @foreach($urls as $service => $url)
        <a href="{{ $url }}" 
           target="_blank" 
           rel="noopener noreferrer"
           class="inline-flex items-center justify-center rounded-full text-white 
                  hover:opacity-80 transition-opacity focus:outline-none focus:ring-2 focus:ring-offset-2
                  {{ $size === 'sm' ? 'w-8 h-8' : ($size === 'lg' ? 'w-12 h-12' : 'w-10 h-10') }}
                  {{ $this->getServiceColor($service) }}"
           aria-label="{{ __('pub_theme::event.share_on_' . $service . '.label') }}">
            <x-dynamic-component 
                :component="'pub_theme::icons.social.' . $service" 
                :class="$size === 'sm' ? 'w-4 h-4' : ($size === 'lg' ? 'w-6 h-6' : 'w-5 h-5')" />
        </a>
    @endforeach
</div>
```

### 2. Share Modal

File: `Themes/Meetup/resources/views/components/ui/share-modal.blade.php`

```blade
@props(['show' => false, 'urls' => [], 'title' => ''])

<div x-data="{ show: @js($show) }" 
     x-show="show" 
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     @keydown.escape.window="show = false">
    
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Backdrop -->
        <div x-show="show" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm"
             @click="show = false"></div>
        
        <!-- Modal -->
        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white dark:bg-slate-800 rounded-xl shadow-2xl max-w-md w-full p-6">
            
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">
                {{ __('pub_theme::event.actions.share_event.label') }}
            </h3>
            
            <div class="space-y-3">
                @foreach($urls as $service => $url)
                    <a href="{{ $url }}" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        <span class="w-10 h-10 rounded-full {{ $this->getServiceColor($service) }} flex items-center justify-center text-white">
                            <x-dynamic-component :component="'pub_theme::icons.social.' . $service" class="w-5 h-5" />
                        </span>
                        <span class="font-medium text-slate-700 dark:text-slate-300">
                            {{ __('pub_theme::event.share_on_' . $service . '.label') }}
                        </span>
                    </a>
                @endforeach
            </div>
            
            <button @click="show = false" 
                    class="mt-6 w-full py-2 px-4 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-lg font-medium transition-colors">
                {{ __('pub_theme::actions.close.label') }}
            </button>
        </div>
    </div>
</div>
```

## Service Colors

Tailwind CSS color classes for each social platform:

```php
// In Volt component or helper
public function getServiceColor(string $service): string
{
    return match($service) {
        'facebook' => 'bg-[#1877F2] hover:bg-[#166fe5]',
        'twitter', 'x' => 'bg-black hover:bg-slate-800',
        'linkedin' => 'bg-[#0A66C2] hover:bg-[#0958a8]',
        'whatsapp' => 'bg-[#25D366] hover:bg-[#1fb955]',
        'telegram' => 'bg-[#26A5E4] hover:bg-[#1d94c8]',
        'reddit' => 'bg-[#FF4500] hover:bg-[#e03f00]',
        'pinterest' => 'bg-[#E60023] hover:bg-[#cc001f]',
        'email' => 'bg-slate-600 hover:bg-slate-700',
        default => 'bg-slate-500 hover:bg-slate-600',
    };
}
```

## Usage in Event Detail

### Volt Component Integration

File: `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`

```php
new class extends Component {
    // ... existing properties ...
    
    public function getShareUrls(): array
    {
        if (!$this->event) return [];
        
        $shareService = app(\Modules\Seo\Services\SocialShareService::class);
        
        return $shareService->getUrls($this->event, [
            'facebook',
            'twitter',
            'linkedin',
            'whatsapp',
            'telegram',
        ]);
    }
    
    public function getServiceColor(string $service): string
    {
        return match($service) {
            'facebook' => 'bg-[#1877F2]',
            'twitter', 'x' => 'bg-black',
            'linkedin' => 'bg-[#0A66C2]',
            'whatsapp' => 'bg-[#25D366]',
            'telegram' => 'bg-[#26A5E4]',
            default => 'bg-slate-500',
        };
    }
};
```

### Template Implementation

```blade
{{-- In sidebar or below event title --}}
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 border border-slate-200 dark:border-slate-700">
    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">
        {{ __('pub_theme::event.actions.share_event.label') }}
    </h3>
    
    <div class="flex flex-wrap gap-3">
        @foreach($this->getShareUrls() as $service => $url)
            <a href="{{ $url }}" 
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center justify-center w-10 h-10 rounded-full text-white 
                      hover:opacity-80 transition-opacity {{ $this->getServiceColor($service) }}"
               aria-label="{{ __('pub_theme::event.share_on_' . $service . '.label') }}">
                <x-dynamic-component :component="'pub_theme::icons.social.' . $service" class="w-5 h-5" />
            </a>
        @endforeach
    </div>
</div>
```

## Translation Keys

Add to `Themes/Meetup/lang/{locale}/event.php`:

```php
'share' => [
    'label' => 'Share',
    'help' => 'Share this event with your network',
],
'share_on_facebook' => [
    'label' => 'Share on Facebook',
],
'share_on_twitter' => [
    'label' => 'Share on X',
],
'share_on_linkedin' => [
    'label' => 'Share on LinkedIn',
],
'share_on_whatsapp' => [
    'label' => 'Share on WhatsApp',
],
'share_on_telegram' => [
    'label' => 'Share on Telegram',
],
'share_on_reddit' => [
    'label' => 'Share on Reddit',
],
'copy_link' => [
    'label' => 'Copy link',
    'help' => 'Copy the event URL to clipboard',
],
```

## Open Graph Meta Tags

The Meetup theme automatically includes Open Graph tags via the Seo module:

```blade
{{-- In Themes/Meetup/resources/views/layouts/app.blade.php --}}
<head>
    {{-- Standard meta --}}
    <title>{{ $title ?? config('app.name') }}</title>
    
    {{-- Open Graph / Social --}}
    @if(isset($openGraph))
        <meta property="og:title" content="{{ $openGraph['title'] }}">
        <meta property="og:description" content="{{ $openGraph['description'] }}">
        <meta property="og:image" content="{{ $openGraph['image'] }}">
        <meta property="og:url" content="{{ $openGraph['url'] }}">
        <meta property="og:type" content="{{ $openGraph['type'] ?? 'website' }}">
        <meta property="og:site_name" content="{{ config('app.name') }}">
        
        {{-- Twitter Card --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $openGraph['title'] }}">
        <meta name="twitter:description" content="{{ $openGraph['description'] }}">
        <meta name="twitter:image" content="{{ $openGraph['image'] }}">
    @endif
</head>
```

## Responsive Design

The share buttons are responsive by default:

- **Mobile**: Buttons stack vertically or use smaller size
- **Desktop**: Buttons display inline with hover effects
- **Dark mode**: All colors adapt automatically

```blade
{{-- Mobile-optimized --}}
<div class="flex flex-wrap gap-2 sm:gap-3">
    <x-pub_theme::ui.share-buttons 
        :urls="$this->getShareUrls()"
        size="sm"
        class="sm:hidden" />
    
    <x-pub_theme::ui.share-buttons 
        :urls="$this->getShareUrls()"
        size="md"
        class="hidden sm:flex" />
</div>
```

## Accessibility

All share buttons follow WCAG 2.1 guidelines:

- **ARIA labels**: Each button has descriptive `aria-label`
- **Keyboard navigation**: Full keyboard support with focus rings
- **Color contrast**: All brand colors meet WCAG contrast requirements
- **Screen reader support**: Hidden icons, visible text alternatives

## Anti-Patterns

### ❌ WRONG: Inline hardcoded URLs
```blade
<a href="https://facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}">
    Facebook
</a>
```

### ✅ CORRECT: Service-based approach
```blade
<x-pub_theme::ui.share-buttons :urls="$this->getShareUrls()" />
```

### ❌ WRONG: Missing Open Graph
```html
<head>
    <title>My Event</title>
    {{-- No OG tags = bad social sharing --}}
</head>
```

### ✅ CORRECT: Full Open Graph
```html
<head>
    <title>{{ $event->title }}</title>
    <meta property="og:title" content="{{ $event->title }}">
    <meta property="og:description" content="{{ $event->description }}">
    <meta property="og:image" content="{{ $event->cover_image }}">
</head>
```

## References

- [Seo Module Social Share](../modules/seo/docs/social-share-component.md)
- [Volt Component Pattern](./volt-component-pattern.md)
- [Translation Guidelines](./translations.md)

## Anti-Pattern: Composer Packages for Simple URL Generation

## Backlinks

- [Meetup Theme README](./readme.md)
- [Roadmap](./roadmap.md)

---

**Created**: 2026-02-19

**Status**: Draft - Implementation pending

**Related Issues**: 
- GitHub Issue: Social Share Component for Events
- GitHub Discussion: Social Media Integration Strategy
