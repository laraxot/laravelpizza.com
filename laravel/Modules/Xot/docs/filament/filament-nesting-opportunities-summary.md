# Filament 5.x Nested Resources - Riepilogo Opportunità

**Data Analisi**: 2026-01-22  
**Versione Filament**: 5.x  
**Documentazione Upstream**: https://filamentphp.com/docs/5.x/resources/nesting

## Scopo del Documento

Questo documento fornisce un riepilogo delle opportunità di applicare il nesting nativo di Filament 5.x in tutti i moduli del progetto, con priorità e motivazioni.

## Panoramica Filament 5.x Nesting

### Cos'è il Nesting

Il nesting in Filament 5.x permette di creare risorse figlie con pagine complete (List, Create, Edit, View) invece di essere gestite solo tramite modal nei relation managers.

**Vantaggi**:
- **UX Migliore**: Pagine complete invece di modal ristrette
- **Complessità Gestibile**: Form complessi possono essere gestiti meglio
- **Navigazione Chiara**: URL strutturati che riflettono la gerarchia
- **Breadcrumbs Automatici**: Filament gestisce automaticamente i breadcrumbs
- **Nativo**: Parte del core Filament, sempre aggiornato

### Quando Usare Nesting vs Relation Manager

**Usa Nested Resource quando**:
- Form è complesso (10+ campi, repeater, fieldset)
- Serve pagina dedicata per gestione
- Ci sono azioni multiple o workflow complessi
- Serve navigazione chiara parent-child
- Relazione è hasMany o belongsTo

**Usa Relation Manager quando**:
- Form è semplice (pochi campi)
- Gestione può essere fatta in modal
- Non serve navigazione dedicata
- Relazione è many-to-many semplice

## Opportunità per Modulo

### Modulo Quaeris

**Documentazione**: [Modules/Quaeris/docs/filament-nesting-opportunities.md](../../Quaeris/docs/filament-nesting-opportunities.md)

**Opportunità Identificate**:

1. **Contact → Nested di SurveyPdf** 🟡 ALTA
   - Form complesso (14+ attributi)
   - Workflow complesso (SMS, email, token)
   - URL: `/survey-pdfs/{id}/contacts`

2. **SurveyPdf → Nested di Customer** 🟡 ALTA
   - Form molto complesso
   - Workflow complesso (PDF generation, export)
   - URL: `/customers/{id}/survey-pdfs`

3. **QuestionChart → Già Nested** ✅ COMPLETATO
   - Verificare usa pattern Filament 5.x nativo

### Modulo Limesurvey

**Documentazione**: [Modules/Limesurvey/docs/filament-nesting-opportunities.md](../../Limesurvey/docs/filament-nesting-opportunities.md)

**Opportunità Identificate**:

1. **LimeGroup → Nested di LimeSurvey** 🟡 ALTA
   - Gerarchia logica
   - Form dedicato
   - URL: `/surveys/{id}/groups`

2. **LimeQuestion → Nested di LimeGroup** 🔴 CRITICA
   - Form molto complesso (30+ tipi question)
   - Supporto sub-questions
   - URL: `/surveys/{id}/groups/{id}/questions`

3. **LimeAnswer → Nested di LimeQuestion** 🟡 ALTA
   - Gerarchia logica
   - Form dedicato
   - URL: `/surveys/{id}/groups/{id}/questions/{id}/answers`

4. **LimeSurveysLanguagesetting → Nested di LimeSurvey** 🟢 MEDIA
   - Gestione lingue
   - URL: `/surveys/{id}/languages`

### Modulo Cms

**Documentazione**: [Modules/Cms/docs/filament-nesting-opportunities.md](../../Cms/docs/filament-nesting-opportunities.md)

**Opportunità Identificate**:

1. **Block → Nested di Page** 🟡 ALTA
   - Form complesso
   - Gestione dedicata
   - URL: `/pages/{id}/blocks`

2. **Block → Nested di Section** 🟡 ALTA
   - Coerenza con Page
   - URL: `/sections/{id}/blocks`

3. **Metatag → Nested di Page** 🟢 MEDIA
   - Form SEO dedicato
   - URL: `/pages/{id}/metatag`

4. **Menu Sub-items → Nested Ricorsivo** 🟢 MEDIA
   - Gerarchia menu
   - URL: `/menus/{id}/sub-menus/{id}`

### Modulo User

**Documentazione**: [Modules/User/docs/filament-nesting-opportunities.md](../../User/docs/filament-nesting-opportunities.md)

**Opportunità Identificate**:

1. **TeamInvitation → Nested di Team** 🟡 ALTA
   - Workflow complesso
   - Gestione dedicata
   - URL: `/teams/{id}/invitations`

2. **TeamUser → Nested di Team** 🟢 MEDIA
   - Gestione membri
   - URL: `/teams/{id}/members`

## Priorità Complessiva

### 🔴 CRITICA (Implementare Subito)

1. **LimeQuestion Nested Resource** (Limesurvey)
   - Necessaria per creazione survey
   - Form molto complesso

### 🟡 ALTA (Implementare a Breve)

1. **Contact Nested Resource** (Quaeris)
2. **SurveyPdf Nested Resource** (Quaeris)
3. **LimeGroup Nested Resource** (Limesurvey)
4. **LimeAnswer Nested Resource** (Limesurvey)
5. **Block Nested Resource** (Cms - Page e Section)
6. **TeamInvitation Nested Resource** (User)

### 🟢 MEDIA (Implementare Quando Possibile)

1. **Metatag Nested Resource** (Cms)
2. **Menu Sub-items Nested** (Cms)
3. **LimeSurveysLanguagesetting Nested** (Limesurvey)
4. **TeamUser Nested Resource** (User)

## Migrazione da Legacy

### Pattern Legacy da Evitare

```php
// ❌ NON USARE
use SevendaysDigital\FilamentNestedResources\NestedResource;
use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;

class ChildResource extends NestedResource
{
    public static function getParent(): string
    {
        return ParentResource::class;
    }
}
```

### Pattern Filament 5.x Native

```php
// ✅ USARE
use Modules\Xot\Filament\Resources\XotBaseResource;

class ChildResource extends XotBaseResource
{
    protected static ?string $parentResource = ParentResource::class;
}
```

## Comandi Artisan

### Creare Nested Resource

```bash
php artisan make:filament-resource Contact --nested --module=Quaeris
```

### Creare Relation Manager

```bash
php artisan make:filament-relation-manager SurveyPdfResource contacts email
# Rispondere "yes" quando chiede di linkare a nested resource
# Selezionare ContactResource
```

## Checklist Implementazione

### Per Ogni Nested Resource

- [ ] Creare nested resource con `--nested` flag
- [ ] Aggiungere `$parentResource = ParentResource::class`
- [ ] Creare relation manager o page per parent
- [ ] Implementare `getTableQuery()` per filtrare per parent
- [ ] Implementare `mutateFormDataUsing()` per popolare parent_id
- [ ] Testare navigazione e breadcrumbs
- [ ] Verificare URL structure corretta
- [ ] Aggiornare documentazione

## Collegamenti

- [Filament 5.x Nesting Documentation](https://filamentphp.com/docs/5.x/resources/nesting)
- [Filament 5.x Nesting Migration Guide](./filament-5-nesting-migration.md)
- [Quaeris Nesting Opportunities](../../Quaeris/docs/filament-nesting-opportunities.md)
- [Limesurvey Nesting Opportunities](../../Limesurvey/docs/filament-nesting-opportunities.md)
- [Cms Nesting Opportunities](../../Cms/docs/filament-nesting-opportunities.md)
- [User Nesting Opportunities](../../User/docs/filament-nesting-opportunities.md)

---

**Ultimo Aggiornamento**: 2026-01-22  
**Prossima Revisione**: 2026-02-22
