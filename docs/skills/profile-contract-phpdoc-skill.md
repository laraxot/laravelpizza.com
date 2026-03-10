# Skill: Profile Contract PHPDoc

## Trigger
Quando un PHPDoc di model annota `creator`, `updater`, `deleter` o relazioni audit simili con un model `Profile` concreto.

## Regola
Sostituire il tipo concreto con `\Modules\Xot\Contracts\ProfileContract|null`.

## Passi
1. cercare le occorrenze residue nei model PHP;
2. correggere il PHPDoc verso il contratto;
3. aggiornare regole, memory e docs di ide-helper se la regressione arriva da una wave generata;
4. riportare la decisione nei thread GitHub se ha valore di governance.
