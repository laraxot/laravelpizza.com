# Architettura Servizi ANPR - Modulo Pdnd

## Panoramica
Il modulo Pdnd utilizza un'architettura a servizi per interfacciarsi con ANPR (Anagrafe Nazionale Popolazione Residente) tramite PDND.

## Gerarchia Classi

```
PdndClientService (base)
├── Gestione autenticazione OAuth2
├── Generazione JWT Bearer
└── Configurazione endpoint ANPR

AnprServiceOrchestrator
├── Coordinamento servizi ANPR
└── Gestione errori centralizzata

Servizi Specifici:
├── C003Service (Verifica Generalità)
│   ├── verificaPerIdAnpr()
│   └── Gestione TipoGeneralita
│
└── C030Service (Accertamento ID)
    ├── cercaPerCodiceFiscale()
    └── Estrazione ID ANPR
```

## Servizi Implementati

### PdndClientService
**Namespace**: `Modules\Pdnd\Services\Client`

**Responsabilità**:
- Autenticazione OAuth2 con PDND
- Generazione e refresh token JWT
- Gestione certificati client mTLS
- Configurazione endpoint per ambiente (test/prod)

**Metodi principali**:
```php
public function __construct(string $ambiente = 'test')
public function getAccessToken(): PdndAccessToken
public function makeRequest(string $endpoint, array $data): array
```

**Configurazione**:
```php
// .env
PDND_CLIENT_ID=your-client-id
PDND_CLIENT_SECRET=your-secret
PDND_CERTIFICATE_PATH=/path/to/cert.pem
PDND_KEY_PATH=/path/to/key.pem
```

### C003Service - Verifica Dichiarazione Generalità
**Namespace**: `Modules\Pdnd\Services\Anpr\Services\C003`

**Scopo**: Verificare la corrispondenza tra generalità dichiarate da un cittadino e quelle registrate in ANPR.

**Input richiesto**:
- ID ANPR del soggetto
- Oggetto `TipoGeneralita` contenente:
  - Codice fiscale
  - Cognome
  - Nome
  - Sesso
  - Data di nascita
  - Luogo di nascita

**Metodo principale**:
```php
public function verificaPerIdAnpr(
    string $idAnpr, 
    TipoGeneralita $generalita
): array
```

**Output**:
```php
[
    'successo' => true|false,
    'lista_soggetti' => [
        [
            'info_soggetto_ente' => [
                ['valore' => 'OK'|'KO']
            ]
        ]
    ],
    'errori' => [...] // se presenti
]
```

**Uso nelle pagine**:
```php
$c003Service = new C003Service(
    app()->make(PdndClientService::class, [
        'servizio' => ServizioAnprEnum::C003,
        'ambiente' => 'test', // o 'prod'
    ])
);

$risultato = $c003Service->verificaPerIdAnpr($idAnpr, $generalita);
```

### C030Service - Accertamento ID Unico Nazionale
**Namespace**: `Modules\Pdnd\Services\Anpr\Services\C030`

**Scopo**: Ricerca soggetto in ANPR tramite codice fiscale e ottiene l'ID ANPR univoco.

**Input richiesto**:
- Codice fiscale del soggetto

**Metodo principale**:
```php
public function cercaPerCodiceFiscale(string $codiceFiscale): array
```

**Output**:
```php
[
    'successo' => true|false,
    'lista_soggetti' => [
        [
            'id_anpr' => 'ABC123XYZ456',
            'dati_anagrafici' => [...]
        ]
    ],
    'errori' => [...] // se presenti
]
```

**Uso nelle pagine**:
```php
$c030Service = new C030Service(
    app()->make(PdndClientService::class, [
        'ambiente' => 'test', // o 'prod'
    ])
);

$risultato = $c030Service->cercaPerCodiceFiscale('RSSMRA80A01H501U');
$idAnpr = $risultato['lista_soggetti'][0]['id_anpr'] ?? null;
```

## Data Transfer Objects (DTO)

### Request Objects
- `RichiestaE002`: Base per tutte le richieste
- `TipoDatiRichiestaE002`: Dati della richiesta
- `TipoCriteriRicercaE002`: Criteri di ricerca
- `TipoVerificaE002`: Dati per verifica

### Response Objects
- `RispostaE002OK`: Risposta successo
- `RispostaKO`: Risposta errore
- `TipoListaSoggetti`: Lista soggetti trovati
- `TipoDatiSoggettiEnte`: Dati soggetto

### Common Objects
- `TipoGeneralita`: Dati anagrafici completi
- `TipoCodiceFiscale`: Wrapper codice fiscale
- `TipoLuogoEvento`: Luogo nascita/residenza
- `TipoComune`: Dati comune
- `TipoLocalita`: Dati località

## Pattern di Utilizzo

### Pattern 1: Verifica Completa (C030 + C003)
```php
// Step 1: Cerca ID ANPR
$c030Service = new C030Service(app(PdndClientService::class));
$risultatoC030 = $c030Service->cercaPerCodiceFiscale($codiceFiscale);
$idAnpr = $risultatoC030['lista_soggetti'][0]['id_anpr'];

// Step 2: Verifica generalità
$c003Service = new C003Service(
    app()->make(PdndClientService::class, [
        'servizio' => ServizioAnprEnum::C003,
    ])
);

$generalita = new TipoGeneralita(
    codiceFiscale: new TipoCodiceFiscale($codiceFiscale),
    cognome: $cognome,
    nome: $nome,
    sesso: $sesso,
    dataNascita: $dataNascita,
    luogoNascita: $luogoNascitaObj
);

$risultatoC003 = $c003Service->verificaPerIdAnpr($idAnpr, $generalita);
```

### Pattern 2: Solo Ricerca ID
```php
$c030Service = new C030Service(app(PdndClientService::class));
$risultato = $c030Service->cercaPerCodiceFiscale($codiceFiscale);

if ($risultato['successo']) {
    $idAnpr = $risultato['lista_soggetti'][0]['id_anpr'];
    // Usa $idAnpr...
}
```

## Gestione Errori

### Errori ANPR
Gli errori vengono restituiti nell'array response:
```php
[
    'successo' => false,
    'errori' => [
        'tipo' => 'ENS001',
        'descrizione' => 'Soggetto non trovato',
    ]
]
```

### Errori di Sistema
```php
try {
    $risultato = $c030Service->cercaPerCodiceFiscale($cf);
} catch (PdndException $e) {
    Log::error('Errore PDND: ' . $e->getMessage());
    // Gestione errore specifico PDND
} catch (Exception $e) {
    Log::error('Errore generico: ' . $e->getMessage());
    // Gestione errore generico
}
```

## Sicurezza

### Autenticazione
- OAuth2 con client credentials grant type
- JWT Bearer token con chiave privata RSA
- mTLS con certificati client

### Validazione Input
- Tutti i campi form sono validati lato server
- Sanitizzazione output prima di mostrarlo in Livewire
- Nessun dato sensibile nei log

### Best Practices
- Mai loggare dati personali completi
- Sanitizzare ID ANPR prima di assegnarlo a proprietà Livewire
- Usare `preg_replace()` per rimuovere caratteri speciali

## Performance

### Ottimizzazioni
- Lazy loading dei servizi (dependency injection)
- Riuso token OAuth2 fino a scadenza
- Timeout configurabili per richieste HTTP

### Monitoring
- Log di tutte le richieste ANPR
- Tracking tempi di risposta
- Alert su errori critici

## Migrazione Futura: Da Services a Actions

⚠️ **IMPORTANTE**: Il modulo attualmente usa Services tradizionali, ma deve migrare a Spatie Queueable Actions secondo le convenzioni Laraxot.

### Migrazione Prevista

#### Prima (Services):
```php
$c030Service = new C030Service(app(PdndClientService::class));
$risultato = $c030Service->cercaPerCodiceFiscale($cf);
```

#### Dopo (Actions):
```php
use Modules\Pdnd\Actions\CercaPerCodiceFiscaleAction;

$risultato = CercaPerCodiceFiscaleAction::dispatchSync($cf);
// oppure asincrono:
CercaPerCodiceFiscaleAction::dispatch($cf);
```

### Vantaggi della migrazione:
- Possibilità di esecuzione asincrona (code)
- Migliore testabilità
- Retry automatico su fallimento
- Conformità architettura Laraxot

Vedere: [filament-best-practices.md - Sezione 6](./filament-best-practices.md#6-architettura-actions-invece-di-services)

## Collegamenti

### Documentazione Modulo
- [Best Practices Filament](./filament-best-practices.md)
- [Fix PHPStan](./phpstan-fixes.md)

### Documentazione Esterna
- [PDND Interoperabilità](https://docs.pagopa.it/interoperabilita-1/)
- [ANPR API Docs](https://www.anpr.interno.it/portale/documentazione-tecnica)
- [Spatie Laravel Data](https://spatie.be/docs/laravel-data)

*Ultimo aggiornamento: 1 Ottobre 2025*

