# Pattern di Design per Email Moderne

## Introduzione

Questo documento esplora i pattern di design più efficaci per le email moderne, basati sull'analisi di numerosi framework e risorse specializzate nel settore. L'obiettivo è fornire linee guida per creare email che massimizzino l'engagement mantenendo compatibilità cross-client e aderenza alle best practices di SaluteOra.

## Pattern Principali

### 1. Modular Design System

Il design modulare consente di costruire email complesse assemblando componenti riutilizzabili:

```
┌─────────────────────────┐
│        HEADER           │
├─────────────────────────┤
│      HERO SECTION       │
├─────────────────────────┤
│    CONTENT SECTION 1    │
├─────────────────────────┤
│    CONTENT SECTION 2    │
├─────────────────────────┤
│         FOOTER          │
└─────────────────────────┘
```

**Vantaggi**:
- Facilità di manutenzione e aggiornamento
- Coerenza visiva tra diverse email
- Testing semplificato di singoli componenti

### 2. Approccio Mobile-First

Progettare prima per dispositivi mobili, poi espandere per desktop:

```css
/* Base styles for mobile */
.column {
  width: 100%;
  display: block;
}

/* Then enhance for larger screens */
@media screen and (min-width: 600px) {
  .column {
    width: 50%;
    display: inline-block;
  }
}
```

**Vantaggi**:
- Priorità all'esperienza della maggioranza degli utenti
- Semplificazione delle decisioni di design
- Caricamento più veloce su dispositivi mobili

### 3. Progressive Enhancement

Implementare funzionalità avanzate con fallback per client meno supportati:

```html
<!-- Base version works everywhere -->
<div style="background-color: #f0f0f0; padding: 20px;">
  <!-- Enhanced version with modern CSS -->
  <!--[if !mso]><!-->
  <div style="background-image: linear-gradient(#f0f0f0, #ffffff); border-radius: 8px;">
  <!--<![endif]-->
    Content here
  <!--[if !mso]><!-->
  </div>
  <!--<![endif]-->
</div>
```

**Vantaggi**:
- Esperienza ottimale su client moderni
- Compatibilità universale
- Future-proof design

## Componenti Ottimizzati

### 1. Header Efficace

Un header ottimizzato include:

```html
<div class="header">
  <div class="logo">
    <img src="{{ asset('modules/notify/images/logo.png') }}" alt="{{ config('app.name') }}" width="180" height="40">
  </div>
  <div class="preheader" style="display:none; font-size:1px; color:#ffffff; line-height:1px; max-height:0px; max-width:0px; opacity:0; overflow:hidden;">
    {{ $preheader ?? 'Anteprima del messaggio che appare nella casella di posta' }}
  </div>
</div>
```

**Elementi chiave**:
- Logo ad alta risoluzione con dimensioni definite
- Preheader nascosto per anteprima nelle inbox
- Design minimalista per caricamento rapido

### 2. Call-to-Action Ottimizzati

```html
<!-- Primary CTA Button -->
<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center">
  <tr>
    <td style="border-radius: 6px; background: #4F46E5;">
      <a href="{{ $cta_url }}" target="_blank" style="padding: 16px 24px; border-radius: 6px; color: #ffffff; font-size: 16px; font-weight: bold; text-decoration: none; display: inline-block;">
        {{ $cta_text ?? 'SCOPRI DI PIÙ' }}
      </a>
    </td>
  </tr>
</table>

<!-- Text Fallback for Better Accessibility -->
<div style="margin-top: 10px; text-align: center;">
  <small style="color: #666666;">Problemi con il pulsante? <a href="{{ $cta_url }}" style="color: #4F46E5; text-decoration: underline;">Clicca qui</a></small>
</div>
```

**Elementi chiave**:
- Struttura tabellare per compatibilità
- Dimensione touch-friendly (min 44x44px)
- Contrasto elevato per accessibilità
- Fallback testuale

### 3. Griglia Responsive a Due Colonne

```html
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
  <tr>
    <!-- Column One -->
    <td class="column" width="50%" style="padding: 0 10px;">
      <img src="{{ $image1_url }}" alt="{{ $image1_alt }}" width="100%" style="max-width: 280px; height: auto; display: block; margin: 0 auto;">
      <h3 style="font-size: 18px; color: #333333;">{{ $title1 }}</h3>
      <p style="font-size: 14px; color: #666666;">{{ $content1 }}</p>
    </td>
    
    <!-- Column Two -->
    <td class="column" width="50%" style="padding: 0 10px;">
      <img src="{{ $image2_url }}" alt="{{ $image2_alt }}" width="100%" style="max-width: 280px; height: auto; display: block; margin: 0 auto;">
      <h3 style="font-size: 18px; color: #333333;">{{ $title2 }}</h3>
      <p style="font-size: 14px; color: #666666;">{{ $content2 }}</p>
    </td>
  </tr>
</table>

<style>
  @media screen and (max-width: 600px) {
    .column {
      width: 100% !important;
      display: block !important;
    }
  }
</style>
```

**Elementi chiave**:
- Layout a due colonne per desktop
- Collassa in colonna singola su mobile
- Immagini responsive con dimensioni esplicite
- Spaziatura coerente

### 4. Footer Compliant

```html
<div class="footer" style="padding: 30px 0; background-color: #f9fafb; text-align: center; color: #6b7280; font-size: 12px;">
  <p>© {{ date('Y') }} {{ config('app.name') }}. Tutti i diritti riservati.</p>
  
  <p>{{ $company_address ?? 'Via Roma 123, 00100 Roma, Italia' }}</p>
  
  <p>
    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('privacy-policy')) }}" style="color: #4b5563; text-decoration: underline;">Privacy Policy</a> | 
    <a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('terms-of-service')) }}" style="color: #4b5563; text-decoration: underline;">Termini e Condizioni</a>
  </p>
  
  <p>Hai ricevuto questa email perché sei iscritto alle comunicazioni di {{ config('app.name') }}.</p>
  
  <p>
    <a href="{{ $unsubscribe_url }}" style="color: #4b5563; text-decoration: underline;">Annulla iscrizione</a> | 
    <a href="{{ $preferences_url }}" style="color: #4b5563; text-decoration: underline;">Gestisci preferenze</a>
  </p>
</div>
```

**Elementi chiave**:
- Conforme alle normative GDPR
- Link di annullamento iscrizione e preferenze
- Informazioni legali complete
- Utilizzo di LaravelLocalization per URL localizzati

## Dark Mode Support

```html
<meta name="color-scheme" content="light dark">
<meta name="supported-color-schemes" content="light dark">

<style>
  :root {
    color-scheme: light dark;
    supported-color-schemes: light dark;
  }
  
  @media (prefers-color-scheme: dark) {
    body {
      background-color: #121212 !important;
      color: #f5f5f5 !important;
    }
    .container {
      background-color: #1f1f1f !important;
    }
    .header {
      background-color: #333333 !important;
    }
    h1, h2, h3 {
      color: #ffffff !important;
    }
    p {
      color: #e0e0e0 !important;
    }
    .footer {
      background-color: #333333 !important;
      color: #a0aec0 !important;
    }
    .footer a {
      color: #90cdf4 !important;
    }
  }
</style>
```

**Note Importanti**:
- Utilizzare `!important` per sovrascrivere gli stili inline
- Testare su dispositivi reali con dark mode abilitata
- Fornire versioni adattate per immagini in dark mode

## Integrazione con Traduzioni

```html
<h1>{{ __('email.welcome.title') }}</h1>
<p>{{ __('email.welcome.subtitle', ['name' => $name]) }}</p>

<a href="{{ $cta_url }}" class="cta-button">
  {{ __('email.welcome.cta') }}
</a>
```

Struttura del file di traduzione:

```php
// lang/it/email.php
return [
    'welcome' => [
        'title' => 'Benvenuto ',
        'subtitle' => 'Ciao :name, siamo felici di averti con noi',
        'cta' => 'ACCEDI AL TUO ACCOUNT',
    ],
];
```

## Elementi di Engagement Avanzati

### 1. Countdown Timer

```html
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
  <tr>
    <td style="background-color: #fef3c7; padding: 20px; text-align: center; border-radius: 8px;">
      <h3 style="color: #92400e; margin: 0 0 10px;">L'offerta scade tra:</h3>
      <div style="font-size: 24px; font-weight: bold; color: #b45309;">
        <!-- Immagine GIF del countdown -->
        <img src="{{ $countdown_url }}" alt="Countdown timer" width="300" height="60">
      </div>
      <p style="color: #92400e; margin-top: 10px;">Approfittane prima che sia troppo tardi!</p>
    </td>
  </tr>
</table>
```

### 2. Personalizzazione Dinamica

```html
<!-- Saluto personalizzato basato sull'orario -->
<h2 style="font-size: 24px; color: #333333;">
  {{ $time < 12 ? __('email.greeting.morning') : ($time < 18 ? __('email.greeting.afternoon') : __('email.greeting.evening')) }}, 
  {{ $name }}!
</h2>

<!-- Contenuto personalizzato basato sul profilo -->
<div style="padding: 20px; background-color: {{ $user_preferences->favorite_color ?? '#f9fafb' }};">
  <p>Abbiamo selezionato questi contenuti in base ai tuoi interessi:</p>
  
  @foreach($recommended_items as $item)
    <div style="margin-bottom: 15px;">
      <h4>{{ $item->title }}</h4>
      <p>{{ $item->description }}</p>
    </div>
  @endforeach
</div>
```

### 3. Micro-Interazioni

```html
<!-- Hover effect per CTA button -->
<style>
  .cta-button {
    transition: all 0.3s ease;
  }
  .cta-button:hover {
    background-color: #3730a3 !important;
    transform: translateY(-2px);
  }
</style>

<!-- Visualizzazione Progressiva (supportata in alcuni client) -->
<div style="opacity: 0; transform: translateY(20px); transition: all 0.5s ease; animation: fadeIn 0.5s forwards;">
  <p>Questo contenuto apparirà con un leggero effetto di fade-in dove supportato.</p>
</div>
<style>
  @keyframes fadeIn {
    to { opacity: 1; transform: translateY(0); }
  }
</style>
```

## Considerazioni Tecniche Finali

1. **Performance**:
   - Peso totale email: max 100KB
   - Ottimizzazione immagini con [TinyPNG](https://tinypng.com/)
   - Minificazione HTML dove possibile

2. **Accessibilità**:
   - Attributi ALT per tutte le immagini
   - Contrasto WCAG AA (min 4.5:1)
   - Struttura semantica con titoli gerarchici
   - Test con screen reader

3. **Testing Cross-Client**:
   - Verifica su Gmail, Outlook, Apple Mail, Yahoo Mail
   - Test su dispositivi iOS e Android
   - Validazione per spam score con [Mail Tester](https://www.mail-tester.com/)

## Riferimenti

- [Responsive Email Templates](./RESPONSIVE_EMAIL_TEMPLATES.md)
- [Email Best Practices](./mail-templates/EMAIL_BEST_PRACTICES.md)
- [HTML Email Compatibility](./mail-templates/HTML_EMAIL_COMPATIBILITY.md)
- [Spatie Email Integration](./SPATIE_EMAIL_USAGE_GUIDE.md)
