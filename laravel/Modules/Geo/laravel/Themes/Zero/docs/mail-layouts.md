# Tema Zero - Mail Layouts

## Panoramica

Il tema Zero utilizza un layout email basato sul **Design System Italiano** ([italia/design-comuni-pagine-statiche](https://github.com/italia/design-comuni-pagine-statiche)) e integrato con **spatie/laravel-database-mail-templates** per garantire accessibilità, coerenza e professionalità nelle comunicazioni email.

## Struttura Layout

### File Layout

```
Themes/Zero/resources/mail-layouts/
└── base.html          # Layout principale con design italiano
```

### Caratteristiche Principali

1. **Design Italiano**: Colori istituzionali italiani (Blu Italia #0066CC, Verde #00AA66)
2. **Accessibilità WCAG**: Contrasto, semantic HTML, skip links
3. **Responsive Design**: Ottimizzato per mobile, tablet e desktop
4. **Dark Mode**: Supporto automatico per preferenze sistema
5. **TailwindCSS-inspired**: Spacing e colori coerenti con il sistema design
6. **Spatie Mail Templates**: Compatibile con `spatie/laravel-database-mail-templates`

## Integrazione con Spatie Mail Templates

Il layout utilizza il placeholder `{{{ body }}}` come richiesto da `spatie/laravel-database-mail-templates`. Il contenuto viene iniettato dal database tramite la tabella `mail_templates`.

### Esempio di Utilizzo

```php
// Modules/Notify/app/Emails/SpatieEmail.php
public function getHtmlLayout(): string
{
    $xot = XotData::make();
    $pub_theme = $xot->pub_theme; // 'Zero'
    
    $pathToLayout = base_path("Themes/{$pub_theme}/resources/mail-layouts/base.html");
    
    return file_get_contents($pathToLayout);
}
```

## Variabili Disponibili

Il layout supporta le seguenti variabili Mustache:

### Header
- `{{ logo_header }}` - URL del logo
- `{{ logo_header_base64 }}` - Logo in base64
- `{{ logo_svg }}` - Logo SVG
- `{{ company_name }}` - Nome azienda/ente (default: "Provincia di Treviso")

> **Nota 18 novembre 2025**  
> Il valore di default di `logo_svg` punta al nuovo vettoriale multi-canale (`Modules/Notify/resources/svg/logo.svg`). Se un tema vuole personalizzarlo è sufficiente duplicare il file e modificare le classi `.ring`, `.channel`, `.hub` mantenendo le stesse variabili Mustache documentate qui.

### Contenuto
- `{{{ body }}}` - **REQUIRED** - Contenuto principale dall'HTML template del database

### Footer
- `{{ company_address }}` - Indirizzo azienda/ente
- `{{ facebook_url }}` - Link Facebook
- `{{ twitter_url }}` - Link Twitter
- `{{ linkedin_url }}` - Link LinkedIn
- `{{ site_url }}` - URL del sito web
- `{{ unsubscribe_url }}` - Link per annullare iscrizione
- `{{ year }}` - Anno corrente

## Design System

### Colori Istituzionali Italiani

```css
--color-primary: #0066CC;      /* Blu Italia */
--color-primary-dark: #004080;
--color-primary-light: #3399FF;
--color-secondary: #00AA66;     /* Verde Italia */
--color-success: #00AA66;
--color-warning: #FF9900;
--color-danger: #C8102E;
```

### Tipografia

- **Font Family**: 'Titillium Web', 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif
- **Font Size Base**: 16px
- **Line Height**: 1.6

### Spacing (TailwindCSS-inspired)

- `--spacing-xs`: 4px
- `--spacing-sm`: 8px
- `--spacing-md`: 16px
- `--spacing-lg`: 24px
- `--spacing-xl`: 32px
- `--spacing-2xl`: 48px

## Accessibilità

### Requisiti WCAG Implementati

1. **Contrasto**: Minimo 4.5:1 per testo normale, 3:1 per testo grande
2. **Skip Links**: Link per saltare al contenuto principale
3. **Alt Text**: Attributi alt per tutte le immagini
4. **Semantic HTML**: Utilizzo di elementi semantici appropriati
5. **ARIA Labels**: Etichette per link social e elementi interattivi
6. **Responsive**: Layout accessibile su tutti i dispositivi

## Responsive Design

### Breakpoint Mobile

```css
@media screen and (max-width: 600px) {
    /* Layout si adatta automaticamente */
    /* Padding ridotto */
    /* Pulsanti a larghezza piena */
    /* Testo ottimizzato */
}
```

### Compatibilità Client Email

Testato e compatibile con:
- ✅ Gmail (Web, iOS, Android)
- ✅ Outlook (2016, 2019, 365)
- ✅ Apple Mail (macOS, iOS)
- ✅ Yahoo Mail
- ✅ Thunderbird

## Dark Mode

Il layout supporta automaticamente la modalità scura attraverso `@media (prefers-color-scheme: dark)`:

```css
@media (prefers-color-scheme: dark) {
    /* Colori automaticamente invertiti */
    /* Background scuro */
    /* Testo chiaro */
    /* Mantiene contrasto WCAG */
}
```

## Best Practices

### 1. Utilizzo del Layout

Il layout viene caricato automaticamente quando `pub_theme` è impostato a `Zero` nella configurazione:

```php
// config/local/tv/prov/personale2019/xra.php
return [
    'pub_theme' => 'Zero',
    // ...
];
```

### 2. Personalizzazione Logo

Il layout supporta tre modalità per il logo:
1. URL esterno (`logo_header`)
2. Base64 inline (`logo_header_base64`)
3. SVG (`logo_svg`)

Fallback automatico se nessuno è disponibile.

### 3. Social Links

I link social vengono mostrati solo se tutte le variabili sono presenti:
- `facebook_url`
- `twitter_url`
- `linkedin_url`

### 4. Footer Links

I link nel footer sono condizionali:
- Link al sito se `site_url` è presente
- Link unsubscribe se `unsubscribe_url` è presente

## Esempi di Template Database

### Template di Benvenuto

```php
MailTemplate::create([
    'mailable' => SpatieEmail::class,
    'slug' => 'welcome',
    'subject' => 'Benvenuto, {{ first_name }}',
    'html_template' => '
        <h1>Benvenuto, {{ first_name }}!</h1>
        <p>Grazie per esserti registrato a {{ company_name }}.</p>
        <p><a href="{{ login_url }}" class="btn">Accedi al Portale</a></p>
    ',
]);
```

### Template con Pulsante (TailwindCSS-style)

```html
<div style="text-align: center; margin: 24px 0;">
    <a href="{{ action_url }}" class="btn" style="display: inline-block; padding: 12px 24px; background-color: #0066CC; color: #FFFFFF; text-decoration: none; border-radius: 4px; font-weight: 600;">
        Conferma Account
    </a>
</div>
```

## Fallback Strategy

Il sistema implementa una strategia di fallback a cascata:

1. **Layout tema-specifico**: `Themes/{pub_theme}/resources/mail-layouts/base.html`
2. **Layout Notify responsive**: `Modules/Notify/resources/mail-layouts/base/responsive.html`
3. **Layout Notify base**: `Modules/Notify/resources/mail-layouts/base.html`

## Collegamenti

### Documentazione Correlata

- [Mail Layouts Theme Integration](../../../Modules/Notify/docs/mail-layouts-theme-integration.md)
- [Spatie Database Mail Templates](../../../Modules/Notify/docs/spatie-database-mail-templates-deep-dive.md)
- [Email Best Practices](../../../Modules/Notify/docs/email_html_best_practices.md)

### Repository di Riferimento

- [spatie/laravel-database-mail-templates](https://github.com/spatie/laravel-database-mail-templates)
- [italia/design-comuni-pagine-statiche](https://github.com/italia/design-comuni-pagine-statiche)

## Manutenzione

### Quando Modificare il Layout

- Modifiche ai colori istituzionali
- Aggiornamenti design system italiano
- Miglioramenti accessibilità
- Nuove variabili template

### Versionamento

Il layout segue il versionamento semantico del tema Zero. Modifiche breaking devono essere documentate.

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione Layout**: 1.0.0  
**Compatibilità**: Spatie Mail Templates 3.x+

