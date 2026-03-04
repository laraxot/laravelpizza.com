# Filosofia dei Getter Semantici in MetatagData

## Premessa
Nel contesto di Xot, la classe `MetatagData` rappresenta la fonte autorevole di tutti i dati di branding e metadati per il frontend di un'applicazione Laravel multi-tenant. La progettazione dei suoi metodi getter segue una filosofia rigorosa e zen, che si ispira ai principi della Domain-Driven Design (DDD), della chiarezza semantica e della coerenza architetturale.

## Perché i metodi come `getBrandName()` sono corretti

### 1. **Semantica e Dominio**
- I metodi getter devono riflettere lo scopo semantico del dato, non il dettaglio implementativo o la posizione di utilizzo.
- `getBrandName()` comunica chiaramente che si sta recuperando il "nome del brand", a prescindere da dove venga visualizzato (header, footer, ecc.).
- Analogamente, `getBrandLogo()` esprime l'intento di ottenere il logo del brand, non un logo specifico per una posizione (come `getLogoHeader()`).

### 2. **Astrazione e Manutenibilità**
- L'astrazione permette di cambiare l'implementazione interna senza dover modificare tutte le chiamate nel codice.
- Se domani il logo "principale" cambiasse posizione o logica, il metodo rimarrebbe semanticamente valido.
- La retrocompatibilità viene mantenuta tramite metodi deprecati che richiamano quelli nuovi.

### 3. **Zen della Chiarezza**
- Il codice deve essere "autoesplicativo" e leggibile anche fuori contesto.
- Un metodo come `getDarkModeBrandLogo()` è immediatamente comprensibile: fornisce il logo del brand per la modalità scura, senza ambiguità.

### 4. **Religione della Consistenza**
- Tutti i metodi relativi al brand devono seguire la stessa convenzione: `getBrandX()` o `getDarkModeBrandX()`.
- Questo elimina la duplicazione semantica (es: `getLogoHeader`, `getLogoFooter`, ecc.) e centralizza la logica di branding.

### 5. **Errori Comuni da Evitare**
- **Sbagliato:** `->brandName($metatag->title)`
- **Corretto:** `->brandName($metatag->getBrandName())`

- **Sbagliato:** `->darkModeBrandLogo($metatag->getLogoHeaderDark())`
- **Corretto:** `->darkModeBrandLogo($metatag->getDarkModeBrandLogo())`

- **Sbagliato:** `->brandLogoHeight($metatag->getLogoHeight())`
- **Corretto:** `->brandLogoHeight($metatag->getBrandLogoHeight())`

- **Corretto:** `->favicon($metatag->getFavicon())`

## Best Practices
- Usare sempre getter semantici per tutte le proprietà di branding.
- Aggiornare il codice legacy per rimuovere riferimenti a metodi implementativi.
- Documentare chiaramente i metodi deprecati e guidare la migrazione verso i nuovi.

## Collegamenti
- [naming-conventions.md](../naming-conventions.md)
- [datas/metatagdata.md](metatagdata.md)
- [logo_resolution.md](../logo_resolution.md)

---
**Ultima modifica:** 2025-05-06
