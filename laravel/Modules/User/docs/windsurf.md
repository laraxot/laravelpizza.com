---
description:
globs:
alwaysApply: false
related:
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
<<<<<<< .merge_file_DK7Bkh
<<<<<<< .merge_file_MBicNp
qmd: "windsurf regola migrazioni xotbasemigration"
=======
>>>>>>> .merge_file_PBfkkZ
=======
qmd: "windsurf regola migrazioni xotbasemigration"
>>>>>>> .merge_file_Qqbvgp
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
- [Documentazione centrale](mdc:../../../../../docs/index.md)
