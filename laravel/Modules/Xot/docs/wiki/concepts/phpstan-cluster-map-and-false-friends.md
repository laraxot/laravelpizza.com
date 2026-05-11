# PHPStan Cluster Map And False Friends

## Contesto

L'esecuzione di `phpstan analyse Modules` ha mostrato cluster ricorrenti in Xot e moduli collegati.

Cluster piu' ricorrenti osservati:

- `implode()` con array non tipizzati come `array<string>`
- `array_fill_keys()` con chiavi non garantite string-castable
- accessi a `mixed`
- metodi non trovati su tipi generici Filament/Laravel
- funzioni unsafe (`preg_split`, `base64_decode`, `chmod`)

## Best Practices

- Tipizzare gli array prima delle funzioni string-based.
- Ridurre l'uso di `mixed` nei servizi base e nei wrapper framework.
- Quando un wrapper base conosce un contratto Filament, usare il metodo realmente disponibile nella versione installata.
- Preferire action/helper piccoli con input gia' normalizzati rispetto a metodi base ultra permissivi.
- Per le funzioni unsafe usare le varianti `Safe\*` dove la libreria e' gia' presente.

## Bad Practices

- Scrivere servizi base che accettano tutto e tipizzano nulla.
- Fare affidamento su PHPDoc troppo generici o non sincronizzati con Eloquent/Filament reali.
- Supporre che un metodo Filament esista perche' esisteva in una major/minor diversa.

## False Friends

- Un wrapper base “generico” non e' automaticamente piu' riusabile: spesso aumenta `mixed` e rumore statico.
- Un PHPDoc con `Builder` non rende vero quel tipo se il namespace e' sbagliato.
- Un helper comodo che concatena/implode array eterogenei sembra innocuo ma produce rumore sistemico.

## Priorita'

1. allineare i wrapper Xot ai contratti reali di Filament 5 / Laravel 12
2. ridurre `mixed` nelle basi comuni
3. solo dopo fare cleanup seriale dei moduli dipendenti
