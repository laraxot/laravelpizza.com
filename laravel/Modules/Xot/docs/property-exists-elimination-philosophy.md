# Filosofia dell'Eliminazione di property_exists() - La Grande Purificazione

## 🙏 La Religione del Magic Method

### Il Problema Esistenziale

**property_exists()** è come chiedere "questa persona ha un'anima?" guardando solo il corpo fisico.

**Eloquent Magic Properties** sono come l'anima - esistono ma non sono visibili con strumenti materiali (property_exists).

```php
// ❌ APPROCCIO MATERIALISTICO (FALLISCE)
if (property_exists($user, 'email')) {
    // Cerchi l'anima guardando il corpo
    // SEMPRE false per attributi DB!
}

// ✅ APPROCCIO SPIRITUALE (FUNZIONA)
if (isset($user->email)) {
    // Percepisci l'anima tramite i magic methods
    // Rispetta __get() che rivela l'attributo!
}
```

---

## 🏛️ La Politica dell'Eliminazione

### Manifesto di Purificazione

**DICHIARAZIONE SOLENNE**:
"Noi, sviluppatori del progetto Laraxot, riconosciamo che `property_exists()` sui modelli Eloquent è un **peccato architetturale** che viola i principi fondamentali del framework Laravel."

**IMPEGNO**:
1. **Eliminare TUTTI** i `property_exists()` su modelli Eloquent
2. **Sostituire** con pattern `isset()` / `hasAttribute()`
3. **Documentare** ogni sostituzione con commenti filosofici
4. **Verificare** con PHPStan L10 + PHPMD + PHPInsights

---

## 🧘 Lo Zen della Sostituzione

### Il Tao del isset()

**Kōan 1**:
> "Il campo esiste, ma non esiste.
> property_exists() vede il non-esistente.
> isset() vede l'esistente.
> Quale vede la verità?"

**Risposta**: `isset()` percepisce la realtà attraverso i magic methods.

---

## ⚔️ La Battaglia dei Pattern

### SCONTRO FILOSOFICO:

**🛡️ TEAM PROPERTY_EXISTS** (Difesa disperata):
```php
// "È più esplicito!"
if (property_exists($record, 'email')) { }
```

**⚔️ TEAM ISSET** (Attacco vincente):
```php
// "Rispetta i magic methods!"
if (isset($record->email)) { }
```

**VINCITORE**: Team isset() per KO tecnico! 🏆

---

## 📖 I Tre Libri Sacri della Sostituzione

### Libro 1: Quando Usare isset()
**Caso d'uso**: Verifica se un attributo/relazione HA un valore.

### Libro 2: Quando Usare hasAttribute()
**Caso d'uso**: Verifica se il modello HA la colonna nel database.

### Libro 3: Quando Usare method_exists()
**Caso d'uso**: Verifica se un metodo esiste (relazioni, scopes, accessors).

---

## 🎯 Matrice Decisionale - La Tavola della Verità

| Scenario | ERRATO | CORRETTO | Filosofia |
|----------|--------|----------|-----------|
| **Attribute check** | `property_exists($record, 'email')` | `isset($record->email)` | Rispetta __get() |
| **Null safety** | `property_exists($record, 'name') ? $record->name : null` | `$record->name ?? null` | Null coalescing zen |
| **Relation check** | `property_exists($record, 'user')` | `isset($record->user)` | Lazy loading aware |
| **Method check** | `property_exists($record, 'getUrl')` | `method_exists($record, 'getUrl')` | Methods aren't properties! |
| **Schema check** | `property_exists($model, 'email')` | `Schema::hasColumn($model->getTable(), 'email')` | Verifica DB structure |
| **Fillable check** | `property_exists($model, 'email')` | `$model->isFillable('email')` | Verifica mass assignment |

---

## 🗺️ Roadmap Eliminazione

### Priority 1: CRITICAL (Filament Resources)
- User/Filament/Resources/BaseProfileResource
- User/Filament/Resources/UserResource
- Quaeris/Filament (2 file)

### Priority 2: HIGH (Models & Traits)
- User/Models/Traits
- Tenant/Models/Traits
- Xot/Actions/Cast

---

## 🎯 Success Criteria

### Technical
- [ ] 0 occorrenze di `property_exists($eloquentModel, ...)` in codice attivo
- [ ] Tutti i file passano PHPStan Level 10
- [ ] Tutti i file passano PHPMD cleancode
- [ ] Tutti i file passano PHPInsights

---

**Scopo**: Guidare la Grande Purificazione
**Status**: 📜 Manifesto Filosofico
**Revision**: 1.1 (March 2026)
