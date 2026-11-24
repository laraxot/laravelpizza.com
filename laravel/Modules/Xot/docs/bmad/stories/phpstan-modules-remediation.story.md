---
<<<<<<< HEAD
=======
<<<<<<< HEAD
title: "Remediation PHPStan globale dei moduli"
status: done
qmd: "phpstan Modules errori 23 source-first swarm BMAD"
---

# Story: remediation PHPStan globale dei moduli

## Obiettivo

Portare `cd laravel && ./vendor/bin/phpstan analyse Modules` a zero errori,
correggendo i contratti alla sorgente e preservando il comportamento di dominio.

## Acceptance criteria

- [x] Gate globale PHPStan eseguito in una sola lane isolata, exit 0.
- [x] Errori raggruppati per causa e corretti senza baseline o cast cosmetici.
- [x] Test/gate Pest dello scope modificato tentato; blocco DB remoto documentato.
- [x] QMD/second brain aggiornato e diff controllato.
- [x] Commit tracciabile con soli file di questa story; sincronizzazione Git verificata.

## Evidenza iniziale

Il gate esclusivo del 2026-11-23 ha rilevato 23 errori su 8 file: numerici,
deprecated PhpSpreadsheet, chiavi array nullable, confronto nullo in mutator,
ritorno nullable nel mixin e assert già ristrette nel test FeatureFlags.

## Piano swarm

- Cluster Performance: assegnazione numerica di `importo_totale`.
- Cluster Ptv: foglio deprecated, chiavi array e confronto nullo nel mutator.
- Cluster Xot: export PhpSpreadsheet e ritorno nullable del PanelMixin.
- Cluster test Xot: assert ridondanti, preservando le verifiche comportamentali.

## Verifica

Fix swarm completati sui cluster Performance, Ptv, Xot e test Xot. Il gate finale esclusivo ha restituito
`/tmp/phpstan-current-final4/result.json` con `errors=0`, `file_errors=0`, exit 0. Il risultato iniziale è stato salvato in
`/tmp/phpstan-current-unique/result.json`; nessun processo concorrente deve
essere usato come evidenza del gate.

## Riferimenti

- `laravel/phpstan.neon`
- `bashscripts/lock/`
- `laravel/Modules/Xot/docs/ecc/00-index.md`
- `bashscripts/ai/wiki/memories/source-first-before-fix.md`
=======
>>>>>>> laraxot/dev
id: 2026-10-09-phpstan-modules-remediation
title: PHPStan Modules — remediation funzionale con swarm
type: story
module: Xot
epic: quality/phpstan
status: review
created: 2026-10-09
updated: 2026-10-09
related:
  - ./5.260-phpstan-modules-current-remediation.story.md
---

# Scopo

Portare `cd laravel && ./vendor/bin/phpstan analyse Modules` a zero errori,
correggendo la causa funzionale e mantenendo il comportamento dei moduli.
Il lavoro è diviso solo su file disgiunti, con lock e subagent; non introduce
nuovi Service né usa `mixed` come scorciatoia.

## Acceptance criteria

- [ ] Bootstrap PHPStan funzionante.
- [ ] Nessuna segnalazione PHPStan residua.
- [ ] Ogni cluster ha verifica mirata e gate Pest documentato.
- [ ] Documentazione aggiornata solo nei moduli/temi realmente coinvolti.
- [ ] Second brain/QMD aggiornati con le evidenze finali.

## Evidenza iniziale 2026-10-09

- Primo run: bootstrap bloccato da autoload generato che puntava al rimosso
  `Modules\\Tenant\\Services\\TenantService`; `composer dump-autoload --no-scripts`
  ha riallineato l'indice senza modificare codice applicativo.
- Secondo run: bootstrap bloccato da marker di merge transitori in
  `XotBaseServiceProvider`; il file è stato verificato senza marker.
- Run successivo: fatal su override di `getTableColumns()` in Rating; il file è
  già sotto lock di un altro agente (`rating-table-hook-fix`) e non viene toccato
  da questa sessione.
- Full run successivo: fatal di compatibilità tra il contratto Xot e il trait
  vendor `HasAdjacencyList`: il contratto imponeva return type nativi che il
  trait runtime non dichiara. Corretto alla fonte mantenendo i tipi in PHPDoc;
  `php -l`, autoload delle classi e PHPStan mirato su Xot tree/BaseRating verdi.
- Pest mirato non eseguito fino in fondo: il database testing
  `10.100.200.53:3306` è irraggiungibile; la limitazione è infrastrutturale.

## Esito gate 2026-10-09

- `cd laravel && ./vendor/bin/phpstan analyse Modules --no-progress
  --error-format=raw`: **exit 0**, nessuna segnalazione residua.
- `qmd update`: completato; 5 documenti embedded e 5 hash aggiornati.
- `graphify update .`: avviato in parallelo; il lock di rebuild era presente
  al controllo finale, quindi l'esito del grafo va riverificato.
- Pest mirato su Xot/User: interrotto dopo circa 3 minuti senza output; non
  risultano errori applicativi, ma il bootstrap/DB non ha risposto. Da ripetere
  in ambiente testing raggiungibile.

## Regole operative

Verificare prima i caller e la responsabilità funzionale; correggere alla fonte,
non sopprimere l'errore. Non usare reset/restore/stash, baseline, ignore o
migrazioni distruttive. La riorganizzazione massiva delle docs è fuori scope:
si fanno solo correzioni documentali direttamente provate dal cluster.
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
