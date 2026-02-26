# LangServiceProvider: Gestione automatica delle label nei Filament Forms

## Regola
Non usare mai il metodo `->label()` nei componenti Filament. Le label sono gestite automaticamente tramite LangServiceProvider e i file di traduzione.

## Motivazione
- **Uniformità**: Tutte le label sono centralizzate nei file di lingua, garantendo coerenza tra moduli e componenti.
- **Manutenibilità**: Cambiare una label in una sola posizione aggiorna tutta l'applicazione.
- **Facilità di traduzione**: Tutte le lingue sono gestite tramite i file di traduzione, senza duplicazione di label nel codice.
- **Pulizia del codice**: I form risultano più leggibili e privi di duplicazioni inutili.
- **Scalabilità**: Aggiungere nuove lingue o modificare la struttura è semplice e senza refactoring del codice.

## Come funziona
- Ogni campo viene risolto tramite la chiave `modulo::risorsa.fields.campo.label`.
- Il LangServiceProvider intercetta le richieste di label e restituisce il valore corretto dal file di lingua.

## Esempio
**File di traduzione**
```php
// modules/patient/lang/it/doctor-resource.php
return [
    'fields' => [
        'first_name' => [ 'label' => 'Nome' ],
        'last_name' => [ 'label' => 'Cognome' ],
        // ...
    ],
];
```
**Form Filament**
```php
TextInput::make('first_name') // la label viene risolta automaticamente
```

## Collegamenti
- [Doc specifica Patient](../../Patient/project_docs/langserviceprovider-labels.md)

**Questa regola è obbligatoria per tutti i moduli.**

## Collegamenti tra versioni di langserviceprovider-labels.md
* [langserviceprovider-labels.md](../../Patient/project_docs/langserviceprovider-labels.md)

