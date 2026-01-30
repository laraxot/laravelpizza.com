# Metodologia di Sviluppo Riflessivo

## La Filosofia del "Documento Prima, Codifica Dopo"

### 1. Prima Fase: Documentazione Preventiva
- **SEMPRE** aggiornare prima la documentazione esistente
- Documentare lo stato attuale del sistema
- Identificare i file e le strutture coinvolte
- Mappare le dipendenze

### 2. Seconda Fase: Studio Approfondito
- Rileggere TUTTA la documentazione pertinente
- Verificare la coerenza tra documentazione e codice
- Identificare pattern e convenzioni esistenti
- Comprendere il "perché" delle scelte architetturali

### 3. Terza Fase: Pianificazione Documentata
- Scrivere nella documentazione COSA si intende fare
- Dettagliare il COME si intende procedere
- Elencare i file che verranno modificati
- Prevedere possibili effetti collaterali

### 4. Quarta Fase: Riflessione Critica
- Prendersi una pausa mentale
- Rileggere quanto scritto con occhi critici
- Chiedersi: "È davvero la soluzione migliore?"
- Considerare alternative

### 5. Quinta Fase: Dialogo Interno Silenzioso
- Discutere mentalmente pro e contro
- Verificare la coerenza con l'architettura esistente
- Controllare l'allineamento con le best practices
- Assicurarsi di non introdurre debito tecnico

### 6. Sesta Fase: Analisi Filosofica Profonda

#### Politica
- La soluzione rispetta le politiche del progetto?
- È coerente con le decisioni architetturali precedenti?
- Mantiene la separazione dei concern?

#### Filosofia
- Segue il principio DRY (Don't Repeat Yourself)?
- Rispetta SOLID principles?
- È KISS (Keep It Simple, Stupid)?

#### Logica
- Il flusso è logico e intuitivo?
- Le dipendenze sono sensate?
- La struttura è prevedibile?

#### "Religione" del Codice
- Rispetta le convenzioni sacre del progetto?
- Mantiene la purezza dei pattern adottati?
- Onora gli standard di qualità stabiliti?

### 7. Settima Fase: Aggiornamento Documentazione Finale
- Documentare la decisione finale
- Aggiornare TUTTE le cartelle docs coinvolte
- Creare/aggiornare diagrammi se necessario
- Preparare note per il changelog

### 8. Ottava Fase: Implementazione
- SOLO ORA implementare la correzione
- Seguire esattamente quanto documentato
- Testare ogni passaggio
- Verificare che tutto corrisponda alla documentazione

## Esempio Pratico

```
1. Ho un errore nel widget Livewire
2. Documento l'errore in /docs/ERRORI/widget-multiple-roots.md
3. Studio la documentazione Livewire e del progetto
4. Scrivo in /docs/SOLUZIONI/widget-single-root-solution.md
5. Rifletto: "È la soluzione minimale? Rompe qualcosa?"
6. Dialogo interno: "Sì, è corretto. No, mantiene compatibilità"
7. Analizzo: Politica (Livewire rules), Filosofia (Single Responsibility), 
   Logica (un componente = un root), Religione (standard Livewire)
8. Aggiorno /docs/WIDGETS/best-practices.md
9. Implemento la correzione nel file .blade.php
```

## Benefici di Questa Metodologia

1. **Prevenzione Errori**: Pensare prima di agire
2. **Documentazione Sempre Aggiornata**: La docs guida il codice
3. **Decisioni Ponderate**: Niente modifiche impulsive
4. **Tracciabilità**: Ogni decisione è documentata
5. **Qualità**: Il codice riflette un pensiero maturo
6. **Manutenibilità**: Chi viene dopo capisce il "perché"

## Quando Applicare Questa Metodologia

- **SEMPRE** per modifiche strutturali
- **SEMPRE** per nuove feature
- **SEMPRE** per refactoring
- **SEMPRE** quando si tocca codice critico
- Anche per bug fix non banali

## Checklist Pre-Implementazione

- [ ] Ho documentato lo stato attuale?
- [ ] Ho studiato tutta la documentazione pertinente?
- [ ] Ho scritto cosa intendo fare?
- [ ] Ho riflettuto sulle alternative?
- [ ] Ho fatto il dialogo interno?
- [ ] Ho analizzato politica/filosofia/logica/religione?
- [ ] Ho aggiornato TUTTA la documentazione?
- [ ] Sono SICURO che è la soluzione giusta?

Solo quando TUTTE le caselle sono spuntate, procedo con l'implementazione.

---

*"Il codice scritto in fretta viene debuggato con calma. Il codice pensato con calma funziona in fretta."*
