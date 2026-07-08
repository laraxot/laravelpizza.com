# Template Email di Base

## Introduzione

Questo documento definisce i template email di base da utilizzare nel modulo Notify, basati sui template di [MailPace](https://github.com/mailpace/templates).

## Template Disponibili

### 1. Welcome Email
**Percorso**: `resources/mail-layouts/templates/welcome.html`

```html
@extends('mail-layouts.base')

@section('content')
<div class="welcome-container">
    <h1>Benvenuto su {{ app_name }}!</h1>
    <p>Grazie per esserti registrato. Siamo entusiasti di averti con noi.</p>
    
    @include('mail-layouts.components.button', [
        'url' => $verification_url,
        'text' => 'Verifica il tuo account'
    ])
    
    <p class="small">Se non hai creato tu questo account, ignora questa email.</p>
</div>
@endsection
```

### 2. Email Confirmation
**Percorso**: `resources/mail-layouts/templates/confirmation.html`

```html
@extends('mail-layouts.base')

@section('content')
<div class="confirmation-container">
    <h1>Conferma il tuo indirizzo email</h1>
    <p>Per completare la registrazione, clicca sul pulsante qui sotto:</p>
    
    @include('mail-layouts.components.button', [
        'url' => $confirmation_url,
        'text' => 'Conferma Email'
    ])
    
    <p class="small">Questo link scadrà tra 24 ore.</p>
</div>
@endsection
```

### 3. Password Reset
**Percorso**: `resources/mail-layouts/templates/password-reset.html`

```html
@extends('mail-layouts.base')

@section('content')
<div class="password-reset-container">
    <h1>Reset della Password</h1>
    <p>Hai richiesto il reset della password. Clicca sul pulsante per procedere:</p>
    
    @include('mail-layouts.components.button', [
        'url' => $reset_url,
        'text' => 'Reset Password'
    ])
    
    <p class="small">Se non hai richiesto tu il reset, ignora questa email.</p>
</div>
@endsection
```

### 4. Receipt
**Percorso**: `resources/mail-layouts/templates/receipt.html`

```html
@extends('mail-layouts.base')

@section('content')
<div class="receipt-container">
    <h1>Ricevuta di Pagamento</h1>
    
    <div class="receipt-details">
        <p><strong>Numero Ordine:</strong> {{ order_number }}</p>
        <p><strong>Data:</strong> {{ order_date }}</p>
        <p><strong>Importo:</strong> {{ order_amount }}</p>
    </div>
    
    <div class="order-items">
        @foreach($items as $item)
            <div class="item">
                <span>{{ $item->name }}</span>
                <span>{{ $item->price }}</span>
            </div>
        @endforeach
    </div>
    
    @include('mail-layouts.components.button', [
        'url' => $order_url,
        'text' => 'Visualizza Ordine'
    ])
</div>
@endsection
```

### 5. Security Alert
**Percorso**: `resources/mail-layouts/templates/security-alert.html`

```html
@extends('mail-layouts.base')

@section('content')
<div class="security-alert-container">
    <h1>Avviso di Sicurezza</h1>
    <p>Abbiamo rilevato un accesso al tuo account da un nuovo dispositivo.</p>
    
    <div class="alert-details">
        <p><strong>Data:</strong> {{ login_date }}</p>
        <p><strong>IP:</strong> {{ login_ip }}</p>
        <p><strong>Dispositivo:</strong> {{ login_device }}</p>
    </div>
    
    @include('mail-layouts.components.button', [
        'url' => $security_url,
        'text' => 'Verifica Attività'
    ])
    
    <p class="small">Se non sei stato tu, cambia immediatamente la password.</p>
</div>
@endsection
```

## Stili CSS

### main.css
```css
/* Stili comuni */
.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Stili specifici per template */
.welcome-container,
.confirmation-container,
.password-reset-container,
.receipt-container,
.security-alert-container {
    background-color: #ffffff;
    border-radius: 8px;
    padding: 24px;
    margin: 20px 0;
}

/* Stili per elementi comuni */
h1 {
    color: #1F2937;
    font-size: 24px;
    margin-bottom: 16px;
}

p {
    color: #4B5563;
    line-height: 1.5;
    margin-bottom: 16px;
}

.small {
    font-size: 14px;
    color: #6B7280;
}

/* Stili per ricevuta */
.receipt-details {
    background-color: #F9FAFB;
    padding: 16px;
    border-radius: 4px;
    margin: 16px 0;
}

.order-items {
    margin: 16px 0;
}

.item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #E5E7EB;
}
```

## Variabili Template

Ogni template accetta le seguenti variabili comuni:

```php
[
    'app_name' => 'Nome Applicazione',
    'company_name' => 'Nome Azienda',
    'company_address' => 'Indirizzo Azienda',
    'company_phone' => 'Telefono Azienda',
    'company_email' => 'Email Azienda',
    'logo_url' => 'URL Logo',
    'primary_color' => '#4F46E5',
    'secondary_color' => '#6366F1'
]
```

## Best Practices

1. **Personalizzazione**
   - Mantenere la coerenza del brand
   - Personalizzare i colori
   - Adattare i testi al contesto

2. **Responsive Design**
   - Testare su mobile
   - Usare media queries
   - Mantenere layout fluido

3. **Accessibilità**
   - Alt text per immagini
   - Contrasto colori
   - Struttura semantica

4. **Performance**
   - Ottimizzare immagini
   - Minimizzare CSS
   - Inline stili critici

## Note Importanti

1. Mantenere la struttura modulare
2. Testare su vari client email
3. Verificare la compatibilità
4. Documentare le variabili

## Collegamenti Correlati

- [Documentazione MailPace](https://github.com/mailpace/templates)
- [Struttura Template](./MAIL_TEMPLATES_STRUCTURE.md)
- [Best Practices](./EMAIL_HTML_BEST_PRACTICES.md)

## Supporto

Per supporto tecnico:
- Email: support@example.com
- Documentazione: https://docs.example.com
- Repository: https://github.com/organization/notify 
