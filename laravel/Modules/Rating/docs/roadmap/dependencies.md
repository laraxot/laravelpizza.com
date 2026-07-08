# Dipendenze e confini del modulo Rating

Relazioni con altri moduli e pacchetti, cosa il modulo **dipende** e da cosa può essere **usato**.

---

## Dipendenze in ingresso (il Rating dipende da)

- **Laravel / Framework**: Laravel 12, Eloquent, migrazioni, container.
- **Xot**: classi base Filament (`XotBaseResource`, `XotBasePage`, …), convenzioni di namespace e traduzioni, eventuale `XotBaseMigration`.
- **Spatie (se in uso)**: es. `spatie/schemaless-attributes` per `extra_attributes` sul modello Rating (vedi [architecture.md](../architecture.md)); versioni allineate al `composer.json` del modulo.
- **Nessun modulo di dominio applicativo**: Rating non deve dipendere da User, Patient, Cms, ecc. per la sua logica core.

---

## Dipendenze in uscita (chi usa il Rating)

- **Moduli consumer**: qualsiasi modulo che necessiti di valutazioni (es. User per reputazione, servizi per rating qualità, contenuti per rating utenti). Integrazione tramite:
  - uso del trait `HasRatingsTrait` sui modelli rateable;
  - chiamata ad Actions esposte per calcolo/aggregazione;
  - eventuale uso di Resource/Widget Filament generici del modulo Rating.
- **Filament / Admin**: pannello admin può registrare le Resource del modulo Rating per gestire criteri e (se previsto) punteggi.

---

## Rischio dipendenze circolari

- **Regola**: il modulo Rating non deve importare modelli o servizi da moduli “consumer”. Le dipendenze devono essere solo verso framework, Xot e pacchetti generici.
- **Verifica**: nessun `use Modules\<AltroModulo>\` nei file sotto `Modules/Rating/` (eccetto test che mockano o usano modelli fittizi).

---

## Versioni minime (riferimento)

- PHP 8.2+
- Laravel ^12.0
- Filament ^5.0 (se usato)
- Estensioni e pacchetti come da `Modules/Rating/composer.json`.
