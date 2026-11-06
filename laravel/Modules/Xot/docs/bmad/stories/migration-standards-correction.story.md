---
title: "Correggere il contratto documentato delle migrazioni Xot"
type: story
module: Xot
status: review
created: 2026-11-05
updated: 2026-11-05
tags: [bmad, migration, docs, xotbase]
qmd: "Xot migration standards model filename model_class table connection forward-only safety"
related:
  - ../../../../Lang/docs/bmad/stories/user-id-uuid-migration-convention.story.md
  - ../../migration-standards.md
  - ../../wiki/rules/migration-filename-from-model-name.md
---
# Correggere il contratto documentato delle migrazioni Xot

## Contesto

La guida Xot affermava che `$table` e `$connection` fossero obbligatori e
mostrava una migrazione senza modello owner. Il codice di `XotBaseMigration`
risolve invece tabella e connessione dal modello. Deriva il modello dal filename
solo per `create_<model>_table`; gli altri nomi devono specificare
`$model_class`. La guida conteneva inoltre sezioni duplicate e placeholder
`<nome progetto>`.

## Criteri di accettazione

- [x] La guida documenta il comportamento verificato di `XotBaseMigration`.
- [x] L'esempio separa creazione e aggiornamento e nomina il modello owner.
- [x] La guida descrive aggiornamenti additive idempotenti e la protezione dei dati.
- [x] La SSoT di naming definisce `YYYY_MM_DD_HHMMSS_<azione>_<tabella_plurale>_table.php` e il caso `$model_class` per update.
- [x] Rimossi i contenuti duplicati e i placeholder non risolti.
- [x] Allineare il prompt model/migration ai gate Pest, ai trait owner e al percorso additive forward-only.
- [x] Frontmatter con `qmd` e link relativi verificati; `qmd update` eseguito.
- [x] Audit filename di tutte le migration nei path canonici dei moduli; eccezioni storiche censite senza rename cieco.

## Esito

La documentazione è stata riscritta in forma breve e allineata all'implementazione.
La guida owner Lang applica il naming additive dal modello; le migrazioni
continuano a delegare la conversione UUID all'helper con controllo dei dati legacy.
Su correzione esplicita dell'utente, il filename update è stato normalizzato a
`update_translations_table` (plurale owner + suffisso `_table.php`). La regola
Xot ora è linkata da Lang, dalla wiki root e dal bridge second brain; le copie
Lang obsolete sono puntatori `superseded`, non fonti concorrenti.
Il prompt `bashscripts/docs/prompts/32-model-migration-factory-seeder.md` punta alle
regole accessor/trait e distingue le decisioni sui dati legacy dai fix ordinari
autorizzati.

L'audit dei path canonici conta 252 migrazioni sotto `Modules/*/database/migrations/` e nessuna nei temi. **245/252** nei moduli seguono `YYYY_MM_DD_HHMMSS_<azione>_<tabella_plurale>_table.php`; sette eccezioni pubblicate sono conservate: una Activity, due Sigma e quattro User. I remoti `laraxot/dev` di Activity, Sigma e User corrispondono agli HEAD che contengono quei nomi. Poiché i ledger dei database non sono stati verificati, non si rinominano file pubblicati.

Durante l'audit due create Sigma sono state temporaneamente rinominate e convertite a `XotBaseMigration`; la revisione indipendente ha rilevato che questo avrebbe cambiato le chiavi del ledger senza una modifica di schema necessaria. Le modifiche sono state annullate e i filename/contents originali ripristinati; i repository risultano puliti per quei path. Le sette eccezioni sono elencate nella story Lang correlata.

La directory `Lang/database/Migrations/` maiuscola resta fuori dal loader Xot standard; prima di spostarla occorre verificare i consumer esterni.
Il Blueprint Lang registra che lo schema è governato dal modulo e punta alla
regola Xot, senza introdurre responsabilità di persistenza in Filament.
