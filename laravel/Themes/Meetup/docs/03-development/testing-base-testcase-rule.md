# Testing Base TestCase Rule

Per coerenza con Laraxot, i test dei moduli che supportano il tema devono usare la gerarchia:

`Modules/*/tests/TestCase.php` -> `Modules\\Xot\\Tests\\XotBaseTestCase`

Obiettivo:
- bootstrap unico,
- setup prevedibile,
- riduzione della duplicazione.

Nota: i test in `Themes/*` non devono introdurre un bootstrap alternativo incompatibile con `XotBaseTestCase`.
