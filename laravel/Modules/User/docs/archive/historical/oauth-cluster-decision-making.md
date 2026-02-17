# OAuth Cluster - Processo Decisionale

**Data**: 2025-01-22
**Metodologia**: Super Mucca
**Filosofia**: DRY + KISS + Organizzazione Logica

---

## 🧠 La Litigata Interna

### Contesto
Devo creare un cluster Filament per raggruppare tutte le risorse Passport/OAuth nel modulo User. Attualmente ci sono 5 risorse sparse nella navigazione.

### Le Voci in Dibattito

#### 🗣️ Voce A - Cluster Minimale (Solo Cluster Base)
> "Creiamo solo il cluster base OAuthApi che estende XotBaseCluster, senza page Settings. È KISS - facciamo solo quello che serve ora."

**Argomenti a favore**:
- ✅ KISS estremo - solo cluster base
- ✅ Implementazione rapida
- ✅ Zero complessità aggiuntiva
- ✅ Può essere esteso in futuro se necessario

**Argomenti contro**:
- ❌ Perde opportunità di centralizzare configurazione
- ❌ Admin deve andare in PassportServiceProvider per settings
- ❌ Meno valore immediato

---

#### 🗣️ Voce B - Cluster Completo (Cluster + Settings Page)
> "Creiamo cluster base E page Settings per gestire token expiration e scopes. Centralizziamo tutta la gestione OAuth in un unico posto."

**Argomenti a favore**:
- ✅ Centralizza tutta la gestione OAuth
- ✅ Admin può modificare settings da Filament
- ✅ Migliore UX - tutto in un posto
- ✅ Coerenza con filosofia "tutto gestibile da admin panel"

**Argomenti contro**:
- ❌ Aggiunge complessità (page Settings)
- ❌ Settings sono già in PassportServiceProvider
- ❌ Potrebbe essere over-engineering
- ❌ Richiede più tempo implementazione

---

#### 🗣️ Voce C - Cluster Base + Documentazione (SCELTA)
> "Creiamo cluster base minimale, spostiamo tutte le risorse, documentiamo il pattern. Se in futuro serve Settings page, la aggiungiamo. Ora facciamo solo quello che serve."

**Argomenti a favore**:
- ✅ KISS - solo quello che serve
- ✅ DRY - pattern documentato e riusabile
- ✅ Organizzazione logica immediata
- ✅ Facile estendere in futuro
- ✅ Rispetta filosofia "docs prima"
- ✅ Zero over-engineering

**Argomenti contro**:
- ❌ Settings rimangono in PassportServiceProvider (ma va bene così)

---

## 🏆 Il Vincitore: Voce C

### Perché Ha Vinto

1. **Rispetta KISS Estremo**
   - Fa solo quello che serve: raggruppare risorse
   - Zero complessità aggiuntiva
   - Implementazione veloce

2. **È DRY**
   - Pattern documentato e riusabile
   - Altri moduli possono seguire lo stesso pattern
   - Documentazione chiara per futuro

3. **Organizzazione Immediata**
   - Risolve il problema principale: risorse sparse
   - Navigazione più chiara subito
   - Zero attesa per valore

4. **Estendibilità Futura**
   - Se serve Settings page, si aggiunge facilmente
   - Cluster base è già pronto
   - Non blocca future evoluzioni

5. **Rispetta Filosofia Progetto**
   - Docs prima del codice
   - DRY + KISS estremi
   - Qualità maniacale senza over-engineering

### Decisione Finale

**Implementazione**:
1. ✅ Creare cluster `Passport` che estende `XotBaseCluster`
2. ✅ Posizionare le risorse OAuth sotto `app/Filament/Clusters/Passport/Resources`
3. ✅ Lasciare che Filament le scopra tramite `discoverClusters()` (Filament v4 scopre anche le Resource dentro la directory dei cluster)
4. ✅ Evitare duplicazioni: non mantenere una seconda copia delle stesse resource in `app/Filament/Resources` (collisioni di slug/route)
5. ⏸️ Settings page: da implementare in futuro se necessario

**Pattern da Seguire**:
- Cluster estende `XotBaseCluster` (non `Filament\Clusters\Cluster` direttamente)
- Le Resource OAuth stanno sotto `Modules/User/app/Filament/Clusters/Passport/Resources`
- Ogni Resource del cluster imposta `protected static ?string $cluster = \Modules\User\Filament\Clusters\Passport::class;`
- Discovery: il panel provider deve chiamare `discoverClusters(...)` (già fatto da `XotBasePanelProvider`)
- Anti-duplicazione: una sola fonte di verità per ogni Resource (evitare duplicati top-level)

---

## 📋 Implementazione Step-by-Step

### Step 1: Creare Cluster
```php
// Modules/User/app/Filament/Clusters/Passport.php
class Passport extends XotBaseCluster
{
    // Minimale - solo cluster base
}
```

### Step 2: Spostare Risorse
Per ogni risorsa OAuth nel cluster:
```php
protected static ?string $cluster = \Modules\User\Filament\Clusters\Passport::class;
```

### Step 3: Verificare Navigation
- Cluster gestirà automaticamente la navigazione
- Verificare che icona e label siano corrette

### Step 4: Documentare
- Aggiornare docs con pattern implementato
- Documentare decisioni e futuro

---

## 🎯 Risultato Atteso

### Prima (Risorse Sparse)
```
Navigation:
- OAuth Clients
- OAuth Access Tokens
- OAuth Refresh Tokens
- OAuth Auth Codes
- OAuth Personal Access Clients
```

### Dopo (Cluster Organizzato)
```
Navigation:
- Passport (Cluster)
  ├── OAuth Clients
  ├── OAuth Access Tokens
  ├── OAuth Refresh Tokens
  ├── OAuth Auth Codes
  └── OAuth Personal Access Clients
```

---

## 🔮 Futuro (Se Necessario)

Se in futuro serve Settings page:
1. Creare `OAuthApi/Pages/Settings.php`
2. Estendere `XotBasePage`
3. Aggiungere form per token expiration e scopes
4. Documentare estensione

**Ma per ora**: Cluster base è sufficiente.

---

**Filosofia Applicata**:
> "Fai solo quello che serve ora.
> Documenta il pattern per il futuro.
> Estendi solo quando necessario.
> KISS sempre e comunque."

---

**Ultimo aggiornamento**: 2025-01-22
**Versione**: 1.0.0
**Status**: Decisione consolidata - da implementare
