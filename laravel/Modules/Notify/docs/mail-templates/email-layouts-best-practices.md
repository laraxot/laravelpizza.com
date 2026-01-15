# Email Layouts Best Practices 

Questa documentazione descrive le best practices da seguire per i layout email quando si utilizza `spatie/laravel-database-mail-templates` nel modulo Notify di .
Questa documentazione descrive le best practices da seguire per i layout email quando si utilizza `spatie/laravel-database-mail-templates` nel modulo Notify di <nome progetto>.

## Indice

- [Introduzione](#introduzione)
- [Architettura Corretta](#architettura-corretta)
- [Layout Base vs Contenuto del Template](#layout-base-vs-contenuto-del-template)
- [Responsive Design](#responsive-design)
- [Social Icons con SVG Inline](#social-icons-con-svg-inline)
- [Dark Mode Support](#dark-mode-support)
- [Errori Comuni da Evitare](#errori-comuni-da-evitare)
- [Riferimenti](#riferimenti)

## Introduzione

 utilizza `spatie/laravel-database-mail-templates` per memorizzare e gestire i template email nel database. Questo approccio separa nettamente:
<nome progetto> utilizza `spatie/laravel-database-mail-templates` per memorizzare e gestire i template email nel database. Questo approccio separa nettamente:

1. **Layout HTML base**: Struttura generale dell'email (`resources/mail-layouts/*.html`)
2. **Contenuto dei template**: Contenuto specifico memorizzato nel database (tabella `mail_templates`)

## Architettura Corretta

### Directory e File Corretti

```
/Modules/Notify/
├── resources/
│   ├── mail-layouts/          # Directory per layout HTML base
│   │   ├── README.md          # Documentazione dei layout
│   │   ├── base.html          # Layout principale con header, footer, e placeholder {{{ body }}}
│   │   ├── base/              # Layout base alternativi
│   │   │   ├── default.html   # Layout minimale
│   │   │   └── responsive.html # Layout ottimizzato per responsività
│   │   └── themes/            # Temi alternativi
│   │       ├── light.html     # Tema chiaro
│   │       └── dark.html      # Tema scuro
```

### Regole Fondamentali

1. I file in `resources/mail-layouts/` devono essere **esclusivamente file HTML statici**
2. I layout devono contenere **sempre** il placeholder `{{{ body }}}` dove verrà iniettato il contenuto
3. **MAI** inserire template completi nelle cartelle `mail-layouts/` - solo layout base
4. **MAI** utilizzare file `.blade.php` nella directory `mail-layouts/` - solo file `.html`

## Layout Base vs Contenuto del Template

### Layout Base (file HTML)

I layout base (`resources/mail-layouts/*.html`) forniscono la struttura di base dell'email:

- DOCTYPE, head, meta tag
- Stili CSS comuni e media queries
- Struttura tabellare di base
- Header con logo
- Footer con contatti e social
- Placeholder `{{{ body }}}` per il contenuto

Esempio di layout base corretto:

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>/* CSS comune */</style>
</head>
<body>
    <table>
        <tr><td>Header</td></tr>
        <tr><td>{{{ body }}}</td></tr>
        <tr><td>Footer</td></tr>
    </table>
</body>
</html>
```

### Contenuto del Template (nel database)

Il contenuto specifico del template (memorizzato nella tabella `mail_templates`) contiene il contenuto HTML che verrà iniettato nel placeholder `{{{ body }}}` del layout base:

```html
<h1>Benvenuto {{ $name }}</h1>
<p>Grazie per esserti registrato su {{ $app_name }}.</p>
<!-- Altri contenuti specifici del template -->
```

## Responsive Design

Le email devono essere ottimizzate per la visualizzazione su tutti i dispositivi. Le best practices per il responsive design nelle email includono:

### 1. Meta Tag Viewport

```html
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

### 2. Layout a Tabelle Fluido

```html
<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <table role="presentation" class="container" width="600" cellpadding="0" cellspacing="0">
                <!-- Contenuto -->
            </table>
        </td>
    </tr>
</table>
```

### 3. Media Queries per Mobile

```css
@media screen and (max-width: 600px) {
    .container {
        width: 100% !important;
        border-radius: 0 !important;
    }
    .responsive-padding {
        padding: 15px !important;
    }
    /* Altri stili per mobile */
}
```

### 4. Classi CSS per Responsività

```html
<td class="responsive-content" style="padding: 40px;">
    {{{ body }}}
</td>
```

## Social Icons con SVG Inline

### Perché Usare SVG Inline

1. **Compatibilità**: Molti client email bloccano le immagini esterne per impostazione predefinita
2. **Performance**: Eliminano richieste HTTP aggiuntive
3. **Accessibilità**: Possono includere attributi ARIA per accessibilità
4. **Stili**: Possono essere stilizzati con CSS
5. **Scaling**: Si adattano perfettamente a qualsiasi dimensione senza perdita di qualità

### Esempio di Implementazione Corretta

```html
<!-- Facebook SVG Icon -->
<a href="{{ facebook_url }}" class="responsive-social" style="display: inline-block; margin: 0 10px;">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #F9FAFB;">
        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
    </svg>
</a>
```

### Da Evitare

```html
<!-- MAI usare immagini esterne per icone social -->
<a href="{{ facebook_url }}"><img src="{{ facebook_icon }}" alt="Facebook"></a>
```

## Dark Mode Support

Il supporto per la Dark Mode migliora l'esperienza utente e riduce l'affaticamento visivo in ambienti con poca luce.

### Meta Tags per Dark Mode

```html
<meta name="color-scheme" content="light dark">
<meta name="supported-color-schemes" content="light dark">
```

### CSS per Dark Mode

```css
@media (prefers-color-scheme: dark) {
    body {
        background-color: #111827 !important;
        color: #f1f5f9 !important;
    }
    .container {
        background-color: #1e293b !important;
    }
    /* Altri stili per dark mode */
}
```

## Errori Comuni da Evitare

1. **Template nel posto sbagliato**: MAI inserire template completi in `resources/mail-layouts/` - questi vanno nel database
2. **File Blade in mail-layouts**: MAI utilizzare `.blade.php` in `mail-layouts/` - solo file `.html` puri
3. **Icone come immagini esterne**: Usare sempre SVG inline per le icone, mai immagini esterne
4. **Layout non responsive**: Includere sempre media queries e classi responsive
5. **Mancato supporto per Dark Mode**: Includere sempre supporto per dark mode con meta tags e media queries
6. **Stili CSS non inline**: Preferire stili inline per massima compatibilità con client email
7. **Mancanza del placeholder**: Includere sempre `{{{ body }}}` nei layout

## Riferimenti

- [Documentazione Spatie Laravel Database Mail Templates](https://github.com/spatie/laravel-database-mail-templates)
- [Email Templates Guide](./EMAIL_TEMPLATES_GUIDE.md)
- [Spatie Mail Templates Structure](./SPATIE_MAIL_TEMPLATES_STRUCTURE.md)
- [Template Content Examples](./TEMPLATE_CONTENT_EXAMPLES.md)
