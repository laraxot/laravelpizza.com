# Controllo conflitti Notify - 2026-04-21

## Esito

Il modulo `Notify` diretto non contiene marker di conflitto Git nei file tracciati fuori dalla directory annidata `laravel/`.

Sono stati trovati e risolti tre conflitti reali nella copia annidata del tema Sixteen sotto `laravel/Modules/Notify/laravel/Themes/Sixteen`:

- `resources/assets/css/comune-custom.css`
- `resources/views/components/blocks/flow/segnalazione/01-privacy.blade.php`
- `resources/views/components/blocks/flow/segnalazione/03-riepilogo.blade.php`

## Decisioni

- Nel CSS sono stati rimossi marker e duplicati di blocchi gia' presenti per header e footer AGID.
- Nel blocco privacy e' stata mantenuta la navigazione AGID/Bootstrap gia' integrata, rimuovendo il bottone Tailwind duplicato.
- Nel riepilogo e' stato mantenuto il blocco FAQ/contacts post-contenuto.

## Validazioni

- `php -l` OK sui due Blade corretti.
- `git diff --check` OK sui tre file corretti.
- Nessun marker residuo nei tre file risolti.

## Nota operativa

Sotto `laravel/Modules/Notify` esiste una grande massa di file non tracciati e una copia annidata `laravel/Modules/...` con molti marker storici/documentali. Non e' stata normalizzata in blocco per evitare modifiche distruttive o non richieste.
