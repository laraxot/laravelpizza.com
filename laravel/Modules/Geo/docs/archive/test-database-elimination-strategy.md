# Strategia di Eliminazione Database dai Test - <nome progetto>

## PROBLEMA IDENTIFICATO

La maggior parte dei test <nome progetto> sta ancora usando database e factory, contraddicendo la regola fondamentale **NO DATABASE NEI TEST**.

## ERRORI PRINCIPALI

### 1. QueryException: "no such table: users"
- **Causa**: Factory che tentano di salvare su database
- **Test coinvolti**: AppointmentBusinessLogicTest, ReportPendingStateTest, AppointmentStateTransitionTest
- **Soluzione**: Sostituire tutte le factory calls con oggetti plain PHP

### 2. BindingResolutionException: "Target class [config] does not exist" 
- **Causa**: Test Unit che tentano di usare container Laravel
- **Test coinvolti**: FetchCalendarEventsActionTest
- **Soluzione**: Rimuovere dipendenze da container

### 3. InvalidArgumentException: "Unknown format 'firstNameMale'"
- **Causa**: Factory che usano metodi Faker inesistenti
- **Test coinvolti**: DoctorFactory usata da FetchCalendarEventsActionTest
- **Soluzione**: Correggere DoctorFactory oppure eliminare del tutto

### 4. Errori di Precisione Decimale
- **Causa**: diffInMinutes() che ritorna float invece di int
- **Test coinvolti**: AppointmentManagementBusinessLogicTest
- **Soluzione**: Usare assertEquals invece di toBe per confronti numerici

### 5. Test Homepage con Dipendenze Web
- **Causa**: Test che fanno richieste HTTP reali
- **Test coinvolti**: HomepageRequirementsTest
- **Soluzione**: Mockare risposta HTML o convertire in unit test

## STRATEGIA DI RISOLUZIONE

### Fase 1: Identificare tutti i test con database
```bash
grep -r "::factory" Modules/<nome progetto>/tests/ --include="*.php"
grep -r "RefreshDatabase" Modules/<nome progetto>/tests/ --include="*.php" 
grep -r "uses(TestCase" Modules/<nome progetto>/tests/ --include="*.php"
```

### Fase 2: Convertire sistematicamente ogni test
1. **AppointmentBusinessLogicTest**: Sostituire factory con oggetti plain
2. **ReportPendingStateTest**: Eliminare database dependencies 
3. **AppointmentStateTransitionTest**: Convertire in logic pura
4. **FetchCalendarEventsActionTest**: Rimuovere config dependencies
5. **HomepageRequirementsTest**: Mockare HTML response

### Fase 3: Pattern di sostituzione standardizzati
```php
// ❌ DA ELIMINARE
$appointment = Appointment::factory()->create([
    'patient_id' => $patient->id,
    'doctor_id' => $doctor->id
]);

// ✅ SOSTITUIRE CON
$appointment = (object) [
    'id' => 4001,
    'patient_id' => 1001,
    'doctor_id' => 2001,
    'starts_at' => Carbon::now()->addDay(),
    'ends_at' => Carbon::now()->addDay()->addHour(),
    'type' => 'consultation',
    'status' => 'scheduled'
];
```

## PRINCIPI GUIDA

### Velocità
- Test senza database = millisecondi
- Test con database = secondi
- 47 test falliti per database = tempo sprecato

### Isolamento
- Ogni test deve essere completamente indipendente
- Zero side effects tra test
- Zero stato condiviso

### Determinismo
- Risultati sempre identici
- Zero variabilità da database
- Zero dipendenze esterne

### Semplicità
- Zero setup database
- Zero connessioni
- Zero transazioni
- Focus sulla logica di business

## ZEN DEL TESTING SENZA DATABASE

**"Un test che non può fallire per problemi di infrastruttura è un test che testa davvero la logica"**

**"Il database è un dettaglio di implementazione, non un requisito di business logic"**

**"Test veloci = test che vengono eseguiti = bug trovati prima"**

## DELIVERABLES

1. **Tutti i test passanti** senza alcuna dipendenza database
2. **Documentazione aggiornata** con pattern sostitutivi 
3. **Regole permanenti** per prevenire regressioni future
4. **Memoria collettiva** per non ripetere errori

## METRICHE DI SUCCESSO

- ✅ 0 test con `::factory()->create()`
- ✅ 0 test con `RefreshDatabase`
- ✅ 0 test con `uses(TestCase::class)`
- ✅ 0 `QueryException` nei test
- ✅ Tempo esecuzione < 10 secondi per tutto il modulo
- ✅ 100% test passanti

## ANTI-PATTERN DA EVITARE SEMPRE

1. `use Illuminate\Foundation\Testing\RefreshDatabase;`
2. `uses(TestCase::class, RefreshDatabase::class);`
3. `Model::factory()->create()`
4. Dipendenze da `config()` nei Unit test
5. Richieste HTTP reali nei test logic

*Documento creato: 2025-01-06*
*Status: In implementazione attiva*
