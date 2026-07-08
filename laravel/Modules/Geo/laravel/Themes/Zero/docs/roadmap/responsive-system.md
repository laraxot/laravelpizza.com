# Sistema responsive e grid

## Obiettivo

Definire un sistema responsive coerente con griglie, breakpoint e layout riutilizzabili.

## Passi operativi

1. Mappare i layout correnti e individuare i breakpoint reali.
2. Definire una scala di breakpoint con naming consistente.
3. Introdurre una griglia base con varianti per contenuto e sidebar.
4. Aggiornare i layout principali con classi comuni.
5. Validare su dispositivi rappresentativi.

## Criticita

- Layout storici non allineati ai breakpoint moderni.
- Componenti con stili inline non riutilizzabili.

## Punti di forza

- Base CSS gia presente.
- Template principali centralizzati.

## Punti di debolezza

- Mancanza di griglia unica.
- Stili ridondanti per le stesse sezioni.

## Colli di bottiglia

- Coordinamento tra layout e componenti.
- Regressioni visive non coperte da test.

## Come risolverli

- Creare una griglia unica e documentata.
- Usare una check-list visiva per le pagine chiave.

## Religione

- La leggibilita sui diversi viewport e una priorita.

## Filosofia

- La griglia deve semplificare, non complicare.

## Politica

- Aggiornamenti incrementali, pagina per pagina.

## Output attesi

- Breakpoint ufficiali e condivisi.
- Layout coerenti su mobile, tablet e desktop.

## Collegamenti correlati

- [`Roadmap tema Zero`](../roadmap.md)
- [`component-library.md`](component-library.md)
- [`performance-optimization.md`](performance-optimization.md)
- [`layouts.md`](../layouts.md)
- [`architecture.md`](../architecture.md)
