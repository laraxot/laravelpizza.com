---
<<<<<<< .merge_file_yHiCdn
<<<<<<< HEAD
title: "Lang possiede i dati di localizzazione"
type: decision
=======
>>>>>>> laraxot/dev
=======
title: "Lang possiede i dati di localizzazione"
type: decision
>>>>>>> .merge_file_47ADyi
status: accepted
module: Lang
---

# Lang possiede i dati di localizzazione

## Contesto

Le lingue supportate attraversano routing, contenuti CMS, notifiche e interfacce.

## Decisione

Lang governa selezione e dati di traduzione; i moduli owner forniscono le chiavi e il tema non duplica traduzioni di dominio.

La forma delle chiavi segue il protocollo architetturale di Xot in
<<<<<<< HEAD
<<<<<<< .merge_file_yHiCdn
<<<<<<< HEAD
=======
>>>>>>> .merge_file_47ADyi
[`translation-key-protocol`](../../Xot/docs/adr/translation-key-protocol.md):
=======
[`translation-key-protocol`](../../../Xot/docs/adr/translation-key-protocol.md):
>>>>>>> laraxot/dev
<<<<<<< .merge_file_yHiCdn
=======
[`translation-key-protocol`](../../Xot/docs/adr/translation-key-protocol.md):
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_47ADyi
`<namespace>::<file>.<collection>.<key>.<type>`. Perciò una forma come
`trade::widgets.signal.none_value` è incompleta; il tipo finale va scelto dopo
aver letto il catalogo owner, ad esempio
`trade::widgets.signal.none_value.label` quando la foglia è un'etichetta.

## Driver della decisione

- Mantenere fallback e routing coerenti.

## Alternative scartate

- Hardcodare le stringhe nelle view.
- Gestire una configurazione lingua indipendente per ogni tema.

## Conseguenze

Le lingue restano coerenti tra superfici; una nuova chiave deve avere una sorgente owner e fallback verificabile.

## Conferma

Verificare risoluzione locale, fallback e cataloghi del modulo Lang.
<<<<<<< .merge_file_yHiCdn
<<<<<<< HEAD
=======
>>>>>>> .merge_file_47ADyi

## Verifica

- `Modules/Lang/tests/Unit/Providers/LangServiceProviderTest.php`: carica i cataloghi dei moduli con il namespace
  corretto, supporta it/en/de e ricade sulla lingua di default quando manca la traduzione.
- `Modules/Lang/tests/Unit/Datas/LangConfigDataTest.php`: lingua di default e lingue supportate lette dalla
  configurazione del modulo.
- Nessun test vieta traduzioni duplicate nel tema: la parte «il tema non duplica traduzioni di dominio» è solo
  revisione (da coprire con un test source-level).
<<<<<<< .merge_file_yHiCdn
=======
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_47ADyi
