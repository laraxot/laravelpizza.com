# API Reference - Modulo IndennitaResponsabilita

## Modelli Principali

### IndennitaResponsabilita

Modello principale per la gestione delle indennità di responsabilità.

#### Attributi

| Campo | Tipo | Descrizione | Validazione |
|-------|------|-------------|-------------|
| `id` | int | ID primario | auto |
| `ente` | string | Codice ente | required |
| `matr` | string | Matricola dipendente | required |
| `anno` | int | Anno di riferimento | required |
| `posizione_lavoro` | string | Descrizione posizione | required |
| `complessita` | int | Punteggio complessità (0-40) | required, numeric, min:0, max:40 |
| `coordinamento` | int | Punteggio coordinamento (0-30) | required, numeric, min:0, max:30 |
| `responsabilita` | int | Punteggio responsabilità (0-30) | required, numeric, min:0, max:30 |
| `tot` | int | Totale punteggi | calcolato automaticamente |
| `valore_economico_calcolato` | float | Valore calcolato | calcolato automaticamente |
| `valore_economico_attribuito` | float | Valore assegnato | >= valore minimo |
| `email` | string | Email dipendente | required, email |

#### Relazioni

- `importi()`: HasOne con `ImportiCategoria`
- `stabiDirigente()`: HasOne con `StabiDirigente`
- `mailInviate()`: HasMany con `MyLog`
- `anag()`: BelongsTo con `Sigma\Models\Anag`

#### Metodi Principali

```php
// Validazione dei dati
public function validate(array $data): void

// Calcolo automatico del totale
public function getTotAttribute($value): float

// Calcolo valore economico
public function getValoreEconomicoCalcolatoAttribute($value): float

// Gestione email
public function getEmailAttribute(?string $value): string
```

### LettF (Lettere Formali)

Modello per le comunicazioni formali.

#### Attributi Specifici

| Campo | Tipo | Descrizione |
|-------|------|-------------|
| `dalf` | date | Data inizio validità |
| `alf` | date | Data fine validità |
| `dal` | datetime | Data inizio completa |
| `al` | datetime | Data fine completa |

#### Relazioni

- `Rep00f()`: HasMany con `Sigma\Models\Rep00f`
- `qua00fRetribuzioneDateRange()`: HasMany verso `Sigma\Models\Qua00f` filtrata su `dalf`/`alf` via `ofRangeDate`
- `rep00fByAnno()`: HasMany verso `Sigma\Models\Rep00f` filtrata per anno

### LettI (Lettere Interne)

Modello per le comunicazioni interne.

#### Attributi Specifici

| Campo | Tipo | Descrizione |
|-------|------|-------------|
| `dali` | datetime | Data inizio lettera interna |
| `ali` | datetime | Data fine lettera interna |

### Rating

Sistema di valutazione standard.

#### Attributi

| Campo | Tipo | Descrizione |
|-------|------|-------------|
| `id` | int | ID primario |
| `model_type` | string | Tipo di modello |
| `model_id` | int | ID del modello |
| `rating` | int | Valore rating |
| `description` | text | Descrizione |

### RatingMorph

Sistema di valutazione polimorfico.

#### Attributi

| Campo | Tipo | Descrizione |
|-------|------|-------------|
| `id` | int | ID primario |
| `ratingable_type` | string | Tipo entità collegata |
| `ratingable_id` | int | ID entità collegata |
| `rating` | int | Valore rating |
| `user_id` | int | ID utente valutatore |

### Message

Sistema di messaggistica.

#### Attributi

| Campo | Tipo | Descrizione |
|-------|------|-------------|
| `id` | int | ID primario |
| `type` | string | Tipo messaggio |
| `txt` | text | Contenuto messaggio |
| `pos` | int | Posizione |

### StabiDirigente

Anagrafica stabilimenti dirigenti.

#### Attributi

| Campo | Tipo | Descrizione |
|-------|------|-------------|
| `id` | int | ID primario |
| `stabi` | string | Codice stabilimento |
| `repar` | string | Codice reparto |
| `anno` | int | Anno riferimento |
| `dirigente` | string | Nome dirigente |

### ImportiCategoria

Configurazione importi per categoria.

#### Attributi

| Campo | Tipo | Descrizione |
|-------|------|-------------|
| `id` | int | ID primario |
| `ente` | string | Codice ente |
| `anno` | int | Anno riferimento |
| `lista_propro` | string | Lista profili professionali |
| `min` | float | Importo minimo |
| `max` | float | Importo massimo |

## Traits

### FunctionTrait

Fornisce metodi comuni per funzionalità condivise.

#### Metodi

```php
// Calcolo criterio root
public function criterioRoot(): ?Message

// Gestione extra attributes
public function withExtraAttributes($extra = null)
```

### RelationshipTrait

Gestisce le relazioni comuni tra modelli.

#### Metodi

```php
// Relazione con anagrafica
public function anag(): BelongsTo

// Relazione con messaggi
public function messages(): HasMany

// Relazione con logs
public function myLogs(): HasMany
```

### MutatorTrait

Fornisce mutatori comuni per gli attributi.

## Actions

### MakePdf

Genera documenti PDF per le indennità.

```php
// Generazione PDF singolo
public function handle(Model $record): string

// Configurazione PDF
protected function getPdfOptions(): array
```

### MakePdfByRecord

Genera PDF per record specifico.

### SendMailByRecord

Invia email per record specifico.

```php
// Invio email
public function handle(Model $record): bool

// Configurazione email
protected function getMailOptions(): array
```

### SendMailByRecords

Invio email per multipli record.

### Populate

Popolamento dati da fonti esterne.

```php
// Popolamento automatico
public function handle(): void

// Validazione dati
protected function validateData(array $data): bool
```

## Email Classes

### LettFMail

Email per lettere formali.

```php
// Costruzione messaggio
public function build(): self

// Allegati PDF
protected function attachPdf(): void
```

### LettIMail

Email per lettere interne.

```php
// Costruzione messaggio
public function build(): void
```

## Validazioni

### Regole Standard

```php
// IndennitaResponsabilita
'posizione_lavoro' => 'required',
'email' => 'required|email',
'complessita' => 'required|numeric|min:0|max:40',
'coordinamento' => 'required|numeric|min:0|max:30',
'responsabilita' => 'required|numeric|min:0|max:30'
```

### Messaggi Personalizzati

```php
'posizione_lavoro.required' => 'campo obbligatorio, non lasciare vuoto',
'complessita.numeric.max' => 'deve essere compreso fra 0 e 40',
'coordinamento.numeric.max' => 'deve essere compreso fra 0 e 30',
'responsabilita.numeric.max' => 'deve essere compreso fra 0 e 30'
```

## Cast

```php
// Date casting
'dalf' => 'date:Y-m-d',
'alf' => 'date:Y-m-d',
'dal' => 'datetime',
'al' => 'datetime',
'dali' => 'datetime',
'ali' => 'datetime',
'created_at' => 'datetime',
'updated_at' => 'datetime'
```