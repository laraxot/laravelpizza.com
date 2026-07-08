# Struttura Template Email

## Introduzione

Questo documento descrive la struttura corretta dei template email nel modulo Notify, utilizzando il pacchetto `spatie/laravel-database-mail-templates`.

## Directory Structure
```
mail-layouts/
├── base.html              # Layout base per tutte le email
└── components/           # Componenti riutilizzabili
    ├── button.html
    ├── header.html
    └── footer.html
```

## Base Layout
Il file `base.html` contiene la struttura HTML base per tutte le email, inclusi:
- Meta tags per client email
- Reset CSS per compatibilità
- Supporto responsive
- Supporto dark mode
- Placeholder per il contenuto (`{{{ body }}}`)

## Componenti
I componenti in `components/` sono parti riutilizzabili del layout:
- `button.html`: Pulsanti CTA
- `header.html`: Header con logo
- `footer.html`: Footer con social e opt-out

## Gestione Template
I template sono gestiti tramite la tabella `mail_templates` usando il pacchetto `spatie/laravel-database-mail-templates`:

```php
MailTemplate::create([
    'mailable' => WelcomeMail::class,
    'subject' => 'Benvenuto, {{ name }}',
    'html_template' => '<h1>Benvenuto, {{ name }}!</h1>',
    'text_template' => 'Benvenuto, {{ name }}!',
]);
```

## Best Practices
1. Mantenere una struttura pulita
2. Creare componenti riutilizzabili
3. Usare HTML email-safe
4. Testare su vari client email
5. Supportare dark mode
6. Ottimizzare per performance

## Gestione Allegati

### Struttura Corretta
Gli allegati devono essere passati come array di array, anche per un singolo allegato:

```php
$attachments = [
    [
        'path' => 'path/to/file.png',
        'as' => 'filename.png',
        'mime' => 'image/png'
    ]
];
```

### Errori Comuni
1. **Errore**: `Cannot access offset of type string on string`
   - **Causa**: Passaggio di un singolo array invece di un array di array
   - **Soluzione**: Wrappare l'array dell'allegato in un array esterno

2. **Errore**: `File not found`
   - **Causa**: Path relativo non corretto
   - **Soluzione**: Usare path assoluto o relativo alla root del progetto

3. **Errore**: `Invalid mime type`
   - **Causa**: Mime type non supportato
   - **Soluzione**: Verificare il mime type corretto del file

### Best Practices Allegati
1. Usare sempre array di array per gli allegati
2. Verificare l'esistenza del file prima dell'invio
3. Specificare sempre il mime type corretto
4. Usare path assoluti o relativi alla root
5. Limitare la dimensione degli allegati
6. Verificare i permessi dei file

### Esempio di Implementazione
```php
// Corretto
$attachments = [
    [
        'path' => storage_path('app/public/logo.png'),
        'as' => 'logo.png',
        'mime' => 'image/png'
    ]
];

// Errore
$attachments = [
    'path' => 'logo.png',  // Array singolo invece di array di array
    'as' => 'logo.png',
    'mime' => 'image/png'
];
```

## Supporto Client Email
- Gmail
- Outlook
- Apple Mail
- Yahoo Mail
- Client mobile

## Test
1. Testare su vari client email
2. Verificare responsive design
3. Controllare dark mode
4. Testare allegati
5. Verificare performance

## Collegamenti Correlati

- [Documentazione MailPace](https://github.com/mailpace/templates)
- [Best Practices Email HTML](./EMAIL_HTML_BEST_PRACTICES.md)
- [Guida Testing](./EMAIL_TESTING.md)

## Supporto

Per supporto tecnico:
- Email: support@example.com
- Documentazione: https://docs.example.com
- Repository: https://github.com/organization/notify 

## Lezioni Apprese

### Gestione Allegati

#### Approccio Corretto
1. **Struttura Dati**:
   - Gli allegati devono essere un array di array
   - Ogni allegato deve avere `path`, `as` e `mime`
   - Il path deve essere relativo alla root del progetto

2. **Path Relativi**:
   - Usare path relativi alla root del progetto
   - Esempio: `modules/notify/resources/assets/images/logo.png`
   - Non usare `storage_path()` o `base_path()`

3. **Mime Type**:
   - Specificare sempre il mime type corretto
   - Esempio: `image/png` per immagini PNG
   - Verificare la compatibilità con i client email

#### Errori da Evitare
1. **Path Assoluti**:
   - ❌ `storage_path('app/public/logo.png')`
   - ❌ `base_path('resources/assets/logo.png')`
   - ✅ `modules/notify/resources/assets/images/logo.png`

2. **Struttura Array**:
   - ❌ Array singolo per allegati
   - ✅ Array di array per allegati

3. **Mime Type**:
   - ❌ Lasciare il mime type predefinito
   - ✅ Specificare sempre il mime type corretto

#### Best Practices Verificate
1. **Organizzazione File**:
   - Mantenere gli allegati in directory dedicate
   - Usare una struttura chiara e organizzata
   - Documentare la posizione dei file

2. **Naming**:
   - Usare nomi descrittivi per i file
   - Evitare spazi e caratteri speciali
   - Mantenere una convenzione coerente

3. **Manutenzione**:
   - Verificare periodicamente i file
   - Aggiornare i mime type se necessario
   - Mantenere la documentazione aggiornata

### Integrazione con Spatie

#### Configurazione
1. **Template**:
   - I template sono gestiti nel database
   - Gli allegati sono gestiti nel codice
   - Separare contenuto e allegati

2. **Mailable**:
   - Estendere `TemplateMailable`
   - Gestire gli allegati nel costruttore
   - Passare le variabili necessarie

3. **Invio**:
   - Usare `Mail::to()->send()`
   - Specificare la locale
   - Gestire gli errori

#### Workflow Corretto
1. **Preparazione**:
   - Verificare l'esistenza dei file
   - Controllare i mime type
   - Validare i path

2. **Invio**:
   - Preparare gli allegati
   - Configurare il template
   - Inviare l'email

3. **Verifica**:
   - Controllare i log
   - Verificare la consegna
   - Testare gli allegati

### Note Importanti
1. La struttura degli allegati è fondamentale
2. I path relativi sono preferibili
3. I mime type devono essere corretti
4. La documentazione deve essere aggiornata
5. I test devono essere completi 
