# Errore: View pub_theme::components.sections.footer not found

## 🚨 Problema

L'errore `View pub_theme::components.sections.footer not found` si verifica quando il componente `Section` del modulo CMS cerca di renderizzare una view del tema pubblico ma non riesce a trovarla.

## 🔍 Causa

Il problema si verifica nel file `Modules/Cms/app/View/Components/Section.php` alla riga 65, quando il componente cerca di renderizzare la view:

```php
public function render(): ViewContract
{
    $view='pub_theme::components.sections.'.$this->slug;
    if($this->tpl){
        $view.='.'.$this->tpl;
    }
    if(!view()->exists($view)){
        throw new \Exception('View '.$view.' not found'); // ← Errore qui
    }
    return view($view);
}
```

### Causa Principale
Il tema Sixteen non era registrato come dipendenza nel `composer.json` principale, causando il mancato caricamento del ServiceProvider del tema e quindi la mancata registrazione del namespace `pub_theme`.

## ✅ Soluzione

### 1. Registrazione Manuale del Tema

Aggiungere nel `AppServiceProvider.php`:

```php
/**
 * Bootstrap any application services.
 */
public function boot(): void
{
    // Registra il tema Sixteen manualmente
    $this->registerThemeSixteen();
}

/**
 * Registra il tema Sixteen manualmente
 */
protected function registerThemeSixteen(): void
{
    // Registra le viste del tema Sixteen con il namespace pub_theme
    $this->app['view']->addNamespace('pub_theme', base_path('Themes/Sixteen/resources/views'));

    // Registra le traduzioni del tema Sixteen
    $this->app['translator']->addNamespace('pub_theme', base_path('Themes/Sixteen/lang'));
}
```

### 2. Verifica della Soluzione

```bash
# Test di verifica
php artisan tinker --execute="echo view()->exists('pub_theme::components.sections.footer') ? 'EXISTS' : 'NOT FOUND';"

# Output atteso: EXISTS
```

## 📚 Architettura

### Componente Section
Il componente `Section` del modulo CMS:
- Cerca di renderizzare views del tema usando il pattern `pub_theme::components.sections.{slug}`
- Verifica l'esistenza della view prima del rendering
- Lancia un'eccezione se la view non esiste

### Namespace pub_theme
- `pub_theme::` è un alias dinamico che punta al tema attualmente attivo
- Configurato in `config/local/techplanner/xra.php` con `'pub_theme' => 'Sixteen'`
- Deve essere registrato dal ServiceProvider del tema

## 🔗 Riferimenti

- [Documentazione Completa](../../../../docs/pub_theme-view-not-found-error.md)
- [Componente Section](../../app/View/Components/Section.php)
- [Configurazione Tema](../../../../config/local/techplanner/xra.php)
- [ServiceProvider Tema Sixteen](../../../../Themes/Sixteen/app/Providers/ThemeServiceProvider.php)

---

# Errore: View pub_theme::components.sections.footer not found

## 🚨 Problema

L'errore `View pub_theme::components.sections.footer not found` si verifica quando il componente `Section` del modulo CMS cerca di renderizzare una view del tema pubblico ma non riesce a trovarla.

## 🔍 Causa

Il problema si verifica nel file `Modules/Cms/app/View/Components/Section.php` alla riga 65, quando il componente cerca di renderizzare la view:

```php
public function render(): ViewContract
{
    $view='pub_theme::components.sections.'.$this->slug;
    if($this->tpl){
        $view.='.'.$this->tpl;
    }
    if(!view()->exists($view)){
        throw new \Exception('View '.$view.' not found'); // ← Errore qui
    }
    return view($view);
}
```

### Causa Principale
Il tema Sixteen non era registrato come dipendenza nel `composer.json` principale, causando il mancato caricamento del ServiceProvider del tema e quindi la mancata registrazione del namespace `pub_theme`.

## ✅ Soluzione

### 1. Registrazione Manuale del Tema

Aggiungere nel `AppServiceProvider.php`:

```php
/**
 * Bootstrap any application services.
 */
public function boot(): void
{
    // Registra il tema Sixteen manualmente
    $this->registerThemeSixteen();
}

/**
 * Registra il tema Sixteen manualmente
 */
protected function registerThemeSixteen(): void
{
    // Registra le viste del tema Sixteen con il namespace pub_theme
    $this->app['view']->addNamespace('pub_theme', base_path('Themes/Sixteen/resources/views'));

    // Registra le traduzioni del tema Sixteen
    $this->app['translator']->addNamespace('pub_theme', base_path('Themes/Sixteen/lang'));
}
```

### 2. Verifica della Soluzione

```bash
# Test di verifica
php artisan tinker --execute="echo view()->exists('pub_theme::components.sections.footer') ? 'EXISTS' : 'NOT FOUND';"

# Output atteso: EXISTS
```

## 📚 Architettura

### Componente Section
Il componente `Section` del modulo CMS:
- Cerca di renderizzare views del tema usando il pattern `pub_theme::components.sections.{slug}`
- Verifica l'esistenza della view prima del rendering
- Lancia un'eccezione se la view non esiste

### Namespace pub_theme
- `pub_theme::` è un alias dinamico che punta al tema attualmente attivo
- Configurato in `config/local/techplanner/xra.php` con `'pub_theme' => 'Sixteen'`
- Deve essere registrato dal ServiceProvider del tema

## 🔗 Riferimenti

- [Documentazione Completa](../../../../docs/pub_theme-view-not-found-error.md)
- [Componente Section](../../app/View/Components/Section.php)
- [Configurazione Tema](../../../../config/local/techplanner/xra.php)
- [ServiceProvider Tema Sixteen](../../../../Themes/Sixteen/app/Providers/ThemeServiceProvider.php)

---

