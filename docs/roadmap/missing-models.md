# Modelli mancanti e completamento schema

## Obiettivo

Completare i modelli mancanti e garantire coerenza tra schema, factory e seeder.

## Passi operativi

1. Inventariare i modelli attesi e mancanti.
2. Allineare migrazioni e naming delle tabelle.
3. Creare factory e seeder minimi.
4. Aggiornare la documentazione dei modelli.
5. Aggiungere test di base per ogni modello nuovo.

## Criticita

- Tabelle con naming non uniforme.
- Modelli legacy senza factory.

## Punti di forza

- Documentazione delle dipendenze gia presente.
- Pattern di modellazione in altri moduli.

## Punti di debolezza

- Poche verifiche automatiche su schema.
- Test limitati ai modelli principali.

## Colli di bottiglia

- Allineamento tra migrazioni e casting.
- Verifica delle relazioni cross-modulo.

## Come risolverli

- Introdurre checklist per ogni modello.
- Usare esempi esistenti come riferimento.

## Religione

- Nessun modello senza factory e seeder.

## Filosofia

- Schema coerente per evitare debito tecnico.

## Politica

- Ogni modello nuovo richiede test dedicato.

## Output attesi

- Modelli completi e coerenti con lo schema.
- Factory e seeder disponibili.

## Collegamenti correlati

- [`Roadmap modulo Tenant`](../roadmap.md)
- [`test-coverage.md`](test-coverage.md)
- [`documentation-consolidation.md`](documentation-consolidation.md)
- [`data-models.md`](../data-models.md)
- [`models-factory-seeder-analysis.md`](../models-factory-seeder-analysis.md)
