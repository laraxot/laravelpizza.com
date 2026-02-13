# Media Module Test Coverage

## Coverage Results

**Date**: 2026-01-18  
**Module**: Media  
**Status**: Tests pass but 0.00% per-module code coverage

## Test Execution Summary

- **Tests Passed**: 59
- **Tests Skipped**: 5
- **Assertions**: 122
- **Coverage (Modules/Media/app)**: 0.00% (0/2140 statements)

## Running Tests

```bash
./vendor/bin/pest Modules/Media/tests
```

## Running Coverage (Clover)

```bash
./vendor/bin/pest Modules/Media/tests --coverage-clover /tmp/media-clover.xml
```

## Compute per-module coverage

Filter the Clover report on `Modules/Media/app` and compute statement coverage:

```bash
python3 - <<'PY'
import xml.etree.ElementTree as ET
from pathlib import Path

root = ET.parse(Path('/tmp/media-clover.xml')).getroot()
covered = total = 0
for file_el in root.findall('.//file'):
    name = file_el.get('name') or ''
    if '/Modules/Media/app/' not in name:
        continue
    for line_el in file_el.findall('line'):
        if line_el.get('type') != 'stmt':
            continue
        total += 1
        if int(line_el.get('count') or '0') > 0:
            covered += 1

pct = (covered / total * 100) if total else 0.0
print(f'coverage_pct={pct:.2f}')
print(f'statements_covered={covered}')
print(f'statements_total={total}')
PY
```

## Notes

- The Media module test suite is now stable and reflects the actual runtime schema.
- Coverage is currently 0% because the executed tests do not hit code paths under `Modules/Media/app` that are counted as executable statements by the coverage driver.


