---
title: Form/Table/Infolist di una Resource trovate anche dal nome della Resource
status: done
module: Xot (owner), Progressioni
created: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../../Progressioni/docs/stories/schede-navigation-restore.story.md
  - ../../../Ptv/docs/stories/trova-esclusi-correttezza.epic.md
---

# Form/Table/Infolist di una Resource trovate anche dal nome della Resource

## Fase BMAD

Build (bugfix produzione) con decisione di architettura sulla base `XotBaseResource`.

## Errore

`GET /progressioni/admin/scheda-pos`:
`Expected a sub-class of "XotBaseResourceTable". Got: "Modules\Progressioni\Filament\Resources\SchedaDipResource\Tables\SchedasTable"`
(`XotBaseResource.php:202`, `getTableClass()`).

## Percorso completo, verificato

1. `ListRecords::table()` => `SchedaPoResource::table()` => `getTableClass()`.
2. Primo tentativo, nome dal **modello**: `SchedaPoResource\Tables\SchedasTable` (modello `Scheda`).
   Non esiste: il file e' `SchedaPoResource\Tables\SchedaPosTable`.
3. Fallback: `Filament::getModelResource(Scheda::class)` restituisce la **prima** Resource del
   pannello con quel modello, in ordine di discovery (alfabetico): `SchedaDipResource`.
4. `SchedaDipResource\Tables\SchedasTable` non esiste => Assert fallisce.

Stesso schema per `getFormClass()` (`SchedaPoForm`) e `getInfolistClass()` (`SchedaPoInfolist`):
tutte e 5 le varianti (Dip, Po, Dirigente, Polizia, Regionale) erano rotte in lista, modifica e
vista. Funzionava solo "Tutte" (`SchedaResource`, file `SchedasTable`/`SchedaForm`).

## Perche' i file hanno quel nome

Le cartelle delle varianti (commit `9e455a237e`) sono copiate da IndennitaResponsabilita, dove
ogni variante ha il **proprio modello STI** (`SchedaPo`, `SchedaDip`...): li' `SchedaPoForm` e'
il nome dal modello ed e' giusto. In Progressioni le varianti condividono il modello `Scheda`
(sono viste filtrate per `type`), quindi lo stesso nome non e' piu' "dal modello" ma "dalla
Resource", e la base non lo cercava.

## Decisione

`XotBaseResource` risolve Form/Table/Infolist con un solo metodo e tre tentativi, in ordine:

1. nome dal modello: `{Resource}\Schemas\{Model}Form` (invariato, regola
   `parental-sti-filament-schemas`);
2. **nome dalla Resource**: `{Resource}\Schemas\{ResourceSenzaSuffisso}Form`,
   `{Resource}\Tables\{Plurale}Table` (es. `SchedaPoResource` => `SchedaPoForm`, `SchedaPosTable`);
3. fallback invariato: la Resource registrata per il modello.

Scartate:

- rinominare i 15 file delle varianti in `SchedasTable`/`SchedaForm`: funziona, ma ogni nuova
  Resource che condivide un modello ricadrebbe nello stesso errore;
- risalire la gerarchia delle Resource (`SchedaPoResource` => `SchedaResource`): rende inutili i
  file esistenti e aggiunge un comportamento implicito; nessun caso lo richiede oggi.

Nessun cambiamento dove funziona gia': il passo 1 resta il primo (IR, Performance, tutte le
altre Resource).

## Verifica

- Confronto vecchio/nuovo algoritmo su **tutte** le Resource `XotBaseResource` di tutti i
  pannelli (Table e Form, sola risoluzione dei nomi, nessun render): 309 invariate, **0 cambiate**,
  11 riparate. Riparate: le 5 varianti Progressioni (Table + Form) e `Progressioni\PesiResource`
  (Form `PesiForm`: stesso difetto, mai segnalato).
- Infolist delle varianti risolte (`SchedaPoInfolist`, ...). IR invariata (passo 1).
- PHPStan livello 10 su `XotBaseResource.php`: 0 errori. Pint: solo riallineamento phpdoc.
- Logica prima triplicata in `getFormClass/getTableClass/getInfolistClass`, ora in
  `resolveResourcePartClass()`; i commenti esistenti mantenuti e spiegati.
- Pest saltato: produzione.

## Lezione

Copiare una struttura da un modulo a un altro copia anche le sue premesse: in IR "nome dal
modello" e "nome dalla Resource" coincidono perche' ogni variante ha il suo modello STI; in
Progressioni no. Una variante che condivide il modello va verificata aprendo lista, modifica e
vista, non solo il menu.
