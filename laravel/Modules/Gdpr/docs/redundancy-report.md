- Inventario [ridondanze cross-modulo](../docs/redundancy-report.md)
- Concetti [ridondanze cross-cutting](../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md)

# Redundancy Report — Modulo Gdpr

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Problemi Trovati

### 1. 🔴 ConsentResource — Duplicato completo (Cluster vs Standalone)

L'intera struttura ConsentResource esiste in **due copie**:

| Componente | Cluster (`Clusters/Profile/Resources/`) | Standalone (`Resources/`) |
|------------|----------------------------------------|--------------------------|
| ConsentResource.php | ✅ | ✅ duplicato |
| Pages/CreateConsent.php | ✅ | ✅ duplicato |
| Pages/EditConsent.php | ✅ | ✅ duplicato |
| Pages/ListConsents.php | ✅ | ✅ duplicato |
| Schemas/ConsentForm.php | ✅ (usa Section) | ✅ (usa Select/relationship) |
| Schemas/ConsentInfolist.php | ✅ | ✅ duplicato |
| Tables/ConsentsTable.php | ✅ | ✅ duplicato |

**Nota**: `ConsentForm.php` differisce tra le due versioni:
- **Cluster**: usa `Section::make([...])` con layout semplice
- **Standalone**: usa `Select::make('treatment_id')->relationship(...)` con logica più completa

**Azione suggerita**: Mantenere la versione standalone (più completa) ed eliminare il duplicato nel Cluster, oppure unificare in un singolo ConsentForm condiviso.

### 2. 🔴 ProfileResource — Duplicato completo (Cluster vs Standalone)

| Componente | Cluster (`Clusters/Profile/Resources/`) | Standalone (`Resources/`) |
|------------|----------------------------------------|--------------------------|
| ProfileResource.php | ✅ | ✅ duplicato |
| Pages/CreateProfile.php | ✅ | ✅ duplicato |
| Pages/EditProfile.php | ✅ | ✅ duplicato |
| Pages/ListProfiles.php | ✅ | ✅ duplicato |
| Schemas/ProfileForm.php | ✅ | ✅ duplicato |
| Schemas/ProfileInfolist.php | ✅ | ✅ duplicato |
| Tables/ProfilesTable.php | ✅ | ✅ duplicato |

Inoltre, `ProfileResource` esiste anche in:
- `Modules/Blog/app/Filament/Resources/ProfileResource.php`
- `Modules/User/app/Filament/Resources/ProfileResource.php`

**Azione suggerita**: Il modello Profile è di proprietà del modulo User. La versione canonica del ProfileResource dovrebbe vivere in User. Gdpr può referenziare tramite navigation/cluster senza duplicare.

### 3. 🟡 EventServiceProvider — Conforme (usa XotBaseEventServiceProvider)

Nessuna azione richiesta.

## Impatto Quantitativo

La duplicazione Cluster vs Standalone genera circa **14 file PHP duplicati** solo per Consent e Profile. Sommando le copie cross-modulo del ProfileResource, si arriva a ~28 file ridondanti.

## Riepilogo

| Priorità | Problema | File interessati |
|----------|----------|-----------------|
| 🔴 | ConsentResource duplicato (Cluster vs Standalone) | ~7 file |
| 🔴 | ProfileResource duplicato (Cluster vs Standalone + cross-modulo) | ~7+14 file |
| 🟢 | EventServiceProvider conforme | 0 |
