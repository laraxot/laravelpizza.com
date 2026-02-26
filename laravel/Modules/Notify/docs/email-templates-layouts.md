# Template Email e Layout - Modulo Notify

## Scopo
Documentazione dei template email utilizzati dal modulo Notify, con collegamenti ai layout del tema One e best practices DRY/KISS.

## Integrazione con Tema One

### Layout Disponibili
Il modulo Notify utilizza i layout email definiti nel tema One:

- **base.html**: Layout generico con variabili Mustache
- **base-it.html**: Layout localizzato italiano
- **basev1-it.html**: Layout migliorato secondo principi DRY/KISS ✨

### Classe SpatieEmail
Il mailable `Modules/Notify/Emails/SpatieEmail.php` gestisce:
- Caricamento dinamico dei layout dal tema attivo
- Popolamento variabili: `site_url`, `logo_header`, `logo_header_base64`, `body`, `subject`
- Integrazione con sistema di template Spatie

## Variabili Template

### Variabili Standard
```mustache
{{ subject }}           # Oggetto email
{{ preheader }}         # Testo anteprima client (nascosto)
{{{ body }}}           # Contenuto HTML principale
{{ site_url }}         # URL base del sito
{{ logo_header }}      # URL logo (preferito)
{{ logo_header_base64 }} # Logo base64 (fallback)
```

### Variabili Personalizzate
Il modulo Notify può estendere le variabili disponibili tramite:
- Configurazione mail template
- Dati dinamici da modelli
- Variabili di contesto specifiche

## Best Practice DRY/KISS

### Principi Applicati
- **DRY**: Template riutilizzabili tra diverse notifiche
- **KISS**: Struttura semplice e compatibile con tutti i client email
- **Modularità**: Separazione tra layout (tema) e contenuto (modulo)

### Regole di Compatibilità
- Struttura tabelle per massima compatibilità
- CSS inline essenziale + reset nel `<style>`
- Supporto responsive ottimizzato
- Dark mode con fallback sicuri

## Miglioramenti basev1-it.html

### Novità Implementate
- **Semantic HTML**: `role="presentation"` per tabelle layout
- **Accessibilità**: `lang="it"`, alt text significativi
- **Performance**: CSS centralizzato (DRY), meno duplicazione
- **Responsive**: Media queries ottimizzate
- **Dark Mode**: Supporto migliorato con variabili CSS

### Struttura Ottimizzata
```html
<!-- Preheader per migliorare open rate -->
<div style="display:none;">{{ preheader }}</div>

<!-- Container principale -->
<table class="email-wrapper">
  <tr>
    <td class="email-container">
      <!-- Header, Body, Footer -->
    </td>
  </tr>
</table>
```

## Utilizzo nel Modulo Notify

### Configurazione Layout
```php
// In SpatieEmail.php
protected function getHtmlLayout(): string
{
    $theme = config('app.theme', 'One');
    $layout = base_path("Themes/{$theme}/resources/mail-layouts/basev1-it.html");
    
    return file_get_contents($layout);
}
```

### Template Email Personalizzati
```php
// Creazione template con layout specifico
MailTemplate::create([
    'slug' => 'appointment-confirmation',
    'subject' => 'Conferma Appuntamento - {{ patient_name }}',
    'body' => view('notify::emails.appointment-confirmation', $data)->render(),
    'layout' => 'basev1-it', // Specifica layout migliorato
]);
```

## Collegamenti Bidirezionali

### Documentazione Correlata
- **Tema One**: `/Themes/One/docs/email_templates.md`
- **Modulo Notify**: Questo documento
- **SpatieEmail**: `docs/spatie-email/`
- **Mail Templates**: `docs/mail-templates/`

### Flusso di Lavoro
1. **Layout** definiti nel tema One
2. **Contenuto** gestito dal modulo Notify
3. **Variabili** popolate da SpatieEmail
4. **Rendering** finale tramite Mustache

## Roadmap

### Prossimi Miglioramenti
- [ ] Supporto template multilingua automatico
- [ ] Editor WYSIWYG integrato con preview layout
- [ ] Sistema di versioning template
- [ ] Analytics apertura/click integrati

### Refactor Pianificati
- [ ] Unificazione naming convention (kebab-case)
- [ ] Consolidamento documentazione duplicata
- [ ] Ottimizzazione performance rendering

## Note Tecniche

### Compatibilità Client Email
- **Gmail**: Supporto completo con fallback SVG
- **Outlook**: Struttura tabelle ottimizzata
- **Apple Mail**: Dark mode nativo
- **Mobile**: Responsive design avanzato

### Performance
- CSS centralizzato riduce dimensioni email
- Preheader migliora deliverability
- Immagini ottimizzate con fallback

---

**Ultimo aggiornamento**: 2025-08-08  
**Versione**: 1.0  
**Compatibilità**: Laravel 12.x, Filament 3.x, Spatie Mail Templates
