# Struttura Traduzioni - Modulo Pdnd

## Principio Fondamentale
**MAI usare `->label()`, `->placeholder()`, `->tooltip()` nei componenti Filament**. 

Tutte le traduzioni sono gestite automaticamente dal `LangServiceProvider` del modulo Lang.

## Struttura File di Traduzione

### File di Traduzione per Pagine e Widget
Per le pagine e i widget di Filament, le traduzioni devono essere contenute in un file `pages.php` all'interno della directory `lang/<locale>/` del modulo. Questo file deve seguire una struttura specifica per garantire la corretta risoluzione automatica delle traduzioni.

**Struttura Completa (CRITICA) per Pagine e Widget:**
```php
<?php
declare(strict_types=1);

return [
    'nome_pagina_o_widget' => [ // Chiave unica per la pagina/widget (es. 'servizio_verifica_dich_generalita')
        'title' => 'Titolo della Pagina/Widget',
        'description' => 'Descrizione del contenuto della Pagina/Widget',
        'sections' => [
            'info_generali' => [
                'title' => 'Informazioni Generali',
                'description' => 'Dettagli e impostazioni della sezione',
            ],
        ],
        'fields' => [
            'campo_esempio' => [
                'label' => 'Etichetta Campo',
                'placeholder' => 'Testo placeholder',
                'help' => 'Testo di aiuto per il campo',
                'tooltip' => 'Tooltip informativo',
            ],
        ],
        'actions' => [
            'save' => [
                'label' => 'Salva',
                'icon' => 'heroicon-o-check',
                'tooltip' => 'Salva le modifiche',
            ],
        ],
        'notifications' => [
            'success' => 'Operazione completata con successo!',
            'error' => 'Si è verificato un errore durante l\'operazione.',
        ],
    ],
];
```


### Posizionamento
```
Modules/Pdnd/lang/it/
├── pdnd.php                                          # Traduzioni generali
├── pages.php                                         # Traduzioni per Pagine e Widget Filament
├── guzzle_proxy.php                                  # Test Guzzle
└── curl_proxy.php                                    # Test cURL
```

## Pattern di Traduzione per Campi Form

### Struttura Espansa Obbligatoria
```php
// lang/it/servizio_verifica_dich_generalita.php
return [
    'fields' => [
        'codiceFiscale' => [
            'label' => 'Codice Fiscale',
            'placeholder' => 'Inserisci il codice fiscale',
            'help' => 'Codice fiscale del cittadino da verificare',
        ],
        'cognome' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome come dichiarato dal cittadino',
        ],
        'nome' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome come dichiarato dal cittadino',
        ],
        'sesso' => [
            'label' => 'Sesso',
            'placeholder' => 'M o F',
            'help' => 'M per maschio, F per femmina',
        ],
        'dataNascita' => [
            'label' => 'Data di Nascita',
            'placeholder' => 'YYYY-MM-DD',
            'help' => 'Data di nascita nel formato YYYY-MM-DD',
        ],
        'nomeComune' => [
            'label' => 'Nome Comune',
            'placeholder' => 'Es. Roma',
            'help' => 'Nome del comune di nascita',
        ],
        'codiceIstat' => [
            'label' => 'Codice ISTAT',
            'placeholder' => 'Es. 058091',
            'help' => 'Codice ISTAT del comune',
        ],
        'siglaProvinciaIstat' => [
            'label' => 'Sigla Provincia',
            'placeholder' => 'Es. RM',
            'help' => 'Sigla provincia secondo ISTAT',
        ],
        'descrizioneLocalita' => [
            'label' => 'Descrizione Località',
            'placeholder' => 'Es. Lazio',
            'help' => 'Descrizione della località o regione',
        ],
    ],
];
```

## Pattern per Actions

### Struttura Espansa per Azioni
```php
return [
    'actions' => [
        'pdndFormActions' => [
            'label' => 'Invia Richiesta',
            'tooltip' => 'Invia la richiesta ad ANPR',
            'icon' => 'heroicon-o-paper-airplane',
        ],
        'testConnection' => [
            'label' => 'Esegui Test',
            'tooltip' => 'Testa la connessione al proxy',
            'icon' => 'heroicon-o-play',
        ],
        'clearResults' => [
            'label' => 'Pulisci Risultati',
            'tooltip' => 'Cancella i risultati del test',
            'icon' => 'heroicon-o-trash',
        ],
    ],
];
```

## Pattern per Notifications

### Struttura Espansa per Notifiche
```php
return [
    'notifications' => [
        'success' => 'Operazione completata con successo!',
        'error' => 'Si è verificato un errore!',
        'search_completed' => 'Ricerca completata',
        'search_error' => 'Errore nella ricerca',
        'unexpected_error' => 'Errore imprevisto',
    ],
];
```

## Convenzioni di Naming

### File di Traduzione
- Nome file in snake_case
- Suffisso `_p_r_o_d` per varianti produzione
- Prefisso `servizio_` per servizi ANPR

### Chiavi di Traduzione
```php
'fields.campo_nome.label'       // Label del campo
'fields.campo_nome.placeholder' // Placeholder
'fields.campo_nome.help'        // Testo di aiuto

'actions.nome_azione.label'     // Label azione
'actions.nome_azione.tooltip'   // Tooltip azione
'actions.nome_azione.icon'      // Icona (opzionale)

'messages.success'              // Messaggio successo
'messages.error'                // Messaggio errore
```

## Utilizzo nelle Pagine

### ✅ CORRETTO - Senza label()
```php
public function pdndForm(Schema $schema): Schema
{
    return $schema->schema([
        TextInput::make('codiceFiscale')
            ->required(),
        TextInput::make('cognome')
            ->required(),
        TextInput::make('nome')
            ->required(),
    ]);
}
```

Il `LangServiceProvider` automaticamente:
1. Cerca `pdnd::servizio_verifica_dich_generalita.fields.codiceFiscale.label`
2. Applica `->label()` automaticamente
3. Applica `->placeholder()` e `->helperText()` se presenti

### ❌ ERRATO - Con label() esplicito
```php
// ❌ MAI FARE QUESTO
TextInput::make('codiceFiscale')
    ->label('Codice Fiscale')  // VIETATO
    ->placeholder('...')        // VIETATO
    ->required()
```

## File di Traduzione Attuali

### Verificati e Conformi
- ✅ `pdnd.php` - Struttura espansa completa per traduzioni generali del modulo.
- ✅ `pages.php` - Contiene le traduzioni strutturate per tutte le Pagine e i Widget Filament del modulo.
- ✅ `guzzle_proxy.php` - Struttura espansa completa.
- ✅ `curl_proxy.php` / `curl_proxy_page.php` / `consultazione_anagrafica.php` / `servizio_accertamento_generalita.php` - Etichette navigation localizzate.

### Da Aggiornare
- Verificare completezza delle chiavi per tutti i campi e azioni utilizzati nelle Pagine e nei Widget.
- Aggiungere `tooltip` dove mancanti.
- Standardizzare il formato dei messaggi di successo/errore.
- Mantenere sincronizzati `icon`, `group` e `label` con la tassonomia PDND ogni volta che si introduce un nuovo servizio o si aggiorna uno esistente.

## Checklist Traduzioni

Prima di creare un nuovo componente form:
- [ ] Creare/aggiornare file traduzione in `lang/it/`
- [ ] Usare struttura espansa (label, placeholder, help)
- [ ] NON usare `->label()`, `->placeholder()`, `->tooltip()` nel codice
- [ ] Testare che le traduzioni vengano applicate automaticamente
- [ ] Documentare in questo file eventuali convenzioni specifiche

## Automazione LangServiceProvider

Il provider carica automaticamente le traduzioni per:
- `TextInput`
- `Select`
- `Textarea`
- `DatePicker`
- `Toggle`
- `Checkbox`
- Tutti i componenti form Filament standard

### Come funziona
1. Componente `TextInput::make('codiceFiscale')` viene creato
2. `LangServiceProvider` intercetta il componente
3. Cerca la chiave `{module}::{resource}.fields.codiceFiscale.label`
4. Applica automaticamente `->label()`, `->placeholder()`, `->helperText()`

## Best Practices

### 1. Coerenza
Mantenere stessa struttura in tutti i file di traduzione del modulo.

### 2. Completezza
Ogni campo deve avere almeno `label`. Preferibile avere anche `placeholder` e `help`.

### 3. Contesto
Le traduzioni devono essere auto-esplicative senza dover vedere il codice.

### 4. Formato
- Label: Iniziale maiuscola, breve, chiara
- Placeholder: Esempio pratico di input
- Help: Descrizione completa dello scopo del campo

## Errori Comuni

### Errore: Label non appare
**Causa**: Chiave di traduzione mancante o nome file errato
**Soluzione**: Verificare che esista `lang/it/{resource}.php` con chiave corretta

### Errore: Traduzione in inglese
**Causa**: Fallback a lingua di default
**Soluzione**: Aggiungere traduzione italiana mancante

### Errore: `->label()` ignorato
**Causa**: LangServiceProvider sovrascrive label esplicite
**Soluzione**: Rimuovere `->label()` e usare solo file di traduzione

## Collegamenti
- [LangServiceProvider](../../Lang/app/Providers/LangServiceProvider.php)
- [Best Practices Filament](./filament-best-practices.md)
- [Regole Traduzioni Laraxot](../../Xot/docs/translations-best-practices.md)

*Ultimo aggiornamento: 17 Febbraio 2026*

### Modifiche Recenti

- **Introduzione della Struttura per Pagine e Widget:** Aggiunta una sezione dedicata alla struttura obbligatoria dei file di traduzione `pages.php` per le Pagine e i Widget Filament, inclusi `title`, `description`, `sections`, `fields` e `actions`.
- **Pattern per Notifiche:** Inserita una sezione specifica per la standardizzazione delle traduzioni delle notifiche.
- **Aggiornamento Elenco File di Traduzione:** La sezione "File di Traduzione Attuali" è stata rivista per riflettere l'adozione del file `pages.php` e una maggiore chiarezza.


