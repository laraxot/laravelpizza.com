# Audit Ereditarietà Modelli - Tutti i Moduli

## Data Audit
15 Ottobre 2025

## Obiettivo
Verificare che tutti i modelli nei moduli estendano le classi base corrette (`BaseModel`, `BasePivot`, `BaseMorphPivot`) invece di `Illuminate\Database\Eloquent\Model` direttamente.

## Stato Moduli

### ✅ Moduli Corretti

#### Activity
- **Stato**: ✅ Tutti i modelli estendono `BaseModel`
- **BaseModel**: Presente ed estende `XotBaseModel`

#### Gdpr
- **Stato**: ✅ Tutti i modelli estendono `BaseModel`
- **BaseModel**: Presente ed estende `XotBaseModel`
- **BasePivot**: Presente
- **BaseMorphPivot**: Presente

#### UI
- **Stato**: ✅ Tutti i modelli estendono `BaseModel`
- **BaseModel**: Presente ed estende `XotBaseModel`

#### User
- **Stato**: ✅ **CORRETTO** (15 Ottobre 2025)
- **Modelli corretti**: 7 (Tenant, TeamUser, TeamInvitation, TeamPermission, Authentication, SsoProvider, OauthClient)
- **Documentazione**: [MODEL_INHERITANCE_FIXES.md](../../user/docs/model_inheritance_fixes.md)

---

### ⚠️ Moduli con Problemi

#### Cms
**BaseModel**: ❌ Estende direttamente `Model` invece di `XotBaseModel`

**Modelli da correggere**:
- `Conf.php` → Estende `Model`, dovrebbe estendere `BaseModel`
  - **Nota**: Usa trait `Sushi` per dati in-memory

**Azione richiesta**:
```php
// BaseModel.php - CORREGGERE
abstract class BaseModel extends Model  // ❌
// DEVE ESSERE:
abstract class BaseModel extends \Modules\Xot\Models\XotBaseModel  // ✅
```

---

#### Chart
**BaseModel**: ❌ Estende direttamente `Model` invece di `XotBaseModel`

**Azione richiesta**:
```php
// BaseModel.php - CORREGGERE
abstract class BaseModel extends Model  // ❌
// DEVE ESSERE:
abstract class BaseModel extends \Modules\Xot\Models\XotBaseModel  // ✅
```

---

#### Geo
**BaseModel**: ❌ Estende direttamente `Model` invece di `XotBaseModel`

**Modelli da correggere**:
- `GeoNamesCap.php` → Estende `Model`, dovrebbe estendere `BaseModel`

**Azione richiesta**:
```php
// BaseModel.php - CORREGGERE
abstract class BaseModel extends Model  // ❌
// DEVE ESSERE:
abstract class BaseModel extends \Modules\Xot\Models\XotBaseModel  // ✅

// GeoNamesCap.php - CORREGGERE
class GeoNamesCap extends Model  // ❌
// DEVE ESSERE:
class GeoNamesCap extends BaseModel  // ✅
```

---

#### Job
**BaseModel**: Presente ed estende `XotBaseModel` ✅

**Modelli da correggere**:
- `TaskComment.php` → Estende `Model`, dovrebbe estendere `BaseModel`

**Azione richiesta**:
```php
// TaskComment.php - CORREGGERE
class TaskComment extends Model  // ❌
// DEVE ESSERE:
class TaskComment extends BaseModel  // ✅
```

---

#### Lang
**BaseModel**: Presente ed estende `XotBaseModel` ✅

**Modelli da correggere**:
- `BaseModelLang.php` → Estende `Model`, dovrebbe estendere `BaseModel`
- `Post.php.fixed` → File di backup, estende `Model`
- `post.php.fixed` → File di backup, estende `Model`

**Azione richiesta**:
```php
// BaseModelLang.php - CORREGGERE
abstract class BaseModelLang extends Model  // ❌
// DEVE ESSERE:
abstract class BaseModelLang extends BaseModel  // ✅
```

**Nota**: I file `.fixed` sono backup e possono essere ignorati o rimossi.

---

#### Media
**BaseModel**: Presente ed estende `XotBaseModel` ✅

**Modelli da correggere**:
- `TemporaryUpload.php` → Estende `Model`, dovrebbe estendere `BaseModel`
  - **Nota**: Implementa `HasMedia` di Spatie

**Azione richiesta**:
```php
// TemporaryUpload.php - CORREGGERE
class TemporaryUpload extends Model implements HasMedia  // ❌
// DEVE ESSERE:
class TemporaryUpload extends BaseModel implements HasMedia  // ✅
```

---

#### Notify
**BaseModel**: Presente ed estende `XotBaseModel` ✅

**Modelli da correggere**:
- `NotificationLog.php.old4` → File di backup, estende `Model`

**Nota**: Il file `.old4` è un backup e può essere ignorato o rimosso.

---

<<<<<<< .merge_file_a0qsiM
#### healthcare_app
=======
<<<<<<< HEAD
#### ModuloEsempio
=======
#### ExternalProject
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_7g3Jt6
**BaseModel**: ❌ Estende direttamente `Model` invece di `XotBaseModel`

**Modelli da correggere**:
- `ContactSimple.php` → Estende `Model`, dovrebbe estendere `BaseModel`

**Azione richiesta**:
```php
// BaseModel.php - CORREGGERE
abstract class BaseModel extends Model implements ModelContract, HasMedia  // ❌
// DEVE ESSERE:
abstract class BaseModel extends \Modules\Xot\Models\XotBaseModel implements ModelContract, HasMedia  // ✅

// ContactSimple.php - CORREGGERE
class ContactSimple extends Model  // ❌
// DEVE ESSERE:
class ContactSimple extends BaseModel  // ✅
```

---

#### Tenant
**BaseModel**: Presente ed estende `XotBaseModel` ✅

**Modelli da correggere**:
- `TestSushiModel.php` → Estende `Model`, dovrebbe estendere `BaseModel`
  - **Nota**: Usa trait `SushiToJson` per dati in-memory

**Azione richiesta**:
```php
// TestSushiModel.php - CORREGGERE
class TestSushiModel extends Model  // ❌
// DEVE ESSERE:
class TestSushiModel extends BaseModel  // ✅
```

---

## Riepilogo Statistiche

### Moduli con BaseModel Corretto
- ✅ Activity
- ✅ Gdpr
- ✅ Job
- ✅ Lang
- ✅ Media
- ✅ Notify
- ✅ Tenant
- ✅ UI
- ✅ User

**Totale**: 9/13 moduli (69%)

### Moduli con BaseModel da Correggere
- ❌ Cms
- ❌ Chart
- ❌ Geo
<<<<<<< .merge_file_a0qsiM
- ❌ healthcare_app
=======
<<<<<<< HEAD
- ❌ ModuloEsempio
=======
- ❌ ExternalProject
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_7g3Jt6

**Totale**: 4/13 moduli (31%)

### Modelli Individuali da Correggere

| Modulo | File | Tipo Problema |
|--------|------|---------------|
| Cms | `BaseModel.php` | Estende `Model` invece di `XotBaseModel` |
| Cms | `Conf.php` | Estende `Model` invece di `BaseModel` |
| Chart | `BaseModel.php` | Estende `Model` invece di `XotBaseModel` |
| Geo | `BaseModel.php` | Estende `Model` invece di `XotBaseModel` |
| Geo | `GeoNamesCap.php` | Estende `Model` invece di `BaseModel` |
| Job | `TaskComment.php` | Estende `Model` invece di `BaseModel` |
| Lang | `BaseModelLang.php` | Estende `Model` invece di `BaseModel` |
| Media | `TemporaryUpload.php` | Estende `Model` invece di `BaseModel` |
<<<<<<< .merge_file_a0qsiM
| healthcare_app | `BaseModel.php` | Estende `Model` invece di `XotBaseModel` |
| healthcare_app | `ContactSimple.php` | Estende `Model` invece di `BaseModel` |
=======
<<<<<<< HEAD
| ModuloEsempio | `BaseModel.php` | Estende `Model` invece di `XotBaseModel` |
| ModuloEsempio | `ContactSimple.php` | Estende `Model` invece di `BaseModel` |
=======
| ExternalProject | `BaseModel.php` | Estende `Model` invece di `XotBaseModel` |
| ExternalProject | `ContactSimple.php` | Estende `Model` invece di `BaseModel` |
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_7g3Jt6
| Tenant | `TestSushiModel.php` | Estende `Model` invece di `BaseModel` |

**Totale**: 11 file da correggere

### File di Backup da Ignorare/Rimuovere
- `Lang/Post.php.fixed`
- `Lang/post.php.fixed`
- `Notify/NotificationLog.php.old4`

---

## Priorità di Intervento

### 🔴 Alta Priorità
1. **Cms** - BaseModel e Conf (modulo core per contenuti)
<<<<<<< .merge_file_a0qsiM
2. **healthcare_app** - BaseModel e ContactSimple (modulo specifico del progetto)
=======
<<<<<<< HEAD
2. **ModuloEsempio** - BaseModel e ContactSimple (modulo specifico del progetto)
=======
2. **ExternalProject** - BaseModel e ContactSimple (modulo specifico del progetto)
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_7g3Jt6

### 🟡 Media Priorità
3. **Chart** - BaseModel
4. **Geo** - BaseModel e GeoNamesCap
5. **Job** - TaskComment
6. **Media** - TemporaryUpload

### 🟢 Bassa Priorità
7. **Lang** - BaseModelLang (classe astratta secondaria)
8. **Tenant** - TestSushiModel (modello di test)

---

## Script di Verifica

Per verificare tutti i moduli:

```bash
#!/bin/bash
cd Modules

for module in */; do
    echo "=== Checking $module ==="
    grep -r "extends Model" "$module/app/Models/" --include="*.php" 2>/dev/null | \
        grep -v "BaseModel\|BasePivot\|BaseMorphPivot\|\.bak\|\.backup\|\.old\|\.fixed" || echo "✅ OK"
done
```

---

## Prossimi Passi

1. ✅ **User** - Completato (15 Ottobre 2025)
2. ⏳ **Cms** - Da correggere (BaseModel + Conf)
<<<<<<< .merge_file_a0qsiM
3. ⏳ **healthcare_app** - Da correggere (BaseModel + ContactSimple)
=======
<<<<<<< HEAD
3. ⏳ **ModuloEsempio** - Da correggere (BaseModel + ContactSimple)
=======
3. ⏳ **ExternalProject** - Da correggere (BaseModel + ContactSimple)
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_7g3Jt6
4. ⏳ **Chart** - Da correggere (BaseModel)
5. ⏳ **Geo** - Da correggere (BaseModel + GeoNamesCap)
6. ⏳ **Job** - Da correggere (TaskComment)
7. ⏳ **Media** - Da correggere (TemporaryUpload)
8. ⏳ **Lang** - Da correggere (BaseModelLang)
9. ⏳ **Tenant** - Da correggere (TestSushiModel)
10. ⏳ Pulizia file di backup

---

## Note Tecniche

### Casi Speciali

#### Modelli Sushi (In-Memory)
- `Cms/Conf.php` - Usa trait `Sushi`
- `Tenant/TestSushiModel.php` - Usa trait `SushiToJson`

Questi modelli possono comunque estendere `BaseModel` senza problemi.

#### Modelli con HasMedia
<<<<<<< .merge_file_a0qsiM
- `healthcare_app/BaseModel.php` - Implementa `HasMedia`
=======
<<<<<<< HEAD
- `ModuloEsempio/BaseModel.php` - Implementa `HasMedia`
=======
- `ExternalProject/BaseModel.php` - Implementa `HasMedia`
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_7g3Jt6
- `Media/TemporaryUpload.php` - Implementa `HasMedia`

`XotBaseModel` è compatibile con `HasMedia` di Spatie.

#### Classi Astratte Secondarie
- `Lang/BaseModelLang.php` - Classe astratta per modelli multilingua

Dovrebbe estendere `BaseModel` del modulo Lang.

---

## Collegamenti

- [DRY/KISS Analysis](../../../../dry_kiss_analysis.md) - **Analisi completa duplicazioni e piano refactoring**
- [DRY/KISS Refactoring](./dry_kiss_refactoring.md) - **Guida rapida refactoring**
- [User Module Fixes](../../user/docs/model_inheritance_fixes.md)
- [User Module Analysis](../../user/docs/model_inheritance_analysis.md)
- [Code Quality Rules](../../../.windsurf/rules/code-quality.md)
- [XotBaseModel](../app/Models/XotBaseModel.php)
- [XotBasePivot](../app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../app/Models/XotBaseMorphPivot.php)
# Audit Ereditarietà Modelli - Tutti i Moduli

## Data Audit
15 Ottobre 2025

## Obiettivo
Verificare che tutti i modelli nei moduli estendano le classi base corrette (`BaseModel`, `BasePivot`, `BaseMorphPivot`) invece di `Illuminate\Database\Eloquent\Model` direttamente.

## Stato Moduli

### ✅ Moduli Corretti

#### Activity
- **Stato**: ✅ Tutti i modelli estendono `BaseModel`
- **BaseModel**: Presente ed estende `XotBaseModel`

#### Gdpr
- **Stato**: ✅ Tutti i modelli estendono `BaseModel`
- **BaseModel**: Presente ed estende `XotBaseModel`
- **BasePivot**: Presente
- **BaseMorphPivot**: Presente

#### UI
- **Stato**: ✅ Tutti i modelli estendono `BaseModel`
- **BaseModel**: Presente ed estende `XotBaseModel`

#### User
- **Stato**: ✅ **CORRETTO** (15 Ottobre 2025)
- **Modelli corretti**: 7 (Tenant, TeamUser, TeamInvitation, TeamPermission, Authentication, SsoProvider, OauthClient)
- **Documentazione**: [MODEL_INHERITANCE_FIXES.md](../../user/docs/model_inheritance_fixes.md)

---

### ⚠️ Moduli con Problemi

#### Cms
**BaseModel**: ❌ Estende direttamente `Model` invece di `XotBaseModel`

**Modelli da correggere**:
- `Conf.php` → Estende `Model`, dovrebbe estendere `BaseModel`
  - **Nota**: Usa trait `Sushi` per dati in-memory

**Azione richiesta**:
```php
// BaseModel.php - CORREGGERE
abstract class BaseModel extends Model  // ❌
// DEVE ESSERE:
abstract class BaseModel extends \Modules\Xot\Models\XotBaseModel  // ✅
```

---

#### Chart
**BaseModel**: ❌ Estende direttamente `Model` invece di `XotBaseModel`

**Azione richiesta**:
```php
// BaseModel.php - CORREGGERE
abstract class BaseModel extends Model  // ❌
// DEVE ESSERE:
abstract class BaseModel extends \Modules\Xot\Models\XotBaseModel  // ✅
```

---

#### Geo
**BaseModel**: ❌ Estende direttamente `Model` invece di `XotBaseModel`

**Modelli da correggere**:
- `GeoNamesCap.php` → Estende `Model`, dovrebbe estendere `BaseModel`

**Azione richiesta**:
```php
// BaseModel.php - CORREGGERE
abstract class BaseModel extends Model  // ❌
// DEVE ESSERE:
abstract class BaseModel extends \Modules\Xot\Models\XotBaseModel  // ✅

// GeoNamesCap.php - CORREGGERE
class GeoNamesCap extends Model  // ❌
// DEVE ESSERE:
class GeoNamesCap extends BaseModel  // ✅
```

---

#### Job
**BaseModel**: Presente ed estende `XotBaseModel` ✅

**Modelli da correggere**:
- `TaskComment.php` → Estende `Model`, dovrebbe estendere `BaseModel`

**Azione richiesta**:
```php
// TaskComment.php - CORREGGERE
class TaskComment extends Model  // ❌
// DEVE ESSERE:
class TaskComment extends BaseModel  // ✅
```

---

#### Lang
**BaseModel**: Presente ed estende `XotBaseModel` ✅

**Modelli da correggere**:
- `BaseModelLang.php` → Estende `Model`, dovrebbe estendere `BaseModel`
- `Post.php.fixed` → File di backup, estende `Model`
- `post.php.fixed` → File di backup, estende `Model`

**Azione richiesta**:
```php
// BaseModelLang.php - CORREGGERE
abstract class BaseModelLang extends Model  // ❌
// DEVE ESSERE:
abstract class BaseModelLang extends BaseModel  // ✅
```

**Nota**: I file `.fixed` sono backup e possono essere ignorati o rimossi.

---

#### Media
**BaseModel**: Presente ed estende `XotBaseModel` ✅

**Modelli da correggere**:
- `TemporaryUpload.php` → Estende `Model`, dovrebbe estendere `BaseModel`
  - **Nota**: Implementa `HasMedia` di Spatie

**Azione richiesta**:
```php
// TemporaryUpload.php - CORREGGERE
class TemporaryUpload extends Model implements HasMedia  // ❌
// DEVE ESSERE:
class TemporaryUpload extends BaseModel implements HasMedia  // ✅
```

---

#### Notify
**BaseModel**: Presente ed estende `XotBaseModel` ✅

**Modelli da correggere**:
- `NotificationLog.php.old4` → File di backup, estende `Model`

**Nota**: Il file `.old4` è un backup e può essere ignorato o rimosso.

---

<<<<<<< .merge_file_a0qsiM
#### healthcare_app
=======
<<<<<<< HEAD
#### ModuloEsempio
=======
#### ExternalProject
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_7g3Jt6
**BaseModel**: ❌ Estende direttamente `Model` invece di `XotBaseModel`

**Modelli da correggere**:
- `ContactSimple.php` → Estende `Model`, dovrebbe estendere `BaseModel`

**Azione richiesta**:
```php
// BaseModel.php - CORREGGERE
abstract class BaseModel extends Model implements ModelContract, HasMedia  // ❌
// DEVE ESSERE:
abstract class BaseModel extends \Modules\Xot\Models\XotBaseModel implements ModelContract, HasMedia  // ✅

// ContactSimple.php - CORREGGERE
class ContactSimple extends Model  // ❌
// DEVE ESSERE:
class ContactSimple extends BaseModel  // ✅
```

---

#### Tenant
**BaseModel**: Presente ed estende `XotBaseModel` ✅

**Modelli da correggere**:
- `TestSushiModel.php` → Estende `Model`, dovrebbe estendere `BaseModel`
  - **Nota**: Usa trait `SushiToJson` per dati in-memory

**Azione richiesta**:
```php
// TestSushiModel.php - CORREGGERE
class TestSushiModel extends Model  // ❌
// DEVE ESSERE:
class TestSushiModel extends BaseModel  // ✅
```

---

## Riepilogo Statistiche

### Moduli con BaseModel Corretto
- ✅ Activity
- ✅ Gdpr
- ✅ Job
- ✅ Lang
- ✅ Media
- ✅ Notify
- ✅ Tenant
- ✅ UI
- ✅ User

**Totale**: 9/13 moduli (69%)

### Moduli con BaseModel da Correggere
- ❌ Cms
- ❌ Chart
- ❌ Geo
<<<<<<< .merge_file_a0qsiM
- ❌ healthcare_app
=======
<<<<<<< HEAD
- ❌ ModuloEsempio
=======
- ❌ ExternalProject
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_7g3Jt6

**Totale**: 4/13 moduli (31%)

### Modelli Individuali da Correggere

| Modulo | File | Tipo Problema |
|--------|------|---------------|
| Cms | `BaseModel.php` | Estende `Model` invece di `XotBaseModel` |
| Cms | `Conf.php` | Estende `Model` invece di `BaseModel` |
| Chart | `BaseModel.php` | Estende `Model` invece di `XotBaseModel` |
| Geo | `BaseModel.php` | Estende `Model` invece di `XotBaseModel` |
| Geo | `GeoNamesCap.php` | Estende `Model` invece di `BaseModel` |
| Job | `TaskComment.php` | Estende `Model` invece di `BaseModel` |
| Lang | `BaseModelLang.php` | Estende `Model` invece di `BaseModel` |
| Media | `TemporaryUpload.php` | Estende `Model` invece di `BaseModel` |
<<<<<<< .merge_file_a0qsiM
| healthcare_app | `BaseModel.php` | Estende `Model` invece di `XotBaseModel` |
| healthcare_app | `ContactSimple.php` | Estende `Model` invece di `BaseModel` |
=======
<<<<<<< HEAD
| ModuloEsempio | `BaseModel.php` | Estende `Model` invece di `XotBaseModel` |
| ModuloEsempio | `ContactSimple.php` | Estende `Model` invece di `BaseModel` |
=======
| ExternalProject | `BaseModel.php` | Estende `Model` invece di `XotBaseModel` |
| ExternalProject | `ContactSimple.php` | Estende `Model` invece di `BaseModel` |
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_7g3Jt6
| Tenant | `TestSushiModel.php` | Estende `Model` invece di `BaseModel` |

**Totale**: 11 file da correggere

### File di Backup da Ignorare/Rimuovere
- `Lang/Post.php.fixed`
- `Lang/post.php.fixed`
- `Notify/NotificationLog.php.old4`

---

## Priorità di Intervento

### 🔴 Alta Priorità
1. **Cms** - BaseModel e Conf (modulo core per contenuti)
<<<<<<< .merge_file_a0qsiM
2. **healthcare_app** - BaseModel e ContactSimple (modulo specifico del progetto)
=======
<<<<<<< HEAD
2. **ModuloEsempio** - BaseModel e ContactSimple (modulo specifico del progetto)
=======
2. **ExternalProject** - BaseModel e ContactSimple (modulo specifico del progetto)
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_7g3Jt6

### 🟡 Media Priorità
3. **Chart** - BaseModel
4. **Geo** - BaseModel e GeoNamesCap
5. **Job** - TaskComment
6. **Media** - TemporaryUpload

### 🟢 Bassa Priorità
7. **Lang** - BaseModelLang (classe astratta secondaria)
8. **Tenant** - TestSushiModel (modello di test)

---

## Script di Verifica

Per verificare tutti i moduli:

```bash
#!/bin/bash
cd Modules

for module in */; do
    echo "=== Checking $module ==="
    grep -r "extends Model" "$module/app/Models/" --include="*.php" 2>/dev/null | \
        grep -v "BaseModel\|BasePivot\|BaseMorphPivot\|\.bak\|\.backup\|\.old\|\.fixed" || echo "✅ OK"
done
```

---

## Prossimi Passi

1. ✅ **User** - Completato (15 Ottobre 2025)
2. ⏳ **Cms** - Da correggere (BaseModel + Conf)
<<<<<<< .merge_file_a0qsiM
3. ⏳ **healthcare_app** - Da correggere (BaseModel + ContactSimple)
=======
<<<<<<< HEAD
3. ⏳ **ModuloEsempio** - Da correggere (BaseModel + ContactSimple)
=======
3. ⏳ **ExternalProject** - Da correggere (BaseModel + ContactSimple)
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_7g3Jt6
4. ⏳ **Chart** - Da correggere (BaseModel)
5. ⏳ **Geo** - Da correggere (BaseModel + GeoNamesCap)
6. ⏳ **Job** - Da correggere (TaskComment)
7. ⏳ **Media** - Da correggere (TemporaryUpload)
8. ⏳ **Lang** - Da correggere (BaseModelLang)
9. ⏳ **Tenant** - Da correggere (TestSushiModel)
10. ⏳ Pulizia file di backup

---

## Note Tecniche

### Casi Speciali

#### Modelli Sushi (In-Memory)
- `Cms/Conf.php` - Usa trait `Sushi`
- `Tenant/TestSushiModel.php` - Usa trait `SushiToJson`

Questi modelli possono comunque estendere `BaseModel` senza problemi.

#### Modelli con HasMedia
<<<<<<< .merge_file_a0qsiM
- `healthcare_app/BaseModel.php` - Implementa `HasMedia`
=======
<<<<<<< HEAD
- `ModuloEsempio/BaseModel.php` - Implementa `HasMedia`
=======
- `ExternalProject/BaseModel.php` - Implementa `HasMedia`
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_7g3Jt6
- `Media/TemporaryUpload.php` - Implementa `HasMedia`

`XotBaseModel` è compatibile con `HasMedia` di Spatie.

#### Classi Astratte Secondarie
- `Lang/BaseModelLang.php` - Classe astratta per modelli multilingua

Dovrebbe estendere `BaseModel` del modulo Lang.

---

## Collegamenti

- [DRY/KISS Analysis](../../../../dry_kiss_analysis.md) - **Analisi completa duplicazioni e piano refactoring**
- [DRY/KISS Refactoring](./dry_kiss_refactoring.md) - **Guida rapida refactoring**
- [User Module Fixes](../../user/docs/model_inheritance_fixes.md)
- [User Module Analysis](../../user/docs/model_inheritance_analysis.md)
- [Code Quality Rules](../../../.windsurf/rules/code-quality.md)
- [XotBaseModel](../app/Models/XotBaseModel.php)
- [XotBasePivot](../app/Models/XotBasePivot.php)
- [XotBaseMorphPivot](../app/Models/XotBaseMorphPivot.php)
