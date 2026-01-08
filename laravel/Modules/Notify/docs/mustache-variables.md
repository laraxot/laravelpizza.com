# Mustache Variables - SpatieEmail Template System

**Date**: 2025-12-19  
**Module**: Notify  
**Status**: ✅ Documentazione Completa

## Overview

I template email utilizzano il motore di rendering **Mustache** per sostituire variabili dinamiche nel contenuto HTML. Questo documento elenca tutte le variabili disponibili automaticamente e come aggiungerne di personalizzate.

---

## Variabili Automatiche (Sempre Disponibili)

Queste variabili sono automaticamente popolate da `SpatieEmail` durante la costruzione dell'email.

### Informazioni Email

| Variabile | Tipo | Descrizione | Esempio |
|-----------|------|-------------|---------|
| `{{ subject }}` | string | Oggetto dell'email | `"Buone Feste!"` |
| `{{ preheader_text }}` | string | Testo preheader (opzionale) | `"Le nostre offerte natalizie ti aspettano"` |
| `{{{ body }}}` | HTML | Contenuto principale dell'email (HTML non escaped) | `<p>Testo del corpo...</p>` |

### Informazioni Azienda/Organizzazione

| Variabile | Tipo | Descrizione | Esempio |
|-----------|------|-------------|---------|
| `{{ company_name }}` | string | Nome dell'azienda/organizzazione | `"Provincia di Treviso"` |
| `{{ company_address }}` | string | Indirizzo completo (opzionale) | `"Via Roma 1, 31100 Treviso"` |
| `{{ year }}` | integer | Anno corrente | `2025` |

### Logo Aziendale

Tre variabili per il logo con fallback automatico:

| Variabile | Tipo | Descrizione | Uso |
|-----------|------|-------------|-----|
| `{{ logo_header }}` | string | URL del logo (priorità 1) | `<img src="{{ logo_header }}">` |
| `{{ logo_header_base64 }}` | string | Logo in base64 (priorità 2) | `<img src="data:image/png;base64,{{ logo_header_base64 }}">` |
| `{{ logo_svg }}` | string | Logo SVG (priorità 3) | `<img src="{{ logo_svg }}">` |

**Pattern di utilizzo con fallback** (consigliato):

```html
{{#logo_header}}
<img src="{{ logo_header }}" alt="{{ company_name }}">
{{/logo_header}}
{{^logo_header}}
{{#logo_header_base64}}
<img src="data:image/png;base64,{{ logo_header_base64 }}" alt="{{ company_name }}">
{{/logo_header_base64}}
{{^logo_header_base64}}
{{#logo_svg}}
<img src="{{ logo_svg }}" alt="{{ company_name }}">
{{/logo_svg}}
{{/logo_header_base64}}
{{/logo_header}}
```

### Link e URL

| Variabile | Tipo | Descrizione | Esempio |
|-----------|------|-------------|---------|
| `{{ site_url }}` | string | URL del sito web | `"https://example.com/it"` |
| `{{ login_url }}` | string | URL della pagina di login | `"https://example.com/it/auth/login"` |
| `{{ unsubscribe_url }}` | string | URL per disiscriversi (opzionale) | `"https://example.com/unsubscribe/token"` |

### Social Media Links

| Variabile | Tipo | Descrizione | Esempio |
|-----------|------|-------------|---------|
| `{{ facebook_url }}` | string | Link Facebook (opzionale) | `"https://facebook.com/company"` |
| `{{ twitter_url }}` | string | Link Twitter/X (opzionale) | `"https://twitter.com/company"` |
| `{{ linkedin_url }}` | string | Link LinkedIn (opzionale) | `"https://linkedin.com/company/company"` |

### Lingua

| Variabile | Tipo | Descrizione | Esempio |
|-----------|------|-------------|---------|
| `{{ lang }}` | string | Codice lingua corrente | `"it"` |

---

## Variabili dal Record (Modello Eloquent)

Tutte le proprietà accessibili del modello passato al costruttore di `SpatieEmail` sono disponibili come variabili Mustache.

### Esempio: Modello User

Se crei un'email con `new SpatieEmail($user, 'welcome')`, tutte le proprietà del modello `User` sono disponibili:

```php
// User Model
$user = User::find(1);
// $user->first_name = "Mario"
// $user->last_name = "Rossi"
// $user->email = "mario@example.com"

// In template
{{ first_name }}  // "Mario"
{{ last_name }}   // "Rossi"
{{ email }}       // "mario@example.com"
```

### Variabili Comuni User

| Variabile | Tipo | Descrizione | Esempio |
|-----------|------|-------------|---------|
| `{{ first_name }}` | string | Nome | `"Mario"` |
| `{{ last_name }}` | string | Cognome | `"Rossi"` |
| `{{ email }}` | string | Email | `"mario@example.com"` |
| `{{ phone }}` | string | Telefono (se presente) | `"+39 123 456 7890"` |
| `{{ created_at }}` | datetime | Data di creazione | `"2025-01-15 10:30:00"` |

**Nota**: Le variabili disponibili dipendono dal modello specifico passato. Verifica il modello per vedere tutte le proprietà accessibili.

---

## Variabili Personalizzate con mergeData()

Puoi aggiungere variabili personalizzate usando il metodo `mergeData()` prima di inviare l'email.

### Esempio Utilizzo

```php
use Modules\Notify\Emails\SpatieEmail;
use Illuminate\Support\Facades\Mail;

// Creazione email
$email = new SpatieEmail($client, 'christmas-offer');

// Aggiunta variabili personalizzate
$email->mergeData([
    'discount_percentage' => 20,
    'gift_card_value' => 50,
    'offer_url' => route('christmas-offer'),
    'expiration_date' => '2025-12-31',
    'promo_code' => 'NATALE2025',
]);

// Invio
Mail::to($client->email)->send($email);
```

### In Template

```html
<h2>Ciao {{ first_name }},</h2>
<p>Abbiamo un'offerta speciale per te:</p>
<ul>
    <li>{{ discount_percentage }}% di sconto su tutti i servizi</li>
    <li>Gift card da {{ gift_card_value }}€</li>
    <li>Promo code: <strong>{{ promo_code }}</strong></li>
    <li>Valida fino al {{ expiration_date }}</li>
</ul>
<p style="text-align: center;">
    <a href="{{ offer_url }}" class="btn">Scopri l'offerta</a>
</p>
```

---

## Sintassi Mustache

### Variabili Semplici

```html
{{ variable_name }}  <!-- Escape HTML (sicuro) -->
{{{ variable_name }}} <!-- Non escape HTML (usare con cautela) -->
```

### Sezioni Condizionali

```html
{{#variable_name}}
    <!-- Mostra se variable_name esiste ed è truthy -->
    <p>Il valore è: {{ variable_name }}</p>
{{/variable_name}}

{{^variable_name}}
    <!-- Mostra se variable_name NON esiste o è falsy -->
    <p>Valore non disponibile</p>
{{/variable_name}}
```

### Esempio: Logo con Fallback

```html
{{#logo_header}}
    <img src="{{ logo_header }}" alt="{{ company_name }}">
{{/logo_header}}
{{^logo_header}}
    <!-- Fallback se logo_header non esiste -->
    <h1>{{ company_name }}</h1>
{{/logo_header}}
```

### Loop su Array (Se Supportato)

```html
{{#items}}
    <li>{{ name }} - {{ price }}€</li>
{{/items}}
```

**Nota**: La versione base di Mustache supporta i loop, ma assicurati che i dati siano array semplici.

---

## Best Practices

### 1. Escape HTML per Sicurezza

Usa sempre `{{ variable }}` (escape HTML) per dati utente:

```html
<!-- ✅ SICURO -->
<p>{{ first_name }} {{ last_name }}</p>

<!-- ⚠️ ATTENZIONE: Solo se hai certezza del contenuto -->
{{{ body }}} <!-- Per contenuto HTML già validato -->
```

### 2. Fallback per Variabili Opzionali

Sempre usare sezioni condizionali per variabili che potrebbero non esistere:

```html
{{#company_address}}
    <p>{{ company_address }}</p>
{{/company_address}}

{{#unsubscribe_url}}
    <a href="{{ unsubscribe_url }}">Annulla iscrizione</a>
{{/unsubscribe_url}}
```

### 3. Valori di Default

Per valori di default, usa la sintassi `{{^variable}}default{{/variable}}`:

```html
{{#company_name}}{{ company_name }}{{/company_name}}{{^company_name}}Provincia di Treviso{{/company_name}}
```

### 4. Nomi Variabili Consistenti

Usa sempre **snake_case** per i nomi delle variabili:

```php
// ✅ CORRETTO
'first_name', 'last_name', 'discount_percentage'

// ❌ ERRATO
'firstName', 'LastName', 'discountPercentage'
```

---

## Debugging Variabili

### Verificare Variabili Disponibili

```php
$email = new SpatieEmail($record, 'template-slug');
$data = $email->data; // Array con tutte le variabili disponibili

// Log per debug
\Log::info('Email variables', $data);
```

### Template di Test

Crea un template di test per vedere tutte le variabili disponibili:

```html
<!DOCTYPE html>
<html>
<head><title>Debug Variables</title></head>
<body>
    <h1>Available Variables</h1>
    <pre>
    Subject: {{ subject }}
    Company: {{ company_name }}
    Year: {{ year }}
    First Name: {{ first_name }}
    Email: {{ email }}
    Site URL: {{ site_url }}
    </pre>
</body>
</html>
```

---

## Esempi Pratici

### Esempio 1: Newsletter Natalizia

```php
$email = new SpatieEmail($client, 'christmas-newsletter');
$email->mergeData([
    'discount' => 25,
    'promo_code' => 'NATALE25',
    'expires' => '2025-12-31',
]);
```

```html
<h2>Ciao {{ first_name }},</h2>
<p>Buone Feste da {{ company_name }}!</p>
<p>Offerta speciale: <strong>{{ discount }}% di sconto</strong></p>
<p>Usa il codice: <code>{{ promo_code }}</code></p>
<p>Valida fino al {{ expires }}</p>
```

### Esempio 2: Conferma Appuntamento

```php
$email = new SpatieEmail($appointment, 'appointment-confirmation');
$email->mergeData([
    'appointment_date' => $appointment->date->format('d/m/Y'),
    'appointment_time' => $appointment->time->format('H:i'),
    'doctor_name' => $appointment->doctor->full_name,
]);
```

```html
<p>Gentile {{ first_name }},</p>
<p>Il tuo appuntamento è confermato:</p>
<ul>
    <li>Data: {{ appointment_date }}</li>
    <li>Ora: {{ appointment_time }}</li>
    <li>Dottore: {{ doctor_name }}</li>
</ul>
```

---

## Riferimenti

- [Mustache Manual](https://mustache.github.io/mustache.5.html)
- [Spatie Laravel Mail Templates](https://github.com/spatie/laravel-database-mail-templates)
- [Modules/Notify/app/Emails/SpatieEmail.php](../../app/Emails/SpatieEmail.php)
- [Seasonal Email Templates](./seasonal-email-templates.md)

---

**Creato per facilitare lo sviluppo di template email professionali**  
*Ultimo aggiornamento: 2025-12-19*
