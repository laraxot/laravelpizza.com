---
title: "Gitignore: la regola Database/ nasconde i test di User"
type: story
module: User
status: blocked-decision
created: 2026-10-21
updated: 2026-10-27
tags: [docs, user, bmad]
qmd: "regola database/ nel gitignore di user user"
---

# Regola Database/ nel gitignore di User

## Problema

`laravel/Modules/User/.gitignore:484` contiene `Database/`. Questa regola nasconde a git
`tests/Unit/Database/` e `tests/Feature/Database/`. Le modifiche a quei test non
entrano in nessun commit, e il lavoro PHPStan sui seeder risulta invisibile.

## Verifica

`git check-ignore -v laravel/Modules/User/tests/Unit/Database/OauthFactoriesDefinitionTest.php`
restituisce la riga 484 della regola.

## Decisione richiesta

Restringere la regola a `/database/` (solo la cartella di migrazioni e seeder della radice
del modulo), oppure eliminarla se non serve. Il file e' condiviso: decidere prima di cambiarlo.

## Criteri di chiusura

- `git check-ignore` non nasconde piu' i test.
- Nessun file di migrazione o seeder diventa tracciato per errore.