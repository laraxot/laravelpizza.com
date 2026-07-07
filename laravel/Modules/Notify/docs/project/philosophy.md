# FixCity - Filosofia, Logica, Visione e Zen del Progetto

## La Visione

**FixCity** non è solo una piattaforma per la segnalazione di problemi urbani. È un sistema che connette i cittadini con la loro città, creando un circolo virtuoso di miglioramento continuo.

### Principi Fondamentali

1. **Trasparenza**: Ogni segnalazione è tracciabile
2. **Responsabilità**: Ogni problema ha un responsabile
3. **Progresso**: Ogni soluzione migliora la città
4. **Comunità**: I cittadini partecipano attivamente

## La Logica

### Architettura Modulare (Laraxot)

La struttura del progetto segue una logica precisa:
- **Modularità**: Ogni funzionalità è un modulo indipendente
- **Estensibilità**: Nuove funzionalità senza modificare il core
- **Manutenibilità**: Codice pulito, testato, documentato

### No Services, Yes Actions

```
❌ Service Classes (accoppiamento forte, difficile da testare)
✅ Spatie Queueable Actions (disaccoppiamento, testabilità, code)
```

### No Controllers, Yes Volt + Folio

```
❌ Controllers tradizionali
✅ Volt (Livewire) + Folio (file-based routing)
```

## La Religione (Regole Inderogabili)

### Le 10 Leggi di FixCity

1. **Legge DRY**: Non ripetere mai il codice
2. **Legge KISS**: Semplicità prima di tutto
3. **Legge SOLID**: Principi solidi sempre
4. **Legge Type Safety**: PHPStan Level 10
5. **Legge Testing**: Coverage minimo 85%
6. **Legge Documentation**: Documenta o muori
7. **Legge Performance**: Mai Log::info() per routine
8. **Legge XotBase**: Mai usare classi base direttamente
9. **Legge Filament**: Usa sempre XotBase*
10. **Legge Commit**: Piccoli commit, push frequenti

## La Politica

### Gestione del Progetto

- **BMAD**: Business Model And Design
- **GSD**: Get Shit Done
- **Ralph Loop**: Esecuzione iterativa autonoma
- **NotebookLM**: Conoscenza cumulativa

### Multi-Agent Collaboration

Più agenti AI lavorano simultaneamente:
- ✅ Parallelismo
- ✅ Diversità di prospettive
- ✅ Cross-verification
- ✅ Specializzazione

## La Filosofia

### Il Cammino dello Sviluppatore

1. **Studio**: Prima leggi, poi ragiona
2. **Pratica**: Implementa, testa, rifattorizza
3. **Documenta**: Scrivi, aggiorna, condividi
4. **Migliora**: Refactoring continuo

### Lo Zen del Codice

```
Codice pulito = Mente pulita
Test che passano = Pace interiore
PHPStan Level 10 = Illuminazione
```

## Il Zen

### Principi Zen

- **Wabi-sabi**: Bellezza nell'imperfezione, miglioramento continuo
- **Kaizen**: Cambiamento piccolo, costante, positivo
- **Mu**: Vuoto fertile, possibilità infinite

### Pratiche Zen Quotidiane

1. **Refactoring**: Ogni giorno, 10 minuti di pulizia
2. **Testing**: Red-Green-Refactor
3. **Documentazione**: Aggiorna sempre
4. **Comunità**: Condividi la conoscenza

## Connessione con gli Strumenti

### OpenViking
Database di contesto per memoria persistente

### BMAD
Analisi e design del business

### GSD
Esecuzione orientata agli obiettivi

### Ralph Loop
Iterazione autonoma fino al completamento

### NotebookLM
Gestione della conoscenza con AI

## Conclusione

FixCity è più di un progetto software. È un esperimento sociale tecnologico che dimostra come la tecnologia possa migliorare la vita dei cittadini. Ogni segnalazione risolta è una piccola vittoria per la comunità.

> *"La città perfetta non esiste, ma il viaggio verso di essa sì."*

---

## Riferimenti

- [PROJECT.md](./PROJECT.md) - Visione e obiettivi
- [AGENTS.md](./AGENTS.md) - Regole per agenti AI
- [docs/](../docs/) - Documentazione completa
