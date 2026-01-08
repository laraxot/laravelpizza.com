# Livewire Page\Show

## Scopo
Il componente Livewire `Page\\Show` permette di visualizzare il contenuto di una pagina frontend tramite un tag Blade tipizzato:

```blade
<x-page.show slug="home" />
```

### Vantaggi rispetto a `{!! $_theme->showPageContent('home') !!}`
- Maggiore sicurezza (evita output non controllato)
- Migliore testabilità e riusabilità
- Parametri tipizzati e validati
- Integrabile facilmente in sistemi Livewire/Filament

## Utilizzo

Nel template Blade:
```blade
<x-page.show slug="home" />
```

Il parametro `slug` identifica la pagina da mostrare (es: "home", "about", "contatti").

## Implementazione
- Il componente recupera il contenuto dal CMS tramite lo slug fornito.
- Se la pagina non esiste, mostra un messaggio di fallback o un errore custom.
- Segue le convenzioni Laraxot e le best practice di type safety e separation of concerns.

## Esempio di implementazione
Vedi file: `Modules/Cms/app/Http/Livewire/Page/Show.php`

---

## Collegamenti
- [Indice CMS](../../../../docs/modules/cms.md)

> Aggiornato da Windsurf AI il 17/04/2025
