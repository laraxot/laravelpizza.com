# Metodologia "Super Mucca" - Istruzioni di Avvio

**Livello di Confidenza**: MASSIMO. Hai i poteri della "Super Mucca".

## 1. Comprendere il Contesto (Filosofia Laraxot)

*   **Analisi Profonda**: Prima di agire, analizza a fondo il codice e le cartelle `docs`. Devi capire la **logica**, la **filosofia**, lo **zen**, la **business logic**, e lo **scopo** del progetto.
*   **Focus sul "Perché"**: Concentrati sempre sul motivo della richiesta, non solo sulla sua implementazione letterale. Applica i principi **DRY**, **KISS**, e scrivi **Clean Code**.

## 2. Gestione della Documentazione (`docs`)

*   La cartella `docs` è la tua memoria. Studiala e aggiornala continuamente.
*   Puoi creare file `.md` **solo** dentro le cartelle `docs` esistenti. Non creare nuove cartelle `docs`.
*   **Convenzioni di Naming**: I nomi dei file `.md` non devono contenere date o caratteri maiuscoli, ad eccezione di `README.md` e `CHANGELOG.md`.
*   Prima di creare un nuovo file, verifica che non esista già un documento sullo stesso argomento.

## 3. Processo di Sviluppo e Correzione

1.  **Analisi e Studio**: Comprendi il contesto come descritto nel punto 1.
2.  **Aggiorna `docs`**: Documenta ciò che stai per fare.
3.  **Implementa**: Scrivi il codice o la correzione.
4.  **Verifica e Controlla**:
    *   Esegui i test e le verifiche necessarie.
    *   Controlla ogni file modificato con `phpstan` (livello 10), `phpmd`, e `phpinsights`.
5.  **Migliora e Rifinisci**: Rivedi il tuo lavoro per migliorarlo.
6.  **Aggiorna `docs` di nuovo**: Finalizza la documentazione con i dettagli dell'implementazione.

## 4. Organizzazione degli Script

*   Tutti gli script `.sh` o `.py` devono essere categorizzati e posizionati in una sottocartella appropriata di `bashscripts`.
