---
status: accepted
module: Lang
---

# Lang possiede i dati di localizzazione

## Contesto

Le lingue supportate attraversano routing, contenuti CMS, notifiche e interfacce.

## Decisione

Lang governa selezione e dati di traduzione; i moduli owner forniscono le chiavi e il tema non duplica traduzioni di dominio.

La forma delle chiavi segue il protocollo architetturale di Xot in
[`translation-key-protocol`](../../Xot/docs/adr/translation-key-protocol.md):
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
