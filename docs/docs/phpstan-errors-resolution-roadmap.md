# Roadmap risoluzione errori PHPStan (modulo base)

## Scopo
Definire un flusso ripetibile per ridurre gli errori PHPStan fino a **0** nel modulo base, con priorita' sulle dipendenze che impattano gli altri moduli.

## Principi
- Individuare prima gli errori che bloccano l'esecuzione o generano regressioni.
- Correggere per classi di errore (tipi, property, method, generics).
- Evitare soluzioni ad hoc: privilegiare pattern riutilizzabili.

## Flusso operativo
1. **Raccolta**: eseguire l'analisi PHPStan e raggruppare gli errori per categoria.
2. **Classificazione**: separare errori di tipo, accesso a property, e metodi mancanti.
3. **Correzione**: risolvere un gruppo alla volta, con fix minimi e tipizzati.
4. **Verifica**: rilanciare l'analisi e registrare la riduzione degli errori.
5. **Documentazione**: aggiornare le note di workaround e i pattern consigliati.

## Checklist di chiusura
- [ ] 0 errori PHPStan nel modulo base
- [ ] Nessun uso di pattern deprecati
- [ ] Tipi espliciti su metodi e ritorni
- [ ] Note di correzione allineate con i pattern del modulo

## Collegamenti correlati
- [indice documentazione](./00-index.md)
- [roadmap del modulo](./roadmap.md)
- [guida qualita' phpstan](./phpstan-code-quality-guide.md)
- [sessione phpstan](./phpstan-session-january-2026-summary.md)
- [best practices](./best-practices-1.md)
