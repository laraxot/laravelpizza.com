# Analisi Repository Folio + Volt

## Data: [DATE]

## Obiettivo
Analizzare repository GitHub che utilizzano Folio + Volt per estrarre pattern comuni, best practices e implementazioni applicabili al progetto Laravel Pizza Meetups.

## Repository Analizzati

### 1. jasonlbeggs/laravel-news-volt-folio-example
**URL**: https://github.com/jasonlbeggs/laravel-news-volt-folio-example

**Descrizione**: Esempio creato per un articolo su Laravel News

**Stack**:
- Laravel Folio
- Livewire Volt
- PHP 91.3%, Blade 8.7%

**Pattern Identificati**:
- Struttura `resources/views/pages/episodes/` per routing nested
- Uso di Volt direttamente nelle pagine con `@volt`
- Routing file-based con Folio

---

### 2. benjamincrozat/dummy-store
**URL**: https://github.com/benjamincrozat/dummy-store

**Descrizione**: Demo di un negozio online semplice usando Laravel Folio, Livewire v3, e Volt costruito per Laracasts

**Stack**:
- Laravel Folio
- Livewire v3
- Volt
- PHP 93.7%, Blade 5.4%

**Pattern Identificati**:
- Pagine piatte in `resources/views/pages/` (es. `index.blade.php`, `cart.blade.php`)
- Uso di Volt per interattività (carrello, aggiunta prodotti)
- Struttura semplice e diretta

---

### 3. irsyadadl/liosk
**URL**: https://github.com/irsyadadl/liosk

**Pattern Identificati**:
- (In analisi)

---

### 4. inmanturbo/b2bsaas0
**URL**: https://github.com/inmanturbo/b2bsaas0

**Pattern Identificati**:
- (In analisi)

---

### 5. thinkverse/tangerine
**URL**: https://github.com/thinkverse/tangerine

**Pattern Identificati**:
- (In analisi)

---

### 6. inmanturbo/b2bsaas
**URL**: https://github.com/inmanturbo/b2bsaas

**Pattern Identificati**:
- (In analisi)

---

### 7. jumbaeric/laravel-folio-volt-urlshortener
**URL**: https://github.com/jumbaeric/laravel-folio-volt-urlshortener

**Pattern Identificati**:
- (In analisi)

---

### 8. inmanturbo/vflat
**URL**: https://github.com/inmanturbo/vflat

**Pattern Identificati**:
- (In analisi)

---

### 9. ruslansteiger/folio-volt
**URL**: https://github.com/ruslansteiger/folio-volt

**Pattern Identificati**:
- (In analisi)

---

### 10. Patrikgrinsvall/nativephp-starter-folio-volt
**URL**: https://github.com/Patrikgrinsvall/nativephp-starter-folio-volt

**Pattern Identificati**:
- (In analisi)

---

### 11. danie1net0/openai-finetunning
**URL**: https://github.com/danie1net0/openai-finetunning

**Pattern Identificati**:
- (In analisi)

---

### 12. AlpetGexha/Shop-Example
**URL**: https://github.com/AlpetGexha/Shop-Example

**Pattern Identificati**:
- (In analisi)

---

### 13. mangiu90/livewire-volt-folio
**URL**: https://github.com/mangiu90/livewire-volt-folio

**Pattern Identificati**:
- (In analisi)

---

### 14. ryoadi/simple-site
**URL**: https://github.com/ryoadi/simple-site

**Pattern Identificati**:
- (In analisi)

---

### 15. SirAndrewGotham/GothamFolio
**URL**: https://github.com/SirAndrewGotham/GothamFolio

**Pattern Identificati**:
- (In analisi)

---

### 16. boring-dragon/volt-folio-shitz
**URL**: https://github.com/boring-dragon/volt-folio-shitz

**Pattern Identificati**:
- (In analisi)

---

### 17. HyPhy95/mini-crm-folio-volt
**URL**: https://github.com/HyPhy95/mini-crm-folio-volt

**Pattern Identificati**:
- (In analisi)

---

### 18. mfugissecruz/podcast-player
**URL**: https://github.com/mfugissecruz/podcast-player

**Descrizione**: Tutorial per imparare Livewire 3, Volt, e Folio costruendo un podcast player. Postato da @jasonlbeggs

**Stack**:
- Laravel Folio
- Livewire 3
- Volt
- PHP 68.5%, Blade 31.2%, JavaScript 0.3%

**Pattern Identificati**:
- Tutorial completo su Folio + Volt
- Pattern SPA mode con `wire:navigate`
- Route model binding con Folio

---

### 19. DamienToscano/welovedevs-podcast
**URL**: https://github.com/DamienToscano/welovedevs-podcast

**Pattern Identificati**:
- (In analisi)

---

### 20. kemalyen/personalized-laravel-starter-kit
**URL**: https://github.com/kemalyen/personalized-laravel-starter-kit

**Pattern Identificati**:
- (In analisi)

---

## Pattern Comuni Identificati

### Routing (Folio)
1. **Struttura File-Based**:
   - Pagine piatte: `resources/views/pages/index.blade.php` → `/`
   - Routing nested: `resources/views/pages/episodes/[slug].blade.php` → `/episodes/{slug}`
   - Nessun file `routes/web.php` per pagine frontoffice

2. **Route Model Binding**:
   - Folio risolve automaticamente i modelli dai parametri URL
   - Esempio: `[slug].blade.php` con `$slug` automaticamente risolto

3. **Middleware**:
   - Middleware applicati direttamente nelle pagine Folio
   - Pattern: `<?php use function Laravel\Folio\{middleware}; middleware(['auth']); ?>`

### Componenti (Volt)
1. **Uso Diretto nelle Pagine**:
   - `@volt('component-name')` direttamente nelle pagine Blade
   - Nessuna classe separata per componenti semplici
   - State management inline con `@php` blocks

2. **SPA Mode**:
   - `wire:navigate` per navigazione senza reload
   - `@persist` per mantenere stato tra navigazioni
   - Pattern comune nei podcast player e e-commerce

3. **Form Handling**:
   - Validazione inline con Volt
   - Actions chiamate direttamente da componenti Volt
   - Nessun controller necessario

### Architettura
1. **Struttura Standard**:
   ```
   resources/
     views/
       pages/          # Pagine Folio
         index.blade.php
         [slug].blade.php
       components/     # Componenti Blade riutilizzabili
       layouts/       # Layout comuni
   ```

2. **Separazione Responsabilità**:
   - Folio: Routing file-based
   - Volt: Interattività e state management
   - Filament: Solo admin panel (backend)
   - Actions: Business logic (Spatie QueueableAction)

3. **Nessun Controller**:
   - Frontoffice: Folio + Volt + Actions
   - Backend: Filament
   - Pattern: Request → Folio → Blade Page → Volt Component → Action → Service/Model

### Best Practices
1. **DRY + KISS**:
   - Componenti riutilizzabili in `resources/views/components/`
   - Layout comuni in `resources/views/layouts/`
   - Actions per business logic complessa

2. **Type Safety**:
   - Type hints espliciti in Volt components
   - PHPDoc per PHPStan livello 10
   - Spatie Laravel Data per DTO

3. **Performance**:
   - `wire:navigate` per SPA experience
   - `@persist` per stato persistente
   - Lazy loading per componenti pesanti

4. **Testing**:
   - Test separati per pagina, componente, e widget
   - Pattern: `LoginTest.php` (pagina), `LoginVoltTest.php` (componente), `LoginWidgetTest.php` (widget)

---

## Applicabilità al Progetto

### Pattern da Adottare
1. ✅ **Routing File-Based con Folio**:
   - Pagine in `Themes/Meetup/resources/views/pages/`
   - Routing automatico basato su struttura file
   - Route model binding automatico

2. ✅ **Volt per Interattività**:
   - `@volt('component-name')` direttamente nelle pagine
   - State management inline
   - Form handling senza controller

3. ✅ **SPA Mode**:
   - `wire:navigate` per navigazione fluida
   - `@persist` per stato persistente (es. carrello, preferenze)

4. ✅ **Actions per Business Logic**:
   - Spatie QueueableAction per logica complessa
   - Chiamate da componenti Volt, non da controller

5. ✅ **Separazione Responsabilità**:
   - Frontoffice: Folio + Volt + Actions
   - Backend: Filament
   - Nessun controller per pagine pubbliche

### Pattern da Evitare
1. ❌ **Controller per Frontoffice**:
   - NON creare controller per pagine pubbliche
   - NON scrivere rotte in `routes/web.php` per frontoffice

2. ❌ **Livewire Class-Based**:
   - NON usare classi Livewire tradizionali
   - Preferire Volt per semplicità e DRY

3. ❌ **Routing Tradizionale**:
   - NON usare `Route::get()` per pagine frontoffice
   - Usare Folio per routing file-based

4. ❌ **Mixing Patterns**:
   - NON mescolare Folio con routing tradizionale
   - Mantenere coerenza architetturale

---

## Note
Questo documento è in fase di compilazione. L'analisi dei repository è in corso.
