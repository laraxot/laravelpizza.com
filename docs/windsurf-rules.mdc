---
description:
globs:
alwaysApply: false
---
# Regola Windsurf: Migrazioni XotBaseMigration

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
