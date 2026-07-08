# Integrazione HTML2PDF e output stampa

## Obiettivo

Rendere stabile la generazione PDF dal tema con layout e stili coerenti.

## Passi operativi

1. Consolidare i template PDF comuni.
2. Standardizzare gli stili inline richiesti.
3. Verificare le regole per tabelle e immagini.
4. Definire una checklist per regression test.
5. Documentare limiti e workaround noti.

## Criticita

- Parsing HTML rigido nei template complessi.
- Immagini non compatibili senza inline base64.

## Punti di forza

- Documentazione html2pdf gia presente.
- Pattern noti per risolvere i casi comuni.

## Punti di debolezza

- Stili dispersivi in diversi template.
- Mancanza di test automatici per PDF.

## Colli di bottiglia

- Debug dei rendering in produzione.
- Allineamento tra layout web e layout PDF.

## Come risolverli

- Centralizzare gli snippet CSS per PDF.
- Aggiungere test di rendering su template chiave.

## Religione

- PDF stabili prima di layout avanzati.

## Filosofia

- Ridurre complessita HTML per migliorare la compatibilita.

## Politica

- Ogni nuovo template PDF va documentato.

## Output attesi

- Template PDF consolidati e coerenti.
- Riduzione degli errori di parsing.

## Collegamenti correlati

- [`Roadmap tema One`](../roadmap.md)
- [`charts-integration.md`](charts-integration.md)
- [`code-quality.md`](code-quality.md)
- [`html2pdf-integration.md`](../html2pdf-integration.md)
- [`common-errors.md`](../common-errors.md)
