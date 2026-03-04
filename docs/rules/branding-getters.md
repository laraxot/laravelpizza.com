# Regole per Getter di Branding in Xot

## Regola Fondamentale
I metodi getter devono riflettere il "cosa" rappresenta il dato, non il "dove" viene utilizzato.

### Esempi
- ✅ `getBrandName()`
- ✅ `getBrandLogo()`
- ✅ `getDarkModeBrandLogo()`
- ✅ `getBrandLogoHeight()`
- ✅ `getFavicon()`

### Da evitare
- ❌ `getLogoHeader()`
- ❌ `getLogoHeaderDark()`
- ❌ `getLogoHeight()`
- ❌ `title` (proprietà diretta)

## Motivazione
- **Chiarezza semantica:** Il codice è più leggibile e universale.
- **Manutenibilità:** Cambiando il layout o la logica, i metodi rimangono coerenti.
- **Retrocompatibilità:** I metodi deprecati rimandano ai nuovi getter.
- **Zen della coerenza:** Tutto ciò che riguarda il brand segue la stessa convenzione.

## Applicazione
- Aggiornare sempre i riferimenti nei componenti, Blade, Filament, Livewire, ecc.
- Segnalare nei commenti i metodi deprecati.
- Documentare la motivazione nelle pull request e nei file docs.

---
**Ultima modifica:** 2025-05-06
