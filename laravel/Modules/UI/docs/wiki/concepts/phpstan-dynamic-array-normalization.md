# PHPStan Dynamic Array Normalization

## Scopo

Quando componenti UI ricevono output dinamico da action risolte via `app()` o da
stato Livewire, PHPStan non puo' assumere che l'array abbia chiavi e valori
compatibili con il contratto del metodo chiamato.

## Regola

Normalizzare l'array nel codice, elemento per elemento, invece di usare
`@var` inline per sovrascrivere l'inferenza.

## Pattern

- Per `array<int, array<string, mixed>>`, ricostruire ogni item accettando solo
  chiavi stringa.
- Per `array<string, mixed>`, copiare solo le chiavi stringa prima di passare il
  valore a service tipizzati.
- Rimuovere controlli `is_array()` quando PHPStan ha gia' ristretto il tipo.

## Applicazioni

- `UserCalendarWidget::fetchEvents()` normalizza l'output della action calendario.
- `InteractiveMap::getMapFilters()` espone filtri con chiavi stringa a
  `Modules\Geo\Services\MapService`.
- `LocationSelector::validate()` non ripete `is_array()` su stato gia'
  ristretto.

## Gate 2026-05-06

- `php -l` sui file modificati: passato.
- PHPStan mirato su `LocationSelector`, `UserCalendarWidget`, `InteractiveMap`:
  passato.
- PHPMD phar mirato su `UserCalendarWidget`: passato, con deprecation interna
  del phar su PHP 8.3.
- PHPInsights mirato su `UserCalendarWidget`: eseguito; restano avvisi
  architetturali preesistenti su widget Livewire/Xot.
