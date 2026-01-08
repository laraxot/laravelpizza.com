# Spatie Laravel Database Mail Templates - Analisi Approfondita

## Overview

Il pacchetto **spatie/laravel-database-mail-templates** permette di gestire template email nel database invece che in file Blade, offrendo:
- ✅ Template modificabili via admin panel
- ✅ Versioning automatico
- ✅ Variabili Mustache `{{ variable }}`
- ✅ Layout HTML customizzabili
- ✅ Supporto multilingua (via spatie/translatable)

**Versione Installata**: 3.7.1  
**Repository**: https://github.com/spatie/laravel-database-mail-templates

## Architettura nel Progetto PTVX

### Componenti Chiave

```
Spatie Database Mail Templates System
│
├─ MailTemplate (Model)
│  └─ Implementa MailTemplateInterface
│     ├─ subject (traducibile)
│     ├─ html_template (traducibile)
│     ├─ text_template (traducibile)
│     ├─ sms_template (traducibile)
│     └─ mailable (FQCN classe Mail)
│
├─ SpatieEmail (Mailable)
│  └─ Estende TemplateMailable
│     ├─ getHtmlLayout() → Layout da tema
│     ├─ getSlug() → Identific template
│     ├─ mergeData() → Variabili template
│     └─ embedLogo() → Allegati inline
│
└─ MailTemplateResource (Filament)
   └─ CRUD Admin per gestione template
      ├─ Multilingua (Spatie Translatable)
      └─ Riuso cross-module
```

## MailTemplate Model - Approfondimento

### Database Schema

```sql
CREATE TABLE mail_templates (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    mailable VARCHAR(255) NOT NULL,  -- FQCN classe Mail
    name VARCHAR(255),               -- Nome descrittivo
    slug VARCHAR(255) UNIQUE,        -- Identificativo unico
    subject JSON,                    -- Traducibile
    html_template JSON,              -- Traducibile
    text_template JSON,              -- Traducibile
    sms_template JSON,               -- Traducibile
    params TEXT,                     -- Parametri disponibili (CSV)
    counter INT DEFAULT 0,           -- Contatore invii
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP NULL
);
```

### Campi Traducibili

Il modello usa `HasTranslations` di Spatie:

```php
use Spatie\Translatable\HasTranslations;

class MailTemplate extends SpatieMailTemplate
{
    use HasTranslations;
    
    public array $translatable = [
        'subject',
        'html_template',
        'text_template',
        'sms_template',
    ];
}
```

**Struttura JSON**:
```json
{
  "subject": {
    "it": "Benvenuto, {{ first_name }}",
    "en": "Welcome, {{ first_name }}"
  },
  "html_template": {
    "it": "<p>Ciao {{ first_name }},</p>",
    "en": "<p>Hello {{ first_name }},</p>"
  }
}
```

### Scope `forMailable()`

```php
public function scopeForMailable(Builder $query, Mailable $mailable): Builder
{
    if (!method_exists($mailable, 'getSlug')) {
        throw new \Exception('Il metodo getSlug() non è definito');
    }
    
    $slug = $mailable->getSlug();
    
    return $query
        ->where('mailable', get_class($mailable))
        ->where('slug', $slug);
}
```

**Utilizzo**:
```php
$template = MailTemplate::forMailable($welcomeMail)->first();
```

## SpatieEmail - Mailable Dinamica

### Ereditarietà

```
SpatieEmail
  └─> Spatie\MailTemplates\TemplateMailable
       └─> Illuminate\Mail\Mailable
```

### Constructor - Auto-Create Template

```php
public function __construct(Model $record, string $slug)
{
    $this->slug = Str::slug($slug);
    
    // ✅ Auto-crea template se non esiste!
    $tpl = MailTemplate::firstOrCreate(
        [
            'mailable' => SpatieEmail::class,
            'slug' => $this->slug,
        ],
        [
            'subject' => 'Benvenuto, {{ first_name }}',
            'html_template' => '<p>Gentile {{ first_name }} {{ last_name }},</p>...',
            'text_template' => 'Gentile {{ first_name }} {{ last_name }}, ...',
            'sms_template' => 'Gentile {{ first_name }} {{ last_name }}, ...',
        ],
    );
    
    // Incrementa contatore invii
    $tpl->update(['counter' => $tpl->counter + 1]);
    
    // ... prepare data
}
```

**Business Logic**:
1. Se template non esiste → crea con default
2. Incrementa contatore ogni invio
3. Prepara variabili da model

### Data Merging

```php
// 1. Dati da Model
$data = $record->toArray();

// 2. Dati globali
$this->data['lang'] = app()->getLocale();
$this->data['login_url'] = route('login');
$this->data['site_url'] = url('/'.$lang);

// 3. Dati brand
$this->data['logo_header'] = MetatagData::make()->getBrandLogo();
$this->data['logo_header_base64'] = MetatagData::make()->getBrandLogoBase64();
$this->data['logo_svg'] = MetatagData::make()->getBrandLogoSvg();

// 4. Merge tutto
$this->data = array_merge($this->data, $data);
$this->setAdditionalData($this->data);
```

### HTML Layout da Tema

```php
public function getHtmlLayout(): string
{
    $xot = XotData::make();
    $pub_theme = $xot->pub_theme;  // Es: 'Zero', 'One'
    
    $pubThemePath = base_path('Themes/'.$pub_theme);
    $pathToLayout = $pubThemePath.'/resources/mail-layouts/base.html';
    
    return file_get_contents($pathToLayout);
}
```

**Strategia Fallback**:
```
1. Cerca: Themes/{pub_theme}/resources/mail-layouts/base.html
2. Se non esiste → Exception
3. Alternativa: Modules/Notify/resources/mail-layouts/base.html
```

### Attachment System

#### From Path

```php
public function embedLogo(string $path, string $cid = 'logo_header'): self
{
    if (!file_exists($path)) {
        return $this;
    }
    
    $attachment = Attachment::fromPath($path)
        ->as(basename($path))
        ->withMime(File::mimeType($path));
    
    $this->customAttachments[] = $attachment;
    
    return $this;
}
```

**Utilizzo in template**:
```html
<img src="cid:logo_header" alt="Logo" />
```

#### From Data

```php
public function addAttachments(array $attachments): self
{
    foreach ($attachments as $item) {
        // File esistente
        if (isset($item['path']) && file_exists($item['path'])) {
            $attachment = $this->getAttachmentFromPath($item);
        }
        
        // Dati binari
        if ($attachment === null && isset($item['data'])) {
            $attachment = $this->getAttachmentFromData($item);
        }
        
        $this->customAttachments[] = $attachment;
    }
    
    return $this;
}
```

**Esempio**:
```php
$email = new SpatieEmail($user, 'welcome');
$email->addAttachments([
    [
        'path' => storage_path('pdfs/contract.pdf'),
        'as' => 'contratto.pdf',
        'mime' => 'application/pdf',
    ],
    [
        'data' => $pdfBinaryData,
        'as' => 'fattura.pdf',
        'mime' => 'application/pdf',
    ],
]);
```

### SMS Template

```php
public function buildSms(): string
{
    $sms_template = $this->getMailTemplate()->getAttributeValue('sms_template');
    
    $mustache = app(Mustache_Engine::class);
    $sms = $mustache->render($sms_template, $this->data);
    
    return $sms;
}
```

**Utilizzo**:
```php
$email = new SpatieEmail($user, 'reminder');
$smsText = $email->buildSms();

// Invia SMS con servizio SMS
SmsService::send($user->phone, $smsText);
```

## Mustache Engine - Template Syntax

### Variabili Semplici

```html
<!-- Template -->
<p>Ciao {{ first_name }} {{ last_name }}</p>

<!-- Output con $data = ['first_name' => 'Mario', 'last_name' => 'Rossi'] -->
<p>Ciao Mario Rossi</p>
```

### Condizionali

```html
<!-- Template -->
{{#is_verified}}
<p>Il tuo account è verificato!</p>
{{/is_verified}}

{{^is_verified}}
<p>Per favore verifica il tuo account.</p>
{{/is_verified}}

<!-- Con $data = ['is_verified' => true] -->
<p>Il tuo account è verificato!</p>
```

### Loop

```html
<!-- Template -->
<ul>
{{#items}}
  <li>{{ name }} - {{ price }}€</li>
{{/items}}
</ul>

<!-- Con $data = ['items' => [['name' => 'Prodotto 1', 'price' => 10]]] -->
<ul>
  <li>Prodotto 1 - 10€</li>
</ul>
```

### HTML Non Escaped

```html
<!-- Template -->
{{{ html_content }}}  <!-- Triple mustache = non escaped -->

<!-- Output -->
<strong>Testo in grassetto</strong>  <!-- HTML renderizzato -->
```

## HTML Layout System

### Struttura Layout

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ subject }}</title>
    <style>
        /* Stili inline per compatibilità client email */
    </style>
</head>
<body>
    <table class="wrapper">
        <tr>
            <td>
                <!-- Header con logo -->
                <img src="{{ logo_url }}" alt="Logo" />
            </td>
        </tr>
        <tr>
            <td>
                <!-- PLACEHOLDER CONTENUTO -->
                {{{ body }}}  <!-- ← Template DB inserito qui -->
            </td>
        </tr>
        <tr>
            <td>
                <!-- Footer con social, links, unsubscribe -->
            </td>
        </tr>
    </table>
</body>
</html>
```

### Rendering Pipeline

```
1. SpatieEmail::build()
   ↓
2. TemplateMailable::build()
   ↓
3. getMailTemplate() → MailTemplate da DB
   ↓
4. getHtmlLayout() → Layout da tema
   ↓
5. Mustache Engine compila layout
   ↓
6. Mustache Engine compila template
   ↓
7. Inserisce template in layout (placeholder {{{ body }}})
   ↓
8. Email finale pronta
```

### Variabili Layout

#### Variabili Globali (sempre disponibili)

```php
$this->data = [
    // App
    'lang' => app()->getLocale(),  // 'it', 'en'
    'login_url' => route('login'),
    'site_url' => url('/'.$lang),
    
    // Brand
    'logo_header' => 'https://example.com/logo.png',
    'logo_header_base64' => 'data:image/png;base64,...',
    'logo_svg' => '<svg>...</svg>',
    
    // Social (da MetatagData)
    'facebook_url' => 'https://facebook.com/...',
    'twitter_url' => 'https://twitter.com/...',
    'linkedin_url' => 'https://linkedin.com/...',
    
    // Company
    'company_name' => 'Provincia di Trento',
    'company_url' => 'https://provincia.tn.it',
    'company_address' => 'Via...',
    'unsubscribe_url' => route('unsubscribe', ['token' => '...']),
];
```

#### Variabili da Model

```php
// Record passato al constructor
$record = User::find(1);

// Automaticamente convertito in array
$data = $record->toArray();

// Disponibili in template:
// {{ id }}
// {{ first_name }}
// {{ last_name }}
// {{ email }}
// ... tutti gli attributi del model
```

## Utilizzo Pratico

### Scenario 1: Email di Benvenuto

#### 1. Crea Template nel DB

```php
MailTemplate::create([
    'mailable' => 'Modules\\Notify\\Emails\\SpatieEmail',
    'slug' => 'welcome-user',
    'name' => 'Email di Benvenuto Utente',
    'subject' => [
        'it' => 'Benvenuto {{ first_name }}!',
        'en' => 'Welcome {{ first_name }}!',
    ],
    'html_template' => [
        'it' => '
            <h1>Ciao {{ first_name }} {{ last_name }}!</h1>
            <p>Grazie per esserti registrato.</p>
            <p><a href="{{ login_url }}">Accedi ora</a></p>
        ',
        'en' => '
            <h1>Hello {{ first_name }} {{ last_name }}!</h1>
            <p>Thanks for registering.</p>
            <p><a href="{{ login_url }}">Login now</a></p>
        ',
    ],
    'text_template' => [
        'it' => 'Ciao {{ first_name }}, grazie per esserti registrato. Accedi: {{ login_url }}',
        'en' => 'Hello {{ first_name }}, thanks for registering. Login: {{ login_url }}',
    ],
    'params' => 'first_name,last_name,login_url',
]);
```

#### 2. Invia Email

```php
use Modules\Notify\Emails\SpatieEmail;
use Illuminate\Support\Facades\Mail;

$user = User::find(1);

$email = new SpatieEmail($user, 'welcome-user');

Mail::to($user->email)->send($email);
```

#### 3. Con Variabili Extra

```php
$email = new SpatieEmail($user, 'welcome-user');

$email->mergeData([
    'activation_code' => '123456',
    'expires_at' => '2025-10-30 12:00',
]);

Mail::to($user->email)->send($email);
```

Template può usare:
```html
<p>Codice attivazione: {{ activation_code }}</p>
<p>Scade il: {{ expires_at }}</p>
```

### Scenario 2: Email con Allegati

```php
$scheda = Progressioni::find(100);

$email = new SpatieEmail($scheda, 'progressione-approvata');

// Allega PDF generato
$email->addAttachments([
    [
        'path' => storage_path('app/schede/progressione_'.$scheda->id.'.pdf'),
        'as' => 'progressione.pdf',
        'mime' => 'application/pdf',
    ],
]);

// Embed logo inline
$logoPath = public_path('images/logo.png');
$email->embedLogo($logoPath, 'company_logo');

Mail::to($scheda->user->email)->send($email);
```

Template usa logo inline:
```html
<img src="cid:company_logo" alt="Logo" style="height: 40px;" />
```

### Scenario 3: SMS da Template

```php
// Template ha sms_template
MailTemplate::create([
    'slug' => 'otp-verification',
    'sms_template' => [
        'it' => 'Il tuo codice OTP è: {{ code }}. Valido per {{ expires_minutes }} minuti.',
        'en' => 'Your OTP code is: {{ code }}. Valid for {{ expires_minutes }} minutes.',
    ],
]);

// Genera SMS
$email = new SpatieEmail($user, 'otp-verification');
$email->mergeData([
    'code' => '123456',
    'expires_minutes' => 5,
]);

$smsText = $email->buildSms();
// Output: "Il tuo codice OTP è: 123456. Valido per 5 minuti."

SmsGateway::send($user->phone, $smsText);
```

## Layout Email - Architettura Multi-Tema

### Struttura Cartelle

```
/var/www/html/ptvx/
│
├─ laravel/Modules/Notify/resources/mail-layouts/
│  ├─ base.html                    # Layout default
│  ├─ base/
│  │  ├─ default.html
│  │  └─ responsive.html
│  └─ themes/
│     └─ ... (layout tematici)
│
└─ Themes/
   ├─ SbAdmin2Bs4/resources/mail-layouts/
   │  └─ base.html                # Layout tema SbAdmin2Bs4
   │
   └─ One/resources/mail-layouts/
      └─ base.html                # Layout tema One
```

### Selezione Layout Runtime

```php
// SpatieEmail::getHtmlLayout()

$pub_theme = config('xra.pub_theme');  // 'Zero', 'One', etc.

$pathToLayout = base_path("Themes/{$pub_theme}/resources/mail-layouts/base.html");

if (file_exists($pathToLayout)) {
    return file_get_contents($pathToLayout);
}

// Fallback
$pathToLayout = module_path('Notify', 'resources/mail-layouts/base.html');
return file_get_contents($pathToLayout);
```

**Conseguenza**: Ogni installazione/tenant può avere layout email custom basato sul tema attivo!

### Layout Template Requirements

#### Must Have

1. **Placeholder `{{{ body }}}`**:
   ```html
   <td>{{{ body }}}</td>  <!-- Template DB inserito qui -->
   ```

2. **Variabili Globali**:
   ```html
   <img src="{{ logo_url }}" />
   <a href="{{ site_url }}">Sito</a>
   <a href="{{ unsubscribe_url }}">Annulla</a>
   ```

3. **Responsive CSS**:
   ```html
   <style>
   @media screen and (max-width: 600px) {
       .container { width: 100% !important; }
   }
   </style>
   ```

4. **Dark Mode Support**:
   ```html
   <style>
   @media (prefers-color-scheme: dark) {
       body { background-color: #1F2937; color: #F9FAFB; }
   }
   </style>
   ```

#### Best Practice

✅ **Stili Inline**: Massima compatibilità client email
✅ **Table-Based Layout**: Supporto Outlook
✅ **Max Width 600px**: Standard mobile-friendly
✅ **Preheader Text**: Migliora preview email
✅ **Alt Text per Immagini**: Accessibilità
✅ **Unsubscribe Link**: GDPR compliance

## Integration Points

### Con Altri Moduli

#### Progressioni

```php
// Modules/Progressioni/app/Mail/ProgressioneApprovata.php

class ProgressioneApprovata extends SpatieEmail
{
    public function __construct(Progressioni $progressione)
    {
        parent::__construct($progressione, 'progressione-approvata');
        
        // Dati custom per Progressioni
        $this->mergeData([
            'anno' => $progressione->anno,
            'punteggio' => $progressione->punt_progressione_finale,
            'valutatore' => $progressione->valutatore->nome_diri,
        ]);
    }
}
```

Template può usare:
```html
<p>La tua progressione per l'anno {{ anno }} è stata approvata!</p>
<p>Punteggio finale: {{ punteggio }}</p>
<p>Valutatore: {{ valutatore }}</p>
```

#### IndennitaResponsabilita

```php
class IndennitaApprovata extends SpatieEmail
{
    public function __construct(IndennitaResponsabilita $indennita)
    {
        parent::__construct($indennita, 'indennita-responsabilita-approvata');
        
        $this->mergeData([
            'importo' => number_format($indennita->importo, 2, ',', '.'),
            'dal' => $indennita->dal->format('d/m/Y'),
            'al' => $indennita->al->format('d/m/Y'),
        ]);
    }
}
```

### Con Filament

#### CRUD Admin

`MailTemplateResource` permette:
- ✅ Lista template nel panel admin
- ✅ Edit subject/body in RichEditor
- ✅ Switch lingua (Italiano/Inglese)
- ✅ Preview parametri disponibili
- ✅ Contatore invii

#### Test Email da Filament

```php
// Modules/Notify/app/Filament/Clusters/Test/Pages/SendSpatieEmailPage.php

class SendSpatieEmailPage extends Page
{
    public function sendTestEmail(): void
    {
        $template = MailTemplate::where('slug', $this->selectedTemplate)->first();
        
        $testUser = User::factory()->create();
        $email = new SpatieEmail($testUser, $template->slug);
        
        Mail::to('test@example.com')->send($email);
        
        Notification::make()
            ->title('Email inviata!')
            ->success()
            ->send();
    }
}
```

## Advanced Features

### Auto-Update Params

```php
public function mergeData(array $data): self
{
    $this->data = array_merge($this->data, $data);
    $this->setAdditionalData($this->data);
    
    // ✅ Auto-aggiorna params nel DB
    $params = implode(',', array_keys($this->data));
    MailTemplate::where([
        'slug' => $this->slug,
        'mailable' => SpatieEmail::class
    ])->update(['params' => $params]);
    
    return $this;
}
```

**Business Logic**: Ogni volta che invii email con nuove variabili, il campo `params` viene aggiornato automaticamente per documentare i parametri disponibili.

### Recipient Management

```php
protected ?string $recipient = null;

public function setRecipient(string $email): self
{
    $this->recipient = $email;
    return $this;
}

public function envelope(): Envelope
{
    $envelope = new Envelope;
    
    if ($this->recipient) {
        $envelope->to($this->recipient);
    }
    
    return $envelope;
}
```

**Utilizzo**:
```php
$email = new SpatieEmail($user, 'notification');
$email->setRecipient('custom@example.com');
Mail::send($email);
```

## Best Practice

### 1. Naming Convention

**Slug Template**:
```
{module}-{event}-{recipient}

Esempi:
- progressioni-approvata-dipendente
- progressioni-rifiutata-dirigente
- indennita-approvata-amministratore
```

### 2. Parametri Standard

Sempre includere:
```php
[
    'first_name' => $user->first_name,
    'last_name' => $user->last_name,
    'email' => $user->email,
    'lang' => app()->getLocale(),
    'site_url' => url('/'),
    'login_url' => route('login'),
]
```

### 3. Template Organization

```
slug: {module}-{action}

Gruppi logici:
- welcome-*: Email benvenuto
- verification-*: Email verifica
- notification-*: Notifiche generiche
- reminder-*: Promemoria
- approval-*: Approvazioni
- rejection-*: Rifiuti
```

### 4. Multilingua

Sempre creare traduzioni per TUTTE le lingue supportate:

```php
MailTemplate::create([
    'subject' => [
        'it' => 'Oggetto italiano',
        'en' => 'English subject',
    ],
    'html_template' => [
        'it' => '...',
        'en' => '...',
    ],
]);
```

### 5. Testing

```php
// Test rendering
test('welcome email renders correctly', function () {
    $user = User::factory()->create();
    $email = new SpatieEmail($user, 'welcome-user');
    
    $html = $email->render();
    
    expect($html)
        ->toContain($user->first_name)
        ->toContain($user->last_name)
        ->toContain('Benvenuto');
});

// Test invio
test('welcome email is sent', function () {
    Mail::fake();
    
    $user = User::factory()->create();
    Mail::to($user->email)->send(new SpatieEmail($user, 'welcome-user'));
    
    Mail::assertSent(SpatieEmail::class);
});
```

## Troubleshooting

### Problema: Layout Non Trovato

**Errore**: `file_get_contents(): Failed to open stream`

**Causa**: `Themes/{pub_theme}/resources/mail-layouts/base.html` non esiste

**Fix**:
1. Creare file layout nel tema attivo
2. O modificare `getHtmlLayout()` per usare fallback

### Problema: Variabili Non Sostituite

**Template**: `<p>Ciao {{ first_name }}</p>`  
**Output**: `<p>Ciao {{ first_name }}</p>` (non sostituito!)

**Causa**: Variabile non presente in `$data`

**Fix**: Verificare `mergeData()` include tutte le variabili

### Problema: Template Non Multilingua

**Errore**: Template sempre in italiano anche con `app()->setLocale('en')`

**Causa**: Modello non ha trait `HasTranslations` o campo non è JSON

**Fix**:
1. Aggiungere trait al modello
2. Migration per convertire campo in JSON
3. Ricreare template con traduzioni

## Collegamenti

### Documentazione Esterna
- [GitHub spatie/laravel-database-mail-templates](https://github.com/spatie/laravel-database-mail-templates)
- [Mustache Documentation](https://mustache.github.io/mustache.5.html)
- [Email HTML Best Practices](https://www.campaignmonitor.com/css/)

### Documentazione Interna
- [SpatieEmail Class](../app/Emails/SpatieEmail.php)
- [MailTemplate Model](../app/Models/MailTemplate.php)
- [MailTemplateResource](../app/Filament/Resources/MailTemplateResource.php)
- [Mail Layouts README](../resources/mail-layouts/README.md)
- [Spatie Translatable Integration](./spatie-translatable-integration.md)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Versione Pacchetto**: spatie/laravel-database-mail-templates 3.7.1  
**Compatibilità**: Laravel 12.x, PHP 8.3+

