---
title: "Ponytail audit — planning discussione punto per punto"
type: architecture
tags: [ponytail, audit, planning, discussione, yagni]
created: 2026-06-30
updated: 2026-06-30
qmd: "ponytail audit planning discussione punto per punto vincoli predis compoships"
issues:
  - "https://github.com/provtv/base_ptv_fila5_mono/issues/173"
discussions:
  - "https://github.com/provtv/base_ptv_fila5_mono/discussions/174"
related:
  - "./ponytail-audit-report.md"
  - "./wiki/how-to/github-issue-agent-discipline.md"
  - "../laravel/Modules/Xot/docs/post-edit-quality-verification.md"
---

# Ponytail audit — planning

**Stato:** discussione — nessuna modifica codice finché non approviamo punto per punto.

**Report findings:** [ponytail-audit-report.md](./ponytail-audit-report.md)  
**Setup tool:** [wiki/how-to/ponytail-setup.md](./wiki/how-to/ponytail-setup.md)  
**GitHub:** [issue #173](https://github.com/provtv/base_ptv_fila5_mono/issues/173) · [discussion #174](https://github.com/provtv/base_ptv_fila5_mono/discussions/174)

## Vincoli non negoziabili

1. **Esclusi:** moduli `Pdnd`, `Incentivi`
2. **Non eliminare:** `predis/predis`, `.env` storici, `.gitignore` per modulo
3. **Non eliminare:** `awobaz/compoships` — obiettivo = **individuare dove adottarlo**
4. **Ogni edit `.php`:** PHPStan L10 → PHPMD → PHP Insights → Pest (no `migrate --force`)
5. **Ogni edit docs:** modulo/tema owner + `bashscripts/docs/llm-wiki-qmd.sh update` (ingest)

---

## Punto 1 — Tier A quick win (Lang, Xot stub, Performance test fantasma)

| # | Finding | LOC ~ | Rischio | Proposta lazy |
|---|---------|-------|---------|---------------|
| 1.1 | `GetAllModuleTranslationAction` duplicato | 50 | Basso | Delete file + verifica grep |
| 1.2 | `ProfileTest` in Services | 26 | Basso | Delete |
| 1.3 | `Translators/*` vuoti | 54 | Basso | Delete cartella |
| 1.4 | `Xot/app/Services/composer.json` orfano | 32 | Basso | Delete file |
| 1.5 | `User/resources/views/composer.json` | 22 | Medio | Spostare/align con `Themes/One`? |
| 1.6 | Test `CriteriEsclusioneService` senza classe | ~50 | Basso | Delete test o creare servizio |
| 1.7 | Doppia rule Cursor `migration-update*` | ~40 | Basso | Merge una `.mdc` |
| 1.8 | `UseCaseContract` User senza impl | ~40 | Medio | Delete contratti o implementare |

**Domanda per te:** partiamo da 1.1–1.4 in un unico PR minimale, o preferisci solo 1.1 isolato?

---

## Punto 2 — Duplicazione Criteri* (Ptv / Progressioni / Performance)

- `CriteriPrecedenzaService`: Ptv e Progressioni quasi identici; Ptv usa `Progressioni\Models\CriteriPrecedenza`
- `CriteriValutazioneService`: Performance ↔ Progressioni

**Proposta lazy:** non refactor ora. Quando tocchiamo `MakePdfAction` o scheda, estrarre **un** `GetCriteriPrecedenzaFieldsAction` in Progressioni (owner del modello) e far puntare Ptv lì.

**Domanda:** modulo owner canonico = **Progressioni** per `CriteriPrecedenza`? Performance resta owner di `CriteriValutazione`?

---

## Punto 3 — Xot Cast triplicato + GetFactoryAction

- `SafeEloquentCastAction` / `SafeAttributeCastAction` / `SafeObjectCastAction` (~915 LOC)
- `GetFactoryAction` (~190 LOC) vs `Model::factory()`

**Proposta lazy:** documentare in `Modules/Xot/docs` il debito; unificare solo se un bug cast ci costringe a toccare il file.

**Domanda:** hai già pain su cast inconsistenti in produzione, o è solo debito teorico?

---

## Punto 4 — Layer Services vs Actions (146 file)

Religione progetto: `QueueableAction`, no `app/Services` in `laravel/app/`.

**Proposta lazy:** freeze — nessun nuovo `*Service`; al prossimo bug su un Service esistente, converti quello in Action.

**Domanda:** esiste una whitelist di Services «sacro» (Notify, Tenant, RouteDyn) da non migrare mai?

---

## Punto 5 — Compoships (adozione, non rimozione)

Stato: dipendenza presente, **zero uso PHP** oggi.

**Proposta:**

1. Grep relazioni multi-FK in Sigma/Ptv/Performance (es. `matr`+`anno`, `ente`+`stabi`)
2. Documentare candidati in `Modules/Xot/docs/wiki/concepts/compoships-adoption.md` (modulo owner)
3. Pilot su **un** modello dopo OK

**Domanda:** hai già in mente 2–3 relazioni composite «ovvie» da usare come pilot?

---

## Punto 6 — Infrastruttura e tooling

Da validare dal report storico (numeri grossi — servono conteggi freschi prima di agire):

| Item | Tag proposto | Da discutere |
|------|--------------|--------------|
| `.bak` / backup monolith agent (~126k righe) | `delete` | Archiviare fuori repo vs delete |
| `_ide_helper*.php` committati | `shrink` | `.gitignore` + generazione locale |
| `phpstan_constants.php` × moduli | `delete` | Un file centrale in Xot? |
| AWS / Sentry in composer senza `.env` | `yagni` | Uso staging/CI non visibile in `.env` locale? |
| Script bash duplicati | `shrink` | Audit `bashscripts/tools/` prima |

**Domanda:** priorità tooling vs codice dominio — cosa ti dà più valore questa settimana?

---

## Punto 7 — Docs, ingest, second brain

Workflow proposto per ogni fase approvata:

```text
decisione in discussion #174
  → aggiorna docs modulo owner (wiki frontmatter)
  → validate-wiki-frontmatter.sh
  → bashscripts/docs/llm-wiki-qmd.sh update
  → commento issue #173 con path + esito quality gate
```

**Domanda:** ordine moduli docs più stale — partiamo da **Xot** (cast/factory) o **Lang** (duplicato action)?

---

## Sequenza esecuzione suggerita (dopo OK)

| Fase | Scope | Gate |
|------|-------|------|
| **0** | Solo questo planning + report | — |
| **1** | Tier A 1.1–1.4 | PHPStan moduli toccati + Pest Lang/Xot |
| **2** | Compoships mapping doc (no codice) | frontmatter + ingest |
| **3** | Criteri* unificazione (se OK Punto 2) | Pest Ptv/Progressioni |
| **4** | Cast merge (se OK Punto 3) | PHPStan Xot Actions/Cast |

---

## Cosa serve da te adesso

Rispondi per punti (anche solo «OK 1», «skip 3», «domanda su 2»):

1. Tier A — quali numeri approvi?
2. Owner Criteri* — Progressioni sì/no?
3. Cast — debito teorico o bug reale?
4. Services — whitelist?
5. Compoships — relazioni pilot?
6. Tooling — priorità?
7. Docs — modulo first?

Nessun commit codice finché non allineiamo almeno **Punto 1**.
