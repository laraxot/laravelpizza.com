# Redundancy Report — Modulo User

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Problemi Trovati

### 1. 🔴 Oauth Resources — 5 risorse duplicate (Cluster vs Standalone)

Il modulo User contiene **due copie complete** delle risorse Oauth: una nel Cluster `Passport` e una standalone in `Resources/`.

| Resource | Cluster (`Clusters/Passport/Resources/`) | Standalone (`Resources/`) |
|----------|------------------------------------------|--------------------------|
| OauthAccessTokenResource | ✅ | ✅ duplicato |
| OauthAuthCodeResource | ✅ | ✅ duplicato |
| OauthClientResource | ✅ | ✅ duplicato |
| OauthPersonalAccessClientResource | ✅ | ✅ duplicato |
| OauthRefreshTokenResource | ✅ | ✅ duplicato |
| OauthDeviceCodeResource | ✅ | ❌ solo nel Cluster |

Ogni resource ha sottocartelle `Pages/`, `Schemas/`, `Tables/` con le rispettive classi (Form, Infolist, Table, Create, Edit, List, View), raddoppiando il costo di manutenzione.

**Azione suggerita**: Eliminare le copie standalone in `Resources/Oauth*` e usare solo il Cluster `Passport/`. Aggiornare eventuali riferimenti.

### 2. 🔴 BasePivot NON estende XotBasePivot

**File**: `app/Models/BasePivot.php`

```php
// ATTUALE (NON conforme)
abstract class BasePivot extends Pivot
{
    use Updater;
}

// CORRETTO
abstract class BasePivot extends XotBasePivot {}
```

### 3. 🟠 ProfileResource duplicato con Blog e Gdpr

`ProfileResource` esiste in 4 copie tra 3 moduli:

| Modulo | Path |
|--------|------|
| **User** | `app/Filament/Resources/ProfileResource.php` |
| Blog | `Modules/Blog/app/Filament/Resources/ProfileResource.php` |
| Gdpr (Cluster) | `Modules/Gdpr/app/Filament/Clusters/Profile/Resources/ProfileResource.php` |
| Gdpr (Standalone) | `Modules/Gdpr/app/Filament/Resources/ProfileResource.php` |

**Azione suggerita**: La versione canonica del ProfileResource dovrebbe vivere in User (owner del modello Profile). Gli altri moduli dovrebbero referenziare il resource di User via navigation group o cluster, non duplicare l'intera struttura.

### 4. 🟡 EventServiceProvider usa XotBaseEventServiceProvider (conforme)

Il modulo User è uno dei 3 moduli che usa correttamente `XotBaseEventServiceProvider`. Nessuna azione richiesta.

### 5. 🟡 Appearance Cluster duplicato con Cms

| Modulo | Path |
|--------|------|
| User | `app/Filament/Clusters/Appearance.php` |
| Cms | `Modules/Cms/app/Filament/Clusters/Appearance.php` |

Verificare se entrambi i Cluster sono necessari o se uno dovrebbe fare reference all'altro.

## Impatto Quantitativo

La duplicazione Oauth genera circa **60+ file PHP duplicati** tra Pages, Schemas, Tables per le 5 risorse. Questa è la ridondanza più costosa dell'intero codebase in termini di manutenzione.

## Riepilogo

| Priorità | Problema | File interessati |
|----------|----------|-----------------|
| 🔴 | Oauth Resources duplicati (Cluster vs Standalone) | ~60 file |
| 🔴 | BasePivot non conforme | 1 file |
| 🟠 | ProfileResource duplicato cross-modulo | 4 copie |
| 🟡 | Appearance Cluster duplicato | 2 copie |
