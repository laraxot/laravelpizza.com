# Analisi Differenze - Event Detail Page

## Obiettivo
Allineare la pagina evento locale (`/it/events/{slug}-{id}`) con la versione produzione di laravelpizza.com (`/events/{id}`).

## Screenshot di Riferimento

| Fonte | URL | Screenshot |
|-------|-----|------------|
| Produzione | https://laravelpizza.com/events/1 | `laravelpizza-events-1-prod.png` |
| Locale | http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party-1 | `laravelpizza-events-local.png` |

---

## Analisi Sezione per Sezione

### 1. Header & Navigation
| Elemento | Produzione | Locale | Stato | Azione |
|----------|------------|--------|-------|--------|
| Logo | LaravelPizza logo | LaravelPizza logo | ✅ OK | - |
| Nav menu | Hamburger mobile | Hamburger mobile | ✅ OK | - |
| Language switch | IT/EN toggle | IT/EN toggle | ✅ OK | - |
| Active state | Evidenzia "Events" | Verificare | 🟡 Check | Verificare highlight |

### 2. Hero Section
| Elemento | Produzione | Locale | Stato | Azione |
|----------|------------|--------|-------|--------|
| Cover gradient | Rosso Laravel (#ef4444) | Simile | ✅ OK | - |
| Event title | H1 grande, bold | Presente | ✅ OK | - |
| Date badge | "In arrivo" / "Upcoming" | Presente | ✅ OK | - |
| Back button | Freccia + "Torna agli eventi" | Presente | ✅ OK | - |
| Responsive | H1 scala su mobile | Verificare | 🟡 Check | Testare breakpoints |

### 3. Content Area (Left Column)
| Elemento | Produzione | Locale | Stato | Azione |
|----------|------------|--------|-------|--------|
| **Info Cards** |
| Date card | Icona calendario + data | Presente | ✅ OK | - |
| Time card | Icona orologio + orario | Presente | ✅ OK | - |
| Location card | Icona pin + luogo | Presente | ✅ OK | - |
| Card styling | Bordi, shadow, icone colorate | Simile | ✅ OK | - |
| **About Section** |
| Section title | "Informazioni sull'evento" | Presente | ✅ OK | - |
| Description | Testo formattato | Presente | ✅ OK | - |
| Typography | Line-height, spacing | Verificare | 🟡 Check | Confrontare font-size |
| **Attendees Section** |
| Section title | "Partecipanti" | Presente | ✅ OK | - |
| Avatars grid | 6+ avatar sovrapposti | Placeholder/NaN | 🔴 Fix | Implementare avatars reali |
| Attendees count | "15 / 100" | Presente | ✅ OK | - |
| Joined text | "persone si sono unite" | Presente | ✅ OK | - |

### 4. Sidebar (Right Column)
| Elemento | Produzione | Locale | Stato | Azione |
|----------|------------|--------|-------|--------|
| **RSVP Card** |
| Card styling | White bg, rounded, shadow | Presente | ✅ OK | - |
| Title | "Partecipa ora" / "RSVP Now" | Presente | ✅ OK | - |
| Spots label | "Posti ancora disponibili" | Presente | ✅ OK | - |
| Spots number | Grande, bold, rosso | Presente | ✅ OK | - |
| CTA Button | "Prenota" / "RSVP Now" rosso | Presente | ✅ OK | - |
| Urgency text | "I posti si stanno esaurendo" | Presente | ✅ OK | - |
| **Share Card** |
| Card styling | White bg, rounded, shadow | Presente | ✅ OK | - |
| Title | "Condividi evento" | Presente | ✅ OK | - |
| Social buttons | 5 icone (FB, X, LI, WA, TG) | Presenti | ✅ OK | - |
| Copy link | Icona copia link | Mancante? | 🔴 Fix | Aggiungere copy link |
| Button colors | Brand colors specifiche | Verificare | 🟡 Check | Confrontare colori |

### 5. Funzionalità Interattive
| Funzionalità | Produzione | Locale | Stato | Azione |
|--------------|------------|--------|-------|--------|
| RSVP modal | Si apre con form | Da testare | 🟡 Check | Verificare apertura |
| Form fields | Nome, email | Da verificare | 🟡 Check | Controllare fields |
| Submit booking | Conferma prenotazione | Da testare | 🟡 Check | Testare submit |
| Share buttons | Apre social in popup | Da testare | 🟡 Check | Verificare URL |
| Copy link | Copia negli appunti | Mancante | 🔴 Fix | Implementare |

---

## Issues Prioritari

### 🔴 Alta Priorità

1. **Attendees Avatars Non Funzionanti**
   - **Problema**: Mostra "NaN" o placeholder vuoti
   - **Causa**: Probabilmente `attendees_count` è null o relazione non caricata
   - **Fix**: 
     ```php
     // Nel Volt component
     public function getAttendees(): Collection
     {
         return $this->event?->attendees()?->limit(6)->get() ?? collect();
     }
     ```
   - **File**: `detail.blade.php`

2. **Copy Link Mancante**
   - **Problema**: Bottone copia link non presente
   - **Fix**: Aggiungere metodo `copyLink()` e bottone con icona
   - **File**: `detail.blade.php`, aggiungere in sezione share

### 🟡 Media Priorità

3. **Share URL Generation**
   - **Problema**: URL di condivisione potrebbero non essere complete
   - **Verifica**: Controllare che `getShareUrls()` generi URL assolute con locale
   - **File**: Volt component

4. **RSVP Modal Completeness**
   - **Problema**: Da verificare se il modal ha tutti i campi necessari
   - **Checklist**:
     - [ ] Campo nome
     - [ ] Campo email
     - [ ] Validazione
     - [ ] Submit handler
     - [ ] Success message

5. **Dark Mode Icons**
   - **Problema**: Verificare che le icone social siano visibili in dark mode
   - **Fix**: Aggiungere `dark:text-white` o varianti

### 🟢 Bassa Priorità

6. **Typography Micro-Differenze**
   - Font-size leggermente diverso
   - Line-height da affinare
   - Confrontare con devtools

7. **Spacing & Margins**
   - Verificare padding tra sezioni
   - Confrontare con design system

---

## Data Model - Campi Necessari

### Event Model - Verificare Presenza

```php
// Campi già presenti (verificati)
- id ✓
- title ✓
- slug ✓
- description ✓
- start_date ✓
- end_date ✓
- location ✓
- cover_image ✓
- max_attendees ✓
- attendees_count ✓

// Campi potenzialmente mancanti
- organizer_id (per mostrare chi organizza)
- status (published, draft, cancelled)
- tags (JSON per categorie)
- created_at / updated_at ✓
```

### Relazioni da Verificare

```php
// In Event model
public function attendees(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'event_attendee')
        ->withPivot('status', 'registered_at', 'cancelled_at')
        ->wherePivotNull('cancelled_at'); // Solo attivi
}

public function organizer(): BelongsTo
{
    return $this->belongsTo(User::class, 'organizer_id');
}
```

---

## Piano di Implementazione

### Fase 1: Fix Critici (1-2 giorni)
- [ ] 1.1 Correggere attendees avatars (caricamento real dati)
- [ ] 1.2 Aggiungere copy link button
- [ ] 1.3 Testare RSVP modal e fix eventuali bug

### Fase 2: Share Functionality (1 giorno)
- [ ] 2.1 Installare/implementare SocialShareService in Seo module
- [ ] 2.2 Verificare URL condivisione corrette
- [ ] 2.3 Aggiungere Open Graph meta tags

### Fase 3: Polish (1 giorno)
- [ ] 3.1 Aggiustare typography e spacing
- [ ] 3.2 Verificare dark mode completo
- [ ] 3.3 Testare responsive breakpoints
- [ ] 3.4 Testare performance (Lighthouse)

### Fase 4: QA & Documentazione (0.5 giorni)
- [ ] 4.1 Aggiornare screenshot dopo fix
- [ ] 4.2 Documentare cambiamenti in questo file
- [ ] 4.3 Verificare traduzioni complete

---

## File da Modificare

### Primary Files
1. `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`
   - Fix attendees display
   - Add copy link functionality
   - Verify share buttons

2. `Modules/Meetup/Models/Event.php`
   - Verify attendees() relationship
   - Add helper methods if needed

3. `Modules/Seo/Services/SocialShareService.php` (create)
   - Implement share URL generation
   - Configure social services

4. `Themes/Meetup/resources/views/layouts/app.blade.php`
   - Add Open Graph meta tags

### Secondary Files
5. `Themes/Meetup/lang/it/event.php` (and other languages)
   - Add missing translation keys

6. `Themes/Meetup/resources/views/components/ui/share-buttons.blade.php`
   - Verify component implementation
   - Add copy link variant

---

## Testing Checklist

### Funzionalità
- [ ] Page loads without errors
- [ ] Event data displays correctly
- [ ] Attendees avatars show real users
- [ ] RSVP modal opens and closes
- [ ] Booking form validates input
- [ ] Booking submit creates record
- [ ] Share buttons generate correct URLs
- [ ] Copy link copies to clipboard
- [ ] Responsive design works (mobile/tablet/desktop)
- [ ] Dark mode toggle works

### Visual
- [ ] Matches production layout
- [ ] Typography consistent
- [ ] Colors match brand
- [ ] Icons display correctly
- [ ] Spacing consistent
- [ ] Shadows and borders correct

### Performance
- [ ] Page loads < 3s
- [ ] Images optimized
- [ ] No console errors
- [ ] Lighthouse score > 90

---

## Riferimenti

- [Screenshot Documentation](./screenshots/readme.md)
- [Volt Component Pattern](../volt-component-pattern.md)
- [Social Share Documentation](../social-share.md)
- [Seo Module - Social Share](../../modules/seo/docs/social-share-component.md)

---

**Ultimo aggiornamento**: 2026-02-18  
**Prossima revisione**: Dopo Fase 1 completata  
**Responsabile**: Cascade AI + Development Team
