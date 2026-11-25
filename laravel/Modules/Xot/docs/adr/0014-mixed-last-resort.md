---
title: "mixed solo come ultima spiaggia"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
decision-makers: [team back office]
issues: []
module: Xot
qmd: "mixed PHPStan ultima spiaggia narrowing boundary vendor source-first tipizzazione Safe cast action Webmozart Assert ignoreErrors baseline cast nudi livello max"
---

# mixed solo come ultima spiaggia

## Contesto

PHPStan segnala spesso `mixed` a valle di un confine dinamico: input HTTP, dati di
configurazione, attributi Eloquent non dichiarati, risposte di vendor o collezioni
costruite da array. Trattare quel valore come se fosse già concreto nasconde lo
scopo del codice e sposta l'incertezza nei chiamanti. Al contrario, aggiungere
annotazioni o cast senza verificare l'invariante produce una falsa sicurezza.

Il problema da risolvere non è eliminare la parola `mixed` dal report, ma conservare
il contratto funzionale: identificare il confine realmente dinamico, validarlo,
restringere il tipo appena possibile e lasciare ai chiamanti un'API concreta.

Fatti misurati il 2026-11-24. `laravel/phpstan.neon` usa `level: max` con PHPStan 2.3.7,
cioè il livello 10: controlla il `mixed` esplicito e quello implicito. La baseline è
disattivata, `ignoreErrors` è vuoto e `reportUnmatchedIgnoredErrors` è `true`. Nei
sorgenti `Modules/*/app` 37 file dichiarano `mixed` (`: mixed` oppure
`@param|@return|@var mixed`), 15 dei quali in Xot, dove vivono le `Safe*CastAction` e le
basi del framework. Gli strumenti di confine sono di uso quotidiano: `Safe*CastAction` in
95 file, funzioni `Safe\` in 272, `Webmozart\Assert` in 395. `mixed` è quindi
l'eccezione dichiarata, non la lingua del progetto.

## Driver della decisione

- Il dominio deve esprimere i tipi che usa davvero, soprattutto importi, identificativi,
  relazioni Eloquent e strutture dati delle Actions.
- Un errore PHPStan deve portare alla causa nel producer, non a una soppressione nel
  consumer.
- I confini vendor o framework possono restare dinamici, ma devono essere isolati,
  verificati e spiegati.
- La soluzione deve restare compatibile con XotBase, Queueable Actions, Filament 5
  e i test Pest owner-locali.

## Alternative scartate

- **Usare `mixed` ovunque**: nasconde errori di dominio e propaga l'incertezza.
- **Aggiungere cast nudi** (`(string)`, `(int)`, `(array)`) **solo per far sparire il
  messaggio**: `(int) 'abc'` vale `0` e `(string) []` vale `"Array"` con un warning, quindi
  un importo o un voto sbagliato passano in silenzio. Il cast è ammesso solo dopo il
  narrowing.
- **Usare `@phpstan-ignore*`, una baseline o `ignoreErrors`**: vietato senza eccezioni in
  questo progetto («gli errori vanno corretti, non ignorati»: baseline disattivata,
  `ignoreErrors` vuoto). Un limite del vendor si gestisce nel boundary, con narrowing e
  docblock locale, non zittendo l'analizzatore.
- **`@var` inline per sovrascrivere un tipo inferito**, `@var mixed` compreso: mente
  all'analizzatore e sposta l'errore a runtime; `@var mixed` è sempre rumore, perché il
  tipo lo è già.
- **Tipizzare a forza il punto finale**: corregge il sintomo e lascia errato il
  producer o il boundary condiviso.

## Decisione

`mixed` è consentito soltanto come ultima spiaggia, quando il confine è realmente
dinamico o non tipizzabile senza modificare un vendor/framework. Ogni uso deve
seguire questo ordine:

1. cercare il producer e tutti i caller;
2. preferire un contratto concreto: proprietà tipizzate, union, array-shape e generics
   (`Collection<int, X>`, `HasMany<Post, $this>`), Spatie Data in `app/Datas` (mai DTO),
   `instanceof`, `is_*`, `Webmozart\Assert` o una `Safe*CastAction` già presente.
   `Assert::integer($raw)` restringe `mixed` a `int` anche per PHPStan (provato il
   2026-11-24 con un file isolato, PHPStan 2.3.7 e webmozart/assert 2.5.1: il tipo arriva
   dai `@psalm-assert` del sorgente, 48 nel file). L'estensione
   `phpstan/phpstan-webmozart-assert` non è installata: per le varianti dinamiche
   (`all*`, `nullOr*`) si verifica il narrowing caso per caso;
3. validare il valore al confine;
4. restringere il tipo immediatamente dopo la validazione;
5. impedire che `mixed` attraversi l'API pubblica del modulo;
6. documentare nella story BMAD perché il confine non può essere reso concreto,
   quale invariante lo protegge e quale test lo verifica.

Esempio accettabile:

```php
$raw = $payload['amount'] ?? null; // mixed: JSON senza contratto

if (! is_int($raw) && ! is_float($raw)) {
    throw new InvalidArgumentException('Amount must be numeric.');
}

$amount = (float) $raw;
```

Il cast dell'esempio non sostituisce la validazione: viene dopo il narrowing e non
si propaga al chiamante. Per i modelli Eloquent si correggono invece il modello,
il trait, la relazione o il fixture owner; non si usa `property_exists()` né un
`@property` inventato per ingannare l'analizzatore.

### Dove `mixed` è legittimo per costruzione

- L'**ingresso** delle `Safe*CastAction` (`execute(mixed $value): string`,
  `cast(mixed $value)` in `Modules/Xot/app/Actions/Cast/`): sono lo strumento di confine e
  restituiscono sempre un tipo preciso.
- I valori che il framework restituisce già come `mixed` e che nessun contratto descrive:
  `config()`, `request()->input()`, `json_decode()`, `selectOne()`, `pluck()`,
  `Collection::toArray()`. Si restringe al call site (`is_int($id) || is_string($id)`,
  non `(string) $id`) e il valore non esce dal metodo.

### Vietato

- `mixed` nella firma pubblica di Action, Data, Contract, Model o Resource: chi chiama
  non può fidarsi del risultato.
- `mixed` come scorciatoia per far scendere il conteggio PHPStan.

## Conseguenze

- Buono, perché gli errori restano vicini alla loro causa e le API del dominio
  diventano più leggibili.
- Buono, perché i confini dinamici sono riconoscibili e verificabili senza falsare
  PHPStan.
- Cattivo, perché alcuni boundary vendor richiedono phpdoc locale e test mirati.
- Cattivo, perché la correzione può richiedere aggiornare più caller o estrarre un
  contratto, ma questo costo rende esplicita una responsabilità già esistente.
- Cattivo, perché nessun guard automatico conta i `mixed`: la regola oggi è tenuta da
  PHPStan a livello max e dalla review. Un test `arch()` dedicato resta debito dichiarato.

## Conferma

- `cd laravel && ./vendor/bin/phpstan analyse Modules` deve terminare con zero
  `errors` e zero `file_errors`.
- Il test mirato del modulo deve verificare l'invariante del boundary senza usare
  `RefreshDatabase` o dati distruttivi.
- La review controlla che ogni `mixed` o cast nuovo abbia una motivazione nella story
  BMAD e un narrowing o una prova ripetibile. Un `@phpstan-ignore*`, una baseline o una
  voce in `ignoreErrors` nuovi sono sempre un rifiuto.
- Audit ripetibile: `grep -rIlE '(: mixed\b|@(param|return|var) mixed\b)' --include='*.php'
  laravel/Modules/*/app | wc -l` dava 37 il 2026-11-24 (15 in Xot). Un aumento fuori dalle
  `Safe*CastAction` va motivato nella story.
- Story: [xot-adr-mixed-ultima-spiaggia](../bmad/stories/xot-adr-mixed-ultima-spiaggia.story.md).
