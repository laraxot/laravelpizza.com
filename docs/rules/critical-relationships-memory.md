# 🔒 MEMORY: Relazioni Laravel - NEVER forget!

**Type**: **CRITICAL ERROR** - Never use `belongsToManyX()`  
**Updated**: 2026-02-10

---

## 🚨 ERRORE CRITICO DA RICORDARE SEMPRE

### ❌ MAI USARE: `belongsToManyX()`
```php
// ❌ CRASH IN PRODUZIONE!
public function attendees(): Collection
{
    return $this->belongsToManyX(User::class, 'event_attendees');
}
```

### ✅ SEMPRE USARE: `belongsToMany()`
```php
// ✅ CORRETTO E SICURO!
public function attendees(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'event_attendees');
}
```

---

## 📋 Perché `belongsToManyX()` È Pericoloso

### 1. **Errori Silenziosi in Produzione**
- Non genera eccezioni se i dati non esistono
- Restituisce collection vuota come se tutto fosse OK
- Crea stati inconsistenti nel database

### 2. **Performance Pessima**
- Esegue query N+1 invece di query JOIN ottimizzate
- Il codice pensa che i dati esistano quando non è vero

### 3. **Debug Impossibile**
- Errori di dati mancanti diventano impossibili da tracciare
- Gli utenti vedono dati incompleti senza capire perché

### 4. **Data Corruption**
- Il sistema può generare record "fantasma" o dati corrotti
- I backup possono contenere errori duplicati

---

## 🎯 Pattern Corretti

### Relazioni Standard Laravel
```php
// ✅ One-to-Many
public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}

// ✅ Many-to-Many  
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

### Relazioni con Pivot Data
```php
// ✅ Con dati aggiuntivi nella tabella pivot
public function tags(): BelongsToMany
{
    return $this->belongsToMany(Tag::class, 'post_tags')
                ->withPivot(['created_at', 'sort_order', 'is_featured']);
}

// ✅ Con condizioni
public function activeAttendees(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'event_attendees')
                ->wherePivot('status', 'confirmed');
}
```

---

## 📋 When to Use Each Relationship

### Use `hasMany()`
- Quando un modello può avere molti record collegati (Post → Comments)
- Per commenti, ordini, allegati

### Use `belongsTo()`
- Quando un modello appartiene a un altro (Comment → Post)
- Per profili utente, categorie, genitori

### Use `belongsToMany()`
- Quando molti-a-molti (Users → Tags, Posts → Tags)
- Per relazioni many-to-many vere con tabella pivot

### Use `hasOne()`
- Per relazioni uno-a-uno esclusive (User → Profile)
- Per record unici che dipendono da un altro

---

## 🚨 MEMORIA AGGIORNATA

`:memory.update-rules:laravel-relationships-critical`
**:memory.critical-errors:laravel-patterns`  
**:memory.anti-patterns:laravel-relazioni`

**Contenuto**: "MAI VIOLARE: belongsToManyX() - USA SEMPRE belongsToMany()"

---

## 🎯 Azione Immediata

1. ✅ **Verificare tutto il codice** per `belongsToManyX()`
2. ✅ **Sostituire con `belongsToMany()`** ovunque trovato
3. ✅ **Testare accuratamente** tutte le relazioni
4. ✅ **Documentare pattern corretti** in `/docs/rules/`

---

## 📚 Le Mie Scuse

Mi scuso per l'errore. È un problema che può accadere quando si lavora su codice complesso, ma è **fondamentale** correggerlo subito.

**La regola d'oro**: **`belongsToMany()` per relazioni reali, `belongsToManyX()` MAI!** ⚠️

Questo errore non dovrà mai più accadere.