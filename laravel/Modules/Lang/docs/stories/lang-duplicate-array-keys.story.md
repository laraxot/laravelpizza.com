---
qmd: "lang duplicate array keys.story"
title: "Lang: 781 chiavi duplicate in lang_service.php, tutte nella sezione fields"
type: story
module: Lang
epic: 7
story_id: "LANG-7.3"
slug: lang-duplicate-array-keys
status: review
created: 2026-08-24
updated: 2026-08-24
repository: https://github.com/laraxot/module_lang_fila5
tags:
  - phpstan
  - lang
  - traduzioni
  - duplicazione
  - array
estimated_effort: "0.25 dev-day"
issues:
  - "https://github.com/laraxot/bashscripts_fila5/issues/10"
discussions:
  - "https://github.com/laraxot/bashscripts_fila5/discussions/11"
blocked_by: []
related:
  - "../../../Xot/docs/stories/5.37.zero-conflict-markers-repo-wide.story.md"
  - "../../../Xot/docs/stories/5.42.prompts-numbering-uniqueness.story.md"
  - "../../../../../docs/wiki/log.md"
  - "../../../../../bashscripts/docs/prompts/55-md-conventions.md"
  - "../README.md"
owned_scope:
  - laravel/Modules/Lang/lang/en/lang_service.php
  - laravel/Modules/Lang/docs/stories/lang-duplicate-array-keys.story.md
---

# LANG-7.3 — chiavi duplicate in `lang_service.php`

## Story

Come manutentore del gate statico, voglio che `phpstan analyse Modules` torni a zero, e
oggi **tutti i 781 finding stanno in un file solo**: quella è la story.

## Evidenza misurata (2026-08-24)

```text
cd laravel && ./vendor/bin/phpstan analyse Modules --error-format=json
totals.file_errors = 781
```

| | |
|---|---:|
| Moduli coinvolti | **1** (Lang) |
| File coinvolti | **1** (`lang/en/lang_service.php`) |
| Identifier | **1** (`array.duplicateKey`) |

Il file ha 10.028 righe e 1760 blocchi di secondo livello, di cui **934 chiavi distinte**:
**770 chiavi compaiono più di una volta**.

### Il dato che rende la correzione sicura

Analizzando le duplicazioni **con lo scope della sezione** — `fields.title` e
`actions.title` sono chiavi diverse in PHP, e PHPStan non le confonde:

| | |
|---|---:|
| Chiavi duplicate **dentro la stessa sezione** | 770 |
| Di queste, in `fields` | **770 (tutte)** |
| Gruppi in cui i blocchi duplicati sono **byte-identici** | **770 (tutti)** |
| Gruppi con contenuto divergente | **0** |

Nessuna scelta da fare: le copie sono identiche. Tenere la prima e togliere le altre non
cambia il valore di nessuna chiave.

> Una prima analisi senza lo scope di sezione contava 54 «duplicati divergenti». Erano
> falsi positivi: `fields.title` con `label/placeholder/helper_text` contro `actions.title`
> con `label/icon/tooltip`. Chiavi diverse, in sezioni diverse, entrambe legittime.

## Perché conta, oltre al gate

In PHP, in un array letterale con chiavi ripetute **vince l'ultima** e le precedenti sono
codice morto, senza alcun avviso a runtime. Qui le copie sono identiche, quindi non c'è un
bug di comportamento — ma il file pesa 328 KB per contenere 934 chiavi utili, e ogni
`__('lang_service.fields.x')` carica tutto.

Il rischio vero è futuro: se qualcuno modifica **la prima** occorrenza di una chiave
credendo di aggiornare la traduzione, non succede niente. La modifica è silenziosamente
ignorata.

## Acceptance Criteria

<!-- LOCKED. External dev tools must not edit Acceptance Criteria. -->

1. `cd laravel && ./vendor/bin/phpstan analyse Modules` → **0 errori**, cache pulita.
2. In `lang_service.php` nessuna chiave compare più di una volta **all'interno della stessa
   sezione**. Le omonimie fra sezioni diverse (`fields.title` / `actions.title`) restano.
3. Il file resta PHP valido (`php -l`) e l'array resta caricabile: il numero di chiavi
   distinte per sezione **prima e dopo è identico**.
4. Nessun valore cambia: per ogni chiave, il blocco conservato è byte-identico a quello che
   c'era prima della correzione.
5. La correzione tocca **solo** `lang/en/lang_service.php`. Nessuna modifica a
   `phpstan.neon`, nessun `@phpstan-ignore`, nessuna baseline.

## Tasks / Subtasks

<!-- LOCKED. External dev tools must not edit Tasks / Subtasks. -->

- [x] Misurare i duplicati con lo scope della sezione, non globalmente (AC: #2).
- [x] Verificare che ogni gruppo di duplicati sia byte-identico (AC: #4).
- [ ] Rimuovere le occorrenze successive alla prima, dentro ogni sezione (AC: #2).
- [ ] Verificare `php -l` e il conteggio delle chiavi distinte per sezione (AC: #3).
- [ ] Rieseguire il gate a cache pulita (AC: #1).

## Dev Notes

<!-- LOCKED. External dev tools must not edit Dev Notes. -->

- **Lo scope della sezione è la parte che conta.** Contare i duplicati sul nome della
  chiave senza sapere in quale sezione sta produce 54 falsi divergenti e rischia di far
  cancellare `actions.title` credendolo copia di `fields.title`.
- **Non toccare le altre lingue senza rimisurare.** Solo `en` è nel payload di PHPStan
  oggi; se `it` ha lo stesso difetto, è un'altra misura e un'altra riga di questa story.
- **Niente `@phpstan-ignore`, niente baseline.** La policy del progetto è esplicita: gli
  errori si correggono.
- **Il file è generato?** Se esiste un generatore delle traduzioni che ha prodotto le
  duplicazioni, correggere il file senza correggere il generatore è lavoro da rifare. Da
  verificare prima di chiudere.

## Testing

<!-- LOCKED. External dev tools must not edit Testing. -->

- `php -l laravel/Modules/Lang/lang/en/lang_service.php`.
- Confronto strutturale prima/dopo: per ogni sezione, l'insieme delle chiavi distinte deve
  essere **identico**; cambia solo il numero di blocchi.
- Confronto dei valori: per ogni chiave conservata, il blocco è byte-identico all'originale.
- Gate: `rm -rf /tmp/phpstan && ./vendor/bin/phpstan analyse Modules` → 0 errori, con una
  sola corsa in serie (le corse concorrenti si corrompono sulla `tmpDir` condivisa).

## Dev Agent Record

<!-- Da compilare durante l'implementazione. -->

### Esecuzione 2026-08-24 — Claude (Opus 5)

**781 finding, un file, una causa. Rimossi 770 blocchi duplicati, nessun valore cambiato.**

| | Prima | Dopo |
|---|---:|---:|
| Righe di `lang_service.php` | 10.028 | **5.715** |
| Blocchi di secondo livello | 1.760 | 990 |
| Chiavi distinte caricate da PHP | **1.089** | **1.089** |
| Finding `array.duplicateKey` | 781 | 0 |

#### La verifica che rende la correzione difendibile

Non ho confrontato il testo: ho confrontato **l'array che PHP carica**, prima e dopo,
serializzandolo in JSON.

```php
<?php $a = require $argv[1]; echo json_encode($a);
```

Esito: stesse sezioni, stesse chiavi in ogni sezione, **stessi valori**, 1.089 chiavi in
entrambi i casi. Il file è dimezzato e l'applicazione riceve esattamente lo stesso array.

#### L'errore che stavo per fare

La prima analisi contava i duplicati **sul nome della chiave**, senza sapere in quale
sezione stessero. Risultato: 54 «duplicati divergenti», con `title` che appariva sia come
`label/placeholder/helper_text` sia come `label/icon/tooltip`.

Sembrava un conflitto da risolvere a mano. Non lo era: erano `fields.title` e
`actions.title` — **chiavi diverse, in sezioni diverse, entrambe legittime**. PHPStan non
le ha mai confuse; le ho confuse io contandole male.

Rifatta l'analisi con lo scope della sezione: **770 duplicati, tutti dentro `fields`, tutti
byte-identici, zero divergenti**. La correzione da «editoriale, 54 decisioni» è diventata
«meccanica, zero decisioni».

Il generatore: cercato in `Modules/Lang/app/Actions` e `app/Console`, nessuno script
produce questo file. Non è output rigenerabile, quindi la correzione non verrà sovrascritta.

#### Le altre lingue: verificate, non toccate

La Dev Note chiedeva di misurare `it` prima di chiudere. Fatto, con lo stesso criterio
(chiavi con lo scope della sezione):

| Locale | Blocchi | Distinti | Duplicati |
|---|---:|---:|---:|
| `de` | 11 | 11 | **0** |
| `en` | 990 | 990 | **0** (dopo la correzione) |
| `it` | 991 | 991 | **0** |

Il difetto era **solo** in `en`. `it` ha una chiave in più di `en`: è un disallineamento di
copertura fra le due lingue, non un duplicato, e appartiene a un'altra story.

#### Coda: l'ultimo duplicato non era innocuo

Dopo la rimozione dei 770, PHPStan ne segnalava ancora **uno**:
`'notify::filament'`, definito due volte nella stessa sezione.

Il mio parser a due livelli non lo aveva visto perché stava a una profondità diversa. L'ho
trovato con un rilevatore basato sul **tokenizer PHP** invece che sull'indentazione — con
`token_get_all` e una pila di array aperti, il livello di annidamento non conta:

```bash
php /tmp/dupkeys.php Modules/Lang/lang/en/lang_service.php
# riga 1605: chiave duplicata 'notify::filament' (prima occorrenza a riga 1369)
```

E qui, a differenza degli altri 770, **le due copie non erano identiche**:

```php
'notify::filament' => [                    // riga 1369
    'components' => [ 'params-badges' => [] ],
],
...
'notify::filament' => [],                  // riga 1605 — vuota
```

In PHP vince l'ultima: il blocco **vuoto** sovrascriveva quello popolato, e
`notify::filament.components.params-badges` era irraggiungibile. Non era rumore da lint,
era una chiave di traduzione persa.

Rimossa la copia vuota. È l'**unica** modifica di questa story che cambia il comportamento
a runtime, e lo cambia nel verso giusto: la chiave torna a esistere.

`./vendor/bin/phpstan analyse Modules/Lang/lang/en/lang_service.php` → **[OK] No errors**.

#### Lezione per il rilevatore

Contare i duplicati con una regex sull'indentazione funziona finché la struttura è
regolare, e fallisce in silenzio appena qualcosa è annidato diversamente. Il tokenizer non
ha questo limite: `php /tmp/dupkeys.php` è tre volte più corto del parser a livelli e trova
i duplicati a **qualunque** profondità. Vale la pena portarlo in
`bashscripts/quality-gates/`.
