# Integrazione Completa ISEE

> [Torna alla Roadmap Principale](../roadmap.md#q2-2024-aprile-giugno)

## Stato Attuale

L'integrazione del sistema ISEE all'interno della piattaforma il progetto è attualmente implementata al 60%. Il sistema permette la verifica dell'idoneità delle pazienti al programma sulla base del valore ISEE e dello stato di gravidanza.

## Obiettivi dell'Integrazione

L'integrazione completa ISEE mira a:

1. Automatizzare la verifica dell'idoneità delle pazienti
2. Gestire lo storico delle dichiarazioni ISEE
3. Integrare il sistema con il workflow di prenotazione
4. Mantenere l'auditing completo delle verifiche effettuate
5. Supportare il caricamento e la verifica documentale

## Componenti Implementati (60%)

- ✅ Modello dati per la gestione dei valori ISEE (`PatientIsee`)
- ✅ Form di inserimento e verifica dati ISEE
- ✅ Action `CheckPatientEligibilityAction` per la verifica dell'idoneità
- ✅ Integrazione nel workflow multi-step (passo `eligibility_check`)
- ✅ Validazione automatica contro la soglia (20.000€)
- ✅ Persistenza dei dati di verifica con timestamp

## Componenti da Implementare (40%)

- 🚧 Sistema di upload documenti ISEE con verifica (20%)
- 🚧 Integrazione con servizi esterni di verifica (0%)
- 🚧 Generazione automatica reportistica per audit (30%)
- 🚧 Notifiche configurabili per scadenza ISEE (40%)
- 🚧 Dashboard amministrativa dedicata (15%)

## Architettura Tecnica

```
┌─────────────────┐     ┌─────────────────┐     ┌────────────────┐
│                 │     │                 │     │                │
│ Patient Module  │────▶│  ISEE Verifier  │────▶│ Workflow Step  │
│                 │     │                 │     │                │
└─────────────────┘     └─────────────────┘     └────────────────┘
        │                        │                      │
        │                        │                      │
        ▼                        ▼                      ▼
┌─────────────────┐     ┌─────────────────┐     ┌────────────────┐
│                 │     │                 │     │                │
│ Document Store  │     │  Notification   │     │    Reporting   │
│                 │     │     System      │     │                │
└─────────────────┘     └─────────────────┘     └────────────────┘
```

### Struttura Dati

```php
// Struttura tabella patient_isees
Schema::create('patient_isees', function (Blueprint $table) {
    $table->id();
    $table->foreignId('patient_id')->constrained();
    $table->decimal('value', 10, 2); // Valore ISEE
    $table->date('valid_until');     // Data scadenza ISEE
    $table->boolean('verified')->default(false);
    $table->timestamp('verification_date')->nullable();
    $table->string('verification_method')->nullable();
    $table->string('document_path')->nullable();
    $table->timestamps();
});
```

## Integrazione con Altri Moduli

L'integrazione ISEE si collega con:

1. **Modulo Patient**: Associazione dei dati ISEE alla paziente
2. **Modulo Dental**: Verifica idoneità nel workflow appuntamenti
3. **Modulo Notify**: Invio notifiche per esito verifica e scadenze
4. **Modulo Media**: Gestione documenti ISEE caricati
5. **Modulo Reporting**: Statistiche e reportistica

## Calendario di Completamento

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Upload documenti | Maggio 2024 | Alta |
| Notifiche scadenza | Maggio 2024 | Alta |
| Reportistica | Giugno 2024 | Media |
| Dashboard amministrativa | Giugno 2024 | Media |
| Integrazione servizi esterni | Luglio 2024 | Bassa |

## Considerazioni sulla Privacy

In accordo con il GDPR e le normative italiane sulla privacy:

- I dati ISEE sono classificati come dati sensibili
- Viene implementata la minimizzazione dei dati
- I documenti hanno un periodo di conservazione definito
- L'accesso ai dati è limitato a personale autorizzato
- Viene mantenuto un registro completo degli accessi

## Metriche di Successo

- Tempo medio di verifica < 2 minuti
- Tasso di errore manuale < 1%
- Conformità normativa 100%
- Soddisfazione operatori > 4/5

## Riferimenti Normativi

- D.P.C.M. 159/2013 (Regolamento ISEE)
- Art. 33 D.L. 21/2022 (Semplificazione ISEE)
- Linee guida INPS sulla gestione ISEE
