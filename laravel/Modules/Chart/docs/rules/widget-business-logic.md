# Regole per Logica di Business dei Widget

## ⚠️ REGOLA CRITICA: OVERVIEW vs FILTRI SPECIFICI

**ERRORE GRAVE**: Confondere widget di overview generale con widget di dati filtrati per utente specifico.

## Tipologie di Widget

### 1. Widget Overview Generale
**Scopo**: Fornire una panoramica generale del sistema
**Dati**: Tutti i record senza filtri per utente
**Esempio**: `AppointmentStatesOverviewWidget`

```php
// ✅ CORRETTO - Widget Overview Generale
protected function getAppointmentsCountByState(string $stateName): int
{
    try {
        // Mostra TUTTI gli appuntamenti per stato
        return Appointment::where('state', $stateName)->count();
    } catch (\Exception $e) {
        return 0;
    }
}
```

### 2. Widget Dati Specifici Utente
**Scopo**: Mostrare dati specifici per l'utente corrente
**Dati**: Filtrati per utente/ruolo specifico
**Esempio**: `DoctorAppointmentsWidget`, `PatientAppointmentsWidget`

```php
// ✅ CORRETTO - Widget Dati Specifici Utente
protected function getAppointmentsCountByState(string $stateName): int
{
    try {
        return Appointment::where('state', $stateName)
            ->when(auth()->user()->hasRole('doctor'), function ($query) {
                return $query->where('doctor_id', auth()->id());
            })
            ->when(auth()->user()->hasRole('patient'), function ($query) {
                return $query->where('patient_id', auth()->id());
            })
            ->count();
    } catch (\Exception $e) {
        return 0;
    }
}
```

## Regole di Decisione

### Quando Usare Overview Generale
- **Dashboard amministrative**: Panoramica completa del sistema
- **Statistiche globali**: Metriche per tutto il sistema
- **Monitoraggio**: Controllo generale dello stato
- **Report**: Dati aggregati per decisioni

### Quando Usare Dati Specifici Utente
- **Dashboard personali**: Dati specifici dell'utente
- **Gestione personale**: Appuntamenti/task personali
- **Profilo utente**: Informazioni specifiche dell'utente
- **Notifiche personali**: Alert specifici per l'utente

## Esempi di Implementazione

### Widget Overview Generale
```php
class AppointmentStatesOverviewWidget extends XotBaseWidget
{
    /**
     * Mostra TUTTI gli appuntamenti per stato.
     * Scopo: Overview generale del sistema.
     */
    protected function getAppointmentsCountByState(string $stateName): int
    {
        try {
            return Appointment::where('state', $stateName)->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
}
```

### Widget Dati Specifici Dottore
```php
class DoctorAppointmentsWidget extends XotBaseWidget
{
    /**
     * Mostra solo gli appuntamenti del dottore corrente.
     * Scopo: Gestione personale del dottore.
     */
    protected function getAppointmentsCountByState(string $stateName): int
    {
        try {
            return Appointment::where('state', $stateName)
                ->where('doctor_id', auth()->id())
                ->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
}
```

## Checklist di Verifica

Prima di implementare qualsiasi widget:

1. **Il widget è per overview generale?**
   - ✅ Sì → Mostra TUTTI i dati senza filtri
   - ❌ No → Applica filtri appropriati

2. **Il widget è per dati specifici utente?**
   - ✅ Sì → Filtra per utente/ruolo corrente
   - ❌ No → Verifica se è overview generale

3. **Il contesto è appropriato?**
   - ✅ Sì → Implementa logica corretta
   - ❌ No → Rivedi il design del widget

4. **La documentazione è chiara?**
   - ✅ Sì → Documenta lo scopo del widget
   - ❌ No → Aggiungi documentazione

## Errori Comuni da Evitare

### ❌ ERRORE GRAVE: Overview con Filtri
```php
// ❌ ERRORE GRAVE - Widget overview che filtra per dottore
class AppointmentOverviewWidget extends XotBaseWidget
{
    protected function getAppointmentsCountByState(string $stateName): int
    {
        return Appointment::where('state', $stateName)
            ->where('doctor_id', auth()->id()) // ❌ ERRORE: Filtro in overview
            ->count();
    }
}
```

### ❌ ERRORE GRAVE: Dati Specifici Senza Filtri
```php
// ❌ ERRORE GRAVE - Widget personale che mostra tutti i dati
class DoctorAppointmentsWidget extends XotBaseWidget
{
    protected function getAppointmentsCountByState(string $stateName): int
    {
        return Appointment::where('state', $stateName)->count(); // ❌ ERRORE: Nessun filtro
    }
}
```

## Naming Convention

### Widget Overview Generale
- Suffisso: `OverviewWidget`
- Esempio: `AppointmentStatesOverviewWidget`
- Scopo: Panoramica generale

### Widget Dati Specifici
- Suffisso: `Widget` (senza Overview)
- Esempio: `DoctorAppointmentsWidget`
- Scopo: Dati specifici utente

## Documentazione

### Widget Overview
```php
/**
 * Widget panoramica stati appuntamenti.
 * 
 * Visualizza una panoramica compatta degli stati degli appuntamenti
 * con design ottimizzato per occupare meno spazio verticale.
 * Mostra TUTTI gli appuntamenti per stato (overview generale).
 */
```

### Widget Dati Specifici
```php
/**
 * Widget appuntamenti dottore.
 * 
 * Visualizza gli appuntamenti specifici del dottore corrente
 * con possibilità di gestione e azioni rapide.
 */
```

## Penalità per Violazioni

- **Prima violazione**: Correzione immediata + documentazione
- **Violazioni ripetute**: Rischio di perdita di fiducia
- **Logica errata**: Confusione utente e dati inappropriati

## Processo di Correzione

Se viene rilevata logica di business errata:

1. **Identificare il tipo di widget** (overview vs specifico)
2. **Correggere la logica** appropriata
3. **Aggiornare la documentazione** per chiarezza
4. **Testare il comportamento** per verificare correttezza

## Note Importanti

- **SEMPRE** considerare lo scopo del widget prima di implementare
- **SEMPRE** documentare chiaramente il tipo di widget
- **SEMPRE** applicare la logica appropriata per il contesto
- **MAI** mescolare overview generale con dati specifici utente 