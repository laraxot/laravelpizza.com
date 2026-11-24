---
title: "mixed solo come ultima spiaggia: tipi veri, narrowing al confine, motivazione scritta"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
decision-makers: [team back office]
issues: []
qmd: "0015 mixed ultima spiaggia phpstan level max tipi narrowing confine firma ereditata safe cast action data shape generics union"
---

# `mixed` solo come ultima spiaggia

## Contesto

PHPStan gira a `level: max` su `Modules/` (`laravel/phpstan.neon`), senza baseline e senza `ignoreErrors`: gli errori si correggono, non si nascondono. `mixed` è la via più corta per far tacere un errore (`missingType.*`, `argument.type`, `return.type`), ma sposta il problema invece di risolverlo:

- il tipo sparisce dalla firma e il codice smette di dire che cosa deve fare;
- a `level: max` ogni uso successivo del valore genera nuovi errori (`cast.*`, `method.nonObject`, `offsetAccess.nonOffsetAccessible`) che si "risolvono" con cast nudi o `@var`, cioè con altro `mixed` travestito;
- chi chiama la funzione eredita l'ignoranza. Xot è la base di tutti i moduli: un `mixed` in un metodo di base si moltiplica per ogni modulo che lo estende.

Lo scopo del lavoro PHPStan non è far sparire il messaggio: è far tornare ogni pezzo di codice a fare ciò per cui esiste. Un `mixed` quasi sempre indica che manca la forma del dato (una shape, una classe Data, un'union).

La regola esisteva già, ma in due righe sparse e senza il perché: [code-quality](../code-quality.md) («NEVER use `mixed` types unless absolutely necessary») e [phpstan-zero](../phpstan-zero.md) («`mixed` solo con motivazione esplicita»). Non diceva quando `mixed` è lecito e non aveva una verifica.

Misura del 2026-11-24 su `Modules/*/app` (non è uno stato corrente: si rimisura con il comando in *Conferma*): circa 300 occorrenze di `mixed` nei tipi nativi (Xot 127, Geo 31, User 30, AI 24, UI 18, Cms 15, Lang 13, Notify 11) e 89 nei docblock. Quante siano confini legittimi e quante scorciatoie non è ancora classificato: è il debito da misurare.

## Driver della decisione

- **Il tipo è documentazione eseguibile.** Una firma tipizzata dice cosa entra e cosa esce; `mixed` non dice niente e PHPStan non può più aiutare.
- **Propagazione.** Un `mixed` in uscita da una Action o da un metodo di base infetta tutti i chiamanti.
- **Esistono confini davvero non tipizzabili.** Una firma ereditata o un dato esterno non validato: un divieto assoluto spingerebbe a mascherare `mixed` con cast e `@var`, che è peggio di `mixed` dichiarato.
- **Coerenza con il gate.** Se `phpstan.neon` rifiuta baseline e `ignoreErrors`, `mixed` usato per tacere un errore è la stessa scorciatoia con un altro nome.

## Alternative scartate

- **Divieto assoluto di `mixed`.** Impossibile dove la firma è imposta dal genitore: un parametro di un override non si può restringere (contravarianza), per esempio `mixed $value` nei cast Eloquent o `ArrayAccess::offsetGet(mixed $offset)`. Spingerebbe a nascondere il tipo con `(string) $x` o `@var`.
- **Tollerare `mixed` dove "costa troppo tipizzare".** Ricrea il debito che il baseline rifiutato avrebbe nascosto: il costo si ripresenta a ogni chiamante, non sparisce.
- **Nascondere con cast nudi, `@var` inline o `@phpstan-ignore`.** Stesso effetto di `mixed` senza dichiararlo: il tipo inferito diventa una bugia e il prossimo lettore si fida.
- **Convertire ogni payload dinamico in una classe Data.** Sovra-ingegneria quando il valore resta confinato in un adapter o in un confine esterno: lì basta il narrowing immediato (vedi *Decisione*), la classe Data serve quando il payload attraversa più punti.
- **Un guard automatico subito (Pest `arch()` con allowlist).** Giusto come passo successivo, ma richiede prima di classificare i casi esistenti, altrimenti l'allowlist è un baseline mascherato. Resta come debito dichiarato nelle *Conseguenze*.

## Decisione

`mixed` è l'ultimo gradino, non il primo. Si sale solo se il gradino precedente non esprime il dato:

1. array shape (`array{id: int, name: string}`), `list<T>`, `array<K, V>`;
2. generics (`@template T`, `Collection<int, Model>`);
3. classe Spatie Data (mai DTO), Enum o Value Object, per ciò che una Action riceve o restituisce;
4. union precisa (`int|string|null`) o interfaccia/Contract;
5. `object`, `iterable`, `callable`, `Closure(...)`;
6. `mixed`, solo se il dato è davvero non tipizzabile.

`mixed` è ammesso in due soli casi:

- **Firma ereditata.** Un parametro di un override il cui genitore (PHP o vendor) dichiara `mixed`: la contravarianza non permette di restringerlo. Con `#[Override]` la ragione è ovvia. I *ritorni* ereditati come `mixed`, invece, si restringono sempre (la covarianza lo permette): `jsonSerialize(): array`, non `: mixed`.
- **Confine con dati non validati.** `json_decode`, `unserialize`, `config()`, input di request, payload di evento, job o API, risposta HTTP esterna. Il `mixed` vive in una sola riga e si restringe subito sotto, con gli strumenti del progetto:
  - `Webmozart\Assert\Assert` quando esprime un invariante reale;
  - le `Safe*CastAction` di `Modules\Xot\Actions\Cast\` al posto dei cast nudi (`SafeStringCastAction`, `SafeArrayCastAction`, `SafeIntCastAction`, ...);
  - `Data::from()` per i payload strutturati;
  - le funzioni `Safe\` (`thecodingmachine/safe`) per ciò che ritorna `false` in errore.

Regole che valgono sempre:

- **Non si propaga.** Il tipo che esce da una funzione è già ristretto: mai `mixed` nel ritorno di una Action o di un metodo pubblico di una classe base.
- **Motivazione scritta.** Una riga di commento sul punto quando il confine non è ovvio (`// mixed: payload del webhook, ristretto subito sotto`), oppure la motivazione nella story BMAD del modulo owner quando i casi sono molti.
- **Mai per far tacere un errore.** Né `@phpstan-ignore`, né baseline, né `ignoreErrors`, né cast nudo, né `@var` inline che sovrascrive il tipo inferito.
- **Un `mixed` esistente si sostituisce quando la sorgente diventa conoscibile.** Se la produzione del valore viene tipizzata, il `mixed` a valle non ha più ragione di restare e si toglie nella stessa modifica.
- **Prima lo scopo.** Prima di scrivere `mixed` si legge che cosa il codice doveva fare e chi lo chiama: se manca la forma del dato, si crea la shape o la classe Data.

## Conseguenze

- Buono, perché le firme tornano leggibili e gli errori PHPStan restano segnali veri invece di essere mascherati.
- Buono, perché Xot non infetta i moduli: la base espone tipi ristretti.
- Buono, perché la review ha un criterio («rientra nei due casi?») invece di un gusto.
- Cattivo, perché tipizzare una shape o creare una classe Data costa più che scrivere `mixed`, a volte per un solo punto d'uso.
- Debito che resta: i circa 300 `mixed` esistenti non sono classificati e non c'è un guard automatico. Passo successivo: classificarli per modulo (firma ereditata, confine, scorciatoia), correggere le scorciatoie partendo da Xot (moltiplicatore), poi un test `arch()` con ambito esplicito secondo [architecture-tests-pest-arch](architecture-tests-pest-arch.md).
- Cosa misurare: il conteggio per modulo deve scendere e nessun diff nuovo aggiunge `mixed` fuori dai due casi ammessi.

## Conferma

- Gate: `cd laravel && ./vendor/bin/phpstan analyse Modules` a `level: max`, senza baseline. Non basta da solo, ma un `mixed` usato male torna come `cast.*` o `argument.type`.
- Misura per modulo (da `laravel/`, le virgolette sono obbligatorie in zsh):

  ```bash
  grep -rnE '(: *\??mixed\b|\(mixed \$|, *mixed \$)' Modules/*/app --include='*.php' | awk -F/ '{print $2}' | sort | uniq -c | sort -rn
  ```

- In review: `git diff -U0 | grep -E '^\+.*\bmixed\b'`. Ogni riga aggiunta rientra in uno dei due casi ammessi, altrimenti si respinge con un rimando a questo ADR.
- Onestà: oggi non esiste un test automatico dedicato; la presenza di questo ADR non prova l'implementazione.

## Riferimenti

- [mixed-is-last-resort](mixed-is-last-resort.md): la stessa decisione scritta in parallelo senza numero, ora *superseded* da questo ADR. Da quel testo si è recuperato che il `mixed` esistente va tolto quando la sorgente diventa conoscibile e che un payload dinamico confinato in un adapter non richiede una classe Data. Non si è recuperato il narrowing con `assert()` nativo, vietato dalle regole del progetto (ammesso solo `Webmozart\Assert\Assert`).
- [code-quality](../code-quality.md) e [phpstan-zero](../phpstan-zero.md): le regole sintetiche che rimandano qui.
- [architecture-tests-pest-arch](architecture-tests-pest-arch.md): come si verificano le regole di architettura, con ambito esplicito e debito dichiarato.
- [0012-behavioral-contract-governance](0012-behavioral-contract-governance.md): i contratti comportamentali che fissano i tipi pubblici.
