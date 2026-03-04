# Configurazione della Sicurezza

A partire dalla versione 5.3, `Html2Pdf` ha introdotto un `Security Service` per controllare l'accesso a risorse esterne (immagini, fogli di stile, etc.) e prevenire vulnerabilità.

**Menu di Navigazione:**
*   [Panoramica e Installazione](./index.md)
*   [Utilizzo Base e Layout](./usage.md)
*   [Guida agli Stili](./styling.md)
*   [Funzionalità Avanzate](./advanced.md)
*   [Integrazione con Laravel e Best Practices](./laravel.md)

---

## 🛡️ Security Service

Il servizio di sicurezza permette di definire policy per validare gli URI delle risorse esterne.

### Implementazione di una Policy di Sicurezza Personalizzata
È possibile creare una classe che implementa `Spipu\Html2Pdf\Security\SecurityInterface` per definire la propria logica di validazione.

```php
<?php
use Spipu\Html2Pdf\Security\SecurityInterface;

class LaraxotSecurityService implements SecurityInterface
{
    private array $allowedHosts = [];

    public function __construct()
    {
        // Definisci qui gli host considerati sicuri per il progetto
        $this->allowedHosts = [
            'cdn.laraxot.com',
            'images.ptvx.local',
            'fonts.googleapis.com',
        ];
    }

    public function isUriValid(string $uri): bool
    {
        $parsedUrl = parse_url($uri);
        if (!$parsedUrl) {
            return false;
        }

        // Permetti sempre gli URI di tipo 'data' (per immagini Base64)
        if (($parsedUrl['scheme'] ?? '') === 'data') {
            return true;
        }

        // Controlla che lo schema sia http o https
        if (!in_array($parsedUrl['scheme'] ?? '', ['http', 'https'])) {
            return false;
        }

        // Controlla che l'host sia nella whitelist
        $host = $parsedUrl['host'] ?? '';
        return $this->isHostAllowed($host);
    }

    public function isHostAllowed(string $host): bool
    {
        foreach ($this->allowedHosts as $allowedHost) {
            // Usa str_contains per permettere anche sottodomini se necessario
            if (str_contains($host, $allowedHost)) {
                return true;
            }
        }
        return false;
    }

    public function addAllowedHost(string $host): void
    {
        if (!in_array($host, $this->allowedHosts)) {
            $this->allowedHosts[] = $host;
        }
    }
}
```

### Applicare il Servizio di Sicurezza
Una volta creata la classe, puoi associarla all'istanza di `Html2Pdf`.

```php
// In un Service Provider o dove istanzi Html2Pdf
use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf('P', 'A4', 'it');

// Applica il servizio di sicurezza personalizzato
$securityService = new LaraxotSecurityService();
$html2pdf->setSecurityService($securityService);
```

### Metodi del Security Service

#### Aggiungere un Host alla Whitelist
```php
// Aggiunge un host specifico dinamicamente
$html2pdf->getSecurityService()->addAllowedHost('special.trusted-site.com');
```

#### Disabilitare il Controllo (Sconsigliato)
Usare questa opzione solo se strettamente necessario e se si ha pieno controllo dell'HTML, poiché espone a rischi.
```php
// DISABILITA il controllo degli host (USA CON ESTREMA CAUTELA)
$html2pdf->getSecurityService()->disableCheckAllowedHosts();
```

---

## 🎯 Best Practices di Sicurezza

#### 1. Usa Whitelist Selettive
Sii il più specifico possibile con gli host consentiti. Evita wildcard ampie.
```php
// ✅ SICURO
$security->addAllowedHost('cdn.trusted-domain.com');

// ❌ RISCHIOSO
// Non c'è un supporto diretto per i wildcard, ma una logica permissiva
// in `isHostAllowed` potrebbe essere pericolosa.
```

#### 2. Privilegia Immagini in Base64
Il metodo più sicuro per includere immagini è tramite URI `data` (Base64), perché non richiede accessi a risorse esterne e viene validato automaticamente come sicuro.
```html
<!-- ✅ RACCOMANDATO -->
<img src="data:image/png;base64,{{ base64_encode($imageData) }}" />
```

#### 3. Sanitizza sempre l'HTML
Se l'HTML proviene da input dell'utente, è **obbligatorio** sanitizzarlo prima di passarlo a `Html2Pdf` per prevenire attacchi XSS o rotture del layout.
```php
// Esempio con una libreria di sanitizzazione
$sanitizedHtml = HtmlSanitizer::sanitize($userInput);

$html2pdf->writeHTML($sanitizedHtml);
```

#### 4. Logging dei Tentativi Falliti
È utile registrare i tentativi di accesso a URI non validi per monitorare potenziali abusi.
```php
// All'interno del metodo isUriValid
public function isUriValid(string $uri): bool
{
    // ... logica di validazione ...

    if (!$isValid) {
        Log::warning('Tentativo di accesso a URI non valido in Html2Pdf', ['uri' => $uri]);
        return false;
    }
    return true;
}
```
