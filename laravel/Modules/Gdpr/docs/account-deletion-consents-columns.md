# Cancellazione dell'account e colonne di revoca dei consensi

Verificato il 12/11/2026 su LaravelPizza.

## Il problema

`DeleteAccountAction` (art. 17), `RevokeGdprConsentsAction` e il trait `HasGdpr` scrivono su `consents` le colonne
`revoked_at`, `revoked_ip_address` e `metadata`, ma **nessuna migrazione le creava** e `Consent::$fillable` non le
elencava. Risultato:

- "elimina account" falliva con `Unknown column 'revoked_at'` (errore 500);
- `updateOrCreate([...], ['revoked_at' => ..., 'metadata' => ...])` scartava in silenzio i campi non fillable.

## La correzione

- Migrazione `database/migrations/2026_11_12_000002_add_revocation_columns_to_consents_table.php`
  (`revoked_at` indicizzata, `revoked_ip_address`, `metadata` JSON), solo `tableUpdate` con `hasColumn`.
- `Consent`: le tre colonne in `$fillable`; cast `accepted_at`/`revoked_at` datetime e `metadata` array.

## Chi la usa

- LaravelPizza: la pagina "Modifica il profilo" del tema Meetup ha la sezione "Elimina l'account"
  (`Modules\Meetup\Actions\Profile\DeleteOwnAccountAction`), che chiama `DeleteAccountAction::execute()` e poi
  cancella i dati personali. Test: `Modules/Meetup/tests/Feature/ProfileEditPageTest.php`.
- La rotta storica `POST /{lang}/account/delete` (`account.delete`) resta disponibile per gli altri progetti.

Nota: `DeleteAccountAction` da sola fa soft delete e revoca i consensi, ma **non** cancella nome ed email. Un progetto
che nell'informativa promette la cancellazione dei dati deve anonimizzarli dopo la chiamata, come fa
`DeleteOwnAccountAction` in LaravelPizza.
