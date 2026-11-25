---
title: "Qualita' del codice e PHPStan"
type: rule
status: active
module: Xot
qmd: "code quality phpstan level max strict_types mixed safe cast pint gate workflow baseline ignoreErrors arch debt dry kiss"
updated: 2026-11-25
---

# Qualita' del codice e PHPStan

Sintesi delle regole di qualita' dei moduli. Il gate e' uno solo e i fix si fanno alla radice: una soppressione non e' un fix.

## Standard di codice

- `declare(strict_types=1);` in ogni file PHP (guardia: regola `strict` di `tests/Arch/ArchitectureTest.php`, con il debito in `tests/Arch/debt.php`).
- Tipi nativi su parametri, ritorni e proprieta'; array e collection con shape o generics nel docblock (`HasMany<TRelated, $this>`, `list<string>`, `array<string, mixed>`).
- **`mixed` solo come ultima spiaggia** ([ADR 0015](adr/0015-mixed-solo-come-ultima-spiaggia.md)): tipi veri, narrowing al confine (input esterni, JSON, config),
  motivazione scritta. Per i cast sicuri esistono le Action `Modules\Xot\Actions\Cast\Safe*CastAction` (`String`, `NullableString`, `Int`, `Float`, `Boolean`,
  `Array`, `ArrayByModel`, `Object`, `Eloquent`, `Attribute`); per le asserzioni al confine `Webmozart\Assert\Assert`; per le funzioni PHP che restituiscono `false`
  le versioni `Safe\...`.
- Logica di business nelle Action (`QueueableAction`, metodo `execute()`), non in `Services` ne' in Blade/Livewire (vedi [actions-and-contracts.md](actions-and-contracts.md));
  estensioni Filament solo via XotBase ([xotbase-extension-rules.md](xotbase-extension-rules.md)).
- DRY e KISS: un metodo fa una cosa, file focalizzati (200-400 righe tipiche, 800 come tetto morbido), nessuna astrazione senza una ripetizione reale.
- Formattazione: Laravel Pint (preset `laravel`, regole del modulo in `pint.json`).

## PHPStan: configurazione e gate

- Configurazione unica: `laravel/phpstan.neon`, `level: max` su `./Modules/`, `bleedingEdge`, **nessuna baseline e nessun `ignoreErrors` attivo** ("gli errori vanno
  corretti, non nascosti"). Esclusi `vendor`, `build`, `docs`, `tests`, `*.blade.php`, `packages`. `phpstan.single.neon` include la stessa configurazione con un solo processo.
- **Gate ufficiale**: dalla cartella `laravel/`, `./vendor/bin/phpstan analyse Modules` con il neon di default, **mai `-c` con neon di scratch**; prima di misurare
  `./vendor/bin/phpstan clear-result-cache` (una cache vecchia puo' inventare centinaia di `class.notFound`). Un verde ottenuto con un neon o una cache privata non vale.
- Su una macchina condivisa non lanciare piu' di tre PHPStan in parallelo (saturazione dell'host).
- Ordine di risoluzione quando il gate e' rosso: **1) errori di parsing** (marcatori di merge, vedi [git-sync-and-case-sensitivity.md](git-sync-and-case-sensitivity.md)),
  **2) conflitti di classi/file**, **3) tipi**. Dopo lo zero il lavoro continua come boy scout sui file toccati.
- Mai `@phpstan-ignore`, mai baseline generata, mai `mixed` per far tacere un errore: si dichiara il tipo vero o si corregge la causa (il tipo "sparito" si
  moltiplica per ogni modulo che estende Xot).

## Debito di architettura

`tests/Arch/ArchitectureTest.php` (Pest `arch()`) applica a tutti i moduli e temi le regole `php` (niente funzioni di debug/deprecate), `security`
(md5/sha1/uniqid/rand/extract), `strict`, `services` (niente `*Service`) e `xotbase`. Il debito corrente sta in `tests/Arch/debt.php` di ogni pacchetto e **puo' solo scendere**:
chi corregge una classe la toglie dalla lista, chi aggiunge una voce la motiva ([ADR 0020](adr/0020-architecture-tests-pest-arch.md)).

## Prima di dire "fatto"

1. PHPStan sul gate ufficiale a zero errori;
2. `./vendor/bin/pint` sui file toccati;
3. test Pest del modulo owner verdi (vedi [testing.md](testing.md));
4. docblock `@see` alla pagina `docs/` pertinente per ogni classe o metodo toccato ([docs-conventions.md](docs-conventions.md)).

## Decisioni e story collegate

- [adr/0015-mixed-solo-come-ultima-spiaggia.md](adr/0015-mixed-solo-come-ultima-spiaggia.md), [adr/0014-mixed-last-resort.md](adr/0014-mixed-last-resort.md)
- [bmad/stories/0148-phpstan-modules-zero-swarm-standing.story.md](bmad/stories/0148-phpstan-modules-zero-swarm-standing.story.md) (ordine permanente "PHPStan zero")
- [bmad/stories/0160-project-quality-audit.story.md](bmad/stories/0160-project-quality-audit.story.md)
