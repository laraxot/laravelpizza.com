# 🚨 CRITICAL MEMORY - belongsToManyX Pattern

## ⚠️ ERRORE GRAVE IDENTIFICATO

**Hai DIMENTICATO la regola FONDAMENTALE del progetto!**

**Non usare MAI**: `$this->belongsToMany()`
**USA SEMPRE**: `$this->belongsToManyX()`

---

## 🎯 REGOLA CRITICA - belongsToManyX

### **PERCHÉ belongsToManyX è OBBLIGATORIO**

1. **Auto-Pivot Management**: Gestisce automaticamente tabella pivot
2. **Cross-Database Compatibility**: Funziona tra database diversi  
3. **WithPivot Automatic**: Include automaticamente campi pivot
4. **Timestamps Automatici**: Created_at/updated_at sulla pivot
5. **Laraxot Pattern**: È il trait standard del progetto

### **Cosa fa belongsToManyX**

```php
// ✅ CORRETTO - Laraxot RelationX Trait
public function users(): BelongsToMany
{
    return $this->belongsToManyX(User::class);
}

public function tags(): BelongsToMany  
{
    return $this->belongsToManyX(Tag::class, 'post_tag');
}

// Con pivot custom
public function roles(): BelongsToMany
{
    return $this->belongsToManyX(Role::class, 'user_roles')
        ->withPivot(['expires_at', 'permissions'])
        ->withTimestamps();
}
```

### **Cosa NON fa belongsToMany (standard Laravel)**

```php
// ❌ SBAGLIATO - Non usare MAI in questo progetto
public function users(): BelongsToMany
{
    return $this->belongsToMany(User::class);
}
```

---

## 🗂️ MEMORIA TECNICA - RelationX Trait

### **Locazione Trait**
```
Modules/Xot/app/Models/Traits/RelationX.php
```

### **Funzionalità Principali**
- ✅ `belongsToManyX()` - Relazioni many-to-many auto-gestite
- ✅ `hasManyThroughX()` - Relazioni through multiple
- ✅ `morphToManyX()` - Relazioni many-to-many polimorfe
- ✅ Gestione automatica timestamps su pivot
- ✅ Cross-database compatibility
- ✅ Integrata con Model events

---

## 📋 **PATTERN DA SEGUIRE SEMPRE**

### **1. In Modello**
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Xot\Models\Traits\RelationX;

class Event extends BaseModel
{
    use RelationX;
    
    // ✅ CORRETTO - Relazione attendees
    public function attendees(): BelongsToMany
    {
        return $this->belongsToManyX(User::class, 'event_attendee');
    }
    
    // ✅ CORRETTO - Relazione sponsors  
    public function sponsors(): BelongsToMany
    {
        return $this->belongsToManyX(Organization::class, 'event_sponsor')
            ->withPivot(['sponsorship_level', 'is_main_sponsor'])
            ->withTimestamps();
    }
    
    // ❌ SBAGLIATO - MAI USARE!
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class); // FORBIDDEN!
    }
}
```

### **2. In Migration**
```php
// ✅ CORRETTO - Migration pivot con belongsToManyX
public function up(): void
{
    Schema::create('event_attendee', function (Blueprint $table) {
        $table->uuid('event_id');
        $table->uuid('user_id');
        $table->timestamps(); // belongsToManyX gestisce automaticamente
        $table->foreign('event_id')->references('id')->on('meetup_events')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}
```

### **3. In Filament Resource**
```php
// ✅ CORRETTO - Risorsa che usa belongsToManyX
class EventResource extends XotBaseResource
{
    protected static ?string $model = Event::class;
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ✅ Funziona automaticamente con belongsToManyX
                Forms\Components\Repeater::make('attendees')
                    ->relationship('attendees') // uses belongsToManyX()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->email(),
                    ]),
            ]);
    }
}
```

---

## 🚨 **CONSEGUENZE SE VIOLI LA REGOLA**

### **1. Errori Sistemazione**
- ❌ Le relazioni non funzionano correttamente
- ❌ Dati non salvati in tabella pivot
- ❌ Query inefficienti o errate
- ❌ Cross-database incompatibilità

### **2. Problemi Performance**
- ❌ Query N+1 non ottimizzate
- ❌ Mancanza automatica eager loading
- ❌ Callbacks non eseguiti

### **3. Bugs Critici**
- ❌ L'evento non ha attendees/participants
- ❌ Sponsors non associati correttamente  
- ❌ Tags non funzionanti

---

## 🎯 **CHECKLIST DI VERIFICA**

### **Per ogni relazione many-to-many:**

- [ ] Sto usando `belongsToManyX()`? ✅/❌
- [ ] Ho importato `RelationX` trait? ✅/❌
- [ ] La pivot table ha timestamps? ✅/❌
- [ ] Le foreign keys sono corrette? ✅/❌
- [ ] Filament relationship function usa `belongsToManyX`? ✅/❌

### **Correzione Automatica Script:**

```bash
# Trova tutti i belongsToMany sbagliati
find Modules/ -name "*.php" -exec grep -l "belongsToMany(" {} \;

# Sostituisci con belongsToManyX
find Modules/ -name "*.php" -exec sed -i 's/belongsToMany(/belongsToManyX(/g' {} \;

# Verifica la correzione
find Modules/ -name "*.php" -exec grep -l "belongsToManyX(" {} \;
```

---

## 📚 **DOCUMENTAZIONE DI RIFERIMENTO**

### **File da Studiare:**
1. `Modules/Xot/docs/traits/relation-x.md` - Documentazione ufficiale
2. `Modules/Xot/app/Models/Traits/RelationX.php` - Implementazione trait
3. `Modules/Meetup/docs/belongstomanyx-critical.md` - This file

### **Pattern Esempio:**
```php
// Event ↔ Many Users (attendees)
// Event ↔ Many Organizations (sponsors)  
// Event ↔ Many Tags (categories)
// User ↔ Many Events (attended_events)
```

---

## 🔄 **AZIONI IMMEDIATE**

### **1. Correggi Event Model**
```php
// Verifica tutti i belongsToMany() in Event.php
// Sostituiscili con belongsToManyX()
```

### **2. Correggi Migration**
```php
// Assicurati che le tabelle pivot abbiano timestamps()
// Verifica foreign keys corrette
```

### **3. Correggi Resources**  
```php
// Verifica che Filament usi belongsToManyX()
// Testa form relationships
```

---

## ⚡ **RICAPITOLATIVO**

**REMEMBER**: `belongsToManyX()` è FONDAMENTALE in questo progetto!

**Pattern Laraxot** → Cross-database, auto-pivot, performance

**Pattern Standard Laravel** → Solo progetti semplici

**NON DIMENTICARLE MAI!**

---

**AGGIORNATO**: 2026-02-02  
**GRAVITÀ**: 🔴 CRITICAL - Potrebbe rompere l'intera applicazione  
**STATO**: ⚠️ DA IMPLEMENTARE SUBITO in tutti i moduli