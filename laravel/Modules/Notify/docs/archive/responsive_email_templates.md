# Responsive Email Templates - Guida Completa

## Introduzione

Questa guida fornisce una panoramica completa sulla creazione e l'utilizzo di template email HTML responsive nel contesto di SaluteOra, con focus su compatibilità, engagement e best practices di settore. 

## Principi Fondamentali

### 1. Responsive Design

Le email responsive si adattano automaticamente a diverse dimensioni di schermo, garantendo un'esperienza ottimale su qualsiasi dispositivo:

- **Desktop**: Layout completo con larghezza 600-800px
- **Mobile**: Layout semplificato a colonna singola
- **Media Queries**: `@media (max-width: 600px)` per adattamenti specifici
- **Viewport Meta Tag**: `<meta name="viewport" content="width=device-width, initial-scale=1.0">`

### 2. Struttura HTML

```html
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <title>{{ $subject }}</title>
    <style>
        /* Stili CSS */
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- Header content -->
        </div>
        <div class="content">
            <!-- Main content -->
        </div>
        <div class="footer">
            <!-- Footer with unsubscribe options -->
        </div>
    </div>
</body>
</html>
```

### 3. Layout Tabellare vs CSS

Esistono due approcci principali alla struttura di email HTML:

#### Approccio Tabellare

Più ampiamente supportato dai client email legacy:

```html
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td width="50%" style="padding: 10px;">Colonna 1</td>
        <td width="50%" style="padding: 10px;">Colonna 2</td>
    </tr>
</table>
```

#### Approccio CSS Moderno

Migliore esperienza su client moderni:

```html
<div class="row" style="display: flex; width: 100%;">
    <div class="column" style="width: 50%; padding: 10px;">Colonna 1</div>
    <div class="column" style="width: 50%; padding: 10px;">Colonna 2</div>
</div>
```

Per SaluteOra, si raccomanda un **approccio ibrido**:
- Struttura base con tabelle per massima compatibilità
- CSS moderno con fallback per funzionalità avanzate

## Compatibilità Client Email

I principali client email supportano diversi insiemi di funzionalità HTML/CSS:

| Client          | Supporto CSS     | Media Queries | Dark Mode | Note                      |
|-----------------|------------------|---------------|-----------|---------------------------|
| Gmail           | Moderato         | Sì            | Sì        | Limitazioni in stili `<head>` |
| Apple Mail      | Eccellente       | Sì            | Sì        | Supporto CSS moderno      |
| Outlook Windows | Limitato         | No            | No        | Usa motore Word           |
| Outlook Web     | Buono            | Sì            | Parziale  | Migliorato recentemente   |
| Thunderbird     | Eccellente       | Sì            | Sì        | Supporto CSS moderno      |
| Samsung Mail    | Buono            | Sì            | Sì        | Alcune inconsistenze      |

## Best Practices per Email ad Alto Engagement

### Design e Layout

1. **Struttura Modulare**: Sezioni distinte facilmente componibili
2. **Gerarchia Visiva**: Elementi più importanti in alto
3. **Single Column Design**: Layout a colonna singola per mobile
4. **Spaziatura Generosa**: Facilita la lettura e il tap su elementi
5. **Dimensione Font**: Minimo 14px per testo corpo, 22px per titoli

### Contenuti e Interattività

1. **Call-To-Action (CTA)**: Pulsanti grandi (minimo 44×44px)
2. **Personalizzazione**: Utilizzo di dati utente per personalizzare contenuti
3. **Preheader Text**: Testo visibile nelle anteprime, aumenta aperture
4. **Immagini**: Con attributi `width`, `height` e `alt`
5. **Tasso testo-immagini**: Equilibrio 60% testo, 40% immagini

### Ottimizzazioni Tecniche

1. **CSS Inline**: Utilizzare stili inline per massima compatibilità
2. **Dimensione Email**: Massimo 102KB per evitare clipping
3. **Web Fonts**: Limitarsi a 1-2 font con fallback sicuri
4. **Dark Mode**: Supporto per visualizzazione in ambiente scuro
5. **Test Cross-Client**: Testare su almeno 5 principali client

## Librerie e Framework Consigliati

1. **[MJML](https://mjml.io/)**: Framework per semplificare creazione email responsive
2. **[Foundation for Emails](https://get.foundation/emails.html)**: Framework completo con componenti predefiniti
3. **[Maizzle](https://maizzle.com/)**: Framework basato su Tailwind per email
4. **[Cerberus](https://tedgoas.github.io/Cerberus/)**: Pattern responsive minimali
5. **[Email Framework](https://emailframe.work/)**: Componenti CSS pronti all'uso

## Integrazione con Spatie Laravel Database Mail Templates

Il package `spatie/laravel-database-mail-templates` permette di archiviare e gestire template HTML nel database:

### Implementazione 

```php
// Nel modello MailTemplate
public function getHtmlLayout(): string
{
    // Seleziona il layout in base al tipo di template
    $layoutType = $this->template_type ?? 'default';
    
    // Percorso dinamico al layout
    $layoutPath = module_path('Notify', "resources/mail-layouts/{$layoutType}.html");
    
    // Fallback se non esiste
    if (!file_exists($layoutPath)) {
        $layoutPath = module_path('Notify', "resources/mail-layouts/default.html");
    }
    
    return file_get_contents($layoutPath);
}

// Come inviare email utilizzando il template
MailTemplate::findBySlug('welcome-email')
    ->send($user->email, [
        'name' => $user->first_name,
        'action_url' => $confirmationUrl
    ]);
```

### Variabili Supportate nei Template

I template nella directory `mail-layouts` supportano variabili Blade:

```html
<h1>Benvenuto, {{ $name }}!</h1>
<p>{{ $intro_text }}</p>
<a href="{{ $action_url }}">{{ $action_text }}</a>
```

## Risorse e Strumenti

### Tools di Testing

1. **[Email on Acid](https://www.emailonacid.com/)**: Testing su molteplici client
2. **[Litmus](https://www.litmus.com/)**: Suite completa per preview e test
3. **[HTML Email Check](https://www.htmlemailcheck.com/)**: Validazione codice email

### Builder Visivi

1. **[Unlayer](https://unlayer.com/)**: Editor drag-and-drop per email professionali
2. **[Chamaileon](https://chamaileon.io/)**: Builder con preview responsive
3. **[Stripo](https://stripo.email/)**: Editor email con esportazione HTML

## Riferimenti e Approfondimenti

- [Guida ai Layout Email](./MAIL_LAYOUTS_GUIDE.md)
- [Email Best Practices](./mail-templates/EMAIL_BEST_PRACTICES.md)
- [HTML Email Compatibility](./mail-templates/HTML_EMAIL_COMPATIBILITY.md)
- [MailPace Integration](./mail-templates/MAILPACE_TEMPLATES_INTEGRATION.md)
