# Agents overview

Panoramica delle preferenze utente e del canone operativo del repository.

## Preferenze stabili utente

- Rispondere in italiano.
- Commit e push solo dopo verifica reale del perimetro toccato.
- Riuso prima di invenzione.
- DRY + KISS come vincolo, non come slogan.
- Aggiornare gli indici canonici prima di propagare nuova documentazione.

## Front office canonico

- Folio + Volt class-based + Laraxot.
- Blade minimal logic.
- Blade theme e detail page: `bridge-only`.
- Liste e collezioni strutturate: widget Filament.
- Nel progetto il contratto corretto per i table widget e `XotBaseTableWidget`.

## Regola nuova fissata esplicitamente

- `OutcomesTableWidget` non e una deviazione locale: e un widget tabellare di dominio e quindi deve estendere `XotBaseTableWidget`.
- Il perche non e solo tecnico: e coerenza architetturale, riuso, ereditarieta di policy Laraxot e riduzione delle eccezioni.

## Riferimenti

- [Main docs index](./00-INDEX.md)
- [Architecture index](./architecture/00-INDEX.md)
- [Filament table vs blade component](./architecture/filament-table-vs-blade-component.md)
