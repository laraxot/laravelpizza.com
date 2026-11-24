---
title: "Generazione password: lunghezza e casualità crittografica"
type: story
module: Xot
epic: quality
status: review
created: 2026-10-05
related:
  - ./project-quality-audit.story.md
---

# Generazione password: lunghezza e casualità crittografica

## Owned File/Module Scope

- `app/Actions/String/GetPronounceablePasswordAction.php`
- `tests/Unit/Actions/String/GetPronounceablePasswordActionTest.php`
- Questa story. Ownership esclusiva: agente audit-tests, lock acquisiti.

## Acceptance criteria

- [x] La lunghezza rispetta `max(5, $length)`; il minimo conserva il fallback esistente
  di due lettere minuscole, una maiuscola, una cifra e un simbolo.
- [x] Ogni selezione e il mescolamento usano `random_int`, senza generatori prevedibili.
- [x] Sono presenti minuscola, maiuscola, cifra e simbolo consentito.
- [x] Pest puro verde, senza bootstrap applicativo o accessi DB; lint e stile verificati.

## Task e riferimenti

- Verifica consumer: `Modules/User/app/Actions/User/GetNewPasswordAction.php` richiede 12.
- Nessun diff preesistente nei due file PHP; storico `git log -S 'length - 4'` consultato.
- Second brain interrogato tramite router QMD; nessun risultato pertinente.
- Ponytail: funzioni native e Fisher–Yates, nessuna dipendenza aggiunta.
- Host verificato `172.30.162.189`, diverso dal server escluso dai test.

## Evidenze e memoria

Prima: richieste 8/12/16 producono 7/11/15 caratteri. Il seed Mersenne Twister
reinizializzato prima di due generazioni produce la stessa password: `rand`,
`array_rand` e `str_shuffle` non sono adatti a segreti. Il test precedente controllava
solo una lunghezza minima di 8 per una richiesta di 12, lasciando passare il difetto.
Per azioni pure usare Pest senza TestCase applicativo: i gruppi `no-db` da soli non
disattivano `DatabaseTransactions` ereditato.

## Verifica e handoff

- Pest prima del fix: 7 fallimenti, 4 verdi (31 assertion),
  `/tmp/ptvx-password-pest-before.log`.
- Pest dopo il fix: 11 verdi (61 assertion), exit 0,
  `/tmp/ptvx-password-pest-after.log`.
- PHP lint sui due file e Pint mirato: verdi. `git diff --check`: verde.
- PHPStan sui due file con configurazione originale, `--debug --no-progress` e
  `memory_limit=2G`: zero errori, `/tmp/ptvx-password-phpstan.log`.
- Audit indipendente: HasXotTableNoResolveHooksTest e NoSemanticFolioPageDirectoriesTest
  verdi, 4 test e 56 assertion (`/tmp/ptvx-quality-architecture-pest.log`).
- Nessun accesso DB o boot applicativo. Suite completa, PHPMD e PHPInsights non eseguiti:
  verifica limitata ai due file, non certifica il modulo intero.
- Review Ponytail: nessuna dipendenza, nessun helper aggiunto, diff netto -42 righe.
- Handoff al coordinatore per gate combinato, sprint e indicizzazione second brain.
  Lock dei tre file rilasciati a conclusione; nessun commit o push.
