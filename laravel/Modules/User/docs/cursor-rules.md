---
description:
globs:
alwaysApply: false
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
title: "Regola Cursor: Migrazioni XotBaseMigration"
type: note
status: draft
updated: 2026-10-07
tags: [docs, user]
qmd: "regola cursor: migrazioni xotbasemigration user"
---
# Regola Cursor: Migrazioni XotBaseMigration

## Regola
- Usare SEMPRE `$this->hasColumn('nome_colonna')` nelle migrazioni che estendono XotBaseMigration.
- NON usare mai `Schema::hasColumn`.

## Esempio
```php
if (! $this->hasColumn('state')) {
    $this->tableUpdate(function (Blueprint $table) {
        $table->string('state')->nullable();
    });
}
```

## Motivazione
- Compatibilità multi-db
- Coerenza tra i moduli
- Evita errori dovuti a override custom

## Checklist
- [ ] Usare solo $this->hasColumn
- [ ] Aggiornare tutte le vecchie migrazioni

## Collegamenti correlati
- [README User](mdc:README.md)
- [Best Practices](mdc:best-practices.mdc)
- [Linee guida Actions](mdc:actions.mdc)
- [Linee guida Activitylog](mdc:activitylog.mdc)
- [Documentazione centrale](mdc:../../../../docs/INDEX.md)

