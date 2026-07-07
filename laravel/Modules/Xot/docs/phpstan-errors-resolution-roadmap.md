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
# Xot Module - PHPStan Level 10 Errors Resolution Roadmap

**Data**: 2026-01-14  
**Modulo**: Xot (Base Module)  
**Livello PHPStan**: 10  
**Status**: 🧘 **QUASI COMPLETATO - BASE FONDAMENTALE**

---

## 📊 Stato Attuale

**PHPStan Level**: 10
**Totale Errori**: 2 errori in 2 file
**Stato**: ✅ **OTTIMO** - Base quasi stabile

**Nota**: Xot è il modulo base che influenza tutti gli altri moduli. Con solo 2 errori, è un'ottima base di partenza!

## 🎯 Obiettivo

Ridurre gli errori PHPStan a **0**.

## 🔍 Errori Identificati

1. **`app/Console/Commands/OptimizeFilamentMemoryCommand.php`**: Offset 1 might not exist on array<string>|null.
2. **`app/Services/ArtisanService.php`**: Offset 1 might not exist on array|null.

## 🗺️ Roadmap di Risoluzione

### Fase 1: Fix Errori Offset (Priorità Immediata)

**Obiettivo**: Risolvere i 2 errori di offset array.

**Task**:
1. Fix `OptimizeFilamentMemoryCommand.php`: Verificare esistenza indice prima dell'accesso.
2. Fix `ArtisanService.php`: Verificare esistenza indice prima dell'accesso.

### Fase 2: Verifica Finale

**Obiettivo**: Confermare 0 errori.