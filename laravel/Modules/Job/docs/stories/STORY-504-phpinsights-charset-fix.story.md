---
title: "STORY-504 — PHPInsights crash su charset iso-8859-1 in lang it"
type: story
status: draft
tags: [phpinsights, charset, encoding, quality-gate, job, bmad]
created: 2026-09-26
updated: 2026-09-26
qmd: "phpinsights charset iso-8859-1 iconv strlen crash quality gate job lang"
module: Job
story: STORY-504
issues:
  - "https://github.com/laraxot/module_job_fila5/issues/31"
discussions:
  - "https://github.com/laraxot/module_job_fila5/discussions/32"
related:
  - ../../docs/phpstan-syntax-fixes.md
  - ../../docs/phpstan-corrections.md
---

# STORY-504 — PHPInsights crash su charset iso-8859-1 in lang it

## User story

Come maintainer voglio che PHPInsights specchi il codebase senza crash
su file di traduzione, così il quality gate PHPInsights è eseguibile
e bloccante come indicato in `bashscripts/docs/prompts/11-phpinsights.md`.

## Problema verificato

`laravel/Modules/Job/lang/lang/it/job.php` dichiara `charset=iso-8859-1`
nella sua intestazione PHP (riga `@charset` o `Content-Type`), ma contiene
byte UTF-8. PHPInsights (PHP-CS-Finder + `iconv_strlen`) va in errore su
`iconv_strlen(): Detected an illegal character in input string` e termina
con exit-code ≠ 0, bloccando il gate.

PHPStan non è interessato (analizza AST, non encoding), quindi la issue
si vede solo con PHPInsights — costringe a `SKIP_ENV` (regola qualità gate).

## Acceptance criteria

- [ ] Il file `laravel/Modules/Job/lang/lang/it/job.php` usa `charset=utf-8`.
- [ ] Nessun byte iso-8859-1 rimane nel file (verifica con `iconv -f UTF-8`).
- [ ] PHPInsights (`vendor/bin/phpinsights` se disponibile) completa
      l'analisi del modulo Job senza crash su questo file,
      oppure il gate registra `SKIP_ENV` con giustificazione.
- [ ] PHPStan resta verde (0 errori) sul modulo Job.
- [ ] La traduzione italiana carica comunque (stringhe non rotte a runtime).

## Piano tecnico

- Converte l'intestazione `@charset`/`Content-Type` a `utf-8`.
- Normalizza il file con `iconv -f UTF-8 -t UTF-8//IGNORE` o `recode`.
- Verifica: `php -r "var_dump(iconv_strlen(file_get_contents('...')));"`
  restituisce la lunghezza corretta senza avvisi.
- Aggiunge `SKIP_ENV` nel report se PHPInsights non è installato.
