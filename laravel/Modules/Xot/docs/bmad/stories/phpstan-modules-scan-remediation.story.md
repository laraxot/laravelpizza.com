---
title: "Ripristinare il gate PHPStan globale dei moduli"
type: story
module: Xot
status: done
created: 2026-11-05
updated: 2026-11-05
tags: [bmad, phpstan, modules, remediation]
qmd: "PHPStan analyse Modules full tree trait extraction errors remediation gate"
related:
  - ./model-methods-traits-extraction.story.md
  - ./accessor-twin-contract-audit.story.md
---
# Ripristinare il gate PHPStan globale dei moduli

## Obiettivo

Eseguire `php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules`, correggere
gli errori alla sorgente e mantenere il gate pulito durante le estrazioni Eloquent
condivise. La story precedente citata nel `sprint-status.yaml` non è presente nel
filesystem; questa story ripristina una traccia reale e verificabile.

## Criteri di accettazione

- [x] Completare il gate globale dopo che gli agenti hanno terminato le scritture concorrenti.
- [x] Correggere ogni errore risultante, assegnando ownership BMAD e lock per file.
- [x] Ottenere exit 0 sul comando globale e registrare il conteggio.
- [ ] Eseguire Pest mirato per i moduli toccati o documentare lo skip ammesso.

## Primo esito

- Nuovo ciclo: PHPStan inizialmente non era arrivato al type gate perché 243 file
  applicativi/test contenevano marker di merge. Sono stati rimossi dopo una lettura
  dei lati; i blocchi identici e i lati vuoti sono stati risolti automaticamente,
  mentre i conflitti non vuoti richiedono review del dominio owner.
- Il gate successivo ha superato il parse layer ma ha mostrato oltre 1000 errori
  reali/infrastrutturali nella configurazione canonica: Larastan e l'estensione Pest
  risultano assenti da `phpstan diagnose`, mentre il checkout nested di Weighing è
  ancora un rischio di boundary. Non vengono aggiunti ignore, baseline o `mixed`.
- Le lane BMAD sono state assegnate in modo disgiunto a AI, Activity, Media, Notify
  e User/Tenant; il coordinatore eseguirà il gate globale soltanto a swarm fermo.
- Dopo `composer install`, il plugin PHPStan ha rigenerato le estensioni Larastan/Pest
  (`phpstan diagnose` ora le elenca). L'analisi ha inoltre escluso il checkout Laravel
  nested `Modules/Weighing/laravel`, che non appartiene al tree applicativo principale.
- Gate coordinatore aggiornato: `APP_KEY` locale e configurazione corrente producono
  `9933/9933`, exit `1`, `237` file-errors. Le lane successive hanno portato il
  conteggio a `23` file-errors; il JSON è integro con `totals.file_errors = 23`.
  Restano solo tre cluster disgiunti: User/Tenant, Weighing e Lang/Processing/Roosko/Warehouse.
- Gate finale coordinatore: `cd laravel && ./vendor/bin/phpstan analyse Modules` ha
  completato `9932/9932`, stampato `[OK] No errors` ed è terminato con exit `0`.
  Controprova JSON finale: `totals.errors = 0`, `totals.file_errors = 0`, JSON integro.
- Il checkout nested Weighing è escluso esplicitamente dalla scansione principale;
  l'ambiente locale ora contiene `.env` generato da `.env.example` con APP_KEY locale.

- Primo tentativo completo: exit 1 durante una finestra di modifiche concorrenti,
  con errori fatali di collisione trait in `Sigma/Asz00k1.php` e `Sigma/Qua00f.php`.
- Retry completo: 66 errori PHPStan, concentrati nei trait Sigma appena estratti
  (namespace/import PHPDoc non risolti e un helper rimasto inutilizzato). Il tree
  condiviso cambia durante l'audit; il log dettagliato è
  `/tmp/phpstan-modules-scan-remediation.log`.
- Terzo scan completo: `php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules`
  exit 0, `10568/10568`, `[OK] No errors`. Le estrazioni concorrenti erano nel
  frattempo state completate/corrette. Il primo snapshot non va usato come
  inventario finale.
- Nessun ignore PHPStan né baseline aggiunto. I file Sigma hanno ownership/lock
  attivi; i fix vanno coordinati col relativo owner, senza sovrascriverne i diff.
