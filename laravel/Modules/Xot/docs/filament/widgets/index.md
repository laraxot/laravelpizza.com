# Wizard Widget Documentation — Indice Completo

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Documentation Index  
**Audience**: All developers

---

## Panoramica

Questo indice organizza tutta la documentazione sui wizard widget Laraxot per ricerca rapida e prevenzione duplicati.

---

## Documenti Principali (Canonici)

### 📚 Xot Module (Base Class)

| Documento | Scopo | Quando Leggere |
|---|---|---|
| [wizard-widget-rules.md](./wizard-widget-rules.md) | **I 10 Comandamenti** - regole pratiche da seguire SEMPRE | Prima di scrivere qualsiasi wizard widget |
| [xot-base-wizard-widget-philosophy.md](./xot-base-wizard-widget-philosophy.md) | **Filosofia Completa** - perché, visione, religione, zen | Per capire il "perché" profondo |
| [widget-method-architecture.md](./widget-method-architecture.md) | **Anti-Pattern: Metodi Privati Inutili** - quando separare/inline | Prima di creare metodi privati |
| [override-pattern-philosophy.md](./override-pattern-philosophy.md) | **Anti-Pattern: Hook Inutili** - quando usare override diretto | Prima di creare hook protected |
| [infolists-for-summary.md](./infolists-for-summary.md) | **Infolists per Riepilogo** - summary strutturato vs prime content | Quando creare step di riepilogo |
| [submit-button-placement.md](./submit-button-placement.md) | **Submit Button nella Base** - Protocollo vs Contenuto | Per capire dove mettere getWizardSubmitAction() |
| [no-label-placeholder-religion.md](./no-label-placeholder-religion.md) | **RELIGIONE: NO Label/Placeholder** - MAI usarli | **PRIMA DI SCRIVERE qualsiasi componente Filament** |
| [xot-base-wizard-widget.md](./xot-base-wizard-widget.md) | **Reference Tecnico** - metodi, hook, signature | Per consultazione rapida |

---

### 📚 Fixcity Module (Example Implementation)

| Documento | Scopo | Quando Leggere |
|---|---|---|
| [filament-wizard-pattern.md](../../../Fixcity/docs/filament-wizard-pattern.md) | Pattern implementativo con esempi | Per vedere codice reale |
| [filament-wizard-rule.md](../../../Fixcity/docs/filament-wizard-rule.md) | Regole specifiche Fixcity | Per module-specific conventions |
| [CreateTicketWizardWidget.md](../../../Fixcity/docs/CreateTicketWizardWidget.md) | Documentazione widget specifico | Per capire CreateTicketWizardWidget |
| [ticket-wizard-frontoffice.md](../../../Fixcity/docs/ticket-wizard-frontoffice.md) | Guida frontoffice e flusso end-to-end | Per deployment/UX e wiring pagine CMS |

---

## Ricerca Rapida per Argomento

### 🔴 URGENTE: Devo Usare ->label() o ->placeholder()?

**ASSOLUTAMENTE NO!** → Leggi: [no-label-placeholder-religion.md](./no-label-placeholder-religion.md)  
**Regola**: LangServiceProvider li applica automaticamente. MAI usarli espliciti.  
**Script**: `bashscripts/check-auto-label-violations.sh` blocca commit con violazioni.

---

## 🎯 Vuoi Sapere...

#### "Devo usare `->label()`?"
→ Leggi: [wizard-widget-rules.md](./wizard-widget-rules.md) → Comandamento #1  
**Risposta breve**: NO, LangServiceProvider lo applica automaticamente

---

#### "Devo creare un metodo privato separato?"
→ Leggi: [widget-method-architecture.md](./widget-method-architecture.md)  
**Risposta breve**: SOLO se riusato 2+ volte o testing separato

---

#### "Devo creare hook protected per submit button?"
→ Leggi: [override-pattern-philosophy.md](./override-pattern-philosophy.md)  
**Risposta breve**: NO, override diretto di `getWizardSubmitAction()`

---

#### "Devo usare Blade partial per riepilogo?"
→ Leggi: [infolists-for-summary.md](./infolists-for-summary.md)  
**Risposta breve**: NO, usa `Infolists` per i dati riepilogati e `Schemas` prime per eventuale testo statico

---

#### "Devo usare `Log::error()` nel catch?"
→ Leggi: [wizard-widget-rules.md](./wizard-widget-rules.md) → Comandamento #3  
**Risposta breve**: NO, mostra solo notifica user-friendly

---

#### "Quando estendere XotBaseWizardWidget?"
→ Leggi: [xot-base-wizard-widget-philosophy.md](./xot-base-wizard-widget-philosophy.md)  
**Risposta breve**: SEMPRE quando usi Wizard multi-step

---

## Anti-Pattern Catalog

### ❌ Pattern SBAGLIATI (con link alla spiegazione)

| Anti-Pattern | Esempio | Perche Sbagliato | Soluzione |
|---|---|---|---|
| **Label Esplicito** | `->label('Indirizzo')` | Ridondante (LangServiceProvider) | Rimuovi label |
| **Tooltip Esplicito** | `->tooltip('Vai avanti')` | Ridondante (LangServiceProvider) | Rimuovi tooltip |
| **Log nel Dominio** | `Log::error('Submit failed')` | Non e compito del dominio | Solo notifica user |
| **Metodi Privati Inutili** | `createTicketFromFormData()` → `buildTicketPayload()` | Separazione artificiale | Inline nel submit |
| **Hook per Getter** | `useNativeSubmitButton()` → `true` | Frammentazione senza riuso | Override diretto |
| **Blade per Riepilogo** | `SchemaView::make('partial')` | Reinventare Schema semantics | Usa `TextEntry` per dati e `Text` per contenuto statico |
| **XotBaseWidget per Wizard** | `extends XotBaseWidget` | Perde navigazione/sicurezza | Estendi XotBaseWizardWidget |

---

## Best Practice Catalog

### ✅ Pattern CORRETTI (con link alla spiegazione)

| Best Practice | Esempio | Perche Corretto | Link |
|---|---|---|---|
| **Label Auto** | `TextInput::make('address')->required()` | LangServiceProvider applica | [Rules #1](./wizard-widget-rules.md) |
| **Submit Inline** | `Ticket::create([...])` nel submit() | Leggibile, niente salti | [Method Arch](./widget-method-architecture.md) |
| **Override Diretto** | `getWizardSubmitAction()` con HTML | Tutto in un metodo | [Override Phil](./override-pattern-philosophy.md) |
| **Infolists Riepilogo** | `TextEntry::make('address')` | Read-only nativo | [Infolists](./infolists-for-summary.md) |
| **Prime per Notice** | `Text::make('Informativa...')` | Testo arbitrario, non label-value | [Schemas Unified Religion](../../../../../docs/schemas-unified-religion.md) |
| **Notifica User** | `Notification::make()->danger()` | User-friendly | [Rules #3](./wizard-widget-rules.md) |
| **XotBaseWizardWidget** | `extends XotBaseWizardWidget` | Navigazione/sicurezza inclusa | [Philosophy](./xot-base-wizard-widget-philosophy.md) |

---

## Filosofia Zen

### I 6 Pilastri

1. **Separazione delle Responsabilità** → Base gestisce protocollo, dominio gestisce contenuto
2. **DRY + KISS** → UNA implementazione, zero duplicazioni
3. **Allineamento Filament** → Non sostituiamo, incorniciamo
4. **Politica Sicurezza** → `?step=` solo se esplicitamente consentito
5. **Auto-Label (LangServiceProvider)** → Label/tooltip automatici
6. **NO Log nel Dominio** → User-friendly UI, framework logging

**Documenti correlati**:
- [Filosofia Completa](./xot-base-wizard-widget-philosophy.md)
- [Regole Pratiche](./wizard-widget-rules.md)

---

## Checklist Pre-Commit

Prima di committare un wizard widget, verifica TUTTI i punti:

- [ ] Estende `XotBaseWizardWidget` (NON `XotBaseWidget`)
- [ ] NO `->label()` espliciti su campi/azioni
- [ ] NO `->tooltip()` espliciti su azioni
- [ ] NO `Log::error()` nel catch block
- [ ] Usa `$this->resolveInitialStepFromQuery()` nel mount
- [ ] Usa `$this->normalizeWizardFormState()` nel submit (se stato annidato)
- [ ] `getWizardSteps()` e pubblico
- [ ] Step builders sono privati
- [ ] Submit button segue pattern corretto (HTML nativo o tema)
- [ ] Step riepilogo usa Infolists (NON Blade partial)
- [ ] NO metodi privati senza riuso effettivo
- [ ] NO hook protected per getter semplici
- [ ] Traduzioni seguono pattern `{namespace}::{widget_name}.*`

**Link alla checklist completa**: [wizard-widget-rules.md](./wizard-widget-rules.md) → Sezione "Checklist Pre-Commit"

---

## Riferimenti Incrociati

### Implementazioni

- [XotBaseWizardWidget](../../app/Filament/Widgets/XotBaseWizardWidget.php)
- [CreateTicketWizardWidget](../../../Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php)
- [LangServiceProvider](../../../Lang/app/Providers/LangServiceProvider.php)
- [AutoLabelAction](../../../Lang/app/Actions/Filament/AutoLabelAction.php)

### Documentazione Esterna

- [Filament Wizard v5](https://filamentphp.com/docs/5.x/schemas/wizards)
- [Filament Infolists](https://filamentphp.com/docs/5.x/infolists/overview)
- [Filament Prime Components](https://filamentphp.com/docs/5.x/schemas/primes)
- [Schemas Unified Religion](../../../../../docs/schemas-unified-religion.md)
- [Clean Code Principles](../../../../docs/clean-code.md)
- [Laraxot Core Rules](../../../../laraxot-core.md)

---

## Cronologia Aggiornamenti

| Data | Documento | Modifica |
|---|---|---|
| 2026-04-14 | wizard-widget-rules.md | **Creato** - I 10 Comandamenti |
| 2026-04-14 | xot-base-wizard-widget-philosophy.md | **Riscritto** - Filosofia completa |
| 2026-04-14 | widget-method-architecture.md | **Creato** - Anti-pattern metodi privati |
| 2026-04-14 | override-pattern-philosophy.md | **Creato** - Anti-pattern hook inutili |
| 2026-04-14 | infolists-for-summary.md | **Creato** - Forms vs Infolists |
| 2026-04-14 | index.md | **Creato** - Questo indice |

---

## Come Contribuire

1. **Prima di scrivere**: Leggi i documenti canonici
2. **Dopo aver scritto**: Aggiorna questo indice se crei nuovi documenti
3. **Se trovi duplicati**: Segnala o unisci i documenti
4. **Se trovi errori**: Correggi o crea documento di chiarimento

**Regola d'oro**:
> "Un documento canonico per argomento, referenziato da tutti i moduli."

---

*Ultimo aggiornamento: 2026-04-14*
