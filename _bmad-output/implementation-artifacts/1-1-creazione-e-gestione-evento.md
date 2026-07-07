# Story 1.1: Creazione e gestione Evento

Status: ready-for-dev

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As an Organizzatore,
I want creare, modificare ed eliminare un Evento con data, sede, relatori, sponsor e capienza tramite il pannello Filament,
so that posso pubblicare rapidamente un nuovo meetup senza intervento tecnico.

## Acceptance Criteria

1. Un Evento non può essere pubblicato senza una Capienza (`max_attendees`) valorizzata (PRD FR-1).
2. L'eliminazione di un Evento con Iscrizioni attive richiede conferma esplicita, non un delete silenzioso (PRD FR-1).
3. La Resource Filament estende `XotBaseResource` (Architecture AD-2), mai `Filament\Resources\Resource` diretto.
4. Ogni mutazione di stato (create/update/delete) passa da un'Action `Spatie\QueueableAction` (Architecture AD-3); è vietato `$record->update()`/`save()` diretto da un Filament Resource/Page su `Event`, che è un'entità con invarianti.
5. Nessuna regressione sulle funzionalità esistenti della Resource (filtri per stato/data/modalità, colonne tabella, calendario/widget statistiche che leggono da `Event`).

## Tasks / Subtasks

- [ ] **Task 0 — Sbloccare `Event.php` (prerequisito, priorità massima)** (AC: #3, #4, #5)
  - [ ] Rimuovere la duplicazione del metodo `scopeVisibleTo` in `laravel/Modules/Meetup/app/Models/Event.php` (righe ~250 e ~285) — il file oggi **non compila** (PHP fatal error "Cannot redeclare method"). Le due versioni hanno logica leggermente diversa (una permette al `super-admin` di vedere tutto e usa un semplice `orWhere('user_id', ...)`; l'altra distingue Eventi `pending` visibili solo al proprietario). Decidere quale versione riflette il comportamento voluto attualmente in produzione e tenerne una sola — non cancellare a caso, la logica `pending`-only-owner sembra più recente/specifica e probabilmente quella corretta, ma verificare con i test esistenti prima di rimuovere l'altra.
  - [ ] Verificare che il file compili (`php -l laravel/Modules/Meetup/app/Models/Event.php`) prima di procedere con qualunque altro task.

- [ ] **Task 1 — Rendere Capienza obbligatoria** (AC: #1)
  - [ ] In `EventResource::getFormSchema()`, aggiungere `->required()` al campo `max_attendees` (oggi ha solo `->numeric()->default(100)`, quindi tecnicamente salvabile senza che l'utente lo valorizzi esplicitamente se il default viene rimosso via JS o payload manuale).
  - [ ] Aggiungere un test che verifica che il salvataggio fallisca (validazione Filament) se `max_attendees` è vuoto/null.

- [ ] **Task 2 — Conferma esplicita su eliminazione con Iscrizioni attive** (AC: #2)
  - [ ] In `EventResource::table()` (azione `delete`) e in `EditEvent::getHeaderActions()` (azione `delete`), sostituire il `DeleteAction::make()` nativo con una versione che verifica `$record->attendees()->count() > 0` (o l'equivalente su `EventUser`) e, se vero, mostra un messaggio di conferma esplicito aggiuntivo (`->requiresConfirmation()` con testo dedicato) prima di procedere — non basta il "Sei sicuro?" generico di Filament, deve nominare il numero di Iscrizioni che verranno perse.
  - [ ] La cancellazione effettiva, se confermata, passa da una nuova Action `Modules\Meetup\Actions\Event\DeleteEventAction` (pattern `Spatie\QueueableAction`), non da `DeleteAction::make()` che chiama `$record->delete()` internamente in modo implicito — coerente con AD-3.

- [ ] **Task 3 — Instradare create/update su Action** (AC: #4)
  - [ ] Verificare se esistono già `CreateEventAction`/`UpdateEventAction` in `Modules\Meetup\Actions\Event\` (non trovate durante l'analisi — solo `RegisterAttendeeToEventAction`, `ApproveMeetupAction` risultano esistenti in quell'area). Se assenti, crearle seguendo esattamente il pattern di `RegisterAttendeeToEventAction.php` (`use Spatie\QueueableAction\QueueableAction;`, metodo `execute()`, transazione DB se tocca più tabelle).
  - [ ] In `CreateEvent`/`EditEvent` (che estendono `XotBaseCreateRecord`/`XotBaseEditRecord`), verificare come questi hook Filament richiamano il salvataggio (`handleRecordCreation`/`handleRecordUpdate` sono i punti di estensione standard Filament) e farli chiamare l'Action invece del comportamento Eloquent di default.
  - [ ] Non toccare il comportamento di lettura (tabella, filtri, colonne) — solo i percorsi di scrittura.

## Dev Notes

- **BLOCCANTE, leggere prima di iniziare**: `Event.php` non compila oggi a causa del metodo duplicato (Task 0). Non è un marker di conflitto Git (verificato assente), è codice duplicato letterale — probabile residuo dello stesso evento che ha introdotto i 174 file con conflitti committati in `origin/dev` (commit `c6b3499c5` di marco76tv, oggi). Se durante il lavoro emergono altri metodi duplicati in `Event.php` o file collegati, applicare la stessa cautela: capire quale versione è quella voluta, non cancellare a caso.
- **La Resource Filament esiste già** — non è una story "da zero": `laravel/Modules/Meetup/app/Filament/Resources/EventResource.php` + `EventResource/Pages/{ListEvents,CreateEvent,EditEvent}.php` sono già implementate ed estendono correttamente `XotBaseResource`/`XotBaseCreateRecord`/`XotBaseEditRecord` (AC #3 già soddisfatto). Il lavoro di questa story è **colmare i gap** (Capienza obbligatoria, conferma su delete, routing su Action), non ricostruire la Resource.
- **Relazioni esistenti su `Event`** (`app/Models/Event.php`): `owner()`, `creator()`, `updater()`, `organizer()` (tutte `BelongsTo`), `attendees()` (`BelongsToMany`), `venue()` (`BelongsTo`), `performers()`/`sponsors()` (`BelongsToMany` — verificare se usano `belongsToManyX()` come richiede la convenzione di progetto o `belongsToMany()` nativo: da un controllo rapido sembrano usare la relazione nativa, il che sarebbe una violazione della convenzione "belongsToManyX obbligatorio" documentata in CLAUDE.md — segnalarlo se confermato, ma non è nello scope stretto di questa story correggerlo).
- **`Event::isFull()` e `Event::isUserRegistered()` esistono già** (righe 233, 238) e sono il punto autorevole per l'invariante di Capienza (Architecture AD-3) — riusarli, non duplicarli, in qualunque nuova Action.
- **Migrazioni duplicate note (fuori scope di questa story, ma da NON peggiorare)**: esistono due migrazioni `create_events_table` (`2025_01_01_000001` e `2026_02_17_180908`), due `create_event_user_table`, e coppie singolare/plurale per `event_sponsor(s)`/`event_performer(s)` — violazione diretta di Architecture AD-8 ("una tabella, una migrazione"). Questa story **non deve aggiungere una terza migrazione per `events`**; se serve una nuova colonna, usare `add_{column}_to_events_table.php` su una migrazione di update, mai un nuovo `create_events_table`.
- **Pattern Action di riferimento**: `laravel/Modules/Meetup/app/Actions/Event/RegisterAttendeeToEventAction.php` — `Spatie\QueueableAction`, `execute()`, `DomainException` per invarianti violati, transazione esplicita via `app('db')->transaction()`.

### Project Structure Notes

- Nuove Action in `laravel/Modules/Meetup/app/Actions/Event/` (stesso namespace di `RegisterAttendeeToEventAction`).
- Nessuna nuova migrazione di creazione tabella prevista per questa story (Architecture AD-8).
- Nessuna variazione al namespace/struttura Filament esistente (`Modules\Meetup\Filament\Resources\EventResource`).

### References

- [Source: _bmad-output/planning-artifacts/prds/prd-laravelpizza.com-2026-07-07/prd.md#FR-1] — requisito e Consequences testabili.
- [Source: _bmad-output/planning-artifacts/architecture/architecture-laravelpizza.com-2026-07-07/ARCHITECTURE-SPINE.md#AD-2] — XotBase obbligatorio.
- [Source: _bmad-output/planning-artifacts/architecture/architecture-laravelpizza.com-2026-07-07/ARCHITECTURE-SPINE.md#AD-3] — Action pattern, single-owner invariant, divieto update() diretto.
- [Source: _bmad-output/planning-artifacts/architecture/architecture-laravelpizza.com-2026-07-07/ARCHITECTURE-SPINE.md#AD-8] — una tabella, una migrazione.
- [Source: laravel/Modules/Meetup/app/Models/Event.php] — modello esistente, incluso il bug bloccante `scopeVisibleTo` duplicato.
- [Source: laravel/Modules/Meetup/app/Filament/Resources/EventResource.php] — Resource esistente da estendere, non ricreare.
- [Source: laravel/Modules/Meetup/app/Actions/Event/RegisterAttendeeToEventAction.php] — pattern Action di riferimento.

## Dev Agent Record

### Agent Model Used

(da compilare da dev-story)

### Debug Log References

### Completion Notes List

### File List
