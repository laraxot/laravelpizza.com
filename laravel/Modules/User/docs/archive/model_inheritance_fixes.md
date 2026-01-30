# Correzioni Ereditarietà Modelli - Modulo User

## Data Implementazione
15 Ottobre 2025

## Obiettivo
Correggere tutti i modelli del modulo User che estendevano direttamente `Illuminate\Database\Eloquent\Model` per farli estendere le classi base corrette del modulo.

## Modelli Corretti

### 1. Tenant.php
**Prima:**
```php
class Tenant extends Model
```

**Dopo:**
```php
class Tenant extends BaseModel
```

**Motivazione:** Modello standard che rappresenta un'entità tenant.

---

### 2. TeamUser.php
**Prima:**
```php
class TeamUser extends Model
```

**Dopo:**
```php
class TeamUser extends BasePivot
```

**Motivazione:** Tabella pivot per la relazione many-to-many tra User e Team.

---

### 3. TeamInvitation.php
**Prima:**
```php
class TeamInvitation extends Model
```

**Dopo:**
```php
class TeamInvitation extends BaseModel
```

**Motivazione:** Modello standard per gli inviti ai team.

---

### 4. TeamPermission.php
**Prima:**
```php
class TeamPermission extends Model
```

**Dopo:**
```php
class TeamPermission extends BaseModel
```

**Motivazione:** Modello standard per i permessi dei team.

---

### 5. Authentication.php
**Prima:**
```php
class Authentication extends Model
```

**Dopo:**
```php
class Authentication extends BaseModel
```

**Motivazione:** Modello standard per il logging delle autenticazioni.

---

### 6. SsoProvider.php
**Prima:**
```php
class SsoProvider extends Model
```

**Dopo:**
```php
class SsoProvider extends BaseModel
```

**Motivazione:** Modello standard per i provider SSO.

---

### 7. OauthClient.php
**Prima:**
```php
class OauthClient extends Model
```

**Dopo:**
```php
class OauthClient extends BaseModel
```

**Motivazione:** Modello standard per i client OAuth.

---

## Modelli Già Corretti

- ✅ **ModelHasRole** → estende `BaseMorphPivot` (corretto, ha colonne morph)
- ✅ **PermissionUser** → estende `ModelHasPermission` (corretto, eredita da base corretta)

## Benefici delle Correzioni

### 1. Centralizzazione
- La proprietà `$connection = 'user'` è ora definita solo in `BaseModel`, `BasePivot` e `BaseMorphPivot`
- Non serve più ripeterla in ogni modello

### 2. Consistenza
- Tutti i modelli del modulo seguono la stessa gerarchia
- Cast e configurazioni comuni sono centralizzate

### 3. Manutenibilità
- Modifiche future alle configurazioni base si applicano automaticamente a tutti i modelli
- Riduzione della duplicazione del codice

### 4. PHPStan
- Migliore compatibilità con l'analisi statica
- Le classi base personalizzate sono riconosciute correttamente

## Gerarchia Finale

```
Illuminate\Database\Eloquent\Model
    └── Modules\Xot\Models\XotBaseModel
        └── Modules\User\Models\BaseModel
            ├── Tenant
            ├── TeamInvitation
            ├── TeamPermission
            ├── Authentication
            ├── SsoProvider
            └── OauthClient

Illuminate\Database\Eloquent\Relations\Pivot
    └── Modules\Xot\Models\XotBasePivot
        └── Modules\User\Models\BasePivot
            └── TeamUser

Illuminate\Database\Eloquent\Relations\MorphPivot
    └── Modules\Xot\Models\XotBaseMorphPivot
        └── Modules\User\Models\BaseMorphPivot
            └── ModelHasRole
```

## Verifica

Per verificare che non ci siano più modelli che estendono direttamente `Model`:

```bash
cd /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User
grep -r "extends Model" app/Models/ --include="*.php" | grep -v "BaseModel\|BasePivot\|BaseMorphPivot"
```

## Test PHPStan

Dopo le modifiche, eseguire:

```bash
cd /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules/User
./vendor/bin/phpstan analyse --memory-limit=2G
```

## Prossimi Passi

1. ✅ Verificare che tutti i modelli siano corretti
2. ⏳ Eseguire PHPStan per verificare assenza di errori
3. ⏳ Applicare lo stesso pattern agli altri moduli (Patient, Dental, ecc.)
4. ⏳ Aggiornare la documentazione dei moduli

## Collegamenti

- [Analisi Completa](./MODEL_INHERITANCE_ANALYSIS.md)
- [Regole Qualità Codice](../../../.windsurf/rules/code-quality.md)
- [BaseModel](../app/Models/BaseModel.php)
- [BasePivot](../app/Models/BasePivot.php)
- [BaseMorphPivot](../app/Models/BaseMorphPivot.php)
