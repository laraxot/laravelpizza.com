---
title: "Rimozione del modulo Cms dal checkout PTVX"
qmd: "cms assenza modulo bootstrap providers cache composer laravel head"
status: review
---

# Story BMAD — Rimozione del modulo Cms dal checkout PTVX

## Scopo

Questo checkout non include il modulo `Cms`. Il modulo è comune ad altri progetti,
ma non deve essere scoperto, autoloadato o registrato nell'applicazione PTVX.

## Acceptance criteria

- [x] Rimossi i riferimenti Cms dai registri `modules_statuses.json` del progetto.
- [x] Rimossa la connessione database `cms` e la configurazione `config/cms.php`.
- [x] Rimossa la dipendenza esclusiva `laravel/head` da Composer.
- [x] Rigenerate le cache Laravel/Composer senza il provider Cms.
- [x] Il bootstrap `php artisan about` parte correttamente.
- [x] PHPStan level massimo verde sui moduli PTVX escluso Cms.
- [ ] Verificare il PHPStan globale dopo che nessun processo concorrente ricrei `Modules/Cms`.
- [ ] Eseguire Pest completo in ambiente di test isolato.

## Evidenze

Il bootstrap falliva perché `bootstrap/cache/modules.php` registrava
`Modules\\Cms\\Providers\\CmsServiceProvider` mentre il modulo era un albero
non tracciato e soggetto a rigenerazione concorrente. Dopo la pulizia,
`php artisan about` è verde e l'analisi dei moduli PTVX non-Cms è verde.

La directory generata è stata spostata in una quarantena temporanea recuperabile
in `/tmp/base_ptvx_fila5-cms-quarantine-20261116175927`; non sono state toccate
migrazioni o dati.

## Rischio aperto

Un agente concorrente ricrea `laravel/Modules/Cms` e i relativi test durante le
verifiche. La directory contiene anche file PHP con errori di sintassi; finché
la risorgenza non viene fermata, il gate globale non rappresenta il checkout
desiderato.
