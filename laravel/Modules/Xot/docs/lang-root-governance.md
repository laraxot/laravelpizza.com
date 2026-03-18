# Lang Root Governance

## Regola

Nel modulo `Xot` la root corretta delle traduzioni legacy e' `lang/<locale>/...`.

La cartella `lang/lang/` non deve esistere.

## Perche'

- duplica inutilmente il namespace fisico delle traduzioni
- introduce un livello fantasma che non aggiunge significato
- rende piu` ambiguo capire qual e' la vera root i18n del modulo
- aumenta il rischio di drift tra copie duplicate degli stessi file

## Stato verificato

Nel repository `base_predict_fila5` i file sotto `laravel/Modules/Xot/lang/lang/<locale>/...` risultano duplicati del path corretto `laravel/Modules/Xot/lang/<locale>/...`, quindi il livello `lang/lang` e' rumore architetturale e va rimosso.

## Regola operativa

1. Le traduzioni di modulo stanno in `lang/<locale>/...` oppure, se il modulo usa il layout Laravel moderno, in `resources/lang/<locale>/...`.
2. Non si annida mai una seconda cartella `lang/` sotto `lang/`.
3. Se emerge `lang/lang/`, il fix corretto e' rimuovere il duplicato e aggiornare docs/rules/tracking.
