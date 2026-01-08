# Template Email per Alto Engagement

## Introduzione

Questo documento definisce le best practices per la creazione di template email ad alto engagement, basate sull'analisi di oltre 50 risorse e template professionali.

## Struttura Base Ottimizzata

### 1. Header con Logo e Preheader
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ subject }}</title>
    <!-- Preheader Text -->
    <div style="display: none; max-height: 0px; overflow: hidden;">
        {{ preheader_text }}
    </div>
    <div style="display: none; max-height: 0px; overflow: hidden;">
        &#847; &zwnj; &nbsp; &#8199; &shy; &#8203; &#8199; &zwnj; &#847; &zwnj; &nbsp; &#8199; &shy; &#8203; &#8199; &zwnj;
    </div>
</head>
```

### 2. Layout Responsive con Table
```html
<body style="margin: 0; padding: 0; background-color: #f4f4f4; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin: 0; padding: 0;">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Contenuto -->
                </table>
            </td>
        </tr>
    </table>
</body>
```

## Elementi di Engagement

### 1. Hero Section con SVG Animato
```html
<tr>
    <td style="padding: 40px 20px; text-align: center;">
        <svg width="200" height="200" viewBox="0 0 200 200">
            <!-- SVG animato per attirare l'attenzione -->
            <circle cx="100" cy="100" r="80" fill="#4F46E5" opacity="0.2">
                <animate attributeName="r" values="80;90;80" dur="2s" repeatCount="indefinite"/>
            </circle>
            <text x="100" y="110" text-anchor="middle" fill="#4F46E5" style="font-size: 24px; font-weight: bold;">
                {{ headline }}
            </text>
        </svg>
    </td>
</tr>
```

### 2. Call-to-Action Ottimizzato
```html
<tr>
    <td style="padding: 20px; text-align: center;">
        <table role="presentation" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
            <tr>
                <td style="border-radius: 4px; background: linear-gradient(45deg, #4F46E5, #6366F1);">
                    <a href="{{ cta_url }}" style="display: inline-block; padding: 16px 32px; color: #ffffff; text-decoration: none; font-weight: bold; font-size: 16px;">
                        {{ cta_text }}
                    </a>
                </td>
            </tr>
        </table>
    </td>
</tr>
```

### 3. Social Proof
```html
<tr>
    <td style="padding: 20px; text-align: center;">
        <div style="margin: 20px 0;">
            <img src="{{ testimonial_image }}" alt="Testimonial" style="width: 60px; height: 60px; border-radius: 50%;">
            <p style="font-style: italic; color: #4B5563;">
                "{{ testimonial_text }}"
            </p>
            <p style="font-weight: bold; color: #1F2937;">
                {{ testimonial_author }}
            </p>
        </div>
    </td>
</tr>
```

## Ottimizzazione Mobile

### 1. Media Queries
```html
<style>
    @media screen and (max-width: 600px) {
        .container {
            width: 100% !important;
            padding: 10px !important;
        }
        .mobile-padding {
            padding: 10px !important;
        }
        .mobile-text {
            font-size: 16px !important;
            line-height: 1.5 !important;
        }
        .mobile-button {
            width: 100% !important;
            text-align: center !important;
        }
    }
</style>
```

### 2. Fluid Layout
```html
<table role="presentation" width="100%" style="max-width: 600px;">
    <tr>
        <td style="padding: 20px;">
            <img src="{{ image_url }}" alt="{{ image_alt }}" style="width: 100%; height: auto; max-width: 600px;">
        </td>
    </tr>
</table>
```

## Elementi di Fiducia

### 1. Certificazioni e Sicurezza
```html
<tr>
    <td style="padding: 20px; text-align: center; background-color: #F9FAFB;">
        <img src="{{ security_badge }}" alt="Security Badge" style="height: 40px; margin: 0 10px;">
        <img src="{{ ssl_badge }}" alt="SSL Secure" style="height: 40px; margin: 0 10px;">
        <img src="{{ privacy_badge }}" alt="Privacy Certified" style="height: 40px; margin: 0 10px;">
    </td>
</tr>
```

### 2. Footer Professionale
```html
<tr>
    <td style="padding: 20px; text-align: center; background-color: #1F2937; color: #F9FAFB;">
        <p style="margin: 0 0 10px 0;">
            <a href="{{ company_url }}" style="color: #F9FAFB; text-decoration: none;">{{ company_name }}</a>
        </p>
        <p style="margin: 0 0 10px 0; font-size: 14px;">
            {{ company_address }}
        </p>
        <div style="margin: 20px 0;">
            <a href="{{ facebook_url }}" style="margin: 0 10px;"><img src="{{ facebook_icon }}" alt="Facebook" style="height: 24px;"></a>
            <a href="{{ twitter_url }}" style="margin: 0 10px;"><img src="{{ twitter_icon }}" alt="Twitter" style="height: 24px;"></a>
            <a href="{{ linkedin_url }}" style="margin: 0 10px;"><img src="{{ linkedin_icon }}" alt="LinkedIn" style="height: 24px;"></a>
        </div>
        <p style="margin: 0; font-size: 12px;">
            <a href="{{ unsubscribe_url }}" style="color: #9CA3AF; text-decoration: underline;">Annulla iscrizione</a>
        </p>
    </td>
</tr>
```

## Best Practices per Engagement

1. **Personalizzazione**
   - Usa il nome del destinatario
   - Personalizza il contenuto in base al comportamento
   - Segmenta gli invii

2. **Timing**
   - Invia alle ore ottimali
   - Considera i fusi orari
   - Evita i weekend

3. **Contenuto**
   - Usa un tono conversazionale
   - Includi elementi visivi
   - Mantieni il messaggio conciso

4. **Call-to-Action**
   - Usa colori contrastanti
   - Crea un senso di urgenza
   - Rendi il pulsante prominente

## Testing e Ottimizzazione

1. **A/B Testing**
   - Testa diversi subject line
   - Prova layout alternativi
   - Verifica CTA diverse

2. **Analisi**
   - Monitora tassi di apertura
   - Traccia i click
   - Analizza le conversioni

3. **Ottimizzazione**
   - Migliora basandosi sui dati
   - Testa su vari client
   - Verifica la deliverability

## Note Importanti

1. **Compatibilità**
   - Testa su vari client email
   - Verifica su dispositivi mobili
   - Controlla la spam score

2. **Performance**
   - Ottimizza le immagini
   - Minimizza il codice
   - Usa CDN per le risorse

3. **Accessibilità**
   - Usa alt text per le immagini
   - Mantieni un buon contrasto
   - Struttura il contenuto semanticamente

## Collegamenti Correlati

- [Struttura Template](./MAIL_TEMPLATES_STRUCTURE.md)
- [Best Practices HTML](./EMAIL_HTML_BEST_PRACTICES.md)
- [Template Base](./BASE_TEMPLATES.md)

## Supporto

Per supporto tecnico:
- Email: support@example.com
- Documentazione: https://docs.example.com
- Repository: https://github.com/organization/notify 
