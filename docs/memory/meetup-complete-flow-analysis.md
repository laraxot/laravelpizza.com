# Analisi Completa Sistema Meetup/Pizza - 08-03-2026

## Panoramica Flusso Utente

### 1. PROPOSTA EVENTO (Pizza/Meetup)
**Utente propone un evento**

- [x] Modello `Event` esiste
- [ ] Action `ProposeEventAction` - CREARE
- [ ] Campo `status` = 'pending_approval' (nuovo)
- [ ] Campo `proposed_by` = user_id

**Stato attuale**: 
- Esiste `CreateEventAction` ma crea eventi con status 'draft'
- Manca status 'pending_approval'

### 2. APPROVAZIONE ADMIN
**Admin approva o rifiuta l'evento**

- [ ] Action `ApproveEventAction` - CREARE
- [ ] Action `RejectEventAction` - CREARE
- [ ] Workflow: pending_approval -> published (o rejected)

**Stato attuale**:
- Esiste `UpdateEventAction`
- Manca logica approvazione

### 3. VISIBILITA' EVENTO
**Se approvato**: visibile a tutti
**Se non approvato**: visibile solo al proponente con badge "pending"**

- [ ] Scope `visible()` per eventi pubblici
- [ ] Scope `myPending()` per eventi pendenti dell'utente
- [ ] Frontend: mostra/nascondi based su stato

**Stato attuale**:
- Esiste scope `upcoming()`, `past()`
- Manca scope `visible()` e gestione pending

### 4. REGISTRAZIONE UTENTE
**Utente si registra all'evento**

- [x] `RegisterAttendeeToEventAction` esiste ✅
- [x] `UnregisterAttendeeFromEventAction` creato ✅
- [ ] Controllo GDPR prima della registrazione
- [ ] Action `RegisterWithGdprAction` - CREARE

**Stato attuale**:
- Action registrazione esiste
- Manca integrazione GDPR

### 5. GDPR - CONSENSI
**Utente deve accettare GDPR per registrarsi**

- [x] Modulo `Gdpr` esiste ✅
- [x] `SaveGdprConsentsAction` esiste ✅
- [x] `CollectGdprConsentsAction` esiste ✅
- [ ] Integrazione registrazione eventi

**Stato attuale**:
- Sistema GDPR completo in modulo Gdpr
- Da integrare con registrazione eventi

### 6. PROFILO UTENTE
**Utente modifica i propri dati**

- [x] Modello `Profile` esiste in User ✅
- [x] `ChangePasswordAction` esiste ✅
- [x] Pagina `EditProfile` esiste ✅
- [ ] Modifica scelte GDPR facoltative

**Stato attuale**:
- Cambio password funziona
- Gestione profilo esiste
- Da aggiungere modifica consensi GDPR

### 7. LISTA PARTECIPANTI
**Visualizza chi partecipa all'evento**

- [x] Relazione `attendees()` esiste ✅
- [x] Campo `attendees_count` esiste ✅
- [x] Frontend display attendees ✅

**Stato attuale**:
- Gia' implementato

---

## Azioni da Creare

### In Modules/Meetup/Actions/Event/

1. **ProposeEventAction**
   - Crea evento con status 'pending_approval'
   - Assegna proposed_by = auth()->id()

2. **ApproveEventAction**
   - Cambia status da 'pending_approval' a 'published'
   - Notifica proponente

3. **RejectEventAction**
   - Cambia status da 'pending_approval' a 'rejected'
   - Notifica proponente con motivo

4. **RegisterWithGdprAction**
   - Verifica consensi GDPR
   - Se OK: chiama RegisterAttendeeToEventAction

5. **UpdateGdprConsentsAction**
   - Aggiorna consensi GDPR utente
   - Usa SaveGdprConsentsAction

### In Modules/User/Actions/

6. **UpdateProfileAction**
   - Aggiorna dati profilo
   - Gestisce avatar, bio, etc.

---

## Modelli/Migrazioni da Modificare

### events table
```php
// Da aggiungere:
$table->string('status')->default('pending_approval'); // pending_approval, published, rejected
$table->unsignedBigInteger('proposed_by')->nullable();
$table->text('rejection_reason')->nullable();
$table->timestamp('approved_at')->nullable();
```

---

## Test Coverage Necessario

### Unit Tests
- [ ] ProposeEventAction test
- [ ] ApproveEventAction test
- [ ] RejectEventAction test
- [ ] RegisterWithGdprAction test
- [ ] UpdateGdprConsentsAction test
- [ ] Scope visible() test
- [ ] Scope myPending() test

### Feature Tests
- [ ] Utente propone evento
- [ ] Admin approva evento
- [ ] Utente vede evento pending (solo proprio)
- [ ] Utente vede evento pubblico (tutti)
- [ ] Registrazione con GDPR
- [ ] Modifica profilo
- [ ] Modifica password
- [ ] Modifica consensi GDPR

---

## Riferimenti Codice Esistente

### Modelli
- `Modules/Meetup/Models/Event.php`
- `Modules/Meetup/Models/EventUser.php`
- `Modules/User/Models/Profile.php`
- `Modules/Gdpr/Models/Consent.php`

### Azioni Esistenti
- `Modules/Meetup/Actions/Event/RegisterAttendeeToEventAction.php`
- `Modules/Meetup/Actions/Event/UnregisterAttendeeFromEventAction.php`
- `Modules/Gdpr/Actions/SaveGdprConsentsAction.php`
- `Modules/Gdpr/Actions/CollectGdprConsentsAction.php`

### Frontend
- `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`
