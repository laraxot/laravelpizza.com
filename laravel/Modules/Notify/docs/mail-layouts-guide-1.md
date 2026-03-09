# Guida ai Layout Email nel Modulo Notify

## Introduzione

Questo documento descrive i layout di email disponibili nella directory `resources/mail-layouts` del modulo Notify di <nome progetto>. Questi layout sono progettati per essere compatibili con la maggior parte dei client email e forniscono una base solida per tutte le email transazionali dell'applicazione.

## Struttura dei Layout

Il modulo Notify contiene quattro layout email principali:

```
resources/mail-layouts/
├── default.html       # Layout base con header, content e footer
├── main.html          # Layout alternativo con design semplificato
├── marketing.html     # Layout ottimizzato per comunicazioni marketing
└── notification.html  # Layout specifico per notifiche di sistema
```

## Caratteristiche dei Layout

### Layout Default (`default.html`)

Il layout predefinito include:
- Header con logo dell'applicazione
- Contenitore principale per il contenuto dell'email
- Footer con copyright e disclaimer
- Stili CSS inline per massima compatibilità
- Design responsive con media queries

### Layout Main (`main.html`)

Versione minimalista del layout default con:
- Design più essenziale
- Meno elementi grafici
- Ottimizzato per messaggi diretti e concisi

### Layout Marketing (`marketing.html`)

Specializzato per comunicazioni marketing:
- Supporto per immagini di intestazione di grandi dimensioni
- Sezioni per contenuti multipli
- Call-to-action ben evidenziate
- Design accattivante

### Layout Notification (`notification.html`)

Ottimizzato per notifiche di sistema:
- Design compatto
- Enfasi su messaggi di stato
- Icone per differenziare tipi di notifica
- Visualizzazione ottimizzata anche su dispositivi mobile

## Utilizzo dei Layout

I layout possono essere utilizzati in due modi principali:

### 1. Con Blade Templates

```php
// In un Mailable Laravel
public function build()
{
    return $this->view('notify::emails.welcome')
                ->subject('Benvenuto in '.config('app.name'));
}

// Nel template welcome.blade.php
@extends('notify::emails.layouts.default')

@section('content')
    <h2>Benvenuto, {{ $user->name }}!</h2>
    <p>Grazie per esserti registrato.</p>
    <a href="{{ $activationUrl }}" class="button">Attiva il tuo account</a>
@endsection
```

### 2. Con Spatie Mail Templates

```php
// Nel modello MailTemplate
use Spatie\MailTemplates\MailTemplate as SpatieMailTemplate;

class MailTemplate extends SpatieMailTemplate
{
    // ...

    public function getHtmlLayout(): string
    {
        // Recupera il layout in base al tipo di email
        $layout = 'default';
        if ($this->isMarketing()) {
            $layout = 'marketing';
        } elseif ($this->isNotification()) {
            $layout = 'notification';
        }

        return file_get_contents(module_path('Notify', "resources/mail-layouts/{$layout}.html"));
    }
}
```

## Personalizzazione

### Variabili Supportate

I layout supportano le seguenti variabili Blade:

- `$subject` - L'oggetto dell'email
- `$content` - Il contenuto principale dell'email
- `config('app.name')` - Nome dell'applicazione
- `asset('images/logo.png')` - Percorso al logo
- `date('Y')` - Anno corrente per il copyright

### Modifica dei CSS

I CSS sono definiti inline all'interno di ciascun layout per massimizzare la compatibilità. Per modificare lo stile:

1. Individua la sezione `<style>` nel file di layout
2. Modifica le regole CSS esistenti o aggiungi nuove regole
3. Testa il risultato su diversi client email

## Best Practices

1. **Test Cross-Client** - Testa sempre su diversi client email (Gmail, Outlook, Apple Mail)
2. **Ottimizzazione Immagini** - Utilizza immagini ottimizzate e specifica dimensioni
3. **Design Responsivo** - Mantieni la struttura responsive per visualizzazione mobile
4. **Lunghezza Email** - Mantieni le email concise e focalizzate
5. **Accessibilità** - Assicurati che colori e contrasto siano accessibili

## Integrazione con MailPace

I layout attuali sono compatibili con l'approccio utilizzato da [mailpace/templates](https://github.com/mailpace/templates). Vedere [MAILPACE_TEMPLATES_INTEGRATION.md](./mail-templates/MAILPACE_TEMPLATES_INTEGRATION.md) per dettagli sull'integrazione.

## Riferimenti

- [Laravel Mail Documentation](https://laravel.com/docs/mail)
- [Spatie Email Documentation](./SPATIE_EMAIL_USAGE_GUIDE.md)
- [Email Best Practices](./mail-templates/EMAIL_BEST_PRACTICES.md)
- [HTML Email Compatibility Guide](./mail-templates/HTML_EMAIL_COMPATIBILITY.md)
