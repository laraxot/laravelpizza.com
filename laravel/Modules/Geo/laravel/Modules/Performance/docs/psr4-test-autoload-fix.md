# PSR-4 Test Autoload Fix (Issue #47)

## Context
`composer dump-autoload -o` segnalava warning PSR-4 nel test `GetHaDirittoMotivoActionTest.php` per classe helper top-level non conforme.

## Fix Applied
- Rimossa classe top-level dal file test.
- Riscritta la suite con casi coerenti alla signature reale:
  - `execute(BaseIndividualeModel $model, array $criteriEsclusione, array $criteriOption): array{0:int,1:string}`
- Evitata logica fragile legata ad accessor Eloquent non necessari per unit test.

## Verification
- `./vendor/bin/pest Modules/Performance/tests/Unit/Actions/GetHaDirittoMotivoActionTest.php --stop-on-failure`
- Risultato: PASS (16 test)

## Tracking
- Issue: https://github.com/provtv/base_ptv_fila5_mono/issues/47
- Discussion centrale: https://github.com/provtv/base_ptv_fila5_mono/discussions/18
