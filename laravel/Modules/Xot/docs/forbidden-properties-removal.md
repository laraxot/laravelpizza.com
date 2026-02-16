# Rimozione Completa Proprietà Vietate da XotBaseResource - Analisi e Implementazione

**Status**: 🧘 **IN LAVORO**

---

## 🎯 Obiettivo

Rimuovere **completamente** (anche quelle commentate) tutte le proprietà vietate dalle classi che estendono `XotBaseResource`:
- `protected static ?string $recordTitleAttribute`
- `protected static string|\BackedEnum|null $navigationIcon`
- `protected static ?string $modelLabel`
- `protected static ?string $pluralModelLabel`
- `protected static ?int $navigationSort` ⚠️ **NUOVO**

Queste proprietà vengono gestite automaticamente dal sistema di traduzioni tramite `LangServiceProvider` e `NavigationLabelTrait`.

---

## 🧠 Analisi Filosofica e Logica

### Sistema di Traduzioni Automatico

Il progetto Laraxot implementa un sistema di traduzioni centralizzato che:

1. **Auto-Discovery**: `LangServiceProvider` intercetta automaticamente la creazione di componenti Filament
2. **Convention-based Keys**: Genera chiavi di traduzione basate su modulo, risorsa, campo
3. **Auto-Creation**: Crea automaticamente traduzioni mancanti
4. **Centralizzazione**: Tutte le traduzioni in file `lang/{locale}/{resource}.php`

### Perché Queste Proprietà Sono Vietate

1. **DRY Violation**: Duplicazione tra codice PHP e file traduzione
2. **Localizzazione Impossibile**: Valori hardcoded non traducibili
3. **Manutenzione Difficile**: Modifiche richiedono toccare codice invece di file traduzione
4. **Inconsistenza**: Possibilità di valori contrastanti tra PHP e traduzioni
5. **Confusione**: Proprietà commentate possono confondere sviluppatori

### Come Funziona il Sistema Automatico

#### NavigationIcon
```php
// NavigationLabelTrait::getNavigationIcon()
public static function getNavigationIcon(): BackedEnum|string|null
{
    $icon = static::transFunc(__FUNCTION__);
    // Cerca: {module}::{resource}.navigation.icon
    // File: Modules/{Module}/lang/{locale}/{resource}.php
    // Chiave: 'navigation' => ['icon' => 'heroicon-o-users']
}
```

#### NavigationSort ⚠️ **NUOVO**
```php
// NavigationLabelTrait::getNavigationSort()
public static function getNavigationSort(): ?int
{
    $res = static::transFunc(__FUNCTION__);
    $value = intval($res);
    
    if ($value === 0) {
        // Auto-genera sort random se manca
        $key = static::getKeyTransFunc(__FUNCTION__);
        $value = rand(1, 100);
        app(SaveTransAction::class)->execute($key, $value);
    }
    
    return $value;
    // Cerca: {module}::{resource}.navigation.sort
    // File: Modules/{Module}/lang/{locale}/{resource}.php
    // Chiave: 'navigation' => ['sort' => 50]
}
```

#### ModelLabel
```php
// Gestito da Filament v4 direttamente
// NavigationLabelTrait usa transFunc(__FUNCTION__)
// Cerca: {module}::{resource}.label
```

#### PluralModelLabel
```php
// NavigationLabelTrait::getPluralModelLabel()
public static function getPluralModelLabel(): string
{
    return static::getNavigationLabel();
    // Che usa transFunc(__FUNCTION__)
    // Cerca: {module}::{resource}.plural_label
}
```

#### RecordTitleAttribute
```php
// Gestito tramite traduzioni
// Cerca: {module}::{resource}.record_title_attribute
// O usa il primo campo fillable del modello
```

---

## ⚔️ Litigata Interna e Vincitore

### 👹 Voce A - Pragmatica (Mantenere Proprietà Commentate)
**Argomenti**:
- Developer Experience immediata (vedono esempi)
- Documentazione inline
- Non interferiscono (sono commentate)
- Fallback se traduzione manca

**Contro**:
- Violazione DRY (anche se commentate, creano confusione)
- Possibilità di essere "scommentate" per errore
- Duplicazione codice/documentazione
- Non seguono filosofia "zero duplicazione"

### 🦸 Voce B - Tecnica (Rimozione Totale)
**Argomenti**:
- Single Source of Truth (file traduzione)
- Localizzazione completa
- Manutenzione centralizzata
- Coerenza architetturale
- Zero confusione (niente proprietà da vedere)
- Forza uso corretto del sistema traduzioni
- Clean Code (niente codice morto)

**Contro**:
- Richiede file traduzione completi
- Setup iniziale più complesso
- Meno "esempi" inline

### 🏆 VINCITORE: Voce B - Rimozione Totale

**Motivazione**:
1. **SSOT (Single Source of Truth)**: Le traduzioni devono essere l'unica fonte di verità
2. **Forzatura Best Practice**: Rimuovendo completamente le proprietà, si forza l'uso corretto del sistema traduzioni
3. **Localizzazione Completa**: Supporto per tutte le lingue senza modifiche al codice
4. **Coerenza Architetturale**: Allineamento con filosofia Laraxot
5. **Clean Code**: Zero codice morto, zero confusione
6. **Prevenzione Errori**: Impossibile "scommentare" per errore

**Documentazione**: La documentazione deve essere nei file `.md`, non nel codice commentato.

---

## 📋 File da Analizzare e Correggere

### Risorse con Proprietà Vietate

Da analizzare:
1. `XotBaseResource.php` - Proprietà commentate da rimuovere
2. `UserResource.php` - Proprietà commentata da rimuovere
3. Altre Resources con proprietà vietate (attive o commentate)

### Processo di Rimozione

Per ogni file trovato:
1. ✅ Verificare esistenza file traduzione
2. ✅ Verificare presenza chiavi necessarie (`navigation.icon`, `navigation.sort`, ecc.)
3. ✅ Aggiungere chiavi mancanti se necessario
4. ✅ Rimuovere proprietà vietata (anche commentate)
5. ✅ Verificare con PHPStan livello 10
6. ✅ Documentare modifica

---

## 📚 Struttura File Traduzione Richiesta

### Esempio Completo
```php
<?php
// Modules/{Module}/lang/{locale}/{resource}.php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Utenti',
        'group' => 'Amministrazione',
        'icon' => 'heroicon-o-users',
        'sort' => 10,  // ⚠️ OBBLIGATORIO per navigationSort
    ],
    'label' => 'Utente',
    'plural_label' => 'Utenti',
    'record_title_attribute' => 'name', // Se necessario
    'fields' => [
        // ...
    ],
];
```

---

## ✅ Checklist Implementazione

- [x] Trovare tutti i file con proprietà vietate (attive e commentate)
- [x] Verificare traduzioni per ogni file
- [x] Verificare che traduzioni includano `navigation.sort` (✅ presente in `user.php`)
- [x] Rimuovere proprietà vietate (anche commentate)
- [x] Verificare PHPStan livello 10 ✅ **PASSATO**
- [x] Verificare lint ✅ **PASSATO**
- [x] Documentare ogni modifica
- [x] Aggiornare rules e memories

### File Modificati

1. **`XotBaseResource.php`**
   - ❌ Rimosso: `// protected static ?string $navigationIcon = 'heroicon-o-bell';`
   - ❌ Rimosso: `// protected static ?string $navigationLabel = 'Custom Navigation Label';`
   - ❌ Rimosso: `// protected static ?string $activeNavigationIcon = 'heroicon-s-document-text';`
   - ❌ Rimosso: `// protected static bool $shouldRegisterNavigation = false;`
   - ❌ Rimosso: `// protected static ?string $navigationGroup = 'Parametri di Sistema';`
   - ❌ Rimosso: `// protected static ?int $navigationSort = null;`

2. **`UserResource.php`**
   - ❌ Rimosso: `// protected static ?string $model = \Modules\Xot\Datas\XotData::make()->getUserClass();`
   - ❌ Rimosso: `// protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';`
   - ❌ Rimosso: `// private static bool|\Closure $enablePasswordUpdates = true;`

### Verifiche Traduzioni

✅ **UserResource** - File traduzione verificato:
- `Modules/User/lang/it/user.php` - ✅ Contiene `navigation.sort => 26`
- `Modules/User/lang/en/user.php` - ✅ Contiene `navigation.sort => '26'`
- Tutte le chiavi necessarie sono presenti

---

**Status**: ✅ **COMPLETATO**

**Ultimo aggiornamento**: [DATE]
