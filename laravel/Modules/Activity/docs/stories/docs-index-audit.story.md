# Story: Audit indice documentazione — Activity

**Modulo**: Activity
**Tipo**: docs-only (nessuna modifica a codice/PHPStan/Pest)
**Data**: 2026-09-03

## Cosa ho trovato

`Modules/Activity/docs/` contiene 755 file `.md` (non 362 come indicato inizialmente),
con 92 cluster di duplicati quasi identici (227 file, varianti maiuscole/minuscole,
underscore/trattino, numerazioni `-1`/`-2`/`-duplicate`), 49 file completamente vuoti,
73 stub con frontmatter `canonical:` che puntano a `Themes/docs/shared-components/`
(pattern architetturale voluto, non incidente), quattro copie parallele di un batch di
import "grezzo" (`root-md-files/`, `root-txt-files/`, `raw/root-import/` + originali in
root), e una duplicazione sistemica serie-numerata/alias-senza-numero in `roadmap/` e
nei tre alberi `use_cases/{bank,prediction_market,shop}/`. Il problema era gia' noto
(`docs-health.md`, `case-variant-collisions.md`, `task-consolidare-documentazione.md`)
ma mai risolto: il conteggio e' cresciuto da 130 (stimato) a 755.

## Cosa ho fatto

Riscritto `docs/index.md` come indice organizzato per argomento (architettura, database,
Filament/UI, PDF/grafici, event sourcing, casi d'uso, testing, PHPStan/qualita',
errori/troubleshooting, roadmap/prodotto, BMAD story, task, wiki, governance,
traduzioni, sicurezza, ambiente/tooling, git/conflitti, prompt), con link relativi
verificati (414 link, tutti risolti). Aggiunta sezione "Storico / da consolidare" che
elenca tutti i cluster di duplicati con nota sul perche', senza toccare, rinominare o
cancellare alcun file esistente. Nessuna modifica al codice del modulo.

## Cosa resta da fare

- Consolidamento vero e proprio dei 92 cluster (task gia' tracciato in
  `task-consolidare-documentazione.md`, fermo al 30%): richiede lettura a mano dei
  duplicati a "contenuto diverso nonostante nome simile" (es. `module-analysis.md` vs
  `module_analysis.md`) prima di unire qualunque cosa.
- Aggiornare `tasks/tasks-index.md`, che copre solo 3 dei 36 file sotto `tasks/`.
- Decidere il destino delle 4 cartelle di import grezzo (`root-md-files/`,
  `root-txt-files/`, `raw/root-import/`, file orfani in root) — candidate a rimozione
  ma richiede conferma esplicita, non decisa in questo audit.
- Valutare se `llm-wiki/` (scaffold vuoto) va dismesso a favore di `wiki/` (attivo e
  gia' indicizzato).
