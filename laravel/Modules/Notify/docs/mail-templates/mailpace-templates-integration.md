# Integrazione MailPace Templates

## Panoramica

Questo documento descrive l'integrazione dei template email [mailpace/templates](https://github.com/mailpace/templates) nel modulo Notify di . Questi template offrono un design moderno basato su TailwindCSS con supporto nativo per la modalità scura.
Questo documento descrive l'integrazione dei template email [mailpace/templates](https://github.com/mailpace/templates) nel modulo Notify di <nome progetto>. Questi template offrono un design moderno basato su TailwindCSS con supporto nativo per la modalità scura.

## Template Disponibili

MailPace offre i seguenti template transazionali:

1. **Welcome** - Email di benvenuto per nuovi utenti
2. **Email Confirmation** - Conferma dell'indirizzo email
3. **Password Reset** - Ripristino password
4. **Receipt** - Ricevuta per acquisti
5. **Security Alert** - Avviso di sicurezza
6. **Account Deleted** - Notifica di eliminazione account

## Vantaggi dell'Utilizzo

- **Responsive Design** - Ottimizzati per tutti i dispositivi e client email
- **Dark Mode** - Supporto nativo per la modalità scura
- **Accessibilità** - Design accessibile e leggibile
- **Performance** - Ottimizzati per caricamento veloce
- **Personalizzazione** - Facilmente personalizzabili con Maizzle

## Integrazione

### Struttura della Directory

```
Modules/Notify/resources/mail-layouts/
Modules/Notify/resources/mail-layouts/
Modules/Notify/resources/mail-layouts/
├── default.html       # Layout base per la maggior parte delle email
├── main.html          # Alternativa semplificata
├── marketing.html     # Layout ottimizzato per email marketing
└── notification.html  # Layout specifico per notifiche
```

### Processo di Integrazione

1. **Installazione delle Dipendenze**
   ```bash
   npm i -g @maizzle/cli
   cd /percorso/templates
   npm install
   ```

2. **Personalizzazione dei Template**
   ```bash
   npm run dev          # Avvia ambiente di sviluppo
   # Modifica i template secondo necessità
   npm run build        # Genera i template ottimizzati
   ```

3. **Copia dei Template Generati**
   Copia i file HTML dalla directory `dist/` alla directory `resources/mail-layouts/` del modulo Notify.

## Utilizzo dei Template

### Nel Codice

```php
// In un mailable di Laravel
public function build()
{
    return $this->view('notify::emails.welcome')
                ->subject('Benvenuto su '.config('app.name'))
                ->with([
                    'name' => $this->user->name,
                    'actionUrl' => $this->actionUrl,
                ]);
}
```

### Con Spatie/Laravel-Mail-Template

```php
// Nel controller
use Modules\Notify\Models\MailTemplate;

$mailTemplate = MailTemplate::findBySlug('welcome-email');
$mailTemplate->send($user->email, [
    'name' => $user->name,
    'action_url' => $actionUrl
]);
```

## Linee Guida per la Personalizzazione

1. **Mantieni la Struttura Base** - Non modificare la struttura HTML base per garantire compatibilità
2. **Usa Variabili** - Utilizza variabili Blade per contenuti dinamici
3. **Test Cross-Client** - Testa i template su diversi client email
4. **Segui le Convenzioni di Branding** - Usa i colori e font definiti per
4. **Segui le Convenzioni di Branding** - Usa i colori e font definiti per <nome progetto>

## Riferimenti

- [Documentazione Maizzle](https://maizzle.com/docs/)
- [Repository MailPace Templates](https://github.com/mailpace/templates)
- [Guida Spatie Email](../SPATIE_EMAIL_USAGE_GUIDE.md)
- [Implementazione Slug Field](./SLUG_FIELD_IMPLEMENTATION.md)
# Integrazione MailPace Templates

## Panoramica

Questo documento descrive l'integrazione dei template email [mailpace/templates](https://github.com/mailpace/templates) nel modulo Notify di <main module>. Questi template offrono un design moderno basato su TailwindCSS con supporto nativo per la modalità scura.

## Template Disponibili

MailPace offre i seguenti template transazionali:

1. **Welcome** - Email di benvenuto per nuovi utenti
2. **Email Confirmation** - Conferma dell'indirizzo email
3. **Password Reset** - Ripristino password
4. **Receipt** - Ricevuta per acquisti
5. **Security Alert** - Avviso di sicurezza
6. **Account Deleted** - Notifica di eliminazione account

## Vantaggi dell'Utilizzo

- **Responsive Design** - Ottimizzati per tutti i dispositivi e client email
- **Dark Mode** - Supporto nativo per la modalità scura
- **Accessibilità** - Design accessibile e leggibile
- **Performance** - Ottimizzati per caricamento veloce
- **Personalizzazione** - Facilmente personalizzabili con Maizzle

## Integrazione

### Struttura della Directory

```
Modules/Notify/resources/mail-layouts/
├── default.html       # Layout base per la maggior parte delle email
├── main.html          # Alternativa semplificata
├── marketing.html     # Layout ottimizzato per email marketing
└── notification.html  # Layout specifico per notifiche
```

### Processo di Integrazione

1. **Installazione delle Dipendenze**
   ```bash
   npm i -g @maizzle/cli
   cd /percorso/templates
   npm install
   ```

2. **Personalizzazione dei Template**
   ```bash
   npm run dev          # Avvia ambiente di sviluppo
   # Modifica i template secondo necessità
   npm run build        # Genera i template ottimizzati
   ```

3. **Copia dei Template Generati**
   Copia i file HTML dalla directory `dist/` alla directory `resources/mail-layouts/` del modulo Notify.

## Utilizzo dei Template

### Nel Codice

```php
// In un mailable di Laravel
public function build()
{
    return $this->view('notify::emails.welcome')
                ->subject('Benvenuto su '.config('app.name'))
                ->with([
                    'name' => $this->user->name,
                    'actionUrl' => $this->actionUrl,
                ]);
}
```

### Con Spatie/Laravel-Mail-Template

```php
// Nel controller
use Modules\Notify\Models\MailTemplate;

$mailTemplate = MailTemplate::findBySlug('welcome-email');
$mailTemplate->send($user->email, [
    'name' => $user->name,
    'action_url' => $actionUrl
]);
```

## Linee Guida per la Personalizzazione

1. **Mantieni la Struttura Base** - Non modificare la struttura HTML base per garantire compatibilità
2. **Usa Variabili** - Utilizza variabili Blade per contenuti dinamici
3. **Test Cross-Client** - Testa i template su diversi client email
4. **Segui le Convenzioni di Branding** - Usa i colori e font definiti per <main module>

## Riferimenti

- [Documentazione Maizzle](https://maizzle.com/docs/)
- [Repository MailPace Templates](https://github.com/mailpace/templates)
- [Guida Spatie Email](../SPATIE_EMAIL_USAGE_GUIDE.md)
- [Implementazione Slug Field](./SLUG_FIELD_IMPLEMENTATION.md)
