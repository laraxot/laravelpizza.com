# Filament 5.x Nested Resources - Opportunità di Applicazione

**Data Analisi**: 2026-01-22  
**Versione Filament**: 5.x  
**Documentazione Upstream**: https://filamentphp.com/docs/5.x/resources/nesting

## Scopo del Documento

Questo documento identifica dove e perché applicare il nesting nativo di Filament 5.x nel modulo User per gestire relazioni gerarchiche (User → Team, Team → TeamInvitation, User → Role/Permission).

## Panoramica Filament 5.x Nesting

### Cos'è il Nesting

Il nesting in Filament 5.x permette di creare risorse figlie con pagine complete invece di essere gestite solo tramite modal nei relation managers.

**Vantaggi per User Module**:
- **Gerarchia Chiara**: Riflette relazioni User → Team → Invitations
- **Navigazione Logica**: URL che seguono la gerarchia organizzativa
- **Form Complessi**: Team e Invitations hanno configurazioni complesse
- **Context Preservation**: Mantiene sempre il contesto del parent

## Relazioni Modulo User

### Schema Relazioni

```
User
├── Team (n:n) - Teams a cui appartiene
│   ├── TeamInvitation (1:n) - Inviti team
│   └── TeamUser (pivot) - Ruolo nel team
├── Role (n:n) - Ruoli assegnati
├── Permission (n:n) - Permessi diretti
└── Tenant (n:n) - Tenants a cui appartiene
```

## Opportunità di Nesting

### 1. TeamInvitation come Nested Resource di Team

**Stato Attuale**: 
- TeamInvitation gestito tramite relation manager
- Form semplice ma workflow complesso

**Perché Nestare**:
- ✅ **Workflow Complesso**: Invitation ha processo multi-step (creazione, invio, accettazione)
- ✅ **Gestione Dedicata**: Invitation ha stati e tracking
- ✅ **Navigazione Logica**: URL `/teams/{id}/invitations` più intuitivo
- ✅ **Azioni Multiple**: Resend, cancel, revoke invitations

**Implementazione**:

```php
// TeamInvitationResource.php
class TeamInvitationResource extends XotBaseResource
{
    protected static ?string $parentResource = TeamResource::class;
    
    public static function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required(),
            'role' => Select::make('role')
                ->options(Role::pluck('name', 'id'))
                ->required(),
        ];
    }
}
```

**Comando**:
```bash
php artisan make:filament-resource TeamInvitation --nested --module=User
```

**Priorità**: 🟡 **ALTA** - Migliora gestione inviti team

### 2. TeamUser (Pivot) come Nested Resource di Team

**Stato Attuale**: 
- TeamUser gestito tramite relation manager
- Form semplice (solo ruolo)

**Perché Nestare**:
- ✅ **Form Dedicato**: Gestione ruolo nel team
- ✅ **Navigazione Logica**: URL `/teams/{id}/members`
- ✅ **Workflow Dedicato**: Aggiunta/rimozione membri, cambio ruolo

**Nota**: 
- Se form rimane semplice, relation manager può essere sufficiente
- Nesting utile se si aggiungono più campi pivot o workflow complessi

**Priorità**: 🟢 **MEDIA** - Dipende da complessità futura

### 3. Team come Nested Resource di User (Opzionale)

**Stato Attuale**: 
- Team gestito come resource standalone
- Relazione many-to-many con User

**Perché Nestare** (Opzionale):
- ✅ **Gerarchia Logica**: Team appartiene a User (owner)
- ✅ **Navigazione Logica**: URL `/users/{id}/teams`
- ✅ **Isolamento**: Ogni user vede solo i propri teams

**Considerazioni**:
- Team può essere condiviso tra più users
- Gestione standalone può essere più appropriata
- Valutare caso d'uso specifico

**Priorità**: 🟢 **BASSA** - Valutare caso d'uso

## Relazioni da NON Nestare

### 1. Role e Permission

**Motivazione**: 
- Relazioni many-to-many
- Gestione tramite relation manager è appropriata
- Non serve pagina dedicata per ruolo/permesso

**Alternativa**: Continuare con `RelationManager`

### 2. Tenant

**Motivazione**:
- Relazione many-to-many
- Tenant è entità standalone
- Gestione standalone è appropriata

**Alternativa**: Continuare con resource standalone

## URL Structure

Dopo il nesting, gli URL saranno:

```
/teams/{teamId}
  /invitations/{invitationId}
  /members/{memberId}  (se implementato)
```

**Vantaggi**:
- ✅ Gerarchia chiara e navigabile
- ✅ Context sempre preservato
- ✅ Breadcrumbs automatici
- ✅ Filtraggio automatico per parent

## Implementazione Step-by-Step

### Step 1: Creare TeamInvitation Nested Resource

```bash
php artisan make:filament-resource TeamInvitation --nested --module=User
```

```php
// TeamInvitationResource.php
class TeamInvitationResource extends XotBaseResource
{
    protected static ?string $parentResource = TeamResource::class;
    
    public static function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required(),
            'role' => Select::make('role')
                ->relationship('role', 'name')
                ->required(),
        ];
    }
}
```

### Step 2: Creare Relation Manager per Invitations

```bash
php artisan make:filament-relation-manager TeamResource invitations email
# Rispondere "yes" quando chiede di linkare a nested resource
# Selezionare TeamInvitationResource
```

### Step 3: Aggiornare Pagine Nested

```php
// ListTeamInvitations.php
class ListTeamInvitations extends XotBaseListRecords
{
    protected function getTableQuery(): Builder
    {
        $query = static::getResource()::getEloquentQuery();
        
        $team = $this->getParentRecord();
        if ($team instanceof Team) {
            $query = $query->where('team_id', $team->id);
        }
        
        return $query;
    }
}
```

## Customizzazione Relationship Names

Se necessario, personalizzare nomi relazioni:

```php
// TeamInvitationResource.php
use Filament\Resources\ParentResourceRegistration;

public static function getParentResourceRegistration(): ?ParentResourceRegistration
{
    return TeamResource::asParent()
        ->relationship('teamInvitations')  // Nome relazione nel parent
        ->inverseRelationship('team');  // Nome relazione inversa nel child
}
```

## Priorità Implementazione

### 🔴 CRITICA (Implementare Subito)

Nessuna funzionalità critica - il modulo User funziona bene con relation managers

### 🟡 ALTA (Implementare a Breve)

1. **TeamInvitation Nested Resource** - Migliora UX gestione inviti

### 🟢 MEDIA (Implementare Quando Possibile)

1. **TeamUser Nested Resource** - Se form diventa complesso
2. **Team Nested Resource** - Valutare caso d'uso

## Checklist Implementazione

### Per TeamInvitation Nested Resource

- [ ] Creare nested resource TeamInvitation
- [ ] Aggiungere `$parentResource = TeamResource::class`
- [ ] Creare relation manager per invitations
- [ ] Implementare form schema completo
- [ ] Gestire workflow invio inviti
- [ ] Testare navigazione e breadcrumbs
- [ ] Aggiornare documentazione

## Collegamenti

- [Filament 5.x Nesting Documentation](https://filamentphp.com/docs/5.x/resources/nesting)
- [User Module README](./readme.md)
- [Team System](./architecture/teams.md)
- [Authentication Guide](./auth/authentication-flow.md)

---

**Ultimo Aggiornamento**: 2026-01-22  
**Prossima Revisione**: 2026-02-22
