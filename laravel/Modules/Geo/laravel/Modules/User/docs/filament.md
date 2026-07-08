# Filament nel Modulo User

## Documentazione

1. [Migrazione Filament 4](filament4-migration.md) - Guida completa alla migrazione da v3 a v4
2. [Errori Comuni](filament-errors.md) - Documentazione degli errori comuni e delle loro soluzioni
3. [Struttura delle Risorse](structure.md#filament-resources) - Come sono strutturate le risorse Filament
4. [Best Practices](filament-errors.md#best-practices) - Best practices per lo sviluppo con Filament

## Risorse

- UserResource
  - TeamsRelationManager
  - RolesRelationManager
  - PermissionsRelationManager
- TeamResource
- RoleResource
- PermissionResource

## Widgets

- LoginWidget
- RecentLoginsWidget
- UserStatsWidget

## RelationManager

### TeamsRelationManager
- Gestisce la relazione many-to-many tra User e Team
- Implementa le operazioni CRUD per i team associati a un utente
- Supporta attach/detach di team esistenti

### RolesRelationManager
- Gestisce la relazione many-to-many tra User e Role
- Implementa le operazioni CRUD per i ruoli associati a un utente
- Supporta attach/detach di ruoli esistenti

### PermissionsRelationManager
- Gestisce la relazione many-to-many tra User e Permission
- Implementa le operazioni CRUD per i permessi associati a un utente
- Supporta attach/detach di permessi esistenti

## Note Importanti

- Seguire sempre le best practices documentate
- Consultare la documentazione degli errori prima di fare modifiche
- Mantenere aggiornata la documentazione con nuovi errori o soluzioni
- Verificare la compatibilità con la versione di Filament in uso

## Versione di Filament

- **Versione corrente: 4.x** (MIGRATA)
- Versione precedente: 3.x (DEPRECATED)
- Breaking changes: [Documentazione ufficiale](https://filamentphp.com/docs/4.x/upgrade-guide)
- Compatibilità: Laravel 11.x/12.x
- Schema System: Nuovo sistema unificato per componenti

## Modifiche Filament 4

### Sistema Schema
- Implementazione obbligatoria di `HasSchemas` interface
- Utilizzo di `InteractsWithSchemas` trait
- Metodi `form()` ora restituiscono `Schema` invece di `Form`

### Widgets Aggiornati
- LoginWidget: Migrato al sistema Schema
- RegisterWidget: Migrato al sistema Schema
- ResetPasswordWidget: Migrato al sistema Schema
- PasswordExpiredWidget: Migrato al sistema Schema 
