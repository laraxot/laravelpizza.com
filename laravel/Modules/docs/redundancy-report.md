# Redundancy Report — Laraxot Modules

> Generato: 2026-05-21 | Analisi automatica deep-scan su tutti i moduli e temi

## Sommario Esecutivo

L'analisi ha identificato **7 categorie principali di ridondanza** che attraversano l'intero codebase modulare. Le più critiche sono:

1. **BaseModel / BasePivot / BaseMorphPivot** — duplicati in quasi ogni modulo; **`BaseModel` ora allineati a `XotBaseModel`** (Fixcity, Job, Notify, 2026-05-21); restano pivot e altre varianti.
2. **Filament Resources duplicati** — strutture Cluster e standalone identiche (User/Oauth, Gdpr/Consent, Gdpr/Profile)
3. **EventServiceProvider** — 17 copie con base class inconsistente
4. **AddressField / CoordinatePicker** — 3 e 2 copie con logica diversa
5. **ArticleData / AutoLabelAction** — duplicati cross-modulo
6. **CommentsRelationManager** — 2 copie identiche in Fixcity
7. **ProfileResource** — 4 copie in Blog, Gdpr (x2), User

---

## 1. BaseModel — varianti modulo (attualmente tutti conformi ✓ Laraxot 2026-05-21)

Ogni modulo ha un `BaseModel.php` in `app/Models/`. La regola Laraxot è: **estendere `Modules\Xot\Models\XotBaseModel`**.

### Conformi (estendono XotBaseModel)
| Modulo | Path |
|--------|------|
| Activity | `Modules/Activity/app/Models/BaseModel.php` |
| Blog | `Modules/Blog/app/Models/BaseModel.php` |
| Cms | `Modules/Cms/app/Models/BaseModel.php` |
| Comment | `Modules/Comment/app/Models/BaseModel.php` |
| Fixcity | `Modules/Fixcity/app/Models/BaseModel.php` |
| Gdpr | `Modules/Gdpr/app/Models/BaseModel.php` |
| Geo | `Modules/Geo/app/Models/BaseModel.php` |
| Job | `Modules/Job/app/Models/BaseModel.php` |
| Lang | `Modules/Lang/app/Models/BaseModel.php` |
| Media | `Modules/Media/app/Models/BaseModel.php` |
| Notify | `Modules/Notify/app/Models/BaseModel.php` |
| Rating | `Modules/Rating/app/Models/BaseModel.php` |
| Tenant | `Modules/Tenant/app/Models/BaseModel.php` |
| UI | `Modules/UI/app/Models/BaseModel.php` |
| User | `Modules/User/app/Models/BaseModel.php` |

### ~~NON conformi~~ — risolto (2026-05-21)

| Modulo | Path | ~~Problema~~ |
|--------|------|---------------|
| **Fixcity** | `Modules/Fixcity/app/Models/BaseModel.php` | Ora **`extends XotBaseModel`** + `SoftDeletes`; `casts()` senza forzatura `id` string (numeric PK). PHPStan ✓ |
| **Job** | `Modules/Job/app/Models/BaseModel.php` | Ora **`extends XotBaseModel`**; preservato prefisso tabella nel costruttore. PHPStan ✓ |
| **Notify** | `Modules/Notify/app/Models/BaseModel.php` | Ora **`extends XotBaseModel implements HasMedia`** + `InteractsWithMedia`; factory via trait padre. PHPStan ✓ |

## 2. BasePivot — 8 copie, 5 NON conformi

### Conformi (estendono `XotBasePivot`)
| Modulo | Path |
|--------|------|
| Blog | `Modules/Blog/app/Models/BasePivot.php` |
| Cms | `Modules/Cms/app/Models/BasePivot.php` |
| Comment | `Modules/Comment/app/Models/BasePivot.php` |
| Gdpr | `Modules/Gdpr/app/Models/BasePivot.php` |

### NON conformi (estendono `Illuminate\Database\Eloquent\Relations\Pivot` direttamente)
| Modulo | Path |
|--------|------|
| **Fixcity** | `Modules/Fixcity/app/Models/BasePivot.php` |
| **Geo** | `Modules/Geo/app/Models/BasePivot.php` |
| **Notify** | `Modules/Notify/app/Models/BasePivot.php` |
| **User** | `Modules/User/app/Models/BasePivot.php` |

**Azione suggerita**: Migrare tutti a `extends XotBasePivot`.

---

## 3. BaseMorphPivot — 11 copie, 6 NON conformi

### Conformi (estendono `XotBaseMorphPivot`)
| Modulo | Path |
|--------|------|
| Blog | `Modules/Blog/app/Models/BaseMorphPivot.php` |
| Cms | `Modules/Cms/app/Models/BaseMorphPivot.php` |
| Comment | `Modules/Comment/app/Models/BaseMorphPivot.php` |
| Gdpr | `Modules/Gdpr/app/Models/BaseMorphPivot.php` |
| User | `Modules/User/app/Models/BaseMorphPivot.php` |

### NON conformi (estendono `MorphPivot` direttamente)
| Modulo | Path |
|--------|------|
| **Geo** | `Modules/Geo/app/Models/BaseMorphPivot.php` |
| **Job** | `Modules/Job/app/Models/BaseMorphPivot.php` |
| **Lang** | `Modules/Lang/app/Models/BaseMorphPivot.php` |
| **Notify** | `Modules/Notify/app/Models/BaseMorphPivot.php` |
| **Rating** | `Modules/Rating/app/Models/BaseMorphPivot.php` |
| **Xot** | `Modules/Xot/app/Models/BaseMorphPivot.php` (base itself) |

**Azione suggerita**: Migrare Geo, Job, Lang, Notify, Rating a `extends XotBaseMorphPivot`.

---

## 4. EventServiceProvider — 17 copie, inconsistenza nella base class

| Base Class | Moduli |
|------------|--------|
| `XotBaseEventServiceProvider` | Gdpr, Geo, User |
| `BaseEventServiceProvider` (Laravel) | AI, Activity, Cms, Job, Lang, Media, Notify, Rating, Tenant, UI, Xot |
| `ServiceProvider` (Laravel alias) | Blog, Comment, Fixcity, Seo |

**Azione suggerita**: Standardizzare tutti su `XotBaseEventServiceProvider` per consistenza. I moduli senza listener reali possono usare la base XotBase vuota.

---

## 5. Filament Resources Duplicati — Cluster vs Standalone

### User Module — Oauth Resources (CRITICO)
**5 risorse duplicate** tra `Clusters/Passport/Resources/` e `Resources/`:

| Resource | Cluster Path | Standalone Path |
|----------|-------------|-----------------|
| OauthAccessTokenResource | `Clusters/Passport/Resources/` | `Resources/` |
| OauthAuthCodeResource | `Clusters/Passport/Resources/` | `Resources/` |
| OauthClientResource | `Clusters/Passport/Resources/` | `Resources/` |
| OauthPersonalAccessClientResource | `Clusters/Passport/Resources/` | `Resources/` |
| OauthRefreshTokenResource | `Clusters/Passport/Resources/` | `Resources/` |

Cluster ha anche `OauthDeviceCodeResource` (non in standalone).

**Azione suggerita**: Eliminare le copie standalone e usare solo il Cluster `Passport/`.

### Gdpr Module — Consent + Profile Resources
**2 risorse duplicate** tra `Clusters/Profile/Resources/` e `Resources/`:

| Resource | Cluster Path | Standalone Path |
|----------|-------------|-----------------|
| ConsentResource (+ Pages, Schemas, Tables) | `Clusters/Profile/Resources/` | `Resources/` |
| ProfileResource (+ Pages, Schemas, Tables) | `Clusters/Profile/Resources/` | `Resources/` |

Le strutture delle directory sono identiche. I file ConsentForm differiscono solo nel namespace e nella logica form (il Cluster usa Section, lo standalone usa Select/relationship).

**Azione suggerita**: Decidere quale versione è canonica. Eliminare l'altra e aggiornare i riferimenti.

### ProfileResource — 4 copie in 3 moduli
| Modulo | Path |
|--------|------|
| Blog | `Modules/Blog/app/Filament/Resources/ProfileResource.php` |
| Gdpr (Cluster) | `Modules/Gdpr/app/Filament/Clusters/Profile/Resources/ProfileResource.php` |
| Gdpr (Standalone) | `Modules/Gdpr/app/Filament/Resources/ProfileResource.php` |
| User | `Modules/User/app/Filament/Resources/ProfileResource.php` |

**Azione suggerita**: Il `ProfileResource` canonico dovrebbe vivere in un solo modulo (probabilmente User) ed essere referenziato dagli altri via Cluster o navigation.

---

## 6. Componenti Filament Duplicati

### AddressField — 3 copie
| Path | Extends | Note |
|------|---------|------|
| `Modules/Geo/app/Filament/Forms/Components/AddressField.php` | `Section` | Usa `AddressResource` |
| `Modules/Geo/app/Filament/Fields/AddressField.php` | `Section` | Usa `TextInput` direttamente |
| `Modules/UI/app/Filament/Forms/Components/AddressField.php` | `XotBaseField` | Logica diversa con Select |

**Azione suggerita**: Unificare in una sola versione canonica in Geo o UI. Eliminare le altre.

### CoordinatePicker — 2 copie
| Path | Extends | Note |
|------|---------|------|
| `Modules/Geo/app/Forms/Components/CoordinatePicker.php` | `Field` (Filament base) | Vecchia implementazione con `Http::get` |
| `Modules/Geo/app/Filament/Forms/Components/CoordinatePicker.php` | `XotBaseField` | Nuova, usa `HasCoordinatePicker` trait |

**Azione suggerita**: Eliminare la vecchia versione in `Forms/Components/` e mantenere solo quella in `Filament/Forms/Components/`.

### ColumnBuilder — 2 copie dentro Xot
| Path | Note |
|------|------|
| `Modules/Xot/app/Filament/Support/ColumnBuilder.php` | Vecchia, usa `BooleanColumn`, `ImageColumn` |
| `Modules/Xot/app/Filament/Builders/ColumnBuilder.php` | Nuova, usa `IconColumn` |

**Azione suggerita**: Unificare in una sola versione.

---

## 7. Data Objects Duplicati

### ArticleData — 3 copie
| Path | Namespace | Note |
|------|-----------|------|
| `Modules/Blog/app/Datas/ArticleData.php` | `Modules\Blog\Datas` | Completo, con Carbon, Collection, GetBloodline |
| `Modules/Blog/app/DataObjects/ArticleData.php` | `Modules\Blog\DataObjects` | Versione alternativa con ArticleStatus enum |
| `Modules/Xot/app/Datas/ArticleData.php` | `Modules\Xot\Datas` | Versione minimale, solo Data base |

**Azione suggerita**: Mantenere una sola versione in Blog/Datas/ ed eliminare le altre. Xot non dovrebbe avere `ArticleData`.

### AutoLabelAction — 2 copie
| Path | Note |
|------|------|
| `Modules/Lang/app/Actions/Filament/AutoLabelAction.php` | Completo, con SVG, trans, HtmlString |
| `Modules/Xot/app/Actions/Filament/AutoLabelAction.php` | Versione base, con QueueableAction |

**Azione suggerita**: Decidere quale è canonica (probabilmente Lang poiché gestisce traduzioni). Eliminare l'altra.

---

## 8. CommentsRelationManager — 2 copie identiche in Fixcity

| Path |
|------|
| `Modules/Fixcity/app/Filament/Resources/RelationManagers/CommentsRelationManager.php` |
| `Modules/Fixcity/app/Filament/Resources/TicketResource/RelationManagers/CommentsRelationManager.php` |

Entrambe hanno import identici e estendono `RelationManager`. Solo il namespace differisce.

**Azione suggerita**: Mantenere solo quella in `TicketResource/RelationManagers/` ed eliminare la copia standalone.

---

## 9. BaseTreeModel — 3 copie

| Modulo | Path | Note |
|--------|------|------|
| Blog | `Modules/Blog/app/Models/BaseTreeModel.php` | Con `HasPathByParentId`, `SortableTrait` |
| Cms | `Modules/Cms/app/Models/BaseTreeModel.php` | Con `MenuFactory`, `MediaCollection` |
| Xot | `Modules/Xot/app/Models/BaseTreeModel.php` | Base, con `HasRecursiveRelationshipsContract` |

**Azione suggerita**: Blog e Cms dovrebbero estendere `Xot\Models\BaseTreeModel`.

---

## 10. BaseRating — 2 copie

| Path | Note |
|------|------|
| `Modules/Rating/app/Models/BaseRating.php` | Modulo canonico |
| `Modules/Xot/app/Models/BaseRating.php` | Copia in Xot |

**Azione suggerita**: Mantenere solo in Rating. Xot non dovrebbe avere `BaseRating`.

---

## Riepilogo Priorità

| Priorità | Categoria | Impatto | Moduli |
|----------|-----------|---------|--------|
| 🔴 CRITICA | BaseModel non conformi (Fixcity, Job, Notify) | **Risolto** 2026-05-21 (`extends XotBaseModel`) | — |
| 🔴 CRITICA | Oauth Resources duplicati | Manutenzione | User |
| 🟠 ALTA | Gdpr Cluster/Standalone duplicati | Manutenzione | Gdpr |
| 🟠 ALTA | BasePivot/BaseMorphPivot non conformi | Architettura | Geo, Job, Lang, Notify, Rating, User, Fixcity |
| 🟡 MEDIA | EventServiceProvider inconsistente | Consistenza | 14 moduli |
| 🟡 MEDIA | AddressField/CoordinatePicker duplicati | Confusione | Geo, UI |
| 🟢 BASSA | ArticleData/AutoLabelAction duplicati | Pulizia | Blog, Xot, Lang |
| 🟢 BASSA | CommentsRelationManager duplicato | Pulizia | Fixcity |
| 🟢 BASSA | ColumnBuilder duplicato | Pulizia | Xot |
| 🟢 BASSA | BaseTreeModel/BaseRating duplicati | Pulizia | Blog, Cms, Rating, Xot |

---

## 11. Scaffolding modulare (stesso basename, contenuto quasi sempre diverso)

Ogni modulo **nwidart** replica file “di servizio”: `RouteServiceProvider.php`, `EventServiceProvider.php`, `AdminPanelProvider.php`, `Dashboard.php`, `web.php`, `api.php`, `config.php`, `BaseModel.php`, layout Blade (`master.blade.php`), test stub (`TestCase.php`, `Pest.php`), config qualità locale (`.php-cs-fixer.*`, `rector.php`, `phpstan_constants.php`). **Non è errore**: è il contratto Laraxot. La **ridondanza effettiva** è di **costo di manutenzione** (uniformare basi quando cambia il core) più che di bytecode identico.

Esempi di moltiplicità trasversale (scansione struttura `Modules/*/`, maggio 2026):

| Basename ricorrente | Ordine grandezza | Interpretazione |
|---------------------|------------------|-----------------|
| `auth.php` / `validation.php` / `passwords.php` (sotto `lang/`) | decine copie distribuite nei moduli | Directory lingua per modulo (`lang/{locale}/`): nomi Laravel standard ripetuti; il **contenuto** va tenuto sincronizzato solo dove diverge dal fallback app |
| `RouteServiceProvider.php` | una per modulo PHP | Alcuni divergono poco dall’articolo Laravel di default |

**Azione suggerita**: quando si refactora un modulo, prima verificare se la logica può essere spostata in **Xot** (provider base, registreri condivisi) invece di copiare incollamenti.

---

## 12. Documentazione tecnica frammentata (wiki / legacy)

Tre cluster da non confondere con duplicazioni di **codice**:

1. **`Modules/docs/redundancy-report.md` (questo file)** — inventario **cross modulo** tecnico aggiornato.
2. **Report “locali”** — ogni modulo con `docs/redundancy-report.md` approfondisce **solo quel modulo**: Blog, Cms, Fixcity, Gdpr, Geo, Job, Lang, Notify, Rating, UI, User, Xot.
3. **Documentazione tema Sixteen**: molte pagine **`segnalazione-*`** in `Themes/Sixteen/docs/wiki/concepts/` si sovrappongono perché suddividono parity per step/asset; roadmap in [`../../Themes/Sixteen/docs/wiki/concepts/wizard-parity-documentation-map.md`](../../Themes/Sixteen/docs/wiki/concepts/wizard-parity-documentation-map.md).
4. **Modulo User `docs/legacy/`** — migliaia di note storiche ripetute (stesso tema con `-1`, `_` vs `-`, varianti duplicate); uso operativo solo via ricerca mirata — vedi [legacy-docs-duplication-pattern](../User/docs/wiki/concepts/legacy-docs-duplication-pattern.md).

**Collegamento filosofia anti-ridondanza Filament (trait già sulla base)** — [`../Xot/docs/filament/redundancy-rules.md`](../Xot/docs/filament/redundancy-rules.md).

**Indice sintesi Xot (wizard overlap + link al report modulo)** — [`../Xot/docs/wiki/concepts/redundancy-catalog.md`](../Xot/docs/wiki/concepts/redundancy-catalog.md).

---

## 13. Report `redundancy-report.md` per modulo (drill-down)

Approfondimenti locali (percorsi da `laravel/`):

| Modulo | Percorso |
|--------|-----------|
| Blog | `Modules/Blog/docs/redundancy-report.md` |
| Cms | `Modules/Cms/docs/redundancy-report.md` |
| Fixcity | `Modules/Fixcity/docs/redundancy-report.md` |
| Gdpr | `Modules/Gdpr/docs/redundancy-report.md` |
| Geo | `Modules/Geo/docs/redundancy-report.md` |
| Job | `Modules/Job/docs/redundancy-report.md` |
| Lang | `Modules/Lang/docs/redundancy-report.md` |
| Notify | `Modules/Notify/docs/redundancy-report.md` |
| Rating | `Modules/Rating/docs/redundancy-report.md` |
| UI | `Modules/UI/docs/redundancy-report.md` |
| User | `Modules/User/docs/redundancy-report.md` |
| Xot | `Modules/Xot/docs/redundancy-report.md` |

I moduli **senza** report dedicato possono essere aggiunti incrementalmente dopo una passata progetto-centrica sul modulo stesso.

---

## 14. Migrazioni duplicate (audit 2026-05-21)

Ridondanza **runtime** (non solo documentazione): più file `Schema::create` per la stessa tabella nello stesso modulo o tra moduli.

| Tabella | Modulo | Evidenza | Azione |
|---------|--------|----------|--------|
| `users` | User | 6 file `*create_users_table*` + cartella `Database/Migrations/` mirror | Una migration; rimuovere mirror |
| `profiles` | User, Blog | 4+2 migration | Owner **User**; Blog solo FK/relazione |
| `mail_templates` | Notify | 7 migration `000000`–`000007` | Tenere una |
| `consents` | Gdpr | `000001`, `000002`, `000005` | Consolidare |
| `activity` | Activity | 5 file | Vedi anche `Activity/docs/errori_migrazione_activity_table_lezioni.md` |
| `cache` | Xot | `2023_09_04_000000` e `125039` | Eliminare duplicato |
| `notification_logs` | Notify | `2025_03_31` e `2025_07_01` | Una definizione |
| `ratings` | Rating | `2023` e `2026_03_12` | Evoluzione in alter, non secondo create |
| `temporary_uploads` | Media | `2023` e `2026_01_18` | Idem |

Indice concettuale globale: [`../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md`](../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md). Documentazione temi: [`../../Themes/docs/ridondanze-documentazione-temi.md`](../../Themes/docs/ridondanze-documentazione-temi.md).
