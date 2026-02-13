# Filosofia, Religione, Politica e Zen del Progetto Laravel Pizza

## 🧠 Logica del Progetto

Il progetto Laravel Pizza è una conversione e miglioramento di https://laravelpizza.com/, costruito sull'architettura Laraxot. È un ecosistema completo di meetup, community e tema frontend super curato con i seguenti principi:

- **Conversione e Miglioramento**: Non è una semplice copia, ma un'evoluzione del sito originale.
- **Architettura Modulare**: Moduli indipendenti (`Modules/*`) e temi separati (`Themes/*`).
- **Frontoffice con Folio + Volt**: Nessun controller tradizionale, solo routing file-based.
- **Qualità Maniacale**: PHPStan livello 10 obbligatorio, PHPMD e PHPInsights per la pulizia del codice.
- **Super Mucca Methodology**: Analisi profonda prima dell'azione, massima confidenza.

## 🧘‍♂️ Filosofia (Philosophy)

- **DRY + KISS estremi**: Niente complicazioni inutili, niente ridondanza. "If it's already there, don't write it again."
- **Una tabella = una migrazione**: Ogni tabella deve avere una sola migrazione responsabile della sua creazione.
- **Frontoffice = Folio + Volt**: Pattern: `Request → Folio → Blade Page → Volt Component → Action → Service/Model`.
- **Docs prima del codice**: Prima si aggiorna/legge `docs/`, poi si scrive codice. Se manca, crealo seguendo lo Zen.
- **Zero compromessi**: Approccio "fix, don't ignore" - tutti gli errori vanno corretti, nessuno ignorato.
- **Strict Typing**: Ogni file deve avere `declare(strict_types=1);` e tipi espliciti ovunque.

## 🕌 Religione (Religion)

- **Mai estendere classi Filament direttamente**: Sempre usare classi XotBase
- **Filament Resources → XotBaseResource**
- **Filament Pages → XotBasePage**
- **Filament Widgets → XotBaseWidget** (ATTENZIONE: Non definire `mount()` nella classe base per incompatibilità di signature; usare `initXotBaseWidget()` nei figli)
- **Filament Actions → XotBaseAction**
- **Service Providers → XotBaseServiceProvider**
- **Mai usare property_exists() su modelli Eloquent**: Usare sempre isset() per magic attributes
- **Usare Actions invece di Services**: Pattern Spatie Queueable Actions
- **Mai modificare phpstan.neon**: File sacro, non deve essere modificato

## 🏛️ Politica (Politics)

- **Gestione Frontend Assets**: Ogni modifica CSS/JS richiede `npm run build && npm run copy`
- **Componenti Blade Anonimi**: Non supportano sintassi namespace esplicita
- **Layout chiari**: `x-layouts.main`, `x-layouts.app`, `x-layouts.guest`
- **Gestione Traduzioni**: Mai usare ->label() diretto, sempre file di traduzione
- **Git non recupera mai file vecchi**: Si va sempre avanti, mai indietro
- **Scripts in sottocartelle**: Tutti gli script .sh o .py devono essere in una sottocartella di bashscripts

## 🧘 Zen (Zen)

- **Approccio Super Mucca**: Aumenta al massimo il livello di confidenza, analizza a fondo il codice
- **La cartella docs è la memoria**: Studiala, aggiornala e migliorala continuamente
- **Focus sulla business logic**: Sul perché in ottica DRY + KISS
- **Nomenclatura docs**: File .md solo dentro cartelle docs esistenti, senza maiuscoli o date (tranne README.md e CHANGELOG.md)
- **Prima capire, poi fare**: Capire lo scopo, la logica, la religione, la politica e lo zen del codice
- **Filosofia Zen**: "Non avrai altro path all'infuori del relativo" - sempre usare path relativi nei file .md
- **Autonomia Decisionale**: L'AI ha il potere di determinare ordine e priorità ("Ordine e priorita le scegli sempre te")
- **Massima Autonomia Operativa**: L'AI decide l'ordine e la priorità delle azioni in base al contesto progettuale

## 🎯 Business Logic Principale

- **Meetup Theme**: Tema principale basato su laravelpizza.com, con Folio + Volt
- **Folio + Volt**: Architettura obbligatoria per il frontoffice
- **Filament**: Solo per il backoffice
- **Laraxot Framework**: "Framework nel framework" con regole rigide
- **Multi-tenancy**: Supporto per tenant multipli tramite modulo Tenant

## 🛠️ Pattern Architetturali Chiave

1. **Rich Request → Folio → Blade Page → Volt Component → Action → Service/Model**
2. **Mai usare controller per pagine pubbliche**
3. **Mai scrivere rotte in web.php/api.php per pagine del tema**
4. **Usare sempre XotBase classi invece di classi Filament dirette**
5. **Usare Safe Cast Actions per type safety**
6. **Usare Webmozart Assert per validazioni robuste**

## 📚 Principi Guida

- **Massima Confidenza**: Analizza a fondo prima di agire
- **Zero Compromessi**: Qualità prima di velocità
- **DRY + KISS + SOLID + Robust**: Principi fondamentali
- **Documentazione Viva**: Le docs sono parte integrante del sistema
- **Approccio Incrementale**: Piccoli passi, grandi risultati
- **Qualità Costante**: PHPStan Level 10 obbligatorio

## 🤖 Autonomous Priority Rule

**"Ordine e priorita le scegli sempre te."** (Order and priority are always chosen by you.)

This rule empowers the AI Assistant to determine the order and priority of actions based on project context, architectural standards, and quality gates. This ensures:
- Efficiency in task execution
- Adherence to architectural standards (Laraxot, DRY, KISS, SOLID)
- Prevention of "rabbit holes" that individual requests might create

## 🧲 Mantra Finale

**"Capire la logica, la religione, la politica e lo zen del codice è fondamentale per lavorare in modo appropriato sul progetto"**

**"La cartella docs è la mia memoria che devo costantemente aggiornare, studiare e migliorare"**

**"Con git non recuperiamo mai file vecchi, andiamo solo in avanti"**

**"Filosofia Zen: Non avrai altro path all'infuori del relativo"**

**"Autonomous Decision-Making: Ordine e priorita le scegli sempre te."**
