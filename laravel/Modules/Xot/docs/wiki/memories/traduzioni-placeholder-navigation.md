---
title: "I placeholder nelle traduzioni nascono dal codice, non da una svista"
type: memory
module: Xot
created: 2026-09-29
updated: 2026-09-29
tags: [lang, traduzione, transfunc, difetto, code-gen]
qmd: "traduzioni placeholder navigation persistGeneratedTransFuncLabel transfunc segnaposto"
issues: []
discussions: []
related:
  - "./tabella-appartiene-alla-resource-non-alla-pagina.md"
---

# I placeholder nelle traduzioni nascono dal codice, non da una svista

> **SUMMARY** — Centinaia di stringhe come `permission.navigation` nelle guide linguistiche
> non sono errori di battitura: sono **output del codice**. `TransFuncTrait`, quando una
> chiave non esiste, **scrive il segnaposto nel file di lingua**. Da quel momento il sistema
> lo considera una traduzione valida e non lo corregge più: la UI mostra letteralmente
> `permission.navigation` **per sempre**, in silenzio.

## Il percorso del difetto (verificato nel codice)

`Modules/Xot/app/Filament/Traits/TransFuncTrait.php`:

1. `transFunc()` → `resolveTransFuncValue($key)` → `trans($key)`.
2. Chiave mancante ⇒ `trans()` restituisce **la chiave stessa** (comportamento di Laravel).
3. `formatTransFuncResult()` (~riga 100):
   `if ($trans === $key) { return static::persistGeneratedTransFuncLabel($key); }`
4. `persistGeneratedTransFuncLabel()` (righe 118-127):
   `Str::of($key)->between('::', '.')->replace('_', ' ')` — da
   `user::permission.navigation.label` produce `"permission.navigation"` — e chiama
   `app(SaveTransAction::class)->execute($key, $newTrans)`.
5. `Modules/Lang/app/Actions/SaveTransAction.php` **scrive nel file** se
   `config('lang.save_missing_translations') === true` (default **acceso**, spento sotto test:
   nel codice c'è il commento che l'app dei test non carica la config del modulo, quindi un
   default preso solo da lì sarebbe rimasto acceso dove serve spento).

**Perché è permanente**: alla visita successiva `$trans !== $key` (la chiave ora esiste nel
file), quindi il ramo di `persistGeneratedTransFuncLabel()` non viene più preso e il
segnaposto viene restituito come traduzione valida.

## Le tre famiglie di placeholder da riconoscere

| # | Regola di riconoscimento | Esempio | Rilevabile da scanner? |
|---|---|---|---|
| 1 | valore `===` **nome del file** (+ `_`→spazio) | `Xot/lang/it/env.php` → `navigation.label` = `env` | sì |
| 2 | valore `===` **ultimo segmento della chiave** | `Rating/lang/it/rating.php` → `'is_disabled' => ['label' => 'is_disabled']` | **no** |
| 3 | placeholder **figlio** (chiave figlia, valore non correlato) | `Tenant/lang/it/domain.php` → `fields.rating.label` = `rating`; `Sigma/lang/it/web_service.php` → `actions.logout.label` = `logout` | **no** |

Nel 2026-09-29 sono state corrette la famiglia 1 (73 `.navigation` + 315 generici, in tutti e
17 i moduli). Le famiglie 2 e 3 restano: **sono più grandi e lo scanner `/tmp/kilo/placeholder-scan.php`
non le vede** (vedi story 5.253).

## Campi da correggere vs campi da NON toccare

**Da correggere** (sono testo per l'utente): `label`, `title`, `heading`, `text`,
`placeholder`, `helper_text`, `description`, `tooltip`, `navigation.*`.

**Da NON toccare** (identificatori tecnici): `icon`, `filename_prefix`, `slug`, `key`,
`state`, `color`, `url`, `route`, `class`, `method`, `view`, `component`, `provider`, `table`,
`column`, `path`, `disk`, `guard`, `driver`, `connection`, `queue`, `middleware`, `redirect`,
`prefix`, `suffix`, `separator`, `format`, `type`, `size`, `width`, `height`, `per_page`,
`timeout`, `visibility`, `model`, `relation`, `target`, `mode`, `strategy`, `event`,
`channels`, `pattern`, `template`, `variable`, `var`.

Il campo scansiona in modo case-insensitive, quindi segnala come placeholder anche un valore
**già tradotto** che coincide col nome del file solo per maiuscole/minuscole
(`'name' => 'Dashboard'` in `dashboard.php`). **Verifica sempre con `grep` prima di
sostituire**: `grep -rF "=> 'valore'" --include='*.php' <modulo>/lang`.

## Il formato canonico è la stringa semplice, non il "formato ricco"

`formatTransFuncResult()` (~riga 86-100): se `$trans` è un array prende `current($trans)`.
Il formato ricco (`key`/`text`/`description`/`context`/`placeholder`) esiste in **8 file su 18
moduli** contro 10851 righe con un campo `description`, e **nessun consumatore in `Xot/app` o
`Lang/app`**: è una minoranza sperimentale. Nel formato richo il primo elemento è
`'key' => 'user::auth.navigation.name'`, quindi la label mostrata sarebbe **la chiave di
nuovo**. ⇒ Per `.navigation.*` e per i campi utente: **stringa semplice**.

Consumatore reale verificato: `XotBaseRelationManager.php:41`
`return __(static::class.'.navigation.label');` — una **stringa**.

## Due errori da non ripetere

1. **Apostrofo in singoli apici.** In un file di traduzione, una traduzione con apostrofo
   dentro `'...'` spezza la stringa: `php -l` → `syntax error, unexpected identifier`. Usa
   `"..."`.
2. **`queries(true: ..., false: ...)`** su `TernaryFilter`: `true`/`false` sono keyword
   riservate, PHP le tratta come **posizionali** e i valori finiscono scambiati. Chiamale
   posizionalmente, nell'ordine `(per true, per false)`.

## Il difetto di radice → story 5.252

`persistGeneratedTransFuncLabel()` trasforma un errore di battitura in un **bug permanente e
silenzioso**. Le opzioni (da discutere, non applicate): non scrivere affatto su chiave mancante,
oppure scrivere ma segnalare il fallback con un log, oppure marcare il valore come segnaposto
in modo che alla lettura successiva venga risolto. Finché non si decide, **ogni refactor delle
traduzioni genera nuova spazzatura** — quindi ogni batch di correzioni va seguito da uno
scan, non dato per finito.
