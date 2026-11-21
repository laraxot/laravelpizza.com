---
title: "gitignore Tests vs tests — claude-audit"
type: memory
module: Tenant
tags: [tenant, gitignore, claude-audit, pest]
created: 2026-07-09
updated: 2026-07-09
qmd: "gitignore Tests slash ignora tests Pest claude-audit zero test files"
issues:
  - "https://github.com/laraxot/module_tenant_fila5/issues/1"
discussions:
  - "https://github.com/laraxot/platform/discussions/304"
related:
  - ../../Xot/docs/wiki/concepts/claude-audit-static-all-modules.md
---

# `Tests/` in .gitignore e claude-audit

## Problema

Riga `Tests/` nel `.gitignore` del modulo: su WSL la libreria `ignore` è **case-insensitive** → esclude anche `tests/` (Pest) e `audit-coverage/tests/`.

claude-audit legge `.gitignore` → **0 test file** → finding «No Tests Found» (79/100).

## Fix

```gitignore
/Tests/
!tests/
!tests/**
!audit-coverage/
!audit-coverage/**
```

Usare `/Tests/` (solo legacy maiuscolo) + negazioni esplicite per Pest.

## Verifica

```bash
cd laravel/Modules/Tenant && node -e "
const ig=require('ignore');const fs=require('fs');
ig.add(fs.readFileSync('.gitignore','utf-8'));
console.log(ig.ignores('tests/Pest.php')); // false
"
```
