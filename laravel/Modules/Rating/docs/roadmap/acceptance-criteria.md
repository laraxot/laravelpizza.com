# Criteri di accettazione per le fasi

Criteri misurabili e verificabili per considerare completata ogni fase della roadmap.  
Riferimento architettura: [architecture.md](../architecture.md).

---

## Fase 1 · Stabilizzazione della base tecnica

### PHPStan e tipi

- [ ] `./vendor/bin/phpstan analyse Modules/Rating --memory-limit=-1` eseguito dalla root `laravel/` termina con **0 errori**.
- [ ] Nessun file PHP nel modulo senza `declare(strict_types=1);`.
- [ ] Nessun metodo pubblico/protetto senza tipo di ritorno esplicito (eccetto override documentati).
- [ ] Nessun uso di `property_exists()` su istanze Eloquent; sostituiti con `isset($model->attr)` o `Schema::hasColumn()` dove appropriato.

### Modelli e relazioni

- [ ] Ogni modello in `Modules/Rating/Models/` estende `Modules\Rating\Models\BaseModel` (o la classe base indicata in [architecture.md](../architecture.md)).
- [ ] Relazioni con PHPDoc completo (`@return BelongsTo<...>`, `MorphMany<...>`, ecc.) e type hint di ritorno.
- [ ] Uso di `casts()` method (non `$casts` property) dove richiesto da Laravel 12 / regole progetto.

### Filament (se presente)

- [ ] Nessuna chiamata a `->label()`, `->placeholder()`, `->helperText()` nei componenti Filament; tutte le stringhe utente da `lang/it` (e `lang/en`) con struttura espansa.
- [ ] `getTableColumns()`, `getTableFilters()`, `getInfolistSchema()` restituiscono `array<string, Component>` (chiavi stringa verificabili in analisi statica).
- [ ] Resource/Page/Widget estendono solo classi `XotBase*` (nessuna estensione diretta di classi Filament).

### Test

- [ ] Almeno un test Pest che crea un rating, aggiorna un punteggio e verifica persistenza.
- [ ] Test eseguibili con `php artisan test --filter=Rating` (o path equivalente) senza errori.
- [ ] Nessuna cartella `tests/` esclusa da PHPStan (nessun excludePaths per Rating).

---

## Fase 2 · Funzionalità core di rating

### HasRatingsTrait e pivot

- [ ] Il trait `HasRatingsTrait` è documentato in [architecture.md](../architecture.md) con signature dei metodi e contratti (parametri, ritorni, eccezioni).
- [ ] Esiste una tabella pivot (o equivalente) che collega l’entità rateable ai punteggi; migrazione in `database/migrations/` con convenzioni Laraxot (XotBaseMigration se previsto).
- [ ] Un modello “consumer” (anche solo in test) usa il trait e può associare/disassociare rating e valori senza errori.

### Criteri e validazione

- [ ] Modello (o DTO) per i criteri di valutazione con campi chiari: identificativo, nome, descrizione, peso, scala (es. 1–10), attivo, eventuali extra.
- [ ] Regole di validazione per l’inserimento/aggiornamento dei punteggi centralizzate (Form Request o Action con rules) e coperte da test.

### Actions

- [ ] Almeno un’Action dedicata al calcolo del punteggio aggregato (es. media pesata) richiamabile da altri moduli senza conoscere il dominio Rating.
- [ ] Logica di business (calcolo, aggregazione) **non** in controller o in view; solo in Action/Service documentati.

---

## Fase 3 · Integrazione con moduli consumer

### Documentazione integrazione

- [ ] In `docs/` esiste un documento (o sezione) che spiega come un modulo consumer usa Rating (es. use trait, chiamare Action, struttura pivot).
- [ ] Esempi di utilizzo senza riferimenti hardcoded a un singolo modulo (es. “Modulo X” generico o due moduli di esempio).

### Traduzioni

- [ ] File in `Modules/Rating/lang/it/` (e opzionale `lang/en`) con struttura completa per: navigation, fields, actions, messages (nessuna chiave lasciata come placeholder tipo `resource.navigation`).
- [ ] Nessuna stringa utente visibile proveniente da codice (solo da lang).

### Filament dimostrativo (opzionale)

- [ ] Se presente una Resource/Widget di esempio, essa è puramente dimostrativa e documentata come tale; non introduce dipendenze da moduli applicativi specifici.
