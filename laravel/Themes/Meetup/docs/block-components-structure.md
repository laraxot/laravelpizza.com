# block components structure - theme meetup

## overview

il tema Meetup usa un sistema di **content blocks dinamici** caricati da JSON per comporre le pagine.

ogni block ha una view blade corrispondente in `components/blocks/`.

## struttura blocks

```
Themes/Meetup/resources/views/components/blocks/
├── hero/
│   └── main.blade.php
├── features/
│   └── grid.blade.php
├── stats/
│   └── overview.blade.php
├── testimonials/
│   └── carousel.blade.php
├── cta/
│   └── banner.blade.php
└── sidebar/
    ├── quick-links.blade.php
    └── system-info.blade.php
```

## come funziona

### 1. page json definition

**file:** `config/local/laravelpizza/database/content/pages/home.json`

```json
{
    "slug": "home",
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "slug": "hero-section",
                "data": {
                    "view": "pub_theme::components.blocks.hero.main",
                    "title": "Benvenuto",
                    "subtitle": "Sottotitolo",
                    "description": "Descrizione...",
                    "cta_primary": {
                        "label": "Azione Principale",
                        "url": "/admin",
                        "style": "primary"
                    }
                }
            }
        ]
    }
}
```

### 2. component page loader

il component `<x-page slug="home" />` (dal modulo Cms) legge il JSON e renderizza dinamicamente ogni block usando la view specificata in `data.view`.

### 3. block component

ogni block component riceve `$data` con tutti i parametri definiti nel JSON.

**esempio:** `components/blocks/hero/main.blade.php`

```blade
@php
    $title = $data['title'] ?? 'Default Title';
    $subtitle = $data['subtitle'] ?? '';
    $description = $data['description'] ?? '';
    $backgroundImage = $data['background_image'] ?? '';
    $ctaPrimary = $data['cta_primary'] ?? ['label' => null, 'url' => '#', 'style' => 'primary'];
    $ctaSecondary = $data['cta_secondary'] ?? ['label' => null, 'url' => '#', 'style' => 'secondary'];
@endphp

<section id="hero-block" class="relative py-20 md:py-32"
    @if($backgroundImage)
        style="background-image: url('{{ $backgroundImage }}'); background-size: cover;"
    @endif>

    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-bold mb-4">
                <span class="text-white">{{ $title }}</span>
                @if($subtitle)
                    <br>
                    <span class="text-red-500">{{ $subtitle }}</span>
                @endif
            </h1>

            @if($description)
                <p class="text-xl md:text-2xl text-gray-300 mb-10">
                    {{ $description }}
                </p>
            @endif

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if($ctaPrimary['label'] ?? false)
                    <a href="{{ $ctaPrimary['url'] }}"
                       class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-lg">
                        {{ $ctaPrimary['label'] }}
                    </a>
                @endif

                @if($ctaSecondary['label'] ?? false)
                    <a href="{{ $ctaSecondary['url'] }}"
                       class="border-2 border-gray-600 hover:border-gray-500 text-white px-8 py-4 rounded-lg">
                        {{ $ctaSecondary['label'] }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
```

## namespace pub_theme

il namespace `pub_theme::` punta al tema pubblico configurato (in questo caso "Meetup").

**configurazione:** `config/local/laravelpizza/xot.php`

```php
return [
    'pub_theme' => 'Meetup',
    'register_pub_theme' => true,
];
```

**registrazione:** `Modules/Cms/app/Providers/CmsServiceProvider.php`

```php
if ($this->xot->register_pub_theme) {
    $this->registerNamespaces('pub_theme');
}

public function registerNamespaces(string $theme_type): void
{
    $theme_dir = base_path('Themes/'.$this->xot->{$theme_type}.'/resources/views');
    app('view')->addNamespace($theme_type, $theme_dir);
}
```

**risoluzione paths:**
```
pub_theme::components.blocks.hero.main
↓
Themes/Meetup/resources/views/components/blocks/hero/main.blade.php
```

## block types disponibili

### 1. hero block

**tipo:** hero section con titolo, sottotitolo, descrizione e CTA buttons

**view:** `pub_theme::components.blocks.hero.main`

**parametri:**
```json
{
    "title": "string (required)",
    "subtitle": "string (optional)",
    "description": "string (optional)",
    "background_image": "string URL (optional)",
    "cta_primary": {
        "label": "string",
        "url": "string",
        "style": "primary|secondary"
    },
    "cta_secondary": {
        "label": "string",
        "url": "string",
        "style": "primary|secondary"
    }
}
```

### 2. features grid

**tipo:** griglia di features con icone

**view:** `pub_theme::components.blocks.features.grid`

**parametri:**
```json
{
    "title": "string",
    "description": "string",
    "features": [
        {
            "icon": "heroicon-o-users",
            "title": "string",
            "description": "string",
            "url": "string",
            "color": "blue|green|red|purple|orange|indigo"
        }
    ]
}
```

### 3. stats overview

**tipo:** statistiche in numeri

**view:** `pub_theme::components.blocks.stats.overview`

**parametri:**
```json
{
    "title": "string",
    "background_color": "bg-gray-50 (Tailwind class)",
    "stats": [
        {
            "number": "500+",
            "label": "string",
            "description": "string"
        }
    ]
}
```

### 4. testimonials carousel

**tipo:** carousel di testimonianze

**view:** `pub_theme::components.blocks.testimonials.carousel`

**parametri:**
```json
{
    "title": "string",
    "testimonials": [
        {
            "content": "string",
            "author": "string",
            "role": "string",
            "company": "string",
            "avatar": "string URL",
            "rating": 1-5
        }
    ]
}
```

### 5. cta banner

**tipo:** call to action banner

**view:** `pub_theme::components.blocks.cta.banner`

**parametri:**
```json
{
    "title": "string",
    "description": "string",
    "background_color": "bg-blue-600 (Tailwind class)",
    "text_color": "text-white (Tailwind class)",
    "cta_primary": { "label": "string", "url": "string", "style": "white|outline-white" },
    "cta_secondary": { "label": "string", "url": "string", "style": "white|outline-white" }
}
```

### 6. sidebar quick links

**tipo:** lista di link rapidi (sidebar)

**view:** `pub_theme::components.blocks.sidebar.quick-links`

**parametri:**
```json
{
    "title": "string",
    "links": [
        {
            "label": "string",
            "url": "string",
            "icon": "heroicon-o-squares-2x2"
        }
    ]
}
```

### 7. sidebar system info

**tipo:** informazioni di sistema (sidebar)

**view:** `pub_theme::components.blocks.sidebar.system-info`

**parametri:**
```json
{
    "title": "string",
    "info": [
        {
            "label": "string",
            "value": "string | {{ blade expression }}"
        }
    ]
}
```

## creare nuovi blocks

### step 1: creare component blade

**file:** `Themes/Meetup/resources/views/components/blocks/{category}/{name}.blade.php`

```blade
@php
    // Extract data with defaults
    $title = $data['title'] ?? 'Default Title';
    $items = $data['items'] ?? [];
@endphp

<section class="py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8">{{ $title }}</h2>

        @foreach($items as $item)
            <div>{{ $item['content'] }}</div>
        @endforeach
    </div>
</section>
```

### step 2: aggiungere al JSON

**file:** `config/local/laravelpizza/database/content/pages/{slug}.json`

```json
{
    "content_blocks": {
        "it": [
            {
                "type": "custom-block",
                "slug": "my-custom-block",
                "data": {
                    "view": "pub_theme::components.blocks.{category}.{name}",
                    "title": "My Custom Block",
                    "items": [
                        { "content": "Item 1" },
                        { "content": "Item 2" }
                    ]
                }
            }
        ]
    }
}
```

### step 3: testare

```bash
php artisan cache:clear
php artisan view:clear
php artisan serve
```

visitare la pagina e verificare che il block venga renderizzato.

## best practices

### 1. sempre fornire defaults

```blade
@php
    $title = $data['title'] ?? 'Default Title';  // ✅ GOOD
    $items = $data['items'] ?? [];               // ✅ GOOD
@endphp
```

non:
```blade
@php
    $title = $data['title'];  // ❌ BAD - error se manca
@endphp
```

### 2. validare struttura dati

```blade
@php
    $cta = $data['cta'] ?? ['label' => null, 'url' => '#'];

    // Ensure required keys exist
    $cta = array_merge(['label' => null, 'url' => '#', 'style' => 'primary'], $cta);
@endphp

@if($cta['label'])
    <a href="{{ $cta['url'] }}">{{ $cta['label'] }}</a>
@endif
```

### 3. usare tailwind classes

tutti gli stili devono usare Tailwind CSS 4:

```blade
<div class="bg-slate-900 text-white rounded-lg p-6">
    <!-- Content -->
</div>
```

### 4. responsive design

sempre includere classi responsive:

```blade
<h1 class="text-3xl md:text-5xl lg:text-7xl font-bold">
    {{ $title }}
</h1>
```

### 5. dark mode support

usare le classi dark: quando appropriato:

```blade
<div class="bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
    <!-- Content -->
</div>
```

## troubleshooting

### view not found error

**errore:** `view not found: pub_theme::components.blocks.{type}.{name}`

**cause possibili:**
1. File non esiste nel path corretto
2. Namespace pub_theme non registrato
3. Cache non aggiornata

**soluzione:**
```bash
# 1. Verificare che il file esista
ls -la Themes/Meetup/resources/views/components/blocks/{type}/

# 2. Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan optimize:clear

# 3. Verificare config
php artisan tinker
> config('xot.pub_theme')
> config('xot.register_pub_theme')
```

### data non passa al component

**problema:** `$data` è vuoto o mancano parametri

**causa:** JSON malformato o chiave `data` mancante

**soluzione:**
```json
{
    "type": "hero",
    "slug": "hero-section",
    "data": {  // ⬅️ IMPORTANTE: chiave "data" richiesta
        "view": "pub_theme::components.blocks.hero.main",
        "title": "My Title"
    }
}
```

### css non applicato

**problema:** classi Tailwind non funzionano

**causa:** build CSS non aggiornato

**soluzione:**
```bash
npm run build
# oppure in dev mode:
npm run dev
```

---

**version:** 1.0
**
**theme:** Meetup
