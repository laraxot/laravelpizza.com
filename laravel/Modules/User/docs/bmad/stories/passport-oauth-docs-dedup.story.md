---
title: "Dedup documentazione passport/oauth cluster"
type: story
status: done
epic: "USER-MODULE-EXCELLENCE"
module: User
created: 2026-09-29
updated: 2026-09-29
related:
  - "../../passport-oauth-cluster.md"
  - "../../wiki/redundancy/oauth-dual-resource-trees.md"
  - "../../stories/12.4.oauth-dup-resources-ssot.story.md"
---

# Story — Dedup documentazione "passport/oauth cluster"

## Obiettivo

`laravel/Modules/User/docs/` conteneva ~29 file quasi-duplicati sul tema
"passport cluster / oauth cluster", scritti in sessioni diverse nel tempo
(2026-07 → 2026-09), con contenuto sovrapposto e spesso contraddittorio
("✅ COMPLETATO" in un file, "🔴 IN LAVORO"/directory vuota nel file successivo).
Obiettivo: consolidare in un unico documento canonico verificato sul codice
reale, senza perdere nessuna decisione o problema documentato, e senza
toccare il codice applicativo (fuori scope).

## Cosa e' stato trovato

1. **Ridondanza documentale severa**: 23 file `passport-cluster*.md` + 6
   `oauth-cluster*.md`, molti con contenuto quasi identico (stesso template,
   stesse frasi "Metodologia Super Mucca", stesso elenco "20 file PHP").
2. **Corruzione da un dedup precedente mal eseguito**: 13 di questi file erano
   gia' stati ridotti a stub rotti che puntano a
   `../../../Themes/docs/shared-components/<nome>.md` — percorso che **non
   esiste in nessun punto del monorepo**. Il commit che ha introdotto questo
   danno (`7b9cba67`, 2026-09-22, "risolve marker di conflitto residui")
   ha risolto i marker di merge conflict scegliendo il lato sbagliato,
   cancellando contenuto reale. Il contenuto e' stato recuperato dal commit
   `5697a373` (2026-09-07) prima che venisse corrotto.
3. **`git log --follow` inattendibile per la cronologia**: HEAD ha solo 3-4
   commit ".", frutto di un import/squash del 2026-09-28 che appiattisce una
   storia molto piu' lunga (fino al 2026-01-20), recuperabile solo scavando
   nei commit parent.
4. **Stato reale del cluster (verificato su `app/Filament/`, non sui doc)**:
   il cluster `Passport` (e `Socialite`) esiste ed e' stato costruito, con
   6 resource complete (inclusa `OauthDeviceCodeResource`, mai documentata nei
   file "cluster*") e pattern Filament v4 (`Schemas/`, `Tables/`). Pero' le
   vecchie resource standalone in `app/Filament/Resources/Oauth*` **non sono
   mai state rimosse**: doppio albero confermato, con `OauthClientForm`
   presente in **3 copie divergenti** (validazione su tabella diversa:
   `unique('clients', ...)` vs `unique('oauth_clients', ...)`). Questo
   problema era gia' tracciato con precisione in
   `docs/wiki/redundancy/oauth-dual-resource-trees.md` e nella story
   `12.4.oauth-dup-resources-ssot` (status: backlog) — non duplicato, solo
   confermato e collegato dal nuovo documento canonico.
5. **`BMAD-SESSION.md` e `BMAD-SECOND-BRAIN.md`**: letti, **non toccati**.
   Sono log di sessione su un tema completamente diverso (fix PHPStan per
   `UserContract`/`Profile`/`XotData` nel repo `base_restaurant_fila5`,
   2026-09-04) e non hanno nessuna sovrapposizione con il tema passport/oauth
   cluster.

## Cosa e' stato consolidato

- Creato `laravel/Modules/User/docs/passport-oauth-cluster.md` (canonico):
  decisione architetturale finale, stato attuale reale verificato sul codice,
  storia essenziale delle decisioni (litigation → proposal → prima
  implementazione con bug → fix namespace → ondata "completato" → drift
  rilevato → stato odierno), tabella problemi noti risolti/aperti.
- Tutti i 29 file `passport-cluster*.md` / `oauth-cluster*.md` trasformati in
  stub (~10 righe) che puntano al documento canonico via `superseded_by`.
  Nessuna cancellazione: contenuto sostanziale gia' sintetizzato nel canonico.

## Cosa resta aperto (non eseguito in questa story, fuori scope)

- Remediation del dual-resource-tree (cancellare `app/Filament/Resources/Oauth*`
  e unificare `OauthClientForm`): pianificata nella story `12.4`, non eseguita
  qui — e' lavoro sul codice applicativo, esplicitamente fuori scope per questo
  task di consolidamento documentale.
- Nessun PHPStan/Pest eseguito (compito di un altro agente, per direttiva
  esplicita del task).
- Nessun commit/push (lasciato all'agente coordinatore).

## Acceptance criteria

- [x] Documento canonico creato e verificato contro il codice reale.
- [x] Tutti i file `passport-cluster*.md`/`oauth-cluster*.md` trasformati in
  stub che puntano al canonico.
- [x] Nessun contenuto sostanziale perso (recuperato anche il contenuto
  corrotto da un dedup precedente, via git history).
- [x] `BMAD-SESSION.md`/`BMAD-SECOND-BRAIN.md` valutati e lasciati intatti
  (tema distinto).
- [x] Story BMAD di consolidamento documentata.
- [ ] Remediation codice (dual-resource-tree) — intenzionalmente non eseguita,
  tracciata su story `12.4` esistente.
