---
type: story
slug: phpstan-safe-preg-stringable
title: "PHPStan: Safe\\preg_replace sostituito da Str::of()->replaceMatches() dove il risultato deve essere una stringa"
status: done
phase: DONE
owner: Xot
created: 2026-11-12
updated: 2026-11-12
---

# PHPStan: preg_replace di Safe e stringhe

## Perché

`Safe\preg_replace` e `Safe\preg_replace_callback` dichiarano `string|array` come tipo di ritorno anche quando l'input è una
stringa. Ogni `trim()`, `mb_substr()` o `return` tipizzato `string` subito dopo diventa quindi un errore PHPStan.
Analizzando tutti i moduli insieme (`phpstan analyse Modules`, regola del progetto) erano 13 errori in Xot, Cms e Tenant.

## Fatto

Si usa `Str::of($testo)->replaceMatches($pattern, $sostituto|$callback, $limite)->toString()`, che restituisce sempre una
stringa (lo stesso schema già adottato nei moduli di dominio di Roosko). È stato applicato in:

- **Xot**: `ShowArtisanErrorLogAction` (`Str::matchAll`), `BuildTestSqliteCommand::firstLine`, `EnvData::updateVar`,
  `InitialsAvatarProvider`.
- **Cms**: `ComposeDocumentTitleAction`, `ResolvePageDescriptionAction`, `Head::siteRoot`, `HasBlocks::renderAllowedExpressions`.
- **Tenant**: `GetEnteDataAction`, `EnteData::link`.

`ThemePublicSymlinkTest` verifica anche `public_html/assets/<modulo>` e i `.gitignore` del docroot. Un link non ancora creato
(checkout nuovo, CI) fa saltare il test con l'indicazione del comando da lanciare, invece di farlo fallire o
interrompere con «Empty data set».

## Restano

- `trait.unused`: 15 trait dei moduli condivisi non sono usati da nessun modulo installato in Roosko. Possono servire ad
  altri progetti, quindi non si cancellano senza decisione (issue nel repo base).
- `form()` dei filtri deprecato in Filament 5.11.1, `schema()` deprecato nella versione che installa la CI. Dipende
  dalla versione risolta: si risolve versionando `composer.lock` (issue nel repo base).
