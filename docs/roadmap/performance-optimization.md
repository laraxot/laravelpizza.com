# Performance e ottimizzazioni

## Obiettivo

Ridurre i tempi di bootstrap tenant e ottimizzare le query critiche.

## Passi operativi

1. Identificare i colli di bottiglia di bootstrap.
2. Ottimizzare le query principali con eager loading.
3. Definire strategie di caching per tenant.
4. Misurare i tempi di risposta prima/dopo.
5. Documentare linee guida di performance.

## Criticita

- Query ripetute in fase di bootstrap.
- Cache condivise senza separazione tenant.

## Punti di forza

- Report di performance gia presenti.
- Logiche principali tracciate.

## Punti di debolezza

- Mancanza di metriche costanti.
- Ottimizzazioni non uniformi tra servizi.

## Colli di bottiglia

- Setup database per tenant multipli.
- Coordinamento tra moduli dipendenti.

## Come risolverli

- Definire profili di query standard.
- Introdurre metriche leggere e periodiche.

## Religione

- Performance misurabile prima di nuove ottimizzazioni.

## Filosofia

- Ottimizzare dove serve, non ovunque.

## Politica

- Ogni ottimizzazione deve essere documentata.

## Output attesi

- Riduzione dei tempi di bootstrap tenant.
- Query piu prevedibili e documentate.

## Collegamenti correlati

- [`Roadmap modulo Tenant`](../roadmap.md)
- [`tenant-isolation.md`](tenant-isolation.md)
- [`test-coverage.md`](test-coverage.md)
- [`optimization-analysis.md`](../optimization-analysis.md)
- [`performance`](../performance)
