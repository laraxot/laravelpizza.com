# Traduzioni: Best Practices in Laraxot

Questo documento definisce le linee guida ufficiali e le best practices per la gestione delle traduzioni all'interno del framework Laraxot.

## Principi Fondamentali

### 1. Struttura Espansa per i Campi

#### ✅ DO - Utilizzare la struttura espansa per i campi

```php
// resources/lang/it/resource.php
return [
    'fields' => [
        'nome_campo' => [
            'label' => 'Etichetta Campo',
            'tooltip' => 'Descrizione di aiuto per il campo',
            'placeholder' => 'Esempio di input'
        ],
        // Altri campi...
    ],
];
```

#### ❌ DON'T - Non utilizzare mai la struttura semplificata

```php
// NON FARE MAI QUESTO
return [
    'fields' => [
        'nome_campo' => 'Etichetta Campo',
    ],
];
```

### 2. Struttura Espansa per le Azioni

#### ✅ DO - Utilizzare la struttura espansa per le azioni

```php
// resources/lang/it/resource.php
return [
    'actions' => [
        'nome_azione' => [
            'label' => 'Etichetta Azione',
            'icon' => 'heroicon-name',
            'color' => 'primary|secondary|success|danger',
            'tooltip' => 'Descrizione dell\'azione'
        ],
        // Altre azioni...
    ],
];
```

#### ❌ DON'T - Non utilizzare mai la struttura semplificata

```php
// NON FARE MAI QUESTO
return [
    'actions' => [
        'nome_azione' => 'Etichetta Azione',
    ],
];
```

## Struttura Completa dei File di Traduzione

### Risorse Filament

Per le risorse Filament, utilizzare la seguente struttura:

```php
// resources/lang/it/socio-resource.php
return [
    // Metadati della risorsa
    'label' => 'Socio',
    'plural_label' => 'Soci',
    'navigation_group' => 'Anagrafiche',
    'navigation_icon' => 'heroicon-o-user',
    'navigation_sort' => 1,
    'description' => 'Gestione completa dei soci',
    
    // Campi del form e tabella
    'fields' => [
        'id_socio' => [
            'label' => 'ID Socio',
            'tooltip' => 'Identificativo univoco del socio'
        ],
        'cognome' => [
            'label' => 'Cognome',
            'tooltip' => 'Cognome del socio',
            'placeholder' => 'Inserisci il cognome'
        ],
        'nome' => [
            'label' => 'Nome',
            'tooltip' => 'Nome del socio',
            'placeholder' => 'Inserisci il nome'
        ],
        // Altri campi...
    ],
    
    // Azioni disponibili
    'actions' => [
        'create' => [
            'label' => 'Nuovo Socio',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Crea un nuovo profilo socio'
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'heroicon-o-pencil',
            'color' => 'primary',
            'tooltip' => 'Modifica i dati del socio'
        ],
        // Altre azioni...
    ],
    
    // Sezioni del form
    'sections' => [
        'personal_data' => [
            'label' => 'Dati Personali',
            'tooltip' => 'Informazioni anagrafiche di base'
        ],
        'contact_info' => [
            'label' => 'Contatti',
            'tooltip' => 'Informazioni di contatto del socio'
        ],
        // Altre sezioni...
    ],
    
    // Messaggi di feedback
    'messages' => [
        'created' => 'Socio creato con successo',
        'updated' => 'Socio aggiornato con successo',
        'deleted' => 'Socio eliminato con successo'
    ],
    
    // Configurazione tabella
    'table' => [
        'empty_text' => 'Nessun socio trovato',
        'search_prompt' => 'Cerca soci...'
    ],
    
    // Testi per i filtri
    'filters' => [
        'is_active' => [
            'label' => 'Solo attivi',
            'description' => 'Mostra solo i soci attivi'
        ],
        'created_at' => [
            'label' => 'Data creazione',
            'description' => 'Filtra per data di creazione'
        ],
        // Altri filtri...
    ]
];
```

### Template di pagina

Per i template generici e le view, utilizzare la seguente struttura:

```php
// resources/lang/it/convenzioni.php
return [
    // Titoli e sottotitoli
    'title' => 'Gestione Convenzioni',
    'subtitle' => 'Elenco completo delle convenzioni attive',
    
    // Elementi UI
    'ui' => [
        'buttons' => [
            'create' => [
                'label' => 'Nuova Convenzione',
                'tooltip' => 'Crea una nuova convenzione'
            ],
            'import' => [
                'label' => 'Importa',
                'tooltip' => 'Importa convenzioni da file'
            ],
            // Altri bottoni...
        ],
        'tabs' => [
            'active' => [
                'label' => 'Attive',
                'tooltip' => 'Convenzioni attualmente attive'
            ],
            'expired' => [
                'label' => 'Scadute',
                'tooltip' => 'Convenzioni terminate'
            ],
            // Altri tab...
        ],
        // Altri elementi UI...
    ],
    
    // Messaggi di feedback
    'messages' => [
        'success' => [
            'created' => 'Convenzione creata con successo',
            'updated' => 'Convenzione aggiornata con successo',
            'deleted' => 'Convenzione eliminata con successo'
        ],
        'errors' => [
            'not_found' => 'Convenzione non trovata',
            'already_exists' => 'Una convenzione con questo nome esiste già',
            'delete_failed' => 'Impossibile eliminare la convenzione'
        ],
        // Altri messaggi...
    ],
    
    // Tooltip e aiuti
    'help' => [
        'discount' => 'Inserisci la percentuale di sconto senza il simbolo %',
        'expiry' => 'La data di scadenza deve essere futura',
        // Altri aiuti...
    ],
    
    // Testi email e notifiche
    'notifications' => [
        'new_convention' => [
            'subject' => 'Nuova convenzione disponibile',
            'body' => 'È stata aggiunta una nuova convenzione: :name',
            // Altri campi email...
        ],
        // Altre notifiche...
    ]
];
```

## Organizzazione dei File

### 1. Separazione per contesto

Organizzare i file di traduzione per contesto (risorse, pagine, componenti, etc.):

```
resources/lang/it/
├── auth.php               # Autenticazione
├── pagination.php         # Paginazione
├── passwords.php          # Password e reset
├── validation.php         # Messaggi di validazione
├── filament.php           # Traduzioni generiche di Filament
├── resources/             # Risorse Filament
│   ├── socio.php
│   ├── convenzione.php
│   └── ...
├── pages/                 # Pagine specifiche
│   ├── dashboard.php
│   ├── reports.php
│   └── ...
├── components/            # Componenti condivisi
│   ├── data-table.php
│   ├── file-upload.php
│   └── ...
├── emails/                # Template email
│   ├── welcome.php
│   ├── notification.php
│   └── ...
└── common.php             # Traduzioni comuni
```

### 2. Nomi dei file

Utilizzare nomi di file che riflettono chiaramente il contesto:

- `[nome-risorsa]-resource.php` per le risorse Filament
- `[nome-pagina]-page.php` per le pagine specifiche
- `[nome-componente]-component.php` per i componenti condivisi

## Utilizzo con i Componenti Filament

### 1. Non utilizzare mai ->label() nei componenti

Come specificato nei MEMORIES, non utilizzare mai il metodo `->label()` direttamente nei componenti Filament:

#### ✅ DO - Utilizzare il componente senza label

```php
// Corretto
Tables\Columns\TextColumn::make('nome')

// Il sistema recupererà automaticamente la traduzione da:
// 'fields' => ['nome' => ['label' => 'Nome Utente']]
```

#### ❌ DON'T - Non utilizzare label() esplicito

```php
// NON FARE MAI QUESTO
Tables\Columns\TextColumn::make('nome')
    ->label('Nome Utente')
```

### 1.1 Non utilizzare mai ->label() in getInfolistSchema()

Questa regola si applica anche al metodo `getInfolistSchema()`. Non bisogna mai utilizzare il metodo `->label()` nei componenti di Infolist:

#### ✅ DO - Utilizzare il componente senza label

```php
// Corretto
public function getInfolistSchema(): array
{
    return [
        'nome' => TextEntry::make('nome'),
        'email' => TextEntry::make('email')
    ];
}
```

#### ❌ DON'T - Non utilizzare label() esplicito

```php
// NON FARE MAI QUESTO
public function getInfolistSchema(): array
{
    return [
        'nome' => TextEntry::make('nome')->label('Nome Utente'),
        'email' => TextEntry::make('email')->label('Indirizzo Email')
    ];
}
```

Il `LangServiceProvider` gestisce automaticamente l'etichettatura di tutti i componenti attraverso il sistema di traduzione. L'uso di `->label()` interferisce con questo meccanismo automatico e può portare a incoerenze nell'interfaccia utente.

### 2. Utilizzo in altri contesti

Per altri contesti, utilizzare la funzione `trans()` o la direttiva `@lang` con i percorsi completi:

```php
// In un controller o service
$label = trans('module-name::resource.fields.field_name.label');

// In una Blade view
<h2>@lang('module-name::page.title')</h2>
<p>@lang('module-name::page.subtitle')</p>
```

## Gestione delle Pluralizzazioni

Utilizzare la struttura di pluralizzazione di Laravel per gestire correttamente le forme plurali:

```php
// resources/lang/it/messages.php
return [
    'apples' => '{0} Nessuna mela|{1} Una mela|[2,*] :count mele',
    'records_count' => '{0} Nessun record trovato|{1} Un record trovato|[2,*] :count records trovati',
];
```

Utilizzo:

```php
echo trans_choice('messages.apples', 0); // Nessuna mela
echo trans_choice('messages.apples', 1); // Una mela
echo trans_choice('messages.apples', 10, ['count' => 10]); // 10 mele
```

## Parametri e Segnaposto

Utilizzare parametri con segnaposto nei testi:

```php
// resources/lang/it/messages.php
return [
    'welcome' => 'Benvenuto, :name!',
    'goodbye' => 'Arrivederci, :name, a :time!',
];
```

Utilizzo:

```php
echo trans('messages.welcome', ['name' => 'Mario']); // Benvenuto, Mario!
echo trans('messages.goodbye', ['name' => 'Mario', 'time' => 'domani']); // Arrivederci, Mario, a domani!
```

## Vantaggi della Struttura Espansa

L'utilizzo della struttura espansa offre numerosi vantaggi:

1. **Completezza**: Ogni campo/azione può avere più attributi associati (label, tooltip, placeholder, etc.)
2. **Coerenza**: Tutti gli elementi dell'interfaccia utilizzano lo stesso pattern
3. **Estendibilità**: Facile aggiungere nuovi attributi in futuro senza modificare il codice
4. **Organizzazione**: Struttura chiara e prevedibile per tutti i file di traduzione
5. **UX migliorata**: Supporto per tooltip, placeholder e altri elementi per migliorare l'esperienza utente

## Perché è Cruciale

Non utilizzare la struttura espansa può causare i seguenti problemi:

1. **Limitazioni UI**: Impossibilità di aggiungere tooltip, placeholder o altri aiuti contestuali
2. **Incoerenza**: Traduzioni gestite in modi diversi in parti diverse dell'applicazione
3. **Manutenzione difficile**: File di traduzione meno organizzati e più difficili da gestire
4. **Problemi di integrazione**: Incompatibilità con il funzionamento atteso del sistema di traduzioni di Laraxot
5. **Modifiche future più complesse**: Necessità di ristrutturare completamente i file in caso di nuove esigenze

## Implementazione Pratica

### Aggiunta di una nuova traduzione

1. Creare il file nella cartella appropriata se non esiste
2. Aggiungere la struttura completa con tutti gli elementi necessari
3. Assicurarsi di utilizzare la struttura espansa per tutti gli elementi
4. Aggiungere commenti per semplificare la manutenzione

Esempio:

```php
<?php

/**
 * Traduzioni per la risorsa Convenzione
 * 
 * @package Modules\Brain\Resources
 */

return [
    'label' => 'Convenzione',
    'plural_label' => 'Convenzioni',
    'navigation_group' => 'Gestione Associativa',
    'navigation_icon' => 'heroicon-o-document-text',
    'navigation_sort' => 3,
    'description' => 'Gestione delle convenzioni con enti e aziende',
    
    'fields' => [
        'id_convenzione' => [
            'label' => 'ID',
            'tooltip' => 'Identificativo univoco della convenzione'
        ],
        'nome' => [
            'label' => 'Nome',
            'tooltip' => 'Nome dell\'ente o azienda convenzionata',
            'placeholder' => 'Es. Azienda XYZ'
        ],
        'descrizione' => [
            'label' => 'Descrizione',
            'tooltip' => 'Descrizione dettagliata della convenzione',
            'placeholder' => 'Inserisci i dettagli della convenzione...'
        ],
        // Altri campi...
    ],
    
    // Resto della struttura...
];
```

### Aggiornamento di traduzioni esistenti

Per aggiornare le traduzioni esistenti da una struttura semplice a una espansa:

1. Identificare i file che utilizzano la struttura semplice
2. Convertire ogni chiave alla struttura espansa appropriata
3. Aggiungere gli attributi aggiuntivi (tooltip, placeholder, etc.) dove necessario
4. Verificare che non ci siano riferimenti diretti nel codice

## Troubleshooting

### Problema: Traduzioni non visualizzate

**Soluzione:** Verificare che:
1. Il file di traduzione sia nella posizione corretta
2. La struttura sia conforme alle linee guida (espansa vs. semplice)
3. Il nome del campo nel componente corrisponda esattamente alla chiave nel file di traduzione
4. Il service provider del modulo estenda `XotBaseServiceProvider` e chiami `parent::boot()`

### Problema: Label hardcoded visibili invece delle traduzioni

**Soluzione:** Verificare che:
1. Non si stia usando il metodo `->label()` nei componenti Filament
2. Il file di traduzione contenga la chiave corretta nella struttura corretta
3. LangServiceProvider sia registrato correttamente
4. I percorsi di caricamento delle traduzioni siano corretti

## Checklist di Implementazione

- [ ] Tutti i file di traduzione utilizzano la struttura espansa per i campi
- [ ] Tutti i file di traduzione utilizzano la struttura espansa per le azioni
- [ ] Nessun componente Filament utilizza il metodo `->label()`
- [ ] I file sono organizzati secondo la struttura consigliata
- [ ] Pluralizzazioni gestite correttamente dove necessario
- [ ] Parametri utilizzati per testi dinamici dove appropriato
- [ ] File commentati per facilitare la manutenzione

## Riferimenti

- [Documentazione Ufficiale Laravel Localization](https://laravel.com/docs/localization)
- [Documentazione di Filament sulla Localizzazione](https://filamentphp.com/docs/3.x/support/localization)
- [LangServiceProvider](/var/www/html/exa/base_orisbroker_fila3/laravel/Modules/Xot/Providers/LangServiceProvider.php)
- [TRANSLATIONS.md](/var/www/html/exa/base_orisbroker_fila3/laravel/Modules/Brain/docs/TRANSLATIONS.md)
