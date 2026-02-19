# Analisi Modelli, Factory e Seeder - Modulo User

## Panoramica
Questo documento analizza tutti i modelli del modulo User verificando la presenza di factory e seeder corrispondenti, identificando modelli non utilizzati nella business logic principale.

## Modelli Attivi e Business Logic

### Modelli Core Authentication (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **User** | ✅ UserFactory | ✅ UserSeeder | Core - Utente base del sistema |
| **Profile** | ✅ ProfileFactory | ❌ | Core - Profilo utente esteso |
| **Team** | ✅ TeamFactory | ❌ | Core - Team collaboration |
| **TeamUser** | ✅ TeamUserFactory | ❌ | Core - Relazione team-utente |
| **Tenant** | ✅ TenantFactory | ❌ | Core - Multi-tenancy |
| **TenantUser** | ✅ TenantUserFactory | ❌ | Core - Relazione tenant-utente |

### Modelli Permissions & Roles (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Permission** | ✅ PermissionFactory | ✅ PermissionsSeeder | Core - Sistema permessi |
| **Role** | ✅ RoleFactory | ✅ RolesSeeder | Core - Sistema ruoli |
| **ModelHasPermission** | ✅ ModelHasPermissionFactory | ❌ | Core - Permessi modello |
| **ModelHasRole** | ✅ ModelHasRoleFactory | ❌ | Core - Ruoli modello |
| **PermissionRole** | ✅ PermissionRoleFactory | ❌ | Core - Permessi-ruoli |
| **PermissionUser** | ✅ PermissionUserFactory | ❌ | Core - Permessi-utente |
| **RoleHasPermission** | ✅ RoleHasPermissionFactory | ❌ | Core - Ruoli-permessi |

### Modelli Authentication Logs (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Authentication** | ✅ AuthenticationFactory | ❌ | Security - Log autenticazione |
| **AuthenticationLog** | ✅ AuthenticationLogFactory | ❌ | Security - Log dettagliato auth |

### Modelli OAuth & Social (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **OauthAccessToken** | ✅ OauthAccessTokenFactory | ❌ | OAuth - Token accesso |
| **OauthAuthCode** | ✅ OauthAuthCodeFactory | ❌ | OAuth - Codici autorizzazione |
| **OauthClient** | ✅ OauthClientFactory | ❌ | OAuth - Client applicazioni |
| **OauthPersonalAccessClient** | ✅ OauthPersonalAccessClientFactory | ❌ | OAuth - Client personali |
| **OauthRefreshToken** | ✅ OauthRefreshTokenFactory | ❌ | OAuth - Token refresh |
| **SocialiteUser** | ✅ SocialiteUserFactory | ❌ | Social - Utenti social login |
| **SocialProvider** | ✅ SocialProviderFactory | ❌ | Social - Provider social |

### Modelli Utility (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **PasswordReset** | ✅ PasswordResetFactory | ❌ | Security - Reset password |
| **Notification** | ✅ NotificationFactory | ❌ | System - Notifiche utente |
| **Extra** | ✅ ExtraFactory | ❌ | System - Metadati extra |
| **Feature** | ✅ FeatureFactory | ❌ | System - Feature flags |

### Modelli Device Management (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Device** | ✅ DeviceFactory | ❌ | Security - Dispositivi utente |
| **DeviceUser** | ✅ DeviceUserFactory | ❌ | Security - Relazione device-user |
| **DeviceProfile** | ✅ DeviceProfileFactory | ❌ | Security - Profili dispositivi |

### Modelli Jetstream (Utilizzati Condizionalmente)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Membership** | ✅ MembershipFactory | ❌ | Jetstream - Membership team |
| **TeamInvitation** | ✅ TeamInvitationFactory | ❌ | Jetstream - Inviti team |
| **TeamPermission** | ✅ TeamPermissionFactory | ❌ | Jetstream - Permessi team |
| **ProfileTeam** | ✅ ProfileTeamFactory | ❌ | Jetstream - Profilo-team |

### Modelli Base (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **BaseModel** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseUser** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseProfile** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseTeam** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseTenant** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseTeamUser** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BasePivot** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseMorphPivot** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseUuidModel** | ❌ | ❌ | Abstract - Non necessita factory/seeder |

### Modelli Trait/Behavior (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **BaseInteractsWithExtra** | ❌ | ❌ | Trait - Non necessita factory/seeder |
| **BaseInteractsWithTenant** | ❌ | ❌ | Trait - Non necessita factory/seeder |
| **BaseIsTenant** | ❌ | ❌ | Trait - Non necessita factory/seeder |

## Modelli Non Utilizzati/Problematici

### File Jetstream Duplicati
| File | Stato | Motivazione |
|------|-------|-------------|
| **Membership.Jetstream** | ⚠️ Duplicato | File alternativo per Jetstream |
| **Team.Jetstream** | ⚠️ Duplicato | File alternativo per Jetstream |
| **TeamInvitation.Jetstream** | ⚠️ Duplicato | File alternativo per Jetstream |

### File Test/Temporanei
| File | Stato | Motivazione |
|------|-------|-------------|
| **Project.test** | 🗑️ Test File | File di test da rimuovere |

## Seeder Mancanti Necessari

### Seeder Core da Creare
1. **ProfileSeeder** - Per profili utente di base
2. **TeamSeeder** - Per team di collaborazione
3. **TenantSeeder** - Per tenant multi-tenancy
4. **AuthenticationLogSeeder** - Per log autenticazione (opzionale)

### Seeder Pivot da Creare
1. **TeamUserSeeder** - Per relazioni team-utente
2. **TenantUserSeeder** - Per relazioni tenant-utente
3. **ModelHasPermissionSeeder** - Per permessi modello
4. **ModelHasRoleSeeder** - Per ruoli modello
5. **PermissionRoleSeeder** - Per permessi-ruoli
6. **PermissionUserSeeder** - Per permessi-utente

### Seeder OAuth da Creare (Opzionali)
1. **OauthClientSeeder** - Per client OAuth predefiniti
2. **SocialProviderSeeder** - Per provider social configurati

## Factory Mancanti (Nessuna)
Tutti i modelli attivi hanno le factory corrispondenti.

## Raccomandazioni

### Azioni Immediate
1. **Pulizia file duplicati**: Decidere quale versione Jetstream mantenere
2. **Rimozione file test**: Eliminare Project.test
3. **Creare seeder core**: Implementare ProfileSeeder, TeamSeeder, TenantSeeder
4. **Creare seeder pivot**: Implementare i seeder per le relazioni principali

### Azioni Future
1. **Seeder OAuth**: Valutare necessità seeder per OAuth se utilizzato
2. **Consolidamento**: Unificare seeder simili dove possibile
3. **Test coverage**: Assicurare test per tutti i modelli attivi
4. **Documentazione traits**: Documentare utilizzo dei trait base

## Struttura Seeder Esistenti

### Seeder Principali
- **UserDatabaseSeeder** - Seeder principale del modulo
- **UserSeeder** - Utenti base del sistema
- **PermissionsSeeder** - Permessi di sistema
- **RolesSeeder** - Ruoli di sistema

## Note Tecniche

### Pattern Factory Utilizzati
- **GetFactoryAction**: Pattern moderno per risoluzione automatica namespace
- **OAuth Support**: Factory per completo supporto OAuth2
- **Multi-tenancy**: Factory supportano architettura multi-tenant
- **Security Features**: Factory per autenticazione e logging sicurezza

### Architettura Multi-Tenant
Il modulo User implementa multi-tenancy attraverso:
- **Tenant Model**: Gestione tenant
- **TenantUser Pivot**: Relazioni utente-tenant
- **Trait Support**: BaseInteractsWithTenant per comportamenti comuni

### Sistema Permessi
Implementazione completa sistema permessi con:
- **Role-Based Access Control (RBAC)**
- **Permission-Based Access Control (PBAC)**
- **Model-Level Permissions**
- **Team-Level Permissions** (Jetstream)

### Validazione PHPStan
Tutti i file factory devono essere validati con PHPStan livello 9:
```bash
./vendor/bin/phpstan analyze Modules/User/database/factories --level=9
```

## Collegamenti

### Documentazione Correlata
- [Authentication System](./authentication_system.md)
- [Multi-Tenant Architecture](./multi_tenant_architecture.md)
- [Permissions & Roles](./permissions_roles.md)
- [OAuth Integration](./oauth_integration.md)
- [Jetstream Integration](./jetstream_integration.md)

### Moduli Collegati
- [SaluteOra Module](../../saluteora/docs/modelli_factory_seeder_analisi.md)
- [Tenant Module](../../tenant/docs/modelli_factory_seeder_analisi.md)
- [Notify Module](../../notify/docs/modelli_factory_seeder_analisi.md)

*Ultimo aggiornamento: Gennaio 2025*
*Analisi completa di 35+ modelli attivi, sistema completo authentication/authorization*
