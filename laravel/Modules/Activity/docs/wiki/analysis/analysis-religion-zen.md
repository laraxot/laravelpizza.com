---
title: Analysis religion zen
module: Activity
type: note
updated: 2026-10-08
tags: [docs, activity, wiki]
qmd: "activity module: complete analysis (religion, philosophy, politics, zen) activity"
status: superseded
superseded_by: ../../analysis-religion-zen.md
---

# Activity Module: Complete Analysis (Religion, Philosophy, Politics, Zen)

---

## Analisi del modulo

Il modulo Activity gestisce il tracciamento delle attività degli utenti e il log delle azioni, con supporto per event sourcing. Si integra con Spatie Laravel Activitylog e Spatie Laravel Event Sourcing per mantenere un audit trail completo di tutte le operazioni nel sistema.

**Modelli principali**: StoredEvent, Snapshot, Activity
**Actions**: LogActivityAction, LogUserLogoutAction, RedactModelAttributesAction
**Dipendenze**: Xot, User

---

## Religione

1. **Ogni azione deve essere registrata** — Non esiste operation senza log. Se un'azione viene compiuta, deve esserci un record associato.
2. **Event Sourcing è sacro** — Gli eventi sono append-only, non cancellabili. Questo garantisce compliance e audit trail permanente.
3. **Snapshot sono cache read-only** — Gli snapshot sono proiezioni di lettura sugli eventi, non la fonte di verità. Gli eventi sono source of truth.
4. **Guard PK sugli accessor** — Se un accessor ha `save()`, deve verificare `null == $this->getKey()` prima di salvare (Pattern dai docs Xot).
5. **Modelli estendono XotBaseModel** — Ogni modello deve estendere BaseModel per avere `created_by`, `updated_by`, `deleted_by` automatici.
6. **Nessun bypass del logging** — Non saltare mai il log activity, nemmeno per performance. Se serve velocità, cache separata.
7. **Niente property_exists() sui modelli** — Usare `isset()` per controllare attributi Eloquent.

---

## Filosofia

**"Ogni azione racconta una storia. La somma di queste storie diventa la verità del sistema."**

L'audit trail non è solo compliance, è la verità storica del sistema. Ogni modifica, ogni login, ogni cambiamento di stato lascia una traccia immutabile. La filosofia si basa su:
- **Transparency** — Niente nascosto. Tutti sanno chi ha fatto cosa e quando.
- **Accountability** — I nomi (`created_by`, `updated_by`, `deleted_by`) rendono responsabili.
- **Immutability** — Gli eventi non cambiano. La storia non si riscrive.
- **Derivability** — Dagli eventi si possono ricostruire qualsiasi stato passato. Gli snapshot sono derivati.
- **Composability** — Le azioni sono componibili. Un'azione può registrare un'altra azione. Eventi possono triggerare altre azioni.

Il sistema risponde alla domanda: "Cosa è successo, quando e chi l'ha fatto?" invece di "Funziona?".

---

## Politica

- **Nessun DELETE sugli eventi** — Gli eventi sono append-only. Rimozione fisica mai.
- **Snapshot mai modificati dopo creazione** — Read-only caches.
- **Log user logout sempre** — Anche se l'utente chiude browser senza logout formale.
- **Redact model attributes** — Prima di salvare eventi, redigere attributi sensibili (password, token).
- **Snapshot per read performance** — Non querelare sempre eventi per letture frequenti. Usare snapshot.
- **N+1 query sugli eventi** — Risolvere in bulk o cache. Non in loop.
- **Namespace events** — Usare namespace coerenti per classi eventi.

---

## Scopo

Tracciare ogni azione utente nel sistema: loghin, logout, modifiche modelli, eliminazioni, azioni Filament, ecc. Fornisce:
- Audit trail completo per compliance (GDPR, audit interni)
- Analisi comportamentali utenti
- Tracciamento errori e debugging
- Event sourcing per eventuale ricostruzione stato
- Activity logs per dashboard admin

---

## Perché [perché]

**Perché event sourcing invece di log classico?**
Event sourcing fornisce:
1. **Completezza** — Ogni cambio stato è un evento, non una row aggiornata
2. **Reconstruction** — Posso ricostruire qualsiasi stato passato ricompattando eventi
3. **Temporal queries** — Posso chiedere "com'era lo stato a questa data?"
4. **Audit immutable** — Gli eventi non possono essere modificati (solo aggiunti)

**Perché non spatie/laravel-auditing?**
Laravel Auditing fa snapshot delle row (before/after). Event sourcing usa eventi append-only. Noi scelgiamo event sourcing perchè:
- Modifiche sono eventi, non row aggiornate
- Posso ricostruire stato passato
- Più flessibile per query temporali
- Compliance migliore (events never deleted)

**Perché spatie/laravel-activitylog?**
Activitylog registra "cosa è successo" a livello di modello (creato, aggiornato, cancellato). Complementare a event sourcing che registra "cosa è successo" a livello di dominio (business events). Uso entrambi: activitylog per audit row-level, event sourcing per domain events.

---

## Zen

**"L'acqua scorre, non torna indietro."**

L' Activity system incarna questo principio:
- Gli eventi scorrono in un'unica direzione (append-only)
- Non c'è ritorno indietro, non c'è cancellazione
- Ma da ogni evento si può derivare uno snapshot (la superficie dell'acqua)
- La verità è nell'intero flusso, non in un singolo momento
- La chiarezza viene dalla totalità, non dai singoli istanti

---

## Competitors

| Competitor | Approccio | Differenza | Per noi no |
|---|---|---|---|
| **spatie/laravel-auditing** | Row-level snapshots (before/after) | Snapshots delle row, non eventi append-only | Noi: Event sourcing per ricostruzione stato, non solo snapshots |
| **owen-it/laravel-auditing** | Similar a above | Row-level | Noi: Domain-level events |
| **rap2hpoutre/laravel-log-viewer** | Visualizzazione log | UI per visualizzare log | Noi: Più strutturato, event sourcing |
| **Laravel native logging** | Log file generici | Log files, non strutturato | Noi: Database storage, queryable |
| **EventStoreDB** | External event store | DB esterno, complessità infrastrutturale | Noi: DB stesso app, più semplice |
| **Apache Kafka** | Messaging system | Too heavy, distributed system | Noi: Simple PHP app, monolith |

---

## Dove inspirarsi

- **Laravel Event Sourcing** — Pattern base, come registrare ed eventi
- **CQRS** — Separat read models from write models
- **Martin Fowler Event Sourcing** — Principi originali
- **OSS event sourcing libraries** — Patterns from the community
- **Audit best practices** — OWASP, compliance standards
- **Logging patterns** — Centralized logging, structured logs
- **Spatie packages** — Philosophy of testing, quality, documentation

---

## Librerie da installare

### Gia incluse
- **spatie/laravel-activitylog** — Registrazione attività modelli
- **spatie/laravel-event-sourcing** — Event sourcing foundation

### Consigliate
- **phpdocumentor/type-resolver** — Per type resolution eventi (già in Notify composer.json)
- **spatie/laravel-data** — DTO per eventi dati (già in Xot)
- **aws/aws-sdk-php** — Per event storage su S3 se si scala (già in Notify)

### Da evitare
- **Pacchetti log non strutturati** — Lasciare logging a Laravel native
- **Cancellazione eventi** — Mai, è contro la filosofia

---

## Future implementazioni

1. **Domain events più granulari** — Eventi più specifici per domini specifici
2. **Projected read models** — Queryable snapshots per lettura frequente
3. **Tenant-scoped events** — Eventi isolati per tenant in multi-tenant
4. **Event expiration policy** — Policy per eventi vecchi (purge after N years per compliance)
5. **Retry failed events** — Mechanism per eventi che falliscono al dispatch
6. **Event versioning** — Evoluzione schema eventi nel tempo
7. **Cross-module event integration** — Eventi che triggerano azioni in altri moduli
8. **Analytics dashboard** — Dashboard eventi in tempo reale per admin

---

## Cosa fare per renderlo perfetto

1. **PHPStan Level 10** su tutti i nuovi files
2. **Pest tests 85%+** per tutte le Actions
3. **Test ogni provider evento** — Simulare failure, retry, recovery
4. **Audit trail compliance** — Verificare GDPR export/delete funziona
5. **Performance**: Benchmark query eventi vs snapshot
6. **Documentazione API eventi** — Formato eventi pubblici
7. **Integration test** — Event cross-module trigger
8. **Backup strategy** — Events never deleted, ma export periodico

---

## Consigli, dubbi, perplessità

- **Event vs Audit log**: Quando usare l'uno o l'altro? Activity log per row-level changes, event sourcing per domain events. Overlap?
- **Performance impatto**: Event sourcing rallenta write? Sì, ma letture sono veloci con snapshot. Bilanciamento?
- **Storage size**: Events accumulate. Purge policy necessaria? Compliance dice keep N anni.
- **Retry mechanism**: Cosa succede se event dispatch fallisce? Riprova all'infinito o dopo N tentativi?
- **Cross-module events**: Un evento Activity può triggerare azioni in altri moduli? Pattern sicuro?
- **Tenant isolation**: Eventi visibility per tenant? Same DB, different scope?
- **Event naming**: Convensioni nomi eventi. Cosa succede se due moduli hanno eventi con stesso nome?

---

## Best practices

1. **Sempre registrare** — Anche operazioni "minori". Meglio troppo che poco.
2. **Guard PK su save()** — Se accessor ha save(), guard `null == $this->getKey()` sempre.
3. **Redact prima di salvare** — Rimuovere password, token, dati sensibili dall'evento.
4. **Snapshot per read** — Non querelare eventi per read frequenti. Usare snapshot cached.
5. **Namespace events** — `Modules\Activity\Events\...` per evitare collisioni.
6. **Immutabilità** — Non mai cancellare o modificare eventi esistenti.
7. **Query bulk** — Se devi processare N eventi, fare in bulk, non in loop.
8. **Tipizzazione eventi** — Usare Spatie Data o similar per typed event objects.
9. **Chiarezza nome** — Nome evento descrivere cosa successo, non come. `UserLoggedIn` vs `LogUserLoginAction`.
10. **Event payload minimo** — Solo dati necessari. Non includere tutto il modello.

---

## Bad practices

1. **❌ Cancellare eventi** — Events sono append-only. Mai delete fisico.
2. **❌ Bypassare il logging** — Anche operazioni "veloci" devono essere loggate.
3. **❌ property_exists() sui modelli** — Usare `isset()` per attributi Eloquent.
4. **❌ N+1 query su eventi** — Bulk process, non loop.
5. **❌ Salvare dati sensibili** — Redact sempre password, token, PII.
6. **❌ Mischiare audit log ed event sourcing** — Separare responsabilità. Audit = row changes. Event sourcing = domain narrative.
7. **❌ Accessor save() senza guard** — Vulnerabile a Duplicate Entry errors.
8. **❌ Event payload eccessivo** — Solo dati necessari. Non includere intero modello serializzato.
9. **❌ Hardcoded event names** — Usare costanti o namespace, non stringhe libere.
10. **�ignorare failed event dispatch** — Mechanism retry o dead letter queue.

---

## False friends

- **Activity log ≠ Event sourcing** — Activity log snapshot row changes. Event sourcing = append-only events = ricostruisci stato.
- **Snapshot ≠ Event** — Snapshot è derivato, event è source of truth.
- **Log file ≠ Database activity log** — File system vs DB storage, queryability vs simplicity.
- **Redact ≠ Anonymize** — Redact rimuove campi specifici, anonymize trasforma in forma irreversibile.
- **Guard PK ≠ Soft delete** — Guard evita save su nuovo record. Soft delete è mark deleted_at.
- **Event namespace ≣ Event name** — Namespace è path PHP, name è stringa descrittiva.
- **Activity module ≣ Audit module** — Activity = tracking operations. Audit = verification compliance.

---

## Come usare il modulo

### Loggare un'azione manuale
```php
use Modules\Activity\Actions\LogActivityAction;

// Log manuale azione
LogActivityAction::dispatch([
    'description' => 'User logged in',
    'event' => UserLoggedIn::class,
    'subject_type' => User::class,
    'subject_id' => $user->id,
    'causer_type' => User::class,
    'causer_id' => auth()->id(),
    'properties' => ['ip' => request()->ip()],
]);
```

### Usare l'accessor con guard
```php
// Nel modello
public function getSomeCalculatedValueAttribute($value)
{
    // Guard obbligatorio se c'è save() sotto
    if (null == $this->getKey()) {
        return null;
    }
    
    // Log dell'accesso
    // (o delegazione a LogActivityAction)
    
    return $calculatedValue;
}
```

### Registrare logout
```php
use Modules\Activity\Actions\LogUserLogoutAction;

LogUserLogoutAction::dispatch([
    'user_id' => $user->id,
    'session_id' => $session->id,
    'duration' => $durationMinutes,
]);
```

### Query eventi
```php
// Tutti gli eventi per un modello
StoredEvent::where('subject_type', User::class)
    ->where('subject_id', $user->id)
    ->latest()
    ->get();

// Events per causer
StoredEvent::where('causer_type', User::class)
    ->where('causer_id', $admin->id)
    ->where('description', 'User deleted')
    ->get();
```

### Usare gli snapshot
```php
// Ultimo snapshot per un modello
$snapshot = Snapshot::where('subject_type', User::class)
    ->where('subject_id', $user->id)
    ->latest()
    ->first();
```

---

## Come installarlo

```bash
# Il modulo e gia nel monorepo
# Attivazione event sourcing

composer require spatie/laravel-event-sourcing

# Pubblicare config
php artisan vendor:publish --tag=activitylog-config
php artisan vendor:publish --tag=event-sourcing-config

# Migrazioni
php artisan migrate --path="Modules/Activity/database/migrations"

# Seed (opzionale)
php artisan db:seed --class=Modules\\Activity\\Database\\Seeders\\ActivitySeeder

# Test
php artisan tinker
>>> use Modules\Activity\Models\StoredEvent;
>>> $events = StoredEvent::all();
```

---

## Meta

- **Generated**: 2026-09-06
- **Verified Against**: laravel/Modules/Activity/ full codebase
- **Author**: Visionary analysis
