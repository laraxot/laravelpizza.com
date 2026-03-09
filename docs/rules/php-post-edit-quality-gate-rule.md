# PHP Post-Edit Quality Gate Rule

## Regola vincolante

Dopo ogni modifica a un file PHP, prima di dichiarare il lavoro completato bisogna eseguire e controllare almeno questi quality gate:

1. `phpstan`
2. `phpmd`
3. `phpinsights`

Se il file e' testabile, bisogna anche:

4. verificare se esiste gia' un test Pest associato;
5. aggiornarlo o crearlo se manca;
6. eseguire il test pertinente.

## Scope

Questa regola si applica a:

- file applicativi `Modules/*/app/**/*.php`
- file tema PHP/Blade con logica PHP rilevante
- file test `Modules/*/tests/**/*.php`
- file infrastrutturali PHP condivisi

## Strategia minima

Per modifiche mirate, il controllo deve partire dal perimetro piu' stretto possibile:

```bash
cd laravel
./vendor/bin/phpstan analyse path/to/File.php --level=10
./vendor/bin/phpmd path/to/File.php text phpmd.xml
./vendor/bin/phpinsights analyse path/to/File.php --no-interaction
./vendor/bin/pest path/to/AssociatedTest.php
```

Se il file non e' direttamente testabile, va documentato il motivo e va comunque eseguita la verifica piu' vicina disponibile.

## Regole operative

- Non basta `php -l`: il lint sintattico non sostituisce i quality gate.
- Se il file PHP modificato e testabile, non basta verificare: bisogna anche eseguire (o creare/aggiornare) il relativo test in Pest.
- Non basta dire "file non testabile" senza aver valutato un test Pest vicino al comportamento modificato.
- Se `phpmd` o `phpinsights` non sono disponibili o non supportano bene il perimetro richiesto, il blocco va dichiarato esplicitamente nel report finale.
- I controlli vanno lanciati dopo l'editing, non solo prima del commit.
- Il report finale deve dire cosa e' stato eseguito davvero e cosa no.

## Riferimenti

- [verify-before-declare-rule.md](verify-before-declare-rule.md)
- [testing-standards.md](testing-standards.md)
- [phpstan-workflow.md](phpstan-workflow.md)
