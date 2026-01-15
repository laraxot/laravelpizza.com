# Best Practices HTML per Email

## Introduzione

Questo documento definisce le best practices per la creazione di template HTML per email, basate sulle esperienze di [MailPace](https://github.com/mailpace/templates) e altre fonti autorevoli.

## Struttura HTML

### 1. Doctype e Meta Tags
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ subject }}</title>
</head>
```

### 2. Layout Base
```html
<body style="margin: 0; padding: 0; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                    <!-- Contenuto -->
                </table>
            </td>
        </tr>
    </table>
</body>
```

## Best Practices

### 1. Layout e Struttura

#### ✅ Usa Table Layout
```html
<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <!-- Contenuto -->
        </td>
    </tr>
</table>
```

#### ✅ Evita Div Layout
```html
<!-- NON FARE QUESTO -->
<div style="width: 100%;">
    <div style="margin: 0 auto;">
        <!-- Contenuto -->
    </div>
</div>
```

### 2. Stili CSS

#### ✅ Inline CSS
```html
<td style="padding: 20px; background-color: #ffffff;">
    <!-- Contenuto -->
</td>
```

#### ✅ Evita CSS Esterno
```html
<!-- NON FARE QUESTO -->
<link rel="stylesheet" href="styles.css">
```

### 3. Immagini

#### ✅ Dimensioni Esplicite
```html
<img src="logo.png" width="200" height="50" alt="Logo" style="display: block;">
```

#### ✅ Alt Text
```html
<img src="banner.jpg" alt="Descrizione dettagliata" style="display: block;">
```

### 4. Link e Bottoni

#### ✅ Link Stile Button
```html
<a href="{{ url }}" style="display: inline-block; padding: 12px 24px; background-color: #4F46E5; color: #ffffff; text-decoration: none; border-radius: 4px;">
    {{ text }}
</a>
```

#### ✅ Evita Button HTML
```html
<!-- NON FARE QUESTO -->
<button style="padding: 12px 24px;">Click Me</button>
```

## Compatibilità Client Email

### 1. Gmail
- Supporta CSS inline
- Supporta media queries
- Supporta web fonts limitati

### 2. Outlook
- Richiede table layout
- Supporto limitato per CSS
- Problemi con immagini

### 3. Apple Mail
- Supporto completo per CSS
- Supporto per web fonts
- Supporto per media queries

## Responsive Design

### 1. Media Queries
```html
<style>
    @media screen and (max-width: 600px) {
        .container {
            width: 100% !important;
        }
        .mobile-padding {
            padding: 10px !important;
        }
    }
</style>
```

### 2. Fluid Layout
```html
<table role="presentation" width="100%" style="max-width: 600px;">
    <tr>
        <td style="padding: 20px;">
            <!-- Contenuto -->
        </td>
    </tr>
</table>
```

## Performance

### 1. Ottimizzazione Immagini
- Usa formati appropriati (PNG, JPG)
- Comprimi le immagini
- Specifica dimensioni

### 2. CSS
- Minimizza CSS inline
- Usa shorthand properties
- Evita proprietà non supportate

### 3. HTML
- Minimizza markup
- Evita tag non necessari
- Usa attributi HTML base

## Testing

### 1. Client Email
- Gmail (Web, Mobile)
- Outlook (Desktop, Web)
- Apple Mail
- Yahoo Mail

### 2. Dispositivi
- Desktop
- Mobile
- Tablet

### 3. Browser
- Chrome
- Firefox
- Safari
- Edge

## Strumenti di Testing

1. **Email on Acid**
   - Test cross-client
   - Preview in tempo reale
   - Report dettagliati

2. **Litmus**
   - Test di compatibilità
   - Preview responsive
   - Analisi spam

3. **Mailtrap**
   - Test in ambiente sicuro
   - Preview HTML
   - Analisi deliverability

## Note Importanti

1. **Compatibilità**
   - Testare su vari client
   - Verificare responsive
   - Controllare spam score

2. **Accessibilità**
   - Alt text per immagini
   - Contrasto colori
   - Struttura semantica

3. **Performance**
   - Ottimizzare immagini
   - Minimizzare codice
   - Testare velocità

## Collegamenti Correlati

- [Documentazione MailPace](https://github.com/mailpace/templates)
- [Struttura Template](./MAIL_TEMPLATES_STRUCTURE.md)
- [Template Base](./BASE_TEMPLATES.md)

## Supporto

Per supporto tecnico:
- Email: support@example.com
- Documentazione: https://docs.example.com
- Repository: https://github.com/organization/notify 
