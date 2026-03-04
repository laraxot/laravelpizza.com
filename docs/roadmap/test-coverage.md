# Test skipped e copertura critica

## Obiettivo

Rimuovere i test skipped e aumentare la copertura sulle logiche core del modulo.

## Passi operativi

1. Inventariare i test skipped e i motivi.
2. Sistemare dipendenze e fixture mancanti.
3. Aggiungere test per logiche di isolamento tenant.
4. Coprire i flussi di configurazione e bootstrap.
5. Verificare copertura con focus su casi limite.

## Criticita

- Test che dipendono da modelli non presenti.
- Mancanza di dataset coerenti.

## Punti di forza

- Regole di testing documentate.
- Struttura test modulare esistente.

## Punti di debolezza

- Copertura disomogenea tra componenti.
- Test di integrazione limitati.

## Colli di bottiglia

- Setup dati multi-tenant complesso.
- Tempi di esecuzione su suite completa.

## Come risolverli

- Usare factory dedicate e dataset minimi.
- Introdurre helper per setup tenant.

## Religione

- Nessun test ignorato senza motivo documentato.

## Filosofia

- Testare la logica osservabile, non l'implementazione.

## Politica

- Ogni bugfix richiede un test di regressione.

## Output attesi

- Test skipped eliminati.
- Copertura migliorata su core module.

## Collegamenti correlati

- [`Roadmap modulo Tenant`](../roadmap.md)
- [`missing-models.md`](missing-models.md)
- [`tenant-isolation.md`](tenant-isolation.md)
- [`testing.md`](../testing.md)
- [`coverage.md`](../coverage.md)
