# Collisioni di nome per sola differenza di maiuscole

**Misurato**: 2026-08-31
**Regola violata**: `no-case-variations`, `case_sensitive_naming_critical`
**Quadro generale**: [Modules/Xot/docs/stato-qualita-progetto-2026-08-31.md](../../Xot/docs/stato-qualita-progetto-2026-08-31.md)

## Il problema

In questo modulo esistono percorsi che differiscono solo per maiuscole. Su Linux
convivono. Su filesystem case-insensitive, cioe' macOS di default e Windows, i due
percorsi sono lo stesso percorso: al clone uno dei due file sovrascrive l'altro, in
modo non deterministico. Il repository risulta corrotto senza che nulla segnali
l'errore.

Riproduzione:

```bash
cd laravel && find Modules/User -name '*.php' -not -path '*/vendor/*' \
  | awk '{print tolower($0)}' | sort | uniq -d
```

## Coppie a contenuto divergente (1)

Attenzione: qui i due file **non** sono uguali. Sotto lo stesso nome logico
convivono due verita' diverse, e non si sa quale sia quella viva. Vanno letti e
riconciliati a mano, mai cancellati a colpo d'occhio.

```
Modules/User/tests/Feature/Database/migrations/UserMigrationSyntaxTest.php
Modules/User/tests/Feature/Database/Migrations/UserMigrationSyntaxTest.php
```

## Come si chiude

1. Per ogni coppia divergente, confrontare il contenuto e decidere quale versione
   sopravvive; portare in quella le parti utili dell'altra.
2. Rinominare in avanti verso la forma PSR-4 (`Fixtures/`, `Unit/`, `Feature/`,
   `DataObjects/`, `Config/`, `Providers/`).
3. Rimuovere la variante superflua.
4. Verificare che il conteggio del comando qui sopra sia sceso a zero.

Serve un test che impedisca la ricomparsa del difetto: senza, il conteggio torna a
crescere. Vedi il punto 4 del quadro generale.
