# 🎯 PIANO D'AZIONE IMMEDIATO - FixCity Platform

## 📋 Sommario Esecutivo

Questo documento identifica le **azioni immediate** da intraprendere per portare FixCity alla versione 2.0.0 production-ready. Basato sull'analisi completa del progetto e le roadmap dei moduli.

**Data**: 2025-01-01  
**Status Attuale**: 60% completo  
**Target**: Q2 2025 (Aprile-Giugno)

---

## 🚨 Priorità CRITICHE (Settimana 1-2)

### 1. ✅ Correzioni Tecniche Base (COMPLETATE)
- [x] Fix BaseUser.php syntax errors
- [x] Formattazione con Pint
- [x] Verifica sintassi PHP

### 2. 🚧 Risoluzione Conflitti Git
- [ ] Identificare tutti i conflitti rimasti
- [ ] Risolverli manualmente uno per uno
- [ ] Verificare che non ci siano file corrotti
- [ ] Commit consolidato

### 3. 🔧 Stabilizzazione Moduli Core
- [ ] **Modulo User**
  - [ ] Rimuovere file docs duplicati (300+ files!)
  - [ ] Consolidare namespace (rimuovere `App`)
  - [ ] Completare factories per tutti i models

- [ ] **Modulo Fixcity**
  - [ ] Verificare tutti i metodi incompleti
  - [ ] Testare workflow completo
  - [ ] Aggiungere validation rules

- [ ] **Modulo Cms**
  - [ ] Ottimizzare query N+1
  - [ ] Implementare caching pagine
  - [ ] Fix media upload

### 4. 📦 Build & Deploy Check
- [ ] Verificare build processo funzionante
- [ ] Test su ambiente staging
- [ ] Verificare tutti gli asset compilano correttamente

---

## ⚡ Priorità ALTE (Settimana 3-6)

### Frontend Cittadino (Theme Sixteen)

#### Settimana 3-4: Ticket Creation Flow
**Obiettivo**: Permettere ai cittadini di creare segnalazioni facilmente

**Tasks**:
1. [ ] **Form Multi-Step** (`resources/views/pages/tickets/create.blade.php`)
   ```php
   <?php
   use function Livewire\Volt\{state, form};
   
   state(['step' => 1, 'formData' => []]);
   
   $nextStep = function() {
       $this->step++;
   };
   
   $prevStep = function() {
       $this->step--;
   };
   
   $submit = function() {
       // Validazione e creazione ticket
   };
   ?>
   
   <div>
       @if($step === 1)
           {{-- Step 1: Categoria e Localizzazione --}}
       @elseif($step === 2)
           {{-- Step 2: Descrizione e Media --}}
       @elseif($step === 3)
           {{-- Step 3: Contatti --}}
       @else
           {{-- Step 4: Riepilogo --}}
       @endif
   </div>
   ```

2. [ ] **Map Picker**
   - Integrazione Leaflet o Mapbox
   - Geolocalizzazione automatica
   - Marker draggable
   - Reverse geocoding

3. [ ] **Media Upload**
   - Drag & drop
   - Preview immediato
   - Validazione client-side
   - Resize automatico

4. [ ] **Validation & UX**
   - Inline validation
   - Error messages chiare
   - Success feedback
   - Loading states

**Deliverable**: Cittadini possono creare segnalazioni complete

#### Settimana 5-6: Ticket List & Detail
**Obiettivo**: Visualizzazione e interazione con segnalazioni

**Tasks**:
1. [ ] **Ticket List** (`resources/views/pages/tickets/index.blade.php`)
   - Grid/List view toggle
   - Filters (status, category, date)
   - Sort options
   - Pagination
   - Map view

2. [ ] **Ticket Detail** (`resources/views/pages/tickets/[slug].blade.php`)
   - Info complete
   - Timeline stati
   - Gallery immagini
   - Comments thread
   - Share buttons

3. [ ] **Search & Filters**
   - Full-text search
   - Category filter
   - Status filter
   - Date range
   - Location filter (near me)

**Deliverable**: Cittadini possono trovare e monitorare segnalazioni

---

### Backend Admin (Filament)

#### Settimana 3-4: Ticket Management
**Obiettivo**: Admin possono gestire segnalazioni efficacemente

**Tasks**:
1. [ ] **TicketResource Enhancement**
   - Aggiungere bulk actions
   - Migliorare filtri
   - Aggiungere statistiche
   - Export capabilities

2. [ ] **Workflow Actions**
   - Approve action
   - Reject action
   - Assign action
   - Close action

3. [ ] **Notifications**
   - Email su status change
   - Push notifications
   - In-app notifications

**Deliverable**: Admin gestiscono efficacemente le segnalazioni

---

### API Layer

#### Settimana 5-6: RESTful API
**Obiettivo**: Esporre API per integrazioni esterne e future mobile app

**Tasks**:
1. [ ] **API Endpoints** (`routes/api.php`)
   ```php
   // Public endpoints
   Route::prefix('v1')->group(function () {
       Route::get('/tickets', [TicketController::class, 'index']);
       Route::get('/tickets/{id}', [TicketController::class, 'show']);
       
       // Authenticated endpoints
       Route::middleware('auth:sanctum')->group(function () {
           Route::post('/tickets', [TicketController::class, 'store']);
           Route::put('/tickets/{id}', [TicketController::class, 'update']);
       });
   });
   ```

2. [ ] **API Resources**
   ```php
   class TicketResource extends JsonResource
   {
       public function toArray($request): array
       {
           return [
               'id' => $this->id,
               'slug' => $this->slug,
               'title' => $this->name,
               'description' => $this->content,
               'status' => $this->status->value,
               'location' => [
                   'latitude' => $this->latitude,
                   'longitude' => $this->longitude,
               ],
               'created_at' => $this->created_at,
           ];
       }
   }
   ```

3. [ ] **Authentication**
   - Laravel Sanctum setup
   - Token generation
   - Token revocation
   - Rate limiting

4. [ ] **Documentation**
   - OpenAPI 3.0 spec
   - Swagger UI
   - Postman collection
   - Code examples

**Deliverable**: API completa e documentata

---

## 📊 Testing & Quality (Settimana 7-8)

### Unit Tests
**Target**: >80% coverage

**Priority Tests**:
```php
// tests/Unit/Models/TicketTest.php
test('ticket has correct relationships', function () {
    $ticket = Ticket::factory()->create();
    
    expect($ticket->owner)->toBeInstanceOf(User::class);
    expect($ticket->activities)->toBeInstanceOf(Collection::class);
});

// tests/Unit/Services/TicketServiceTest.php
test('ticket service creates ticket correctly', function () {
    $service = app(TicketService::class);
    $user = User::factory()->create();
    
    $ticket = $service->createTicket([
        'name' => 'Test Ticket',
        'content' => 'Test content',
    ], $user);
    
    expect($ticket)->toBeInstanceOf(Ticket::class);
    expect($ticket->owner_id)->toBe($user->id);
});
```

### Feature Tests
**Target**: Core workflows covered

```php
// tests/Feature/Ticket/CreateTicketTest.php
test('citizen can create ticket', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user)
        ->post('/api/v1/tickets', [
            'name' => 'Buca pericolosa',
            'content' => 'Descrizione...',
            'latitude' => '45.4642',
            'longitude' => '9.1900',
        ])
        ->assertCreated()
        ->assertJsonStructure([
            'data' => ['id', 'slug', 'title']
        ]);
    
    assertDatabaseHas('tickets', [
        'name' => 'Buca pericolosa',
        'owner_id' => $user->id,
    ]);
});
```

### E2E Tests
**Tools**: Pest + Laravel Dusk

```php
// tests/Browser/CreateTicketTest.php
test('citizen can create ticket via UI', function () {
    $user = User::factory()->create();
    
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/it/tickets/create')
            ->type('name', 'Test Ticket')
            ->type('content', 'Test Description')
            ->click('@submit-button')
            ->assertPathIs('/it/tickets/*')
            ->assertSee('Segnalazione creata con successo');
    });
});
```

---

## 🔐 Security Hardening (Settimana 9-10)

### Security Checklist
- [ ] **Input Validation**
  - Sanitize all inputs
  - Validate file uploads
  - Check file types/sizes
  - Prevent XSS

- [ ] **Authentication**
  - Implement 2FA
  - Password policies
  - Account lockout
  - Session management

- [ ] **Authorization**
  - Check all policies
  - Verify gates
  - Test permission boundaries
  - API rate limiting

- [ ] **Data Protection**
  - Encrypt sensitive data
  - HTTPS everywhere
  - Secure cookies
  - CORS properly configured

### Penetration Testing
- [ ] SQL Injection tests
- [ ] XSS tests
- [ ] CSRF tests
- [ ] File upload attacks
- [ ] Session hijacking
- [ ] Privilege escalation

---

## 📚 Documentation (Settimana 11-12)

### User Documentation
- [ ] **Manuale Cittadino**
  - Come registrarsi
  - Come creare segnalazione
  - Come monitorare progresso
  - FAQ

- [ ] **Manuale Operatore**
  - Come accedere al sistema
  - Come gestire segnalazioni
  - Workflow approval
  - Best practices

- [ ] **Manuale Admin**
  - Configurazione sistema
  - Gestione utenti
  - Report e statistiche
  - Manutenzione

### Technical Documentation
- [ ] **API Documentation**
  - OpenAPI specification
  - Authentication guide
  - Endpoint reference
  - Code examples

- [ ] **Developer Guide**
  - Setup ambiente
  - Architettura sistema
  - Coding standards
  - Contributing guidelines

---

## 🚀 Launch Checklist

### Pre-Launch (Settimana 13-14)
- [ ] **Performance**
  - Lighthouse score > 90
  - Load test (1000+ concurrent users)
  - Database indexes optimized
  - CDN configured

- [ ] **Monitoring**
  - Error tracking (Sentry)
  - Performance monitoring
  - Uptime monitoring
  - Log aggregation

- [ ] **Backup**
  - Database backup automatico
  - Media files backup
  - Disaster recovery plan
  - Restore procedure tested

### Launch Day
- [ ] Deploy to production
- [ ] Verify all services running
- [ ] Monitor logs for errors
- [ ] User acceptance testing
- [ ] Announce launch

### Post-Launch (Week 1)
- [ ] Monitor performance
- [ ] Collect user feedback
- [ ] Fix critical bugs
- [ ] Optimize based on metrics

---

## 📈 Success Metrics

### Technical Metrics (Week 1-2)
| Metric | Target |
|--------|--------|
| Build success rate | 100% |
| Test pass rate | 100% |
| PHPStan errors | 0 |
| Code coverage | > 80% |

### Functional Metrics (Week 3-6)
| Metric | Target |
|--------|--------|
| Ticket creation time | < 5min |
| Form completion rate | > 80% |
| Error rate | < 1% |
| User satisfaction | > 4/5 |

### Performance Metrics (Week 7-8)
| Metric | Target |
|--------|--------|
| Page load time | < 2s |
| API response time | < 200ms |
| Uptime | > 99.5% |
| Database queries | Optimized |

---

## 🎓 Knowledge Transfer

### Team Training
- [ ] Backend developers: Architecture walkthrough
- [ ] Frontend developers: Theme system training
- [ ] QA team: Testing procedures
- [ ] Support team: User guides

### Documentation Sessions
- [ ] API documentation review
- [ ] User manual review
- [ ] Admin guide review
- [ ] Developer guide review

---

## 📞 Support Structure

### Issue Tracking
- GitHub Issues per bug
- Priorità: Critical, High, Medium, Low
- SLA per priorità

### Communication Channels
- Daily standup (15min)
- Weekly sprint review
- Bi-weekly retrospective
- Slack per comunicazioni rapide

---

**Prossimi Passi Immediati**:

1. ✅ Correzione BaseUser.php - COMPLETATO
2. 🔄 Risoluzione conflitti Git
3. 🚀 Implementazione ticket creation flow
4. 📝 Setup testing infrastructure
5. 🔐 Security hardening
6. 📚 Documentation
7. 🚀 Launch!

**Versione**: 1.0.0  
**Data Creazione**: 2025-01-01  
**Maintainer**: Project Lead  
**Revisione**: Settimanale


