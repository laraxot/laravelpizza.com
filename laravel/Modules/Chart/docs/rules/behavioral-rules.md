# Regole Comportamentali - Aggiornate

## ⚠️ REGOLE CRITICHE DI COMPORTAMENTO

**ERRORE GRAVE**: Agire senza studio approfondito del contesto. Devo sempre analizzare completamente prima di implementare.

## Regole Fondamentali Aggiornate

### 1. Studio Obbligatorio Pre-Azione

**PRIMA di qualsiasi implementazione, devo:**

1. **Analizzare il contesto completo**:
   - Leggere documentazioni esistenti
   - Studiare pattern simili nel codebase
   - Comprendere l'architettura del modulo

2. **Studiare le migrazioni** (per modifiche database):
   - Analizzare migrazioni esistenti
   - Comprendere la struttura delle tabelle
   - Verificare pattern di XotBaseMigration

3. **Studiare i modelli** (per modifiche dati):
   - Analizzare fillable, casts, relazioni
   - Comprendere la logica di business
   - Verificare Single Table Inheritance

4. **Studiare le traduzioni** (per file lang):
   - Analizzare pattern di traduzione
   - Verificare struttura e convenzioni
   - Comprendere helper_text rules

5. **Studiare altri moduli**:
   - Verificare consistenza cross-modulo
   - Analizzare pattern simili
   - Comprendere convenzioni globali

### 2. Regole Specifiche per Tipo di Modifica

#### A. Modifiche Database/Migrazioni
- **SEMPRE** estendere `XotBaseMigration`
- **SEMPRE** usare classi anonime
- **MAI** implementare metodo `down()`
- **SEMPRE** verificare esistenza con `hasColumn()`/`hasTable()`

#### B. Modifiche File di Traduzione
- **SEMPRE** studiare migrazioni e modelli prima
- **SEMPRE** usare array short syntax `[]`
- **SEMPRE** usare `declare(strict_types=1);`
- **MAI** rimuovere traduzioni complete esistenti
- **SEMPRE** aggiungere campi mancanti dalla migrazione

#### C. Modifiche Widget/Componenti
- **SEMPRE** distinguere overview vs dati specifici utente
- **SEMPRE** documentare la logica di business
- **SEMPRE** posizionare documentazione nella cartella corretta

### 3. Posizionamento Documentazione

#### ✅ CORRETTO - Documentazione Modulo
```
/laravel/Modules/{ModuleName}/docs/
```
- Documentazione specifica del modulo
- Regole e pattern del modulo
- Architettura e logica di business

#### ✅ CORRETTO - Documentazione Generica
```
/docs/
```
- Regole generali del progetto
- Standard cross-modulo
- Architettura globale

#### ❌ ERRATO - Posizionamento Misto
```
/docs/ (per documentazione specifica modulo)
```

### 4. Gestione Errori e Logging

#### ✅ CORRETTO - Gestione Errori Appropriata
```php
try {
    return Appointment::where('state', $stateName)->count();
} catch (\Exception $e) {
    // Fallback appropriato senza logging inutile
    return 0;
}
```

#### ❌ ERRATO - Logging Inappropriato
```php
// ❌ MAI fare questo
Log::warning('Errore nel conteggio appuntamenti');
```

### 5. Logica di Business Widget

#### ✅ CORRETTO - Widget Overview
```php
// Mostra TUTTI gli appuntamenti per overview generale
return Appointment::where('state', $stateName)->count();
```

#### ✅ CORRETTO - Widget Specifico Utente
```php
// Filtra per utente specifico
return Appointment::where('state', $stateName)
    ->where('doctor_id', auth()->id())
    ->count();
```

#### ❌ ERRATO - Confusione Logica
```php
// ❌ MAI mescolare overview con filtri specifici
return Appointment::where('state', $stateName)
    ->where('doctor_id', auth()->id()) // ERRORE: Filtro in overview
    ->count();
```

## Processo di Correzione Aggiornato

### Fase 1: Analisi Completa
1. **Identificare il tipo di modifica** (database, traduzione, widget, etc.)
2. **Studiare il contesto specifico** per quel tipo
3. **Analizzare pattern esistenti** nel codebase
4. **Comprendere le regole** specifiche per quel dominio

### Fase 2: Implementazione Corretta
1. **Applicare le regole** specifiche per il tipo di modifica
2. **Seguire i pattern** identificati nello studio
3. **Mantenere consistenza** con il codebase esistente
4. **Documentare** nella posizione corretta

### Fase 3: Verifica e Aggiornamento
1. **Verificare la correttezza** dell'implementazione
2. **Aggiornare le regole** se necessario
3. **Documentare lezioni** apprese
4. **Prevenire ripetizioni** future

## Errori Critici da Evitare

### ❌ ERRORE GRAVE: Azione Senza Studio
```php
// ❌ MAI fare questo
// Implementazione immediata senza analisi
// Risultato: Errori di logica, inconsistenze, violazioni regole
```

### ❌ ERRORE GRAVE: Posizionamento Documentazione Errato
```php
// ❌ MAI documentazione specifica modulo in /docs/
// SEMPRE in /laravel/Modules/{ModuleName}/docs/
```

### ❌ ERRORE GRAVE: Logging Inappropriato
```php
// ❌ MAI logging per errori di codice
// SEMPRE fallback appropriato senza rumore
```

### ❌ ERRORE GRAVE: Confusione Logica di Business
```php
// ❌ MAI mescolare overview con dati specifici utente
// SEMPRE distinguere chiaramente lo scopo
```

## Penalità per Violazioni

- **Prima violazione**: Correzione immediata + studio approfondito
- **Violazioni ripetute**: Rischio di perdita di fiducia
- **Errori di logica**: Confusione utente e manutenzione difficile

## Processo di Recupero

Se viene rilevato un errore:

1. **Analizzare completamente** il problema
2. **Studiare il contesto** mancante
3. **Correggere completamente** l'implementazione
4. **Documentare la lezione** appresa
5. **Aggiornare le regole** per prevenire ripetizioni

## Note Importanti

- **SEMPRE** studiare prima di agire
- **SEMPRE** seguire le regole specifiche per il tipo di modifica
- **SEMPRE** posizionare documentazione correttamente
- **SEMPRE** distinguere logica di business appropriata
- **MAI** agire senza analisi completa
- **MAI** violare le regole consolidate 