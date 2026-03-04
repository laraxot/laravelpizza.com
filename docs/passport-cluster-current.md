# Passport Cluster - Status Attuale e Lavoro Necessario

**Status**: ✅ COMPLETATO
**Metodologia**: Super Mucca
**Vedi**: [passport-cluster-implementation-completed.md](./passport-cluster-implementation-completed.md)

---

## 📋 Situazione Attuale

### ✅ File Esistenti

1. **OauthClientResource.php** - ✅ Esiste ma ha problemi:
   - ❌ Usa `table()` method (final in XotBaseResource - VIETATO)
   - ❌ Override `getModel()` non necessario
   - ❌ Manca `protected static ?string $cluster = Passport::class;`
   - ✅ Namespace corretto: `Modules\User\Filament\Clusters\Passport\Resources`
   - ✅ Pages esistenti ma alcune con namespace sbagliato

2. **OauthAccessTokenResource.php** - ✅ Esiste e corretto:
   - ✅ Namespace corretto
   - ✅ `$cluster` presente
   - ✅ `getFormSchema()` corretto
   - ✅ `getPages()` corretto
   - ✅ Pages esistenti

3. **OauthAuthCodeResource.php** - ⚠️ Esiste ma namespace sbagliato:
   - ❌ Namespace: `Modules\User\Filament\Resources` (SBAGLIATO)
   - ✅ Deve essere: `Modules\User\Filament\Clusters\Passport\Resources`
   - ✅ `$cluster` presente
   - ✅ Pages esistenti ma namespace da correggere

### ❌ File Mancanti

1. **OauthRefreshTokenResource.php** - ❌ NON ESISTE
   - Pages esistenti: ViewOauthRefreshToken.php
   - Pages mancanti: ListOauthRefreshTokens.php

2. **OauthPersonalAccessClientResource.php** - ❌ NON ESISTE
   - Pages esistenti: List, Create, Edit, View
   - Resource mancante

---

## 🔧 Correzioni Necessarie

### 1. OauthClientResource
- [ ] Rimuovere metodo `table()` (final in XotBaseResource)
- [ ] Aggiungere `protected static ?string $cluster = Passport::class;`
- [ ] Rimuovere override `getModel()` se non necessario
- [ ] Correggere namespace pages se necessario
- [ ] Usare `getTableColumns()` invece di `table()` se serve personalizzazione

### 2. OauthAuthCodeResource
- [ ] Spostare da `Modules\User\Filament\Resources` a `Modules\User\Filament\Clusters\Passport\Resources`
- [ ] Aggiornare namespace nelle pages
- [ ] Verificare che tutto funzioni

### 3. OauthRefreshTokenResource
- [ ] Creare resource principale
- [ ] Creare ListOauthRefreshTokens page
- [ ] Verificare ViewOauthRefreshToken page

### 4. OauthPersonalAccessClientResource
- [ ] Creare resource principale
- [ ] Verificare tutte le pages (List, Create, Edit, View)

---

## 📊 Struttura Attesa Finale

```
Modules/User/app/Filament/Clusters/Passport/
├── Passport.php (✅ Esiste)
└── Resources/
    ├── OauthClientResource.php (⚠️ Da correggere)
    │   └── Pages/ (✅ Esistono, alcuni namespace da correggere)
    ├── OauthAccessTokenResource.php (✅ Corretto)
    │   └── Pages/ (✅ Esistono)
    ├── OauthAuthCodeResource.php (⚠️ Da spostare/correggere)
    │   └── Pages/ (✅ Esistono, namespace da correggere)
    ├── OauthRefreshTokenResource.php (❌ DA CREARE)
    │   └── Pages/ (⚠️ Parzialmente esistenti)
    └── OauthPersonalAccessClientResource.php (❌ DA CREARE)
        └── Pages/ (✅ Esistono)
```

---

## 🎯 Priorità

1. **CRITICAL**: Correggere OauthClientResource (rimuovere table(), aggiungere $cluster)
2. **HIGH**: Spostare OauthAuthCodeResource nel namespace corretto
3. **HIGH**: Creare OauthRefreshTokenResource
4. **HIGH**: Creare OauthPersonalAccessClientResource
5. **MEDIUM**: Correggere namespace delle pages

---

**
**Versione**: 1.0.0
**Status**: 🔴 IN LAVORO
