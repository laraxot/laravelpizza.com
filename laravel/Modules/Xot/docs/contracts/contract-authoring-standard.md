---
title: "Standard di authoring dei contratti"
type: standard
owner: Xot
status: accepted
updated: 2026-11-23
qmd: "contract authoring standard contratti"
---

# Standard di authoring dei contratti

Questo standard adatta a FixCity il modello `Contract -> owner -> Pest` del
workshop Laravel Day. `docs/contracts/` descrive ciò che il codice promette;
`docs/adr/` spiega perché è stata scelta quella forma. Non si documentano
comportamenti ipotetici come se fossero già implementati.

Fonte metodologica: [laravelday-harness-workshop](https://github.com/robertogallea/laravelday-harness-workshop),
in particolare l'indice dei contract e il collegamento tra invarianti e gruppi
Pest. Il progetto adotta la filosofia, non copia l'harness né il suo dominio
ordini/rimborsi.

## Contratti di comportamento delle Action

Un'Action che scrive dati, chiama servizi esterni o produce effetti collaterali
ha un file `kebab-case` con:

```yaml
type: `contract`
action: `Modules\\<Module>\\Actions\\<Action>`
```

e, nell'ordine, `Input`, `Output`, `Invarianti`, `Effetti collaterali`,
`Errori`, `Non fa`. Il docblock dell'Action contiene il marker machine-readable:

```text
@see docs/contracts/<file>.md
@contract docs/contracts/<file>.md
```

`@see` è il riferimento PHPDoc leggibile dagli IDE; `@contract` non è un tag
PHPDoc standard né un attributo eseguibile: è il marker per harness, review e
agenti. Il percorso è relativo alla cartella
owner (`Modules/<M>` o `Themes/<T>`), così il contratto resta portabile nel
repository del modulo. Il marker deve puntare al comportamento realmente
implementato; non sostituisce i test e non autorizza requisiti inventati.

Ogni invariante ha un identificativo stabile e un test Pest associabile. Gli
effetti collaterali descrivono anche l'ordine: transazione, commit, eventi,
notifiche, queue, storage e servizi esterni.

## Contratti non-Action

Middleware, componenti, interfacce e shell di tema usano un `type` distinto
(`middleware-contract`, `interface-contract`, `presentation-contract`). Devono
indicare `contract: <FQCN>` e collegarsi alla classe con `@see`, ma non devono
essere forzati nel formato delle sei sezioni delle Action.

## Indici e verifica

Il `README.md` di ogni modulo o tema è l'indice owner-specifico e deve elencare
i file presenti, senza inventare contratti per codice non esistente. La verifica
minima è:

```bash
cd laravel
vendor/bin/pest Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php
vendor/bin/pest Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php
```

Un contratto legacy descrive il comportamento corrente e dichiara i difetti;
non è un modello per il codice nuovo. Le responsabilità di un altro modulo
restano fuori dal contratto dell'owner corrente.
