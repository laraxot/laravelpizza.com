# Filament Resources Coverage Analysis - Modulo User

## Data: 2025-01-02

## Scopo
Analizzare la copertura completa delle Filament Resources per tutti i modelli del modulo User, identificare cosa manca e decidere cosa implementare seguendo la filosofia DRY + KISS.

## Filosofia e Business Logic

### Principi Fondamentali
1. **DRY (Don't Repeat Yourself)**: Non duplicare logica già presente
2. **KISS (Keep It Simple, Stupid)**: Soluzioni semplici e dirette
3. **Security First**: Tutti i modelli sensibili devono avere Resources con Policy
4. **Audit Trail**: Modelli di audit devono essere consultabili ma non modificabili
5. **Pivot Tables**: Le tabelle pivot NON hanno Resources standalone (gestite via RelationManager)

### Business Logic del Modulo User
Il modulo User gestisce:
- **Autenticazione**: Login, logout, sessioni, OAuth
- **Autorizzazione**: Ruoli, permessi, team permissions
- **Audit**: Log di autenticazione, tentativi falliti
- **Organizzazione**: Team, tenant, membership
- **Profilo**: Dati utente, avatar, preferenze

## Analisi Modelli

### Modelli con Resource ✅

1. **User** → `UserResource` ✅
2. **Role** → `RoleResource` ✅
3. **Permission** → `PermissionResource` ✅
4. **Team** → `TeamResource` ✅
5. **Tenant** → `TenantResource` ✅
6. **Device** → `DeviceResource` ✅
7. **Profile** → `ProfileResource` ✅
8. **TeamInvitation** → `TeamInvitationResource` ✅
9. **Feature** → `FeatureResource` ✅
10. **SocialProvider** → `SocialProviderResource` ✅
11. **SocialiteUser** → `SocialiteUserResource` ✅
12. **SsoProvider** → `SsoProviderResource` ✅
13. **AuthenticationLog** → `AuthenticationLogResource` ✅
14. **Client** (OauthClient) → `ClientResource` ✅
15. **OauthAccessToken** → `OauthAccessTokenResource` ✅
16. **OauthAuthCode** → `OauthAuthCodeResource` ✅
17. **OauthRefreshToken** → `OauthRefreshTokenResource` ✅
18. **PasswordReset** → `PasswordResetResource` ✅

### Modelli senza Resource - Analisi

#### 1. Authentication
**Tipo**: Audit/Log Model
**Business Logic**: Traccia tentativi di autenticazione (login/logout)
**Differenza con AuthenticationLog**:
- `Authentication`: Tentativi generici (polymorphic)
- `AuthenticationLog`: Log specifici utente (HasAuthenticationLogTrait)

**Decisione**: ⚠️ **DA VALUTARE**
- Pro: Utile per audit completo sistema
- Contro: Duplicazione con AuthenticationLog
- **Raccomandazione**: Se Authentication è usato attivamente, creare Resource read-only

#### 2. DeviceProfile
**Tipo**: Pivot Model (estende DeviceUser)
**Business Logic**: Relazione device-profile
**Decisione**: ❌ **NON SERVE**
- È un pivot model
- Gestito via RelationManager in DeviceResource o ProfileResource

#### 3. Extra
**Tipo**: Attributi Extra (SchemalessAttributes)
**Business Logic**: Attributi dinamici per qualsiasi modello
**Decisione**: ❌ **NON SERVE**
- Modello di supporto per attributi extra
- Non ha senso CRUD standalone
- Gestito automaticamente dai modelli che lo usano

#### 4. Notification
**Tipo**: Laravel BaseNotification
**Business Logic**: Notifiche sistema Laravel
**Decisione**: ❌ **NON SERVE**
- Gestito nativamente da Laravel
- Accessibile via `$user->notifications`
- Non ha senso CRUD standalone

#### 5. OauthDeviceCode
**Tipo**: OAuth Device Code Flow
**Business Logic**: OAuth2 device authorization grant
**Decisione**: ⚠️ **DA VALUTARE**
- Pro: Utile per gestione OAuth device flow
- Contro: Raro, usato solo per device authorization
- **Raccomandazione**: Solo se necessario per business logic specifica

#### 6. OauthPersonalAccessClient
**Tipo**: OAuth Personal Access Client
**Business Logic**: Client OAuth per accesso personale
**Decisione**: ✅ **CREARE RESOURCE**
- Pro: Gestione client OAuth personali importante
- Utile per admin per vedere/gestire personal access clients
- Ha Policy già esistente

#### 7. OauthToken
**Tipo**: OAuth Token (wrapper PassportToken)
**Business Logic**: Token OAuth generici
**Decisione**: ❌ **NON SERVE**
- Già gestito da `OauthAccessTokenResource`
- `OauthToken` è un alias/wrapper
- Duplicazione inutile

#### 8. TeamPermission
**Tipo**: Permission Model (non pivot)
**Business Logic**: Permessi specifici per team
**Decisione**: ✅ **CREARE RESOURCE**
- Pro: Gestione permessi team importante
- Ha relazioni con Team e User
- Utile per admin per gestire permessi team

## Modelli Pivot (NON hanno Resources)

Questi modelli sono pivot tables e NON devono avere Resources standalone:
- `DeviceUser` (pivot)
- `Membership` (pivot)
- `ModelHasPermission` (pivot Spatie)
- `ModelHasRole` (pivot Spatie)
- `PermissionRole` (pivot Spatie)
- `PermissionUser` (pivot Spatie)
- `ProfileTeam` (pivot)
- `RoleHasPermission` (pivot Spatie)
- `TeamUser` (pivot)
- `TenantUser` (pivot)

**Gestione**: Via RelationManager nelle Resources principali

## Relation Managers Esistenti

### UserResource RelationManagers ✅
- `AuthenticationLogsRelationManager` ✅
- `ClientsRelationManager` ✅
- `DevicesRelationManager` ✅
- `OauthTokensRelationManager` ✅
- `ProfileRelationManager` ✅
- `RolesRelationManager` ✅
- `SocialiteUsersRelationManager` ✅
- `TeamsRelationManager` ✅
- `TenantsRelationManager` ✅
- `TokensRelationManager` ✅

### Altri RelationManagers ✅
- `RoleResource/PermissionsRelationManager` ✅
- `PermissionResource/RoleRelationManager` ✅
- `TeamResource/UsersRelationManager` ✅
- `TenantResource/UsersRelationManager` ✅
- `TenantResource/DomainsRelationManager` ✅
- `DeviceResource/UsersRelationManager` ✅

## Decisioni Finali

### Resources da Creare

1. **OauthPersonalAccessClientResource** ✅
   - **Motivazione**: Gestione client OAuth personali importante per admin
   - **Policy**: `OauthPersonalAccessClientPolicy` già esistente
   - **Priorità**: Media

2. **TeamPermissionResource** ✅
   - **Motivazione**: Gestione permessi team importante per admin
   - **Policy**: Da creare `TeamPermissionPolicy`
   - **Priorità**: Media

### Resources da Valutare

1. **AuthenticationResource** ⚠️
   - **Motivazione**: Audit completo sistema
   - **Decisione**: Solo se Authentication è usato attivamente (verificare usage)
   - **Priorità**: Bassa

2. **OauthDeviceCodeResource** ⚠️
   - **Motivazione**: Gestione OAuth device flow
   - **Decisione**: Solo se necessario per business logic
   - **Priorità**: Bassa

## Checklist Implementazione

### OauthPersonalAccessClientResource
- [ ] Creare Resource estendendo `XotBaseResource`
- [ ] Implementare `getFormSchema()` con chiavi stringhe
- [ ] Implementare `table()` con colonne appropriate
- [ ] Verificare Policy esistente
- [ ] Aggiungere traduzioni
- [ ] Testare CRUD operations

### TeamPermissionResource
- [ ] Creare Resource estendendo `XotBaseResource`
- [ ] Implementare `getFormSchema()` con chiavi stringhe
- [ ] Implementare `table()` con colonne appropriate
- [ ] Creare `TeamPermissionPolicy`
- [ ] Aggiungere traduzioni
- [ ] Testare CRUD operations

## Note

- Tutte le Resources devono estendere `XotBaseResource`
- Tutti i metodi devono restituire array con chiavi stringhe
- Mai usare `->label()` direttamente (solo traduzioni)
- PHPStan Level 10 compliance obbligatoria

## Collegamenti

- [Filament Resources Organization](./filament-resources-organization.md)
- [Filament Best Practices](./filament-best-practices.md)
- [Filosofia Modulo User](./FILOSOFIA_MODULO_USER.md)
