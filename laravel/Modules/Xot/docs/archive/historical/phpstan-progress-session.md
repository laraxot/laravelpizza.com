# PHPStan Level 10 - Sessione di Correzione

**Status**: 🔄 **IN CORSO** (64% completato)

---

## 📊 Riepilogo Progressi

### Errori
- **Iniziali**: 48 errori
- **Risolti**: 31 errori
- **Rimanenti**: 17 errori
- **Progresso**: 64% completato

---

## ✅ Moduli Completati

### 1. Cms (3 errori risolti)
- `app/Models/Conf.php` - varTag.variableNotFound
- `app/Models/Traits/HasBlocks.php` - varTag.variableNotFound
- `app/View/Composers/ThemeComposer.php` - varTag.variableNotFound (2x)

### 2. Job (3 errori risolti)
- `app/Filament/Tables/Columns/ScheduleOptions.php` - return.type + varTag
- `app/Filament/Resources/ScheduleResource/Pages/CreateSchedule.php` - varTag
- `app/Services/ScheduleService.php` - varTag

### 3. Meetup (2 errori risolti)
- `app/Actions/Event/CreateEventAction.php` - varTag
- `app/Actions/Event/DeleteEventAction.php` - varTag

### 4. Geo (7 errori risolti)
- `app/Datas/UpdateCoordinatesResult.php` - return.type
- `app/Models/ComuneJson.php` - return.type (4x)
- `app/Models/Locality.php` - return.type
- `app/Services/GeoDataService.php` - return.type (4x)
- `app/Services/GeoDataValidator.php` - varTag

### 5. Notify (2 errori risolti)
- `app/Factories/TelegramActionFactory.php` - già corretto
- `app/Factories/WhatsAppActionFactory.php` - varTag + Assert

### 6. User (1 errore risolto)
- `app/Filament/Widgets/EditUserWidget.php` - varTag + Assert

---

## 🔄 Errori Rimanenti (17)

### PageSlugMiddleware (6 errori)
**File**: `Cms/app/Http/Middleware/PageSlugMiddleware.php`  
**Problema**: Assert ridondanti su Response (linee 23, 32, 69, 76, 95, 106)
**Soluzione**: Rimuovere assert o usare type hint closure

### GetAddressFromBingMapsAction (2 errori)
**File**: `Geo/app/Actions/Bing/GetAddressFromBingMapsAction.php`  
**Problema**: return.type su array vs array<string, mixed>
**Soluzione**: Type narrowing post json()

### SushiToJson (3 errori)
**File**: `Tenant/app/Models/Traits/SushiToJson.php`  
**Problema**: list<array> vs array<int, array<string, mixed>>
**Soluzione**: Aggiungere PHPDoc corretto per list type

### Altri (6 errori)
- Notify: 2 errori rimanenti
- UI: File mancante UserCalendarWidget
- Tenant: 1 errore
- User: 3 errori rimanenti

---

## 📋 Pattern Applicati

### Pattern 1: varTag.variableNotFound
```php
// ❌ PRIMA
/** @var Type $variable */
return expression();

// ✅ DOPO
$variable = expression();
Assert::isArray($variable); // se necessario
/** @var Type $variable */
return $variable;
```

### Pattern 2: return.type con Assert
```php
// ❌ PRIMA
return mixed_value();

// ✅ DOPO
$result = mixed_value();
Assert::isInstanceOf($result, Type::class);
/** @var Type $result */
return $result;
```

### Pattern 3: Collection return type
```php
// ❌ PRIMA
/* @var Collection<int, Type> $result */
return Cache::remember(...);

// ✅ DOPO
$result = Cache::remember(...);
/** @var Collection<int, Type> $result */
return $result;
```

---

## 🎯 Prossimi Passi

1. ✅ Verificare file corretti con PHPStan
2. ✅ Commit modifiche parziali
3. 🔄 Risolvere PageSlugMiddleware (6 errori)
4. 🔄 Risolvere GetAddressFromBingMapsAction (2 errori)
5. 🔄 Risolvere SushiToJson (3 errori)
6. 🔄 Risolvere errori rimanenti (6 errori)

---

**Ultimo aggiornamento**: 2026-01-09 - Sessione in corso
