<<<<<<< .merge_file_4LKQab
# Regole Fondamentali per Prompt AI - healthcare_app Fila5 Mono
=======
# Regole Fondamentali per Prompt AI - ModuloEsempio Fila5 Mono
>>>>>>> .merge_file_KNKjVx

## 🚨 REGOLA ASSOLUTA: Database Testing

**MAI SQLite per i test - SOLO MySQL con suffisso "_test"**

### Pattern Obbligatorio per Tutti i Prompt

Tutti i prompt per generazione di codice, test, o modifiche devono includere queste regole fondamentali:

```
<<<<<<< .merge_file_4LKQab
Create/Update code for healthcare_app Fila5 Mono with these CRITICAL rules:
=======
Create/Update code for ModuloEsempio Fila5 Mono with these CRITICAL rules:
>>>>>>> .merge_file_KNKjVx
1. NEVER use SQLite for testing - ALWAYS MySQL with "_test" suffixed databases
2. NEVER use RefreshDatabase trait - ALWAYS use DatabaseTransactions
3. ALWAYS copy .env.testing to .env before running tests: cp .env.testing .env
4. Handle race conditions with first() + try/catch pattern for unique constraints
5. Follow PHPStan Level 10 compliance - explicit return types, no mixed types
6. Use XotBase patterns for all components (XotBaseResource, BaseModel, etc.)
7. Use isset() for Eloquent magic properties, NEVER property_exists()
```

## 📋 Esempi di Prompt Corretti

### Per Test Generation
```
<<<<<<< .merge_file_4LKQab
Create test for ProfileService in healthcare_app Fila5 Mono with these rules:
=======
Create test for ProfileService in ModuloEsempio Fila5 Mono with these rules:
>>>>>>> .merge_file_KNKjVx
- Use DatabaseTransactions trait, NEVER RefreshDatabase
- Test concurrent profile creation with first() + try/catch pattern
- Use MySQL testing configuration (.env.testing with "_test" databases)
- Handle race conditions for unique user_id constraints
- Follow PHPStan Level 10 with explicit return types
```

### Per Service Creation
```
<<<<<<< .merge_file_4LKQab
Create ProfileService for healthcare_app Fila5 Mono following these patterns:
=======
Create ProfileService for ModuloEsempio Fila5 Mono following these patterns:
>>>>>>> .merge_file_KNKjVx
- Use Spatie QueueableAction pattern, not static service classes
- Implement getOrCreateProfile with race condition handling:
  try/catch on firstOrFail() then create()
- Return explicit types: Profile model with proper typing
- Use BaseModel as base class for all models
- Include comprehensive docblocks with @throws annotations
```

### Per Filament Resources
```
<<<<<<< .merge_file_4LKQab
Create Filament resource extending XotBaseResource for healthcare_app Fila5 Mono:
=======
Create Filament resource extending XotBaseResource for ModuloEsempio Fila5 Mono:
>>>>>>> .merge_file_KNKjVx
- Extend XotBaseResource, never Filament Resource directly
- Implement getFormSchema() returning array
- NEVER implement getTableColumns() method
- Use proper TextInput/Select components with correct imports
- Follow XotBase patterns for view records and widgets
```

## 🎯 Regole Specifiche per Modulo

### Modulo User
```
User module specific requirements:
- ProfileService with getOrCreateProfile() method
- Handle race conditions for profile creation
- Use DatabaseTransactions in all tests
- Test with multiple concurrent profile creation scenarios
- Follow MySQL testing with "_test" databases
```

### Modulo Xot (Framework Base)
```
Xot module base requirements:
- All models extend BaseModel, BasePivot, or BaseMorphPivot
- All migrations extend XotBaseMigration
- All service providers extend XotBaseServiceProvider
- Critical rule: isset() for Eloquent properties, NEVER property_exists()
- PHPStan Level 10 compliance mandatory
```

<<<<<<< .merge_file_4LKQab
### Modulo healthcare_app
```
healthcare_app module specific requirements:
=======
### Modulo ModuloEsempio
```
ModuloEsempio module specific requirements:
>>>>>>> .merge_file_KNKjVx
- LimeSurvey integration with proper MySQL connections
- Use SurveyResponse scopes, never direct table access
- Multi-database configuration with "_test" suffixes
- Handle large datasets with proper pagination
- Follow PHPStan Level 10 for all survey-related code
```

## 🚫 Pattern da Evitare nei Prompt

### ❌ Pattern Proibiti
```
- "Use RefreshDatabase trait" -> PROIBITO
- "Configure SQLite for testing" -> PROIBITO  
- "Use property_exists() for models" -> PROIBITO
- "Create static service methods" -> PROIBITO
- "Use mixed return types" -> PROIBITO
- "Extend Filament Resource directly" -> PROIBITO
```

### ✅ Pattern Obbligatori
```
- "Use DatabaseTransactions trait" -> OBBLIGATORIO
- "Configure MySQL with _test databases" -> OBBLIGATORIO
- "Use isset() for Eloquent properties" -> OBBLIGATORIO
- "Use Spatie QueueableAction pattern" -> OBBLIGATORIO
- "Extend XotBaseResource" -> OBBLIGATORIO
- "PHPStan Level 10 compliance" -> OBBLIGATORIO
```

## 🏗️ Structure Requirements

### Per Tests
```
Test structure requirements:
- Extend appropriate module TestCase with DatabaseTransactions
- Use Pest syntax (describe(), it(), expect())
- Test concurrent scenarios where applicable
- Verify MySQL "_test" database usage
- Include explicit type declarations
- Handle ModelNotFoundException correctly
```

### Per Services
```
Service structure requirements:
- Use Spatie\QueueableAction\QueueableAction trait
- Execute method with explicit return types
- Proper exception handling with @throws
- Dependency injection through constructor
- Race condition handling for unique constraints
```

### Per Models
```
Model structure requirements:
- Extend BaseModel, not Eloquent Model directly
- Proper connection configuration if needed
- Explicit casts() method with parent merge
- Fillable array with proper typing
- Relationship methods with explicit return types
```

## 📚 Riferimenti Aggiuntivi

### Documentazione Principale
- [AGENTS.md](../../../../agents.md) - Guida completa sviluppatori AI
- [Database Testing Rules](../../../../docs/database-testing-rules.md) - Regole MySQL testing
- [AI Coding Memory](../../../../ai_coding_memory.md) - Memoria completa regole
- [Critical Rules Index](../../../../docs/critical-rules-index.md) - Indice regole critiche

### Regole Specifiche
- [Profile Duplicate Resolution](../../../../docs/profile-duplicate-issue-resolution.md) - Soluzione completa
- [MySQL Testing Configuration](../../../../docs/mysql-testing-configuration.md) - Configurazione MySQL
- [PHPStan Critical Rules](../xot/docs/phpstan-critical-rules.md) - Regole PHPStan

## 🔧 Integration Guidelines

### Multi-Tenant Architecture
```
Multi-tenant requirements:
- DatabaseTransactions to preserve tenant isolation
- Multiple database connections with "_test" suffixes
- Proper tenant context handling in tests
- Connection-specific model configurations
```

### LimeSurvey Integration
```
LimeSurvey specific rules:
- Use SurveyResponse scopes for all queries
- Never access lime_* tables directly
- Proper MySQL configuration for survey databases
- Handle large response datasets efficiently
```

---

**
**MySQL Testing**: ✅ OBBLIGATORIO  
**Race Conditions**: ✅ Pattern first() + try/catch  
**PHPStan Level**: ✅ 10 obbligatorio  
**Status**: Production Ready