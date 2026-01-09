# Sistema di Prompt per la Documentazione

## Panoramica

Questo documento descrive l'integrazione tra il sistema di documentazione di Xot e il sistema di prompt fornito dal modulo bashscripts.

## Collegamenti

- [Documentazione Completa del Sistema di Prompt](../../../../bashscripts/docs/PROMPTS_DOCUMENTATION_SYSTEM.md)
- [Linee Guida Generali per la Documentazione](./DOCUMENTATION-GUIDELINES.md)

## Cos'è il Sistema di Prompt

Il modulo bashscripts include un sistema di prompt che fornisce istruzioni standardizzate per l'organizzazione e la manutenzione della documentazione attraverso tutti i moduli del progetto.

Il file principale è `/var/www/html/<nome progetto>/bashscripts/prompts/docs.txt`, che contiene linee guida dettagliate su:

1. Struttura gerarchica della documentazione
2. Sistema di collegamenti bidirezionali
3. Divisione della documentazione per competenza dei moduli
4. Best practices tecniche specifiche

## Integrazione con il Sistema di Documentazione di Xot

Il sistema di documentazione di Xot e il sistema di prompt di bashscripts si completano a vicenda:

1. **Xot** fornisce la struttura base e le linee guida per la documentazione
2. **bashscripts/prompts** fornisce istruzioni operative dettagliate

### Come Utilizzare Entrambi i Sistemi

1. Consultare le [Linee Guida per la Documentazione](./DOCUMENTATION-GUIDELINES.md) di Xot per comprendere la struttura generale
2. Utilizzare il [Sistema di Prompt](../../../../bashscripts/docs/PROMPTS_DOCUMENTATION_SYSTEM.md) per istruzioni dettagliate

## Miglioramenti Recenti

Il file di prompt `docs.txt` è stato recentemente migliorato per:

1. Rimuovere riferimenti a progetti specifici, rendendolo riutilizzabile
2. Chiarire i nomi dei metodi per riflettere accuratamente la struttura del codice
3. Fornire linee guida più dettagliate sulle convenzioni di naming e organizzazione

## Manutenzione

Qualsiasi aggiornamento al sistema di prompt deve essere:

1. Documentato in `../../../../bashscripts/docs/PROMPTS_DOCUMENTATION_SYSTEM.md`
2. Riflesso in questo documento
3. Coerente con le linee guida generali di documentazione di Xot

## Collegamenti Correlati

- [Sistema di Collegamenti della Documentazione](../../../../docs/collegamenti-documentazione.md)
- [Linee Guida per la Documentazione in Xot](./DOCUMENTATION-GUIDELINES.md)
- [Percorsi Relativi nella Documentazione](../../../../bashscripts/docs/PERCORSI_RELATIVI_DOCUMENTAZIONE.md)
- [Documentazione del Sistema di Prompt](../../../../bashscripts/docs/PROMPTS_DOCUMENTATION_SYSTEM.md)
