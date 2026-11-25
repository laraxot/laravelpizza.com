---
title: "Convenzioni per chi tocca il modulo Gdpr"
type: rules
module: Gdpr
updated: 2026-11-25
---

# Convenzioni

Regole valide per questo modulo, ognuna con il motivo. Le regole generali Laraxot (XotBase, Action, strict types) hanno la loro
documentazione nel modulo Xot; qui solo cio' che cambia o che qui e' gia' costato un guasto.

## Codice

- **Logica = Spatie Queueable Action** in `app/Actions/<Contesto>/<Nome>Action.php`: `use QueueableAction`, unico punto
  d'ingresso pubblico `execute()`, chiamata `app(NomeAction::class)->execute(...)`. Contesti esistenti: `Account`, `Consent`,
  `Cookie`, `Registration`, `Validation`. Non esistono `app/Services/` ne' `app/Support/` e non vanno introdotti; niente
  `*Repository`, niente `new ...Action` inline nei parametri di default. Un'Action non fa da proxy a una relazione Eloquent
  gia' esistente sul modello o sul trait.
- **Classi Filament = `XotBase*`** (`XotBaseResource`, `XotBaseWidget`, `XotBaseSchemaWidget`, `XotBaseCluster`,
  `XotBaseDashboard`, `XotBaseEditProfile`, `XotBasePanelProvider`). Mai `Filament\Resources\Resource` & co. diretti.
- **ServiceProvider minimo**: `GdprServiceProvider` dichiara `$name`, `$module_dir`, `$module_ns` e aggiunge solo il cablaggio del
  banner; ogni override chiama `parent::boot()` per primo ed e' marcato `#[\Override]`. Mai ripetere cio' che fa gia'
  `XotBaseServiceProvider` (viste, traduzioni, migrazioni).
- **Dipendenze**: quelle del dominio stanno in `Modules/Gdpr/composer.json`; il `composer.json` del progetto fa il merge solo dei
  `Modules/*/composer.json`, mai dei temi.
- **`declare(strict_types=1)`** in ogni file PHP; test solo con Pest.
- **Un file PHP non puo' differire da un altro solo per le maiuscole** (macOS e Windows li fonderebbero in modo non
  deterministico): in `tests/Feature` esisteva `conflictresolutiontest.php` accanto a `ConflictResolutionTest.php`; resta la forma
  PascalCase. Controllo: `find Modules/Gdpr -name '*.php' | awk '{print tolower($0)}' | sort | uniq -d` deve essere vuoto.

## Sui dati di consenso

- Solo INSERT per i consensi della registrazione; la revoca e' un `UPDATE` di `revoked_at`; nessun `DELETE`
  ([ADR](adr/consent-proof-is-append-only.md)). `account_deletion` e' l'unica riga aggiornata
  ([account-deletion.md](account-deletion.md)).
- Una colonna nuova = migrazione additiva e idempotente; mai `migrate:fresh` ([database.md](database.md)).
- Ogni Action che scrive dati personali ha un contratto in `docs/contracts/` e lo cita nel docblock con
  `@contract docs/contracts/<nome>.md`; formato in `Modules/Xot/docs/rules/action-behavioral-contract.md`.
- Il modulo non decide testi legali, periodi di conservazione o recapiti del titolare: li legge dal config del tenant e dalle
  traduzioni del progetto ([data-subject-rights.md](data-subject-rights.md)).

## Documentazione di questo modulo

- Un documento per argomento; nomi minuscolo-con-trattini, **niente date nel nome** (la data sta nel frontmatter), niente
  suffissi `-2`/`-copy`/`-old`, niente cartelle `archive`/`raw`/`historical`, niente stub che rimandano ad altri file.
- Neutralita': i docs del modulo non nominano progetti specifici (il modulo e' riusabile): si parla di "progetto ospite".
- Tetto: al massimo 100 `.md` in `docs/`, story/ADR/contratti inclusi; chi aggiunge una pagina ne fonde un'altra.
- Ogni classe o metodo PHP creato o modificato porta nel docblock un `@see Modules/Gdpr/docs/<file>.md` verso la pagina che
  spiega cosa fa e perche' (pagina esistente: non una per metodo). Le pagine citate dal codice non si rinominano:
  `register-widget-copy-ownership.md`, `contracts/*.md`.
- Story BMAD in `docs/stories/`, ADR in `docs/adr/` (cinque sezioni, `## Verifica`, nomi senza date): sono cronologia, si
  collegano o si marcano superate, non si riscrivono.
