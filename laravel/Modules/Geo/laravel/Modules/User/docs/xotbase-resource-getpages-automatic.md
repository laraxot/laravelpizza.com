# XotBaseResource getPages() Automatic: Filosofia DRY

## Data: 2025-01-22

## Il Dibattito Feroce

### 🎭 Protagonisti

**Il Pragmatico** (DRY - Don't Repeat Yourself)
vs
**Il Purista** (Explicit is Better than Implicit)

---

## Round 1: Devo Sovrascrivere getPages()?

### 🟢 Il Pragmatico Attacca

> "XotBaseResource ha già un metodo `getPages()` che genera automaticamente le pagine basandosi su convenzioni di naming! Non serve sovrascriverlo! È violazione DRY!"

**Argomenti:**
- **DRY**: XotBaseResource già implementa `getPages()` con convenzioni
- **Convenzioni**: `List{Plural}`, `Create{Name}`, `Edit{Name}`, `View{Name}`
- **Manutenzione**: Meno codice = meno manutenzione
- **Coerenza**: Tutte le Resources seguono le stesse convenzioni

### 🔴 Il Purista Controattacca

> "Ma se ho bisogno di pagine custom o route diverse? Devo poter sovrascrivere! Explicit is better than implicit!"

**Argomenti:**
- **Flessibilità**: Poter sovrascrivere per casi speciali
- **Explicit**: Vedere esplicitamente quali pagine sono registrate
- **Debug**: Più facile debuggare se vedo il metodo esplicitamente

### 🏆 VINCITORE: Il Pragmatico

**Motivazione della Vittoria:**

1. **DRY First**: `XotBaseResource::getPages()` implementa già la logica:
   ```php
   $prefix = static::class.'\Pages\\';
   $name = Str::of(class_basename(static::class))->before('Resource')->toString();
   $plural = Str::of($name)->plural()->toString();
   $index = Str::of($prefix)->append('List'.$plural)->toString();
   $create = Str::of($prefix)->append('Create'.$name.'')->toString();
   $edit = Str::of($prefix)->append('Edit'.$name.'')->toString();
   $view = Str::of($prefix)->append('View'.$name.'')->toString();
   ```

2. **Convenzioni Standard**: Se segui le convenzioni di naming, `getPages()` funziona automaticamente:
   - `OauthPersonalAccessClientResource` → `ListOauthPersonalAccessClients`, `CreateOauthPersonalAccessClient`, `EditOauthPersonalAccessClient`, `ViewOauthPersonalAccessClient`
   - `TeamPermissionResource` → `ListTeamPermissions`, `CreateTeamPermission`, `EditTeamPermission`, `ViewTeamPermission`

3. **KISS**: Keep It Simple, Stupid. Se non hai bisogno di personalizzazioni, non sovrascrivere.

4. **Manutenzione**: Meno codice duplicato = meno errori, meno manutenzione.

**Decisione Finale**: ✅ **NON SOVRASCRIVERE getPages() SE SEGUI LE CONVENZIONI**

---

## Quando SOVRASCRIVERE getPages()

### Casi Legittimi

1. **Route Custom**: Se hai bisogno di route diverse da `/`, `/create`, `/{record}/edit`, `/{record}`
2. **Pagine Custom**: Se hai pagine con nomi non standard
3. **Ordine Diverso**: Se hai bisogno di un ordine diverso delle pagine
4. **Pagine Condizionali**: Se alcune pagine devono essere registrate solo in certe condizioni

### Esempio di Sovrascrittura Legittima

```php
public static function getPages(): array
{
    return [
        'index' => Pages\ListOauthClients::route('/'),
        'create' => Pages\CreateOauthClient::route('/create'),
        'view' => Pages\ViewOauthClient::route('/{record}'), // View prima di Edit
        'edit' => Pages\EditOauthClient::route('/{record}/edit'),
        'custom' => Pages\CustomOauthClientPage::route('/custom'), // Pagina custom
    ];
}
```

---

## Filosofia Finale

**DRY + KISS = Non Sovrascrivere Se Non Necessario**

- ✅ **Usa le convenzioni**: Se segui `List{Plural}`, `Create{Name}`, `Edit{Name}`, `View{Name}`, non sovrascrivere
- ✅ **Sovrascrivi solo se necessario**: Route custom, pagine custom, ordine diverso
- ✅ **Documenta le eccezioni**: Se sovrascrivi, documenta PERCHÉ

## Prossimi Passi

1. ✅ Rimuovere `getPages()` da Resources che seguono le convenzioni
2. ✅ Verificare che le pagine esistano con i nomi corretti
3. ✅ Documentare eccezioni quando `getPages()` è sovrascritto

## Collegamenti

- [XotBaseResource Source Code](../../../Xot/app/Filament/Resources/XotBaseResource.php)
- [Filament Resources Philosophical Debate](./filament-resources-philosophical-debate.md)
- [Filament Best Practices](./filament-best-practices.md)
