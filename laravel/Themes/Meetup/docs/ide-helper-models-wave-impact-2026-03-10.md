# IDE Helper Models Wave Impact On Theme - 2026-03-10

## Perche' interessa il tema

Il tema non esegue `ide-helper:models`, ma subisce direttamente la qualita' dei PHPDoc dei modelli pubblici.

## Impatto pratico

- PHPDoc piu' accurati riducono errori statici su pagine profilo, eventi e componenti che leggono modelli pubblici;
- annotazioni sbagliate o generate senza controllo propagano rumore anche nei file frontoffice;
- per questo la wave `ide-helper:models -W` va trattata come manutenzione del contratto dati, non come semplice tooling.
