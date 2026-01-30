# Workflow Multi-step per Prenotazioni

> [Torna alla Roadmap Principale](../roadmap.md#q2-2024-aprile-giugno)

## Stato Implementazione

Il workflow multi-step per la gestione delle prenotazioni è attualmente implementato al 40%. Questo sistema rappresenta una componente fondamentale per l'operatività della piattaforma il progetto, consentendo la gestione completa del percorso di prenotazione degli appuntamenti odontoiatrici.

## Architettura del Sistema

Il workflow si basa su un'architettura a stati che traccia il progresso della prenotazione attraverso diversi passaggi sequenziali:

```
Patient Info → Eligibility Check → Dentist Selection → Date Selection → Treatment Definition → Confirmation
```

### Componenti Implementati (40%)

- ✅ Modello `AppointmentWorkflow` con stati e transizioni
- ✅ Form di inserimento informazioni paziente
- ✅ Verifica idoneità ISEE e stato di gravidanza
- ✅ Action `CheckPatientEligibilityAction` per la verifica requisiti
- ✅ Interfaccia base di gestione workflow in Filament

### Componenti da Implementare (60%)

- 🚧 Selezione dentista con disponibilità in tempo reale (30%)
- 🚧 Calendario prenotazioni con blocchi intelligenti (20%)
- 🚧 Form di definizione trattamento con preventivo automatico (10%)
- 🚧 Integrazione completa notifiche ad ogni passaggio (25%)
- 🚧 Finalizzazione workflow con generazione appuntamento (40%)
- 📅 Dashboard di gestione workflow per operatori

## Dettagli Tecnici

Il workflow è implementato utilizzando:

1. **Filament per l'interfaccia**
   - Wizard multi-step con validazione progressiva
   - Form dinamici basati sullo stato corrente
   - Componenti di visualizzazione progresso

2. **Pattern State Machine**
   - Transizioni valide definite e validate
   - Persistenza dello stato tra le sessioni
   - Validazione dei dati ad ogni passaggio

3. **Spatie Queueable Actions**
   - Operazioni asincrone per verifiche complesse
   - Retry automatico in caso di fallimento
   - Logging dettagliato delle operazioni

## Integrazioni

Il workflow si integra con:

- **Modulo Patient** per la gestione dei dati anagrafici
- **Modulo Dental** per le specifiche odontoiatriche
- **Modulo Notify** per l'invio di notifiche multi-canale
- **Modulo Reporting** per statistiche e monitoraggio

## Flusso Completo (Target)

1. **Inserimento paziente**
   - Dati anagrafici
   - Condizioni particolari
   - Consensi privacy

2. **Verifica idoneità**
   - Controllo valore ISEE (< 20.000€)
   - Verifica stato di gravidanza
   - Validazione documenti

3. **Selezione dentista**
   - Filtro per specializzazione
   - Visualizzazione profili e recensioni
   - Preferenze del paziente

4. **Selezione data/ora**
   - Calendario disponibilità in tempo reale
   - Slot temporali preferenziali
   - Gestione conflitti

5. **Definizione trattamento**
   - Selezione prestazioni
   - Preventivo automatico
   - Note particolari

6. **Conferma appuntamento**
   - Riepilogo completo
   - Conferma finale
   - Invio notifiche

## Priorità di Completamento

1. **Alta (Q2 2024)**
   - Completamento selezione dentista
   - Finalizzazione calendario prenotazioni
   - Integrazione notifiche base

2. **Media (Q3 2024)**
   - Definizione trattamento avanzata
   - Dashboard operatori
   - Analytics di conversione

3. **Bassa (Q4 2024)**
   - Ottimizzazioni UX avanzate
   - Integrazione con sistemi esterni
   - Funzionalità di follow-up

## Responsabili e Timeline

- **Backend**: Team Dental (Completamento: Giugno 2024)
- **Frontend**: Team UI (Completamento: Luglio 2024)
- **Testing**: QA Team (Inizio: Maggio 2024)

## Metriche di Successo

- Tasso di completamento workflow > 85%
- Tempo medio di completamento < 5 minuti
- Soddisfazione utente > 4.5/5
