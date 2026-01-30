# Convenzioni di Naming in il progetto

## Introduzione

Questo documento definisce le convenzioni di naming standard da seguire in tutto il progetto il progetto. Seguire queste convenzioni garantisce coerenza, manutenibilità e interoperabilità tra i diversi moduli e componenti del sistema.

## Convenzioni Generali

### Stile di Naming

- **PHP Classes**: PascalCase (es. `PatientResource`, `UserController`)
- **Methods**: camelCase (es. `getFormSchema()`, `createPatient()`)
- **Variables**: camelCase (es. `$patientData`, `$userEmail`)
- **Constants**: UPPER_SNAKE_CASE (es. `MAX_LOGIN_ATTEMPTS`, `DEFAULT_TIMEOUT`)
- **Database Tables**: snake_case, plurale (es. `patients`, `medical_records`)
- **Database Columns**: snake_case (es. `first_name`, `created_at`)
- **Routes**: kebab-case (es. `/patient-records`, `/medical-history`)

## Convenzioni Specifiche

### Campi Utente

#### Regola Fondamentale
- Utilizzare SEMPRE `first_name` invece di `user_name`, `name` o `nome`
- Utilizzare SEMPRE `last_name` invece di `surname` o `cognome`
- Questi campi devono SEMPRE essere usati insieme (se c'è `first_name`, deve esserci anche `last_name`)

#### Motivazioni
1. **Compatibilità con standard internazionali**: I campi `first_name` e `last_name` sono standard internazionali utilizzati in molti sistemi e API.
2. **Coerenza nel database**: Mantiene coerenza tra tutte le tabelle e moduli che gestiscono dati utente.
3. **Integrazione con servizi esterni**: Facilita l'integrazione con servizi di terze parti che utilizzano questi standard.
4. **Supporto multilingua**: Questi nomi di campo sono universalmente riconosciuti e non richiedono traduzioni.
5. **Evita ambiguità**: `first_name`/`last_name` è più chiaro di `nome`/`cognome` o `name`/`surname` in un contesto internazionale.

#### Esempi Corretti
```php
// ✅ CORRETTO - Nei modelli
protected $fillable = [
    'first_name',
    'last_name',
    'email',
];

// ✅ CORRETTO - Nei form Filament
Forms\Components\TextInput::make('first_name')
Forms\Components\TextInput::make('last_name')

// ✅ CORRETTO - Nelle migrazioni
$table->string('first_name');
$table->string('last_name');
```

#### Esempi Errati
```php
// ❌ ERRATO
Forms\Components\TextInput::make('user_name')
Forms\Components\TextInput::make('surname')

// ❌ ERRATO
Forms\Components\TextInput::make('nome')
Forms\Components\TextInput::make('cognome')

// ❌ ERRATO - Incoerente
Forms\Components\TextInput::make('first_name')
Forms\Components\TextInput::make('surname')
```

### Localizzazione

- Chiavi di traduzione: snake_case (es. `patient.registration.success`)
- File di lingua: snake_case (es. `validation.php`, `auth.php`)

### Filament Resources

- Nome classe: PascalCase, suffisso `Resource` (es. `PatientResource`, `DoctorResource`)
- Metodi schema: iniziano con `get` e finiscono con `Schema` o `Step` (es. `getFormSchema()`, `getPersonalDataStep()`)

## Verifica e Conformità

- Implementare controlli automatici nelle CI/CD per verificare l'aderenza a queste convenzioni
- Eseguire revisioni del codice regolari per garantire la conformità
- Aggiornare questo documento quando vengono stabilite nuove convenzioni

## Collegamenti a Documentazione Correlata

- [Filament Best Practices](../Modules/User/docs/FILAMENT_BEST_PRACTICES.md)
- [Database Schema](DATABASE_SCHEMA.md)
- [API Standards](API_STANDARDS.md)

## Collegamenti tra versioni di NAMING_CONVENTIONS.md
* [NAMING_CONVENTIONS.md](laravel/Modules/Xot/docs/NAMING_CONVENTIONS.md)
* [NAMING_CONVENTIONS.md](laravel/docs/NAMING_CONVENTIONS.md)

