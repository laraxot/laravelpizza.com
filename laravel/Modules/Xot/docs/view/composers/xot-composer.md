# XotComposer

Il `XotComposer` è un view composer che gestisce la composizione delle viste per il modulo Xot. Si occupa di iniettare dati comuni in tutte le viste che lo utilizzano.

## Caratteristiche Principali

- Iniezione automatica dei parametri della route
- Gestione del tema corrente
- Supporto per asset e percorsi
- Gestione dei meta tag
- Chiamate dinamiche per dati personalizzati

## Metodi Principali

### compose(View $view)
Inietta i dati base nella vista:
- `route_params`: parametri della route corrente
- `theme`: tema attualmente attivo

### asset(string $path): string
Genera il percorso completo per un asset utilizzando la funzione `asset()` di Laravel.

### path(string $path): string
Gestisce i percorsi relativi nell'applicazione.

### metatag(array $options = []): array
Gestisce i meta tag della pagina con supporto per:
- title
- description
- keywords
- author
- robots

## Utilizzo

```php
// In un service provider
View::composer('*', XotComposer::class);

// Nella vista
@section('title', $metatag['title'])
@section('theme', $theme)
```

## Dipendenze

- RouteService
- ThemeService

## Best Practices

1. Utilizzare il composer per dati condivisi tra più viste
2. Mantenere i dati iniettati al minimo necessario
3. Utilizzare i servizi dedicati per logica complessa
4. Documentare tutti i dati disponibili nella vista

## Link Rapidi

- [Implementazione](../../../app/View/Composers/XotComposer.php)
- [Test](../../../tests/Unit/View/Composers/XotComposerTest.php)
- [RouteService](../../services/route-service.md)
- [ThemeService](../../services/theme-service.md) 