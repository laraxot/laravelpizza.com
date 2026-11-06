---
title: "TESTING"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "TESTING"
issues: []
discussions: []
---

# Testing $MOD

## Quick Start

```bash
./vendor/bin/pest Modules/$MOD/tests
./vendor/bin/pest Modules/$MOD/tests --filter="TestName"
```

## Coverage

Coverage report: docs/coverage.md (auto-generated).

Target: ≥85% coverage.

See Xot module (TESTING.md) for base test patterns.
---
title: "TESTING"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "TESTING"
issues: []
discussions: []
# UI Module Testing

## Component Testing
- Livewire component tests
- Vue component tests
- Filament widget tests

## Theme Testing
- Tailwind CSS build verification
- Theme variable validation
- Dark mode testing

## Integration Tests
- Admin panel flow tests
- Page builder drag-and-drop tests
- Theme switching tests

## Running Tests
```bash
./vendor/bin/pest Modules/UI/tests
```
