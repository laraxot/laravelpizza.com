---
title: "case duplicate fixtures traits verification phpstan clean"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "case duplicate fixtures traits verification phpstan clean"
issues: []
discussions: []
---

# Verifica case-duplicate tests/Fixtures|fixtures/Traits + PHPStan Geo pulito

## Contesto
Task di coordinamento multi-agente su `Modules/Geo` (repo `laraxot/module_geo_fila5`,
remote configurato come `laraxot`, non `origin`). Verifica esplicita richiesta sul
problema storico delle directory case-duplicate:

- `tests/Fixtures/Traits/` (maiuscolo)
- `tests/fixtures/traits/` (minuscolo)

su cui in passato erano finiti file quasi identici con pattern `*PhpstanProbe*`
(vietati da `bashscripts/tools/guard-no-phpstan-probes.sh`), rimossi e ripristinati
più volte da agenti diversi che si sovrascrivevano a vicenda.

## Stato verificato in questa sessione

- `git remote -v` → `laraxot git@github.com:laraxot/module_geo_fila5.git` (fetch/push).
- Branch locale `dev` **allineato** con `laraxot/dev` (0 commit ahead, 0 behind) →
  nessun fetch/rebase necessario, nessun conflitto da risolvere.
- Working tree però molto sporco: 843 file modificati/eliminati non ancora committati
  (probabile lavoro di sessioni/agenti precedenti sullo stesso checkout condiviso),
  in gran parte cancellazioni massive di doc ridondanti sotto `docs/` e sotto
  `tests/Fixtures/Traits/` + `tests/fixtures/traits/`.

### Case-duplicate: risultato verifica

Su disco, ad oggi:
- `tests/Fixtures/Traits/` contiene **solo** `HasAddressTestModel.php` (779 byte,
  file legittimo, non è un pattern probe).
- `tests/fixtures/traits/` (minuscolo) **non esiste più** sul filesystem — i due
  file probe che conteneva (`GeoPhpstanProbeModel.php`, `GeoPhpstanTraitProbes.php`)
  risultano `D` (deleted, non staged) in `git status`.
- Tutti i 7 file `*Probe*.php` sotto la variante maiuscola e i 2 sotto la variante
  minuscola sono già stati rimossi dal working tree (deletion non ancora committata).
- `grep -rn` su tutto il modulo per i nomi delle classi probe
  (`GeoPhpstanProbeModel`, `GeoPhpstanTraitProbes`, `GeoTraitPhpstanProbe`,
  `GeographicalScopesPhpstanProbe`, `HasAddressesPhpstanProbe`,
  `HasPlaceTraitPhpstanProbe`, `SushiToJsonsPhpstanProbe`) → **nessun consumatore
  reale trovato** in `.php`/`.neon`.
- `bash bashscripts/tools/guard-no-phpstan-probes.sh` → **PASS** (`✅ GUARD: no
  PHPStan probe files/dirs`).

**Conclusione case-duplicate**: il problema esiste ancora solo come *evidenza storica*
nell'indice git (deletion non committata), non più come file reali su disco. La
directory duplicata minuscola `tests/fixtures/traits/` è stata eliminata interamente;
quella maiuscola `tests/Fixtures/Traits/` resta con l'unico file legittimo
`HasAddressTestModel.php`. **Nessuna azione distruttiva ulteriore eseguita in questa
sessione** — non è stato fatto alcun `rm`, la situazione era già stata ripulita da
un'esecuzione precedente (probabile agente parallelo). Non ho committato nulla:
il lavoro pregresso resta come modifiche non staged, in attesa di conferma/commit
esplicito da parte del coordinamento (troppi file coinvolti — 843 — per un commit
a scatola chiusa senza review dedicata alle cancellazioni doc).

## PHPStan
```
cd laravel
php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules/Geo --no-progress --error-format=table
```
Risultato: **[OK] No errors**.

`php -l` su tutti i 20 file `.php` modificati (non staged): nessun errore di sintassi.

## Raccomandazione per prossimo agente
1. **Non ripristinare** i file `*PhpstanProbe*` sotto nessuna delle due varianti di
   case: sono vietati dalla regola del progetto e PHPStan resta a 0 errori senza.
2. Prima di qualunque nuovo intervento su `tests/*ixtures/*raits/`, ripetere
   `ls -la` su entrambe le varianti di case per confermare lo stato — su filesystem
   case-insensitive (macOS/Windows) queste due directory collidono silenziosamente,
   qui su Linux sono (state) due entità distinte.
3. Le 843 modifiche pendenti (soprattutto cancellazioni doc sotto `docs/`) non sono
   state committate in questa sessione: richiedono una review/commit dedicati da
   parte del coordinamento multi-agente prima di un `git push`, per evitare di
   perdere contenuto utile insieme al rumore.
4. Nessun conflitto di merge da risolvere: branch `dev` locale = `laraxot/dev`
   remoto, non serve pull/rebase in questo momento.

## Issue #232
Non pertinente a questo task (riguarda "provider geocoding in cascata", non
correlato al case-duplicate né a PHPStan probe files). Nessuna azione presa.
