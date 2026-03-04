# Chaos Monkey Translation Fallbacks (Lang)

## Obiettivo
Evitare degrado funzionale quando Chaos Monkey altera file traduzione, chiavi o namespace.

## Rischi Ricorrenti
- Chiavi strutturate convertite in flat keys.
- Nodi obbligatori vuoti (`navigation`, `fields`, `actions`).
- Namespace tema errato (`meetup::` invece di `pub_theme::`).
- Override manuale con `->label()` che maschera il problema.

## Contromisure Immediate
1. Ripristinare struttura multilivello del file lingua.
2. Garantire nodi obbligatori valorizzati.
3. Verificare naming file componente (`register.php`, `event.php`, ecc.).
4. Eliminare label/placeholder/helperText manuali.
5. Validare fallback locale su lingua primaria (`it` dove previsto).

## Smoke Test
- Form Filament con etichette auto-generate.
- Pagine tema con `pub_theme::`.
- Pagine frontoffice localizzate con URL corretti.

## Comandi
```bash
php artisan optimize:clear
php artisan test --filter=Lang --compact
./vendor/bin/phpstan analyze Modules/Lang --level=10
```
