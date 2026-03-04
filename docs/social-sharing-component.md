# Social Sharing Component Design

## Overview
The Social Sharing Component is a reusable UI element that provides sharing links for various social media platforms. It centralizes the logic for generating SEO-friendly sharing URLs and provides a consistent interface across the application.

## Core Theme: Social Sharing Buttons
Based on the research of modern UI libraries (FlyonUI, Tailwind Elements) and internal design requirements, this component focuses on:
- **Simplicity**: Custom implementation using native PHP/Laravel features.
- **Independence**: No external composer packages for simple UI/sharing logic.
- **Design Parity**: 100% integration within the Laraxot design system.
- **Performance**: Static URL generation in PHP.
- **SEO Integration**: Dynamic injection of current page title, URL, and OG image.

## Technical Implementation Detail

### 1. Data Object (DTO)
We use `spatie/laravel-data` for strict typing and integration with Spatie Actions.

```php
namespace Modules\Seo\Data;

use Spatie\LaravelData\Data;

class SocialShareData extends Data
{
    public function __construct(
        public string $url,
        public ?string $title = null,
        public ?string $text = null,
        public ?string $image = null,
        public ?string $hashtags = null, // Comma-separated
        public ?string $via = null,      // Source handle
        public array $platforms = ['facebook', 'twitter', 'linkedin', 'whatsapp', 'telegram', 'copy'],
    ) {}
}
```

### 2. Deep Dive: URL Construction Patterns
The `GenerateSocialShareLinksAction` implements robust URI construction.

| Platform | URL Pattern | Notes |
| :--- | :--- | :--- |
| **Facebook** | `https://www.facebook.com/sharer/sharer.php?u={url}` | Classic sharer |
| **X (Twitter)**| `https://twitter.com/intent/tweet?url={url}&text={text}&via={via}&hashtags={hashtags}` | Web Intent API |
| **LinkedIn** | `https://www.linkedin.com/sharing/share-offsite/?url={url}` | Offsite share |
| **WhatsApp** | `https://api.whatsapp.com/send?text={text}%20{url}` | Universal link |
| **Telegram** | `https://t.me/share/url?url={url}&text={text}` | Telegram Share API |
| **Copy Link** | `javascript:void(0)` | Alpine.js managed |

### 3. Icon Management (Laraxot Zen)
To maintain **zero external dependencies** and 100% design control:
- **Approach**: Dedicated SVGs stored as Blade components in the `Seo` module.
- **Component Path**: `Modules/Seo/resources/views/components/icons/*.blade.php`
- **Usage**: `<x-seo::icons.facebook class="h-6 w-6" />`
- **Icons Included**: Facebook, X, LinkedIn, WhatsApp, Telegram, Link/Clipboard.

### 4. Interactive UX (Alpine.js Feedbacks)
The widget leverages Alpine.js for "Copy to Clipboard" feedback:

```html
<div x-data="{ copied: false }" class="relative inline-block">
    <button 
        @click="
            navigator.clipboard.writeText('{{ $url }}');
            copied = true;
            setTimeout(() => copied = false, 2000)
        "
        class="p-2 rounded-full hover:bg-gray-100 transition-colors"
        title="Copy Link"
    >
        <x-seo::icons.link x-show="!copied" />
        <x-seo::icons.check x-show="copied" class="text-green-500 animate-bounce" />
    </button>
</div>
```

## Theme Integration (Meetup Case Study)

### Model Integration
The `Event` model in `Modules\Meetup` should provide a helper:
```php
public function getSocialShareData(): SocialShareData
{
    return SocialShareData::from([
        'url' => route('it.events.show', $this->slug),
        'title' => $this->title,
        'image' => $this->getFirstMediaUrl('cover'),
        'hashtags' => 'laravel,meetup,italy',
    ]);
}
```

### Blade Usage
```blade
<div class="mt-8 border-t pt-8">
    <h3 class="text-lg font-bold">Share this Event</h3>
    <x-seo::social-share :data="$event->getSocialShareData()" />
</div>
```

## Final Architecture (

The final implementation follows a pure Laraxot approach:
- **DTO**: [SocialShareData.php](file:///var/www/_bases/base_laravelpizza/laravel/Modules/Seo/app/Data/SocialShareData.php)
- **Action**: [GenerateSocialShareLinksAction.php](file:///var/www/_bases/base_laravelpizza/laravel/Modules/Seo/app/Actions/GenerateSocialShareLinksAction.php)
- **Widget**: [SocialShareWidget.php](file:///var/www/_bases/base_laravelpizza/laravel/Modules/Seo/app/Filament/Widgets/SocialShareWidget.php)

---
*Generated and Verified by Antigravity*
