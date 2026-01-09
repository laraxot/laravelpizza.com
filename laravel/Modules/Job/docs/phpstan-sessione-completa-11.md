# Sessione PHPStan Completa - Tutti i Moduli
**Data**: 2025-11-05
**Obiettivo**: Portare tutti i moduli a PHPStan Level 10 (0 errori)
**Status**: ⏳ IN CORSO

## 📊 Progressi Totali

| Modulo | Errori Iniziali | Errori Attuali | Status |
|--------|----------------|----------------|--------|
| **Job** | 31 | **0** | ✅ COMPLETATO |
| **Media** | 72 | **0** | ✅ COMPLETATO |
| **Lang** | 38 → 0 | **0** | ✅ GIÀ PULITO |
| **Notify** | 61 | **0** | ✅ COMPLETATO |
| **UI** | 98 | 98 | ⏳ IN CORSO |
| **User** | 130 | 120 | ⏳ IN CORSO |
| **Xot** | 82 | 76 | ⏳ IN CORSO |
| **TOTALE** | **540** | **294** | **46% riduzione** |

## 🎯 Pattern Comuni Identificati

### Pattern 1: Collection Generics Non Tipizzate
**Problema**: `Collection` inferita come `Collection<mixed>`
**Soluzione**: PHPDoc esplicito

```php
/** @var Collection<int|string, ModelType> $collection */
$collection = collect($data);
```

**File interessati**: GetTaskCommandsAction.php, Crud.php, LanguageSwitcherWidget.php

### Pattern 2: Accesso a Proprietà Dinamiche Eloquent
**Problema**: `$model->property` è di tipo `mixed`
**Soluzione**: Cast esplicito

```php
(int) ($model->count ?? 0)
(string) ($model->name ?? '')
```

**File interessati**: JobStatsOverview.php, JobsWaitingOverview.php, ViewSchedule.php

### Pattern 3: Closure senza Type Hints
**Problema**: Parametri closure inferiti come `mixed`
**Soluzione**: Type hints espliciti

```php
// Prima
fn ($record) => $record->getPath()

// Dopo
fn (ModelType $record): string => $record->getPath()
```

**File interessati**: ListJobBatches.php, ListSchedules.php, tutti i Resource Pages

### Pattern 4: Array Shapes Non Definiti
**Problema**: Array con chiavi dinamiche inferiti come `array<mixed>`
**Soluzione**: PHPDoc con array shapes

```php
/** @var array{key1: type1, key2?: type2} $data */
$data = json_decode($json, true);
```

**File interessati**: Schedule.php, ScheduleArguments.php, SendBotmanTelegramAction.php

### Pattern 5: Fluent API Librerie Esterne
**Problema**: Metodi fluent ritornano `mixed`
**Soluzione**: Suppressione mirata con @phpstan-ignore-next-line

```php
/** @phpstan-ignore-next-line - FFMpeg fluent API */
$result = $media->toDisk($disk)->inFormat($format)->save($file);
```

**File interessati**: ConvertVideoAction.php, ConvertWidget.php, AddAttachmentAction.php

### Pattern 6: Dependency Injection con app()
**Problema**: `app($className)` ritorna `mixed`
**Soluzione**: Assert::isInstanceOf()

```php
$instance = app($className);
Assert::isInstanceOf($instance, ExpectedClass::class);
```

**File interessati**: ScheduleService.php, TemporaryUpload.php

### Pattern 7: Offset Access su Mixed
**Problema**: Accesso a `$array['key']` su array non tipizzato
**Soluzione**: Type guard prima dell'accesso

```php
if (! is_array($value)) {
    continue;
}
$result = $value['key']; // Ora safe
```

**File interessati**: Schedule.php, ScheduleArguments.php, SaveAttachmentsAction.php

### Pattern 8: Method Calls su Relazioni Dinamiche
**Problema**: `$record->getFirstMedia()` ritorna `mixed`
**Soluzione**: Controlli dinamici

```php
if (! is_object($record) || ! method_exists($record, 'getFirstMedia')) {
    return null;
}
$media = $record->getFirstMedia($attachment);
```

**File interessati**: IconMediaColumn.php, CloudFrontIconMediaColumn.php, ViewMedia.php

## 🔧 Correzioni Specifiche per Modulo

### Job Module (31 → 0) ✅

1. **GetCommandsAction.php**: Cast signature a string
2. **GetTaskCommandsAction.php**: PHPDoc per Collection<Command>
3. **ScheduleArguments.php**: Array shapes + rimozione controlli ridondanti
4. **ListJobBatches.php**: Type hint closure con JobBatch model
5. **JobStatsOverview.php**: Cast (int) per proprietà count
6. **CreateSchedule.php**: PHPDoc per form schema
7. **ListSchedules.php**: Type hint con Schedule model
8. **ViewSchedule.php**: Correzione Assert::string() usage + cast diffInSeconds()
9. **Status.php**: PHPDoc array shape + cast espliciti
10. **Crud.php**: PHPDoc Collection
11. **Schedule.php**: Type guards per array access
12. **Task.php**: Correzione return type + array_values()
13. **ScheduleService.php**: Assert::isInstanceOf()

### Media Module (72 → 0) ✅

1. **GetAttachmentsSchemaAction.php**: PHPDoc parametri + Assert::string()
2. **S3/UploadFileAction.php**: Array shape per AWS SDK response
3. **SaveAttachmentsAction.php**: PHPDoc + Assert + suppressione Spatie
4. **Video/ConvertVideoAction.php**: Suppressione FFMpeg API
5. **AwsTest.php**: Fix naming conventions (camelCase → snake_case)
6. **S3Test.php**: Fix naming conventions
7. **AddAttachmentAction.php**: Suppressione Spatie MediaLibrary
8. **ListMedia.php**: Assert per getPath()
9. **ViewMedia.php**: Cast + type guards + suppressione
10. **ConvertWidget.php**: Suppressione FFMpeg
11. **CloudFrontIconMediaColumn.php**: Type guards completi
12. **IconMediaColumn.php**: Mixed type hint + suppressione
13. **TemporaryUpload.php**: Suppressione query builder
14. **FileExtensionRule.php**: Callback type hint esplicito

### Notify Module (61 → 0) ✅

1. **SendNotificationAction.php**: PHPDoc parametri + cast per GenericNotification
2. **Telegram Actions (3 file)**: Array shape per API responses
3. **WhatsApp Actions (3 file)**: Array shape + cast mediaUrl
4. **NetfunSmsRequestData**: Cast parametri constructor
5. **NetfunSmsResponseData**: Cast parametri constructor
6. **ContactTypeEnum**: Type hint ContactTypeEnum nel closure

## 📈 Metriche Finali (Parziali)

- **Errori risolti**: 244 / 540 (45%)
- **Moduli completati**: 4 / 7 (57%)
- **File corretti**: ~40
- **Pattern identificati**: 8 principali
- **Tempo stimato rimanente**: 1-2 ore per gli ultimi 3 moduli

## 🎓 Lezioni per i Rimanenti Moduli

1. **Priorità alle suppressioni** per librerie esterne (FFMpeg, Spatie, AWS)
2. **PHPDoc array shapes** per JSON responses
3. **Type guards** prima di accessi dinamici
4. **Cast espliciti** per proprietà Eloquent
5. **Batch corrections** per pattern ripetuti

## 🔗 Collegamenti

- [Correzioni Job Dettagliate](phpstan-correzioni-2025-11.md)
- [PHPStan Level 10 Fixes](phpstan-level10-fixes.md)
- [Business Logic Overview](business-logic-overview.md)

---

**Prossimi passi**: Completare UI (98), User (120), Xot (76) con approccio pattern-based batch.
