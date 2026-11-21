---
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
