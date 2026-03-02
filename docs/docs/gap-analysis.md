# Gap Analysis - Modulo Meetup

## 📌 Panoramica
Il modulo Meetup contiene la logica business richiesta per replicare laravelpizza.com, ma alcune aree risultano ancora incomplete o solo parzialmente documentate. Questa analisi elenca i principali elementi mancanti e le relative azioni suggerite.

## 1. Struttura Laravel
- ❌ **Blade views**: mancano i template Blade in `resources/views` allineati alle pagine HTML statiche.
  - ▶️ Copiare gradualmente le pagine da `Themes/Meetup/resources/html` in viste Blade dinamiche.
- ❌ **Route e controller**: non esistono route Laravel che servano il tema.
  - ▶️ Definire route pubbliche e controller dedicati (es. `HomeController`, `MenuController`).

## 2. Modelli e Database
- ❌ **Migrazioni assenti**: `database-schema.md` definisce la struttura dati, ma non esistono file di migrazione.
  - ▶️ Creare migrazioni per tabelle `meetup_*` e popolarle con seeders di esempio.
- ❌ **Factory/Seeder**: nessun factory per generare dati demo (pizze, categorie, ordini).
  - ▶️ Implementare factory e seeders per testing rapido.

## 3. Servizi e Azioni
- ✅ Documentazione presente (`services-guide.md`), ma…
- ❌ **Implementazioni mancanti**: i servizi `PizzaService`, `OrderService`, `CartService` non esistono nel codice.
  - ▶️ Creare classi reali sotto `app/Services` e collegarle ai controller/Livewire.

## 4. Integrazione Filament
- ❌ **Filament resources**: documentate ma non create.
  - ▶️ Generare `PizzaResource`, `CategoryResource`, `OrderResource` per gestione admin.
  - ▶️ Prevedere widget statistici (ordini del giorno, top pizze).

## 5. Componenti Livewire/Volt
- ❌ **Componenti interattivi**: nessun componente per carrello live, filtri, moduli.
  - ▶️ Implementare componenti Volt/Livewire (es. `CartPanel`, `PizzaFilter`, `OrderForm`).

## 6. Internazionalizzazione
- ❌ **Traduzioni**: mancano file `lang/it/meetup.php` (solo doc).
  - ▶️ Creare file di traduzione per testi comuni (menu, CTA, validazioni).

## 7. Tests
- ❌ **Feature/Unit tests**: nessuna coverage per rotte pubbliche, servizi, Filament.
  - ▶️ Scrivere test base: rendering homepage/menu, PizzaService, OrderService, Filament resources.

## 8. Documentazione
- ✅ Documenti principali esistenti, ma…
  - ➕ Creare guida “Dal mockup HTML alla view Blade” per chiarire il workflow.
  - ➕ Aggiungere changelog modulo per tracciare avanzamenti.

## 9. UX / UI
- ✅ HTML statico pronto, tuttavia…
  - ➕ Specificare pattern UI condivisi con altri temi (palette, spacing, componenti).
  - ➕ Documentare come integrare `Themes/Meetup` con assets Vite globali (alias `@theme`).

## Azioni Prioritarie
1. Migrazioni+Seeders (blocca tutte le feature dinamiche).
2. Blade views + Route di base.
3. Implementazione servizi (Pizza/Ordini) + componenti Livewire.
4. Filament resources per gestione catalogo.
5. Test minimi per ogni layer.

## Collegamenti
- [`database-schema.md`](./database-schema.md)
- [`models-architecture.md`](./models-architecture.md)
- [`services-guide.md`](./services-guide.md)
- [`tailwind-best-practices.md`](./tailwind-best-practices.md)
- [`resources/html/README.md`](../../../themes/meetup/resources/html/readme.md)
