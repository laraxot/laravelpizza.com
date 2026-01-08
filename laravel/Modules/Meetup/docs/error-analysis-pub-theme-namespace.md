# error analysis: pub_theme namespace not found

## problema

**errore:** `view not found: pub_theme::components.blocks.hero.main`

**stack trace:** parte da `Themes/Meetup/resources/views/pages/index.blade.php:22`

## analisi del flusso

### 1. entry point: index.blade.php

**file:** `/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/resources/views/pages/index.blade.php`

```blade
<x-layouts.app>
    @volt('home')
        <div>
            <x-page side="content" slug="home" :type="auth()->user()?->type?->value" />
        </div>
    @endvolt
</x-layouts.app>
```

**riga 24:** usa il component `<x-page>` con `slug="home"`

### 2. component page

il component `<x-page>` (probabilmente in Modules/Cms) carica i content blocks dal JSON associato allo slug.

### 3. content blocks json

**file:** `/var/www/_bases/base_laravelpizza/laravel/config/local/laravelpizza/database/content/pages/home.json`

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
                    "title": "Benvenuto in TechPlanner",
                    ...
                }
            },
            ...
        ]
    }
}
```

**riga 15:** specifica `"view": "pub_theme::components.blocks.hero.main"`

### 4. namespace pub_theme

il namespace `pub_theme::` dovrebbe puntare a:
```
/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/resources/views/
```

quindi `pub_theme::components.blocks.hero.main` risolve a:
```
/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/resources/views/components/blocks/hero/main.blade.php
```

### 5. verifica del file

```bash
ls -la /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup/resources/views/components/blocks/hero/
# OUTPUT: main.blade.php ESISTE! ✅
```

**il file esiste** quindi il problema non è il file mancante.

### 6. registrazione namespace

**file:** `Modules/Cms/app/Providers/CmsServiceProvider.php`

```php
public function boot(): void
{
    parent::boot();

    $this->xot = XotData::make();

    if ($this->xot->register_pub_theme) {  // ✅ deve essere true
        $this->registerNamespaces('pub_theme');
    }
}

public function registerNamespaces(string $theme_type): void
{
    $xot = $this->xot;

    Assert::string($theme = $xot->{$theme_type});  // ✅ deve essere 'Meetup'
    $theme_path = 'Themes/'.$theme;
    $resource_path = $theme_path.'/resources';

    $theme_dir = app(FixPathAction::class)->execute(base_path($resource_path.'/views'));

    app('view')->addNamespace($theme_type, $theme_dir);  // ⬅️ REGISTRA NAMESPACE
}
```

### 7. configurazione xot

**file:** `config/local/laravelpizza/xot.php`

```php
return [
    'pub_theme' => 'Meetup',           // ✅ CORRETTO
    'register_pub_theme' => true,       // ✅ CORRETTO
];
```

**la configurazione è corretta!**

### 8. xotdata defaults

**file:** `Modules/Xot/app/Datas/XotData.php`

```php
class XotData extends Data
{
    public string $pub_theme;
    public bool $register_pub_theme = false;  // ⚠️ DEFAULT FALSE
}
```

## diagnosi

il problema è che **Laravel non sta caricando la configurazione corretta**.

possibili cause:
1. ❌ **Cache delle configurazioni non aggiornata**
2. ❌ **File di configurazione non caricato**
3. ❌ **XotData::make() non carica config correttamente**

## soluzione

### step 1: clear all caches

```bash
cd /var/www/_bases/base_laravelpizza/laravel

# Clear cache
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# Optimize (ricrea le cache)
php artisan optimize:clear
```

### step 2: verificare che xotdata carichi config

il metodo `XotData::make()` dovrebbe caricare i valori da `config('xot')`.

verificare in `Modules/Xot/app/Datas/XotData.php` che il metodo `make()` o il costruttore carichi i valori dal config.

### step 3: debug temporaneo

aggiungere debug temporaneo in `CmsServiceProvider::boot()`:

```php
public function boot(): void
{
    parent::boot();

    $this->xot = XotData::make();

    // 🐛 DEBUG
    \Log::info('XotData values', [
        'pub_theme' => $this->xot->pub_theme,
        'register_pub_theme' => $this->xot->register_pub_theme,
    ]);

    if ($this->xot->register_pub_theme) {
        $this->registerNamespaces('pub_theme');

        // 🐛 DEBUG
        \Log::info('Registered pub_theme namespace');
    } else {
        // 🐛 DEBUG
        \Log::info('pub_theme namespace NOT registered');
    }
}
```

### step 4: verificare namespace registrato

in qualsiasi controller o middleware, verificare:

```php
$namespaces = app('view')->getFinder()->getHints();
dd($namespaces);

// Dovrebbe contenere:
// 'pub_theme' => ['/var/www/.../Themes/Meetup/resources/views']
```

## alternative workaround (se cache non risolve)

### workaround 1: usare path diretto

nel JSON, invece di:
```json
"view": "pub_theme::components.blocks.hero.main"
```

usare namespace del tema:
```json
"view": "meetup::components.blocks.hero.main"
```

poi registrare namespace `meetup` in `CmsServiceProvider`.

### workaround 2: copiare blocchi in resources/views

se il namespace non funziona, copiare i blocchi da:
```
Themes/Meetup/resources/views/components/blocks/
```

a:
```
resources/views/vendor/pub_theme/components/blocks/
```

ma questo è **anti-pattern** e va evitato.

## file coinvolti

1. ✅ `Themes/Meetup/resources/views/pages/index.blade.php` - entry point
2. ✅ `config/local/laravelpizza/database/content/pages/home.json` - content blocks
3. ✅ `Themes/Meetup/resources/views/components/blocks/hero/main.blade.php` - component (ESISTE)
4. ✅ `config/local/laravelpizza/xot.php` - configurazione (CORRETTA)
5. ⚠️ `Modules/Cms/app/Providers/CmsServiceProvider.php` - registrazione namespace
6. ⚠️ `Modules/Xot/app/Datas/XotData.php` - defaults (register_pub_theme = false)

## conclusione

**il file esiste**, **la configurazione è corretta**, ma il **namespace non viene registrato** a runtime.

**soluzione principale:** clear all caches + verificare caricamento XotData.

**debugging:** aggiungere log per verificare che `register_pub_theme` sia true al boot del ServiceProvider.

---

**analisi eseguita:** 2025-01-29
**prossimi step:** clear caches → test → debug se necessario
