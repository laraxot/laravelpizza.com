---
title: GetViewByModelClassAction ripiega sulla vista della piattaforma (classi antenate)
status: done
module: Xot (owner), Progressioni, Ptv
created: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ./list-header-buttons-and-grid-toggle.story.md
  - ./resource-part-class-by-resource-name.story.md
---

# GetViewByModelClassAction ripiega sulla vista della piattaforma

## Fase BMAD

Build (bugfix produzione) + decisione sulla base Xot.

## Errore

`/progressioni/admin/scheda-polizias?filters[anno_valutatore][anno]=2026`, bottone "Esporta PDF":
`Exception: view [progressioni::scheda.index.pdf] not Exists`
(`GetViewByModelClassAction.php:28`, chiamato da `ExportPdfAction.php:65`).

## Percorso e scopo

`ExportPdfAction` (Xot, header di ogni lista) stampa le righe filtrate con la vista
`{modulo}::{modello_snake}.index.pdf`. Per le schede e' l'elenco per valutatore (matricola, nome,
tabella valutazioni, motivo di esclusione, firma del dirigente): `ptv::scheda.index.pdf`, nella
piattaforma Ptv. IndennitaResponsabilita ne ha copie proprie (5 viste sottili + una condivisa);
Progressioni nessuna. Il bottone e' comparso in Progressioni con il refactor dell'header delle
liste (bottoni visibili, stessa sessione): prima era un'icona grigia poco evidente, ma rotta
anche allora.

## Decisione

Il modello di una foglia estende la Base della piattaforma (`Progressioni\Models\Scheda` =>
`Ptv\Models\BaseScheda`). Il resolver prova la vista nel modulo del modello e, se manca, nei
moduli delle classi antenate, **con lo stesso nome di modello**:

1. `progressioni::scheda.index.pdf` (assente)
2. `ptv::scheda.index.pdf` (presente) => usata

Chi ha una vista propria la usa ancora (IR: passo 1). Vale per tutti i chiamanti
(`ExportPdfAction`, `PdfByModelAction`, `MakePdfByRecord`, `BaseCompilaScheda`,
`BaseFillOutTheForm`): una foglia eredita le viste della piattaforma finche' non le
personalizza. Scartata la copia `progressioni::scheda.index.pdf`: sarebbe la settima copia
dello stesso template.

Messaggio d'errore: elenca tutte le viste cercate.

## Verifica

- Risoluzione (sola lettura): Progressioni `Scheda` `.index.pdf` => `ptv::scheda.index.pdf`; IR
  `SchedaPo` => `indennitaresponsabilita::scheda_po.index.pdf` e `IndennitaResponsabilita` =>
  la sua vista (invariati); vista inesistente => errore con tutte le candidate
  (`progressioni::` / `ptv::` / `xot::`).
- Template `ptv::scheda.index.pdf` reso con una scheda Progressioni polizia 2026 **non salvata**
  (id nullo, nessuna scrittura degli accessor): matricola e cognome presenti.
- PHPStan livello 10: 0 errori. Test: `Progressioni/tests/Unit/View/SchedaPdfViewFallbackTest.php`.
- Pest saltato: produzione. Download del PDF da provare dal bottone (stesso motore di IR).
