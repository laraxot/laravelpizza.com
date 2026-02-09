# Correzioni Ridondanze - Gennaio 2026

## Problema Identificato

Durante l'implementazione della gestione completa di Passport, sono state introdotte due ridondanze critiche che violano il principio DRY:

1. **HasXotTable ridondante** in RelationManager
2. **Passport policies** registrate in `UserServiceProvider` invece che in `PassportServiceProvider`

## Correzioni Applicate

### 1. Rimozione HasXotTable Ridondante

**Problema**: `UsersRelationManager` aveva `use HasXotTable;` anche se `XotBaseRelationManager` già lo include.

**Correzione**: Rimosso `use HasXotTable;` da `UsersRelationManager` (non era presente nel file, ma era stato aggiunto in precedenza).

**File**: `laravel/Modules/User/app/Filament/Resources/SsoProviderResource/RelationManagers/UsersRelationManager.php`

**Motivazione**: `XotBaseRelationManager` già include `HasXotTable` alla riga 32. Aggiungerlo nuovamente è ridondante e viola DRY.

### 2. Spostamento Policy Passport

**Problema**: `OauthClientPolicy` era registrata in `UserServiceProvider` invece che in `PassportServiceProvider`.

**Correzione**: 
- Rimosso `registerPolicies()` da `UserServiceProvider`
- Aggiunto `registerPolicies()` a `PassportServiceProvider`

**File Modificati**:
- `laravel/Modules/User/app/Providers/UserServiceProvider.php` - Rimosso `registerPolicies()`
- `laravel/Modules/User/app/Providers/PassportServiceProvider.php` - Aggiunto `registerPolicies()`

**Motivazione**: 
- `PassportServiceProvider` è registrato in `module.json` e ha la responsabilità unica di configurare Passport
- `UserServiceProvider` deve occuparsi SOLO della configurazione core del modulo User
- Separation of Concerns: ogni provider ha una responsabilità ben definita

## Verifica Qualità Codice

### PHPStan Level 10
✅ **Nessun errore** - Tutti i file passano l'analisi statica al livello massimo.

### PHPMD
⚠️ **Warning minori** (non bloccanti):
- StaticAccess per `Passport::`, `Assert::`, `Gate::` (normale per ServiceProvider)
- CamelCasePropertyName per `$module_dir` e `$module_ns` (richiesti da XotBaseServiceProvider)
- CyclomaticComplexity per `registerMailsNotification()` (accettabile)

### PHPInsights
✅ **Punteggi eccellenti**:
- **Code**: 94.8%
- **Complexity**: 66.7%
- **Architecture**: 88.2%
- **Style**: 98.8%

### Laravel Pint
✅ **Pass** - Tutti i file formattati correttamente

## Documentazione Aggiornata

1. **Nuovo file**: `laravel/Modules/Xot/docs/filament/redundancy-rules.md`
   - Documenta le regole anti-ridondanza per XotBase classes
   - Include esempi di errori comuni e correzioni

2. **Aggiornato**: `laravel/Modules/Xot/docs/filament/relation-managers.md`
   - Aggiunto warning su HasXotTable ridondante

3. **Aggiornato**: `laravel/Modules/User/docs/SERVICE_PROVIDER_ARCHITECTURE.md`
   - Rimosso riferimento a registrazione policies in UserServiceProvider
   - Aggiunto divieto esplicito per policies di Passport

4. **Nuovo file**: `.cursor/rules/anti-redundancy-rules.mdc`
   - Regole per evitare ridondanze in futuro

## Regole Estrapolate

### Regola 1: HasXotTable in RelationManager

**MAI** aggiungere `use HasXotTable;` in un RelationManager che estende `XotBaseRelationManager`.

**Verifica**:
```bash
grep -r "use HasXotTable" laravel/Modules/Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php
```

### Regola 2: Passport in UserServiceProvider

**MAI** registrare policies o configurare Passport in `UserServiceProvider` quando esiste già `PassportServiceProvider`.

**Verifica**:
```bash
grep -r "PassportServiceProvider" laravel/Modules/User/module.json
```

## Checklist Pre-Commit

Prima di committare, verifica:

- [ ] Nessun trait ridondante aggiunto (es. HasXotTable in RelationManager)
- [ ] Nessuna configurazione Passport in UserServiceProvider
- [ ] Tutte le policies di Passport sono in PassportServiceProvider
- [ ] PHPStan Level 10 passa senza errori
- [ ] Documentazione aggiornata

## Collegamenti

- [Redundancy Rules](../../Xot/docs/filament/redundancy-rules.md)
- [Service Provider Architecture](./SERVICE_PROVIDER_ARCHITECTURE.md)
- [XotBaseRelationManager Documentation](../../Xot/docs/filament/relation-managers.md)

*Ultimo aggiornamento: Gennaio 2026*
