# Passport Filament Cluster Proposal - User Module

**Data**: 2025-01-22
**Filosofia**: DRY + KISS + Organizzazione Logica
**Obiettivo**: Raggruppare tutte le risorse Passport/OAuth in un cluster Filament

---

## 🎯 Analisi Situazione Attuale

### Risorse Passport/OAuth Esistenti
Attualmente le risorse sono sparse nella navigazione:

1. **OauthClientResource** - Gestione client OAuth
2. **OauthAccessTokenResource** - Token di accesso
3. **OauthRefreshTokenResource** - Token di refresh
4. **OauthAuthCodeResource** - Authorization codes
5. **OauthPersonalAccessClientResource** - Personal access clients
6. **ClientResource** - Client generici (se diverso da OauthClient)

### Modelli Correlati
- `OauthClient` - Client OAuth
- `OauthAccessToken` / `OauthToken` - Token di accesso
- `OauthRefreshToken` - Token di refresh
- `OauthAuthCode` - Authorization codes
- `OauthPersonalAccessClient` - Personal access clients
- `OauthDeviceCode` - Device codes

### Relation Managers Esistenti
- `UserResource/RelationManagers/ClientsRelationManager` - Client dell'utente
- `UserResource/RelationManagers/OauthTokensRelationManager` - Token dell'utente

---

## 💡 Proposta: Cluster "Passport"

### Struttura Cluster Proposta

```
Passport (Cluster)
├── Clients
│   ├── OAuth Clients (OauthClientResource)
│   └── Personal Access Clients (OauthPersonalAccessClientResource)
├── Tokens
│   ├── Access Tokens (OauthAccessTokenResource)
│   ├── Refresh Tokens (OauthRefreshTokenResource)
│   └── Authorization Codes (OauthAuthCodeResource)
└── Settings
    └── OAuth Settings (Page per configurazione)
```

### Implementazione

#### 1. Creare Cluster Base

```php
// Modules/User/app/Filament/Clusters/Passport.php
namespace Modules\User\Filament\Clusters;

use Modules\Xot\Filament\Clusters\XotBaseCluster;

class Passport extends XotBaseCluster
{
    // Cluster minimale: le risorse OAuth vivono sotto app/Filament/Clusters/Passport/Resources
}
```

#### 2. Spostare Risorse nel Cluster

```php
// Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource.php
namespace Modules\User\Filament\Clusters\Passport\Resources;

use Modules\User\Filament\Clusters\Passport;
use Modules\Xot\Filament\Resources\XotBaseResource;

class OauthClientResource extends XotBaseResource
{
    protected static ?string $cluster = Passport::class;
}
```

#### 3. Creare Page Settings (Opzionale)

```php
// Modules/User/app/Filament/Clusters/OAuthApi/Pages/Settings.php
namespace Modules\User\Filament\Clusters\OAuthApi\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class Settings extends XotBasePage
{
    protected static ?string $navigationLabel = 'OAuth Settings';

    protected static ?int $navigationSort = 1;

    public function getFormSchema(): array
    {
        return [
            'token_expiration' => Section::make('Token Expiration')
                ->schema([
                    'access_token_expires_in' => TextInput::make('access_token_expires_in')
                        ->label('Access Token (days)')
                        ->default(15)
                        ->numeric(),
                    'refresh_token_expires_in' => TextInput::make('refresh_token_expires_in')
                        ->label('Refresh Token (days)')
                        ->default(30)
                        ->numeric(),
                    'personal_access_token_expires_in' => TextInput::make('personal_access_token_expires_in')
                        ->label('Personal Access Token (months)')
                        ->default(6)
                        ->numeric(),
                ]),
            'scopes' => Section::make('Available Scopes')
                ->schema([
                    // Gestione scopes disponibili
                ]),
        ];
    }
}
```

---

## 📋 Vantaggi del Cluster

### 1. Organizzazione Logica
- ✅ Tutte le risorse OAuth/OAuth in un unico posto
- ✅ Navigazione più chiara e intuitiva
- ✅ Separazione netta da altre funzionalità User

### 2. Manutenibilità
- ✅ Facile trovare e modificare risorse OAuth
- ✅ Pattern riusabile per future risorse API
- ✅ Coerenza architetturale

### 3. UX Migliorata
- ✅ Admin sa dove trovare tutto ciò che riguarda OAuth
- ✅ Cluster può avere icona e descrizione dedicata
- ✅ Possibilità di aggiungere pagine di configurazione

---

## 🔧 Implementazione Step-by-Step

### Step 1: Creare Cluster
```bash
php artisan make:filament-cluster Passport --module=User
```

### Step 2: Spostare Risorse
- Posizionare le risorse sotto `Modules/User/app/Filament/Clusters/Passport/Resources`
- Aggiungere `protected static ?string $cluster = Passport::class;` a ogni risorsa
- Verificare che navigation group sia corretto

### Step 3: Aggiornare Navigation
- Rimuovere navigation items individuali se necessario
- Cluster gestirà la navigazione

### Step 4: Test
- Verificare che tutte le risorse siano accessibili
- Testare CRUD operations
- Verificare permissions

---

## 📝 Checklist Implementazione

- [ ] Creare cluster `OAuthApi`
- [ ] Spostare `OauthClientResource` nel cluster
- [ ] Spostare `OauthAccessTokenResource` nel cluster
- [ ] Spostare `OauthRefreshTokenResource` nel cluster
- [ ] Spostare `OauthAuthCodeResource` nel cluster
- [ ] Spostare `OauthPersonalAccessClientResource` nel cluster
- [ ] Creare page Settings (opzionale)
- [ ] Aggiornare documentazione
- [ ] Testare navigazione
- [ ] Verificare permissions

---

## 🎯 Alternative Considerate

### Opzione A: Cluster Unico (SCELTA)
**Pro**: Organizzazione logica, navigazione chiara
**Contro**: Nessuno significativo

### Opzione B: Navigation Group
**Pro**: Più semplice da implementare
**Contro**: Meno organizzato, non raggruppa logicamente

### Opzione C: Widget Dashboard
**Pro**: Vista d'insieme rapida
**Contro**: Non sostituisce cluster, può essere aggiunto

**Decisione**: Opzione A - Cluster unico per massima organizzazione

---

**Ultimo aggiornamento**: 2025-01-22
**Versione**: 1.0.0
**Status**: Proposta - da implementare
