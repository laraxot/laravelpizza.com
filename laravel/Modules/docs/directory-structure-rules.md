# Directory Structure Rules

Regola globale per tutti i moduli Laraxot di questo repository:

- non creare mai `lang/lang/`;
- non creare mai `_docs/`;
- le traduzioni vivono in `lang/<locale>/`;
- la documentazione ufficiale vive in `docs/`.

Verifica:

```bash
find laravel/Modules -type d \( -path '*/lang/lang' -o -name '_docs' \) | sort
```

Il comando deve produrre output vuoto.

Regola canonica: [docs/wiki/concepts/no-lang-lang-and-no-underscore-docs-rule.md](../../../docs/wiki/concepts/no-lang-lang-and-no-underscore-docs-rule.md).
