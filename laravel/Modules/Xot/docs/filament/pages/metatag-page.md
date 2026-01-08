# MetatagPage

La classe `MetatagPage` è una pagina Filament che gestisce la configurazione dei metatag del sito.

## Caratteristiche Principali

- Gestione completa dei metatag del sito
- Interfaccia utente intuitiva per la configurazione
- Supporto per temi chiari e scuri
- Gestione colori personalizzabile
- Integrazione con il sistema di configurazione Laravel

## Configurazione

```php
protected static ?string $navigationIcon = 'heroicon-o-document-text';
protected static string $view = 'xot::filament.pages.metatag';
```

## Campi Configurabili

### Metatag Base
- `title`: Titolo del sito (obbligatorio)
- `sitename`: Nome del sito
- `subtitle`: Sottotitolo
- `generator`: Generatore
- `charset`: Set di caratteri
- `author`: Autore
- `description`: Descrizione
- `keywords`: Parole chiave

### Logo e Branding
- `logo_header`: Logo principale
- `logo_header_dark`: Logo per tema scuro
- `logo_height`: Altezza del logo

### Gestione Colori
Schema colori personalizzabile con:
- Selezione colori predefiniti
- Colori personalizzati con picker
- Supporto per varianti di colore

## Best Practices

1. **Ottimizzazione SEO**
   - Utilizzare descrizioni uniche e pertinenti
   - Mantenere titoli concisi ed efficaci
   - Includere parole chiave rilevanti

2. **Gestione Logo**
   - Utilizzare immagini ottimizzate
   - Mantenere proporzioni coerenti
   - Fornire alternative per tema scuro

3. **Configurazione Colori**
   - Mantenere coerenza nella palette colori
   - Testare il contrasto per accessibilità
   - Documentare le scelte di design

## Dipendenze

- Filament Forms
- Filament Actions
- Filament Notifications
- Modules Tenant
- Modules Xot

## Esempio di Utilizzo

```php
use Modules\Xot\Filament\Pages\MetatagPage;

// La pagina viene registrata automaticamente in Filament
// e permette la configurazione dei metatag attraverso l'interfaccia admin
```

## Note di Sviluppo

- La vista associata deve essere definita in `xot::filament.pages.metatag`
- I dati vengono salvati nel file di configurazione `metatag.php`
- Supporta la validazione dei campi obbligatori
- Integra il trait `NavigationLabelTrait` per la gestione delle etichette di navigazione

## Link Correlati

- [Documentazione Filament](../../../docs/filament/index.md)
- [Configurazione SEO](../../../docs/seo/index.md)
- [Gestione Temi](../../../docs/themes/index.md) 