# Layout System Analysis - Problema Namespace pub_theme

## Problema Identificato

### Errore
```
InvalidArgumentException
Unable to locate a class or view for component [pub_theme::components.layouts.main]
```

### Causa
Il namespace `pub_theme::` non è registrato correttamente o il percorso della vista non è accessibile.

## Come Funziona il Sistema

### View Namespaces in Laravel
I namespace delle viste come `pub_theme::` devono essere registrati in un Service Provider.

Esempio:
```php
View::addNamespace('pub_theme', '/path/to/theme/views');
```

### Percorsi Tema
Il tema è in:
```
Themes/Meetup/resources/views/
```

Il namespace `pub_theme::` dovrebbe puntare a questo percorso.

## File [slug].blade.php

Attualmente usa:
```blade
<x-layouts.app>
```

Questo è SBAGLIATO - è il layout dashboard/admin.

## Soluzioni Possibili

### Soluzione 1: Creare Layout in resources/views
Creare `resources/views/components/layouts/main.blade.php` che include il tema.

### Soluzione 2: Usare Layout Esistente
Il file `[slug].blade.php` e `index.blade.php` dovrebbero usare lo stesso layout.

### Soluzione 3: Registrare Namespace Theme
Verificare che esista un Service Provider che registra il namespace `pub_theme::`.

## Strategia Corretta

1. **Non usare namespace pub_theme in Folio pages**
2. **Creare un layout pubblico** in `resources/views/components/layouts/`
3. **Il layout pubblico include navigation e footer del tema**
4. **Il content viene renderizzato tramite `<x-page>` component**

## File da Modificare

1. `Themes/Meetup/resources/views/pages/index.blade.php` - homepage
2. `Themes/Meetup/resources/views/pages/[slug].blade.php` - altre pagine
3. Creare `resources/views/components/layouts/public.blade.php` - layout pubblico

## Next Steps

1. ✅ Analizzare il problema
2. ⏳ Creare layout pubblico corretto
3. ⏳ Aggiornare entrambi i Folio pages
4. ⏳ Aggiungere navigation e footer al layout
5. ⏳ Testare
