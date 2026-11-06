---
tags: [documentation]
updated: 2026-09-26
qmd: "xotbaseresourcetable model audit batch tenant limesurvey lang ai.story"
issues: []
discussions: []
title: "XotBaseResourceTable model audit - AI/AiActionProposalsTable"
status: done
type: story
created: 2026-09-11
---

# XotBaseResourceTable model audit - AI/AiActionProposalsTable

**Scope**: `app/Filament/Resources/AiActionProposalResource/Tables/AiActionProposalsTable.php` (batch cross-modulo Tenant/Limesurvey/Lang/AI, audit `protected static string $model` + colonne).

**Trovato**: il file aveva gia' `protected static string $model = AiActionProposal::class;` con `use` corretto, coerente con `protected static ?string $model = AiActionProposal::class;` nella Resource sorella `app/Filament/Resources/AiActionProposalResource.php` — nessuna correzione necessaria.

Verifica schema: la tabella `ai_action_proposals` (connessione `xot`, db `quaeris_data`) non risultava presente al momento del controllo (`Schema::hasTable()` → false, verosimilmente migrazioni non ancora eseguite in questo ambiente) — nessuna scrittura DB tentata (vietato da task), verificato invece leggendo la migrazione `database/migrations/2026_07_24_000003_create_ai_action_proposals_table.php`: colonne `id, public_id, ai_thread_id, proposed_by_user_id, type, payload, preview, status, confirmed_by_user_id, confirmed_at, executed_at, result, error` + `created_at/updated_at/updated_by/created_by` da `updateTimestamps()`.

Le 6 chiavi dirette di `getTableColumns()` (`id`, `type`, `status`, `preview`, `created_at`) sono tutte presenti nella migrazione; `thread.public_id` e' una relazione (dot notation), saltata come da istruzioni — verificato comunque che `AiThread` dichiara `public_id` (`@property string $public_id`, in `$fillable` e `$casts`). Nessuna colonna sospetta.

**Fatto**: due migliorie UX additive a basso rischio:
- `type`: aggiunto `->sortable()` (era `->badge()->searchable()` senza ordinamento, campo stringa enum-like ovviamente ordinabile).
- `preview`: aggiunto `->searchable()` (era `->limit(100)->wrap()` senza ricerca; e' un `longText` di riepilogo, coerente con gli altri campi testuali cercabili della tabella).

Non toccata `thread.public_id` (colonna di relazione, `sortable()` su relazione richiede verifica aggiuntiva della query — fuori dal criterio "basso rischio" di questo batch).

**Verifica**: `php -l Modules/AI/app/Filament/Resources/AiActionProposalResource/Tables/AiActionProposalsTable.php` → nessun errore di sintassi. `vendor/bin/phpstan analyse Modules/AI/app/Filament/Resources/AiActionProposalResource/Tables/AiActionProposalsTable.php --no-progress` (insieme agli altri 3 file del batch) → 0 errori.

**Resta da fare**: se in futuro si vuole rendere ordinabile `thread.public_id`, verificare il supporto Filament per `sortable()` su colonne di relazione dot-notation con questo setup (join esplicito o query callback).
