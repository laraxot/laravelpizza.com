# 🔧 REGOLE FONDAMENTALI - RELAZIONI LARAVEL

**Priority**: 🔥 **CRITICAL** - Non violare MAI  
**Updated**: 2026-02-10

---

## 🚨 REGOLA #1: BELONGSTOMANYX SEMPRE!

**MAI USARE**: `belongsToManyX()`
**SEMPRE USARE**: `belongsToMany()`

### ❌ Codice SBAGLIATO DA CORREGGERE
```php
// ❌ MAI USARE QUESTO CODICE!
public function attendees(): Collection
{
    return $this->belongsToManyX(User::class, 'event_attendees');
}
```

### ✅ Codice CORRETTO DA USARE
```php
// ✅ SEMPRE QUESTO CODICE!
public function attendees(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'event_attendees');
}
```

---

## 📋 Perché belongsToManyX() È Pericoloso

### 1. **Silent Data Corruption**
- Non genera eccezioni quando dati non esistono
- Crea record "fantasma" o incompleti
- Il database si corrompe senza che nessuno se accorga

### 2. **Performance Catastrophe**
- Esegue N+1 query invece di JOIN ottimizzato
- Perde tutti i benefici di eager loading
- Il codice pensa che i dati esistano quando non è vero

### 3. **Debugging Impossibile**
- Errori invisibili che non possono essere tracciati
- Gli utenti vedono dati errati senza sapere perché
- I log non mostrano la vera origine del problema

### 4. **Production Crashes**
- Errori 500 imprevisti in produzione
- Il sito diventa inutilizzabile
- Perdita di dati e fiducia degli utenti

---

## 🎯 Pattern Corretti

### ✅ belongsToMany() - RELAZIONI STANDARD
```php
// ✅ One-to-Many
public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}

// ✅ Many-to-Many con pivot data
public function tags(): BelongsToMany
{
    return $this->belongsToMany(Tag::class, 'post_tags')
                ->withPivot(['created_at', 'sort_order']);
}

// ✅ One-to-One
public function profile(): HasOne
{
    return $this->hasOne(Profile::class);
}
```

### ✅ Eager Loading
```php
// ✅ Ottimizzato con eager loading
$post = Post::with(['comments', 'tags', 'author'])->find($id);
```

### ✅ Query Building
```php
// ✅ Filtraggio con where e orderBy
$activeUsers = User::where('active', true)->orderBy('last_login', 'desc')->get();
```

---

## 📋 When to Use belongsToManyX() 

### ⚠️ SOLO IN QUESTI CASI RARI
1. **Legacy Code Compatibility** - SOLO se migrando da sistema pre-esistente
2. **Cross-Database Queries** - SOLO se hai specifiche esigenze particolari
3. **Relazioni Virtuali** - SOLO per casi documentati

### ✅ Esempi Validi di belongsToManyX()
```php
// ✅ Solo per casi ECCEZIONALI!
public function events(): Collection
{
    return $this->belongsToManyX(Event::class, 'user_events', UserEvent::class);
}
```

---

## 🚀 ACTIONS OBBLIGATORIE

### 1. 🔍 VERIFICARE SUBITO
```bash
# Verifica se qualcuno usa ancora belongsToManyX()
find . -name "*.php" | xargs grep -l "belongsToManyX" | grep -v "laravel/vendor"
```

### 2. ✅ SOSTITUIRE SUBITO
```bash
# Sostituisci tutti i belongsToManyX con belongsToMany
find . -name "*.php" -exec sed -i 's/belongsToManyX/belongsToMany/g' {} \;
```

### 3. 🧪 TESTARE ACCURATAMENTE
```bash
# Esegui test completi di tutte le relazioni
php artisan test --testsuite="relationships"
```

### 4. 📚 DOCUMENTARE
```markdown
# Aggiorna documentazione ufficiale
# Crea guide "when-to-use-belongstomanyx.md"
```

---

## 🎯 MEMORIE DA CREARE

`:memory.critical-laravel-relationships`  
`:memory.anti-patterns-laravel-relazioni`

**Contenuto**: "MAI VIOLARE: belongsToManyX() - USA SEMPRE belongsToMany()"

---

## 📋 CHECKLIST PER OGNI Sviluppatore

- [ ] Ho usato `belongsToManyX()` in nuovo codice? ❌
- [ ] Ho controllato che il codice non usi `belongsToManyX()`? ✅
- [ ] Tutte le relazioni usano pattern standard? ✅
- [ ] PHPStan Level 10 senza errori? ✅
- [ ] Performance testing superato? ✅

---

## 🎉 CONCLUSIONE

**`belongsToManyX()` è un ANTI-PATTERN da evitare assolutamente!**

**REGOLA D'ORO**: **SEMPRE usare `belongsToMany()`** per relazioni reali Laravel.
**`belongsToManyX()` solo per casi eccezionali documentati e ben compresi.**

**Violare questa regola = rischiare crash in produzione!** ⚠️