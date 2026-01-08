# Collegamento al Modulo Cms

Questo documento descrive le relazioni e i collegamenti tra il modulo Lang e il modulo Cms per quanto riguarda le traduzioni e l'internazionalizzazione.

## Traduzioni nei Componenti Filament

Il modulo Lang fornisce il sistema di traduzione utilizzato dal modulo Cms nei suoi componenti Filament. È fondamentale seguire le [regole per le traduzioni in Filament](./filament-translations.md) quando si lavora con i componenti nel modulo Cms.

## Convenzioni di Namespace e Struttura

Il modulo Cms segue specifiche convenzioni di namespace documentate in [Convenzioni Namespace Filament](../../Cms/docs/convenzioni-namespace-filament.md) che si integrano con il sistema di traduzioni di questo modulo.

---

### Nota Importante
Quando aggiungi nuovi componenti Filament nel modulo Cms, ricorda di:
1. NON utilizzare mai `->label()` direttamente
2. Aggiungere le traduzioni appropriate nei file di lingua
3. Mantenere aggiornata la documentazione in entrambi i moduli

## Collegamenti tra versioni di cms-link.md


