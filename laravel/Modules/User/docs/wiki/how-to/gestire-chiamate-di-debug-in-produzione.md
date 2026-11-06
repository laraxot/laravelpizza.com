---
title: "Come trattare dddx() e dd() trovati nel codice di produzione"
type: how-to
status: active
module: User
created: 2026-10-20
updated: 2026-10-20
tags: [debug, dddx, filament, livewire, halt, logicexception, quality]
qmd: "dddx dd produzione catch Halt stub LogicException codice riattivato Filament page action"
related:
  - ../../stories/debug-calls-removal-user.story.md
  - ../../../../Job/docs/stories/debug-calls-removal-job.story.md
  - ../../../../Media/docs/stories/debug-calls-removal-media.story.md
  - ../../../../Setting/docs/stories/debug-calls-removal-setting.story.md
---

# Come trattare dddx() e dd() trovati nel codice di produzione

`dddx()` chiude con `dd()` senza condizioni: in produzione stampa percorsi e dati e uccide la richiesta. Non basta cancellare la
riga: prima si capisce a cosa serviva il punto.

## Misura

Usare un tokenizer PHP, non `grep`: `grep` conta anche commenti e stringhe (falsi positivi come `BaseUser.php`, dove la riga e' in
un blocco `/* */`) e `var_export($x, true)` / `print_r($x, true)`, che restituiscono una stringa e sono legittimi.

## Decisione per caso

| Caso | Azione |
|---|---|
| `catch (Halt)` con `dddx` | `Halt` e' lo stop volontario di Filament, non un errore: `return;` senza `report()`. |
| `catch (\Throwable $e)` con `dddx($e->getMessage())` in una Page o Action Filament | `report($e)` piu' `Notification::make()->danger()` con titolo da chiave di traduzione; mai il messaggio grezzo (puo' contenere SQL o percorsi). |
| `dddx($data)` prima di un salvataggio che esiste | Togliere la riga e leggere il codice dopo: ora girera' davvero. |
| `dddx` dentro un metodo non implementato, con chiamanti (anche solo `wire:submit` nella vista) | `throw new \LogicException('<Classe>::<metodo>() non implementato')`. Mai solo cancellare: resterebbe un pulsante che non fa nulla. |
| Come sopra, senza chiamanti (due ricerche: `rg -P` e `git grep -w`) | Stesso `LogicException` e segnalazione: la decisione di cancellare la classe e' del proprietario. |
| Debug in un ramo gia' coperto da un'altra Action | Rimuovere il ramo. |

## Trappola: il codice dopo il dd

Il `dd` ha nascosto fino ad oggi tutto cio' che lo segue. Cancellare la riga puo' riattivare codice mai eseguito (esempio:
`Webm::convert()` avrebbe restituito il percorso finto `.webmXXX`). Leggerlo come codice nuovo e scriverlo nella story come
"codice riattivato".

## Metodi pubblici Livewire

Un metodo `public` di un componente o widget Livewire e' invocabile dal client anche se la vista non lo usa. Un `dddx` li' e'
raggiungibile da chiunque veda il componente.
