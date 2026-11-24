---
title: "Audit qualita' — modulo User"
type: story
module: User
status: review
created: 2026-11-19
updated: 2026-11-19
issues: ["https://github.com/laraxot/base_techplanner_fila5/issues/64"]
<<<<<<< .merge_file_u5Cb1w
qmd: "audit qualita story user"
=======
>>>>>>> .merge_file_57vQaR
---

# Story: audit qualita' del modulo User

## Contesto

Audit parallelo (7 agenti, issue #64). Scope: solo `Modules/User` (e `Modules/Tenant`, story separata).
Da non toccare: `BaseUser::canAccessPanel` (ruoli `<module>::operator`), flusso Socialite/OAuth.

## Fatto

### Test
- [x] La suite non partiva: `Pest\Exceptions\TestCaseAlreadyInUse` perche' tre file dichiaravano due volte
      `uses(TestCase::class)` (una con FQCN, una con alias): `Unit/Contracts/UserContractBoundaryTest`,
      `Unit/Models/RoleAssignableByTest`, `Unit/Policies/UserActionsPolicyVerdictTest`. Lasciata una sola riga.
- [x] Nuovo test `Unit/Actions/Filament/NormalizeFormSchemaActionTest` (3 casi).
- Nota: un test della suite chiede input da terminale; lanciare Pest con `< /dev/null` per non bloccarsi.

### Documentazione
- [x] Rimossi i duplicati esatti (tenuta la copia col nome piu' pulito, fuori da `legacy/`/`archive/`/`raw/`),
      link interni riscritti.
- [x] Nessuna data nei nomi dei `.md` (date, `YYYYMMDD`, timestamp unix, "gennaio-2025", residui tipo `nome-28.md`):
      file rinominati in kebab-case, data completa spostata in `created:`; collisioni unite nel file senza data.
- [x] Un solo indice: `docs/README.md` (rimossi `index.md`, `INDEX.md`, `00-index.md`, `00-index-1.md`, liste
      generate) e `readme.md` (variante di maiuscole, gia' assorbita nel README). Il README conteneva due volte la stessa meta' ("Contenuto assorbito da readme.md"): rimossa la copia.
- [x] README: versioni corrette (Laravel 13, Filament 5) rispetto a `composer.lock`.

### Codice (`app/`, comportamento invariato)
- [x] DRY: `normalizeFormSchema()` era copiato identico in `EditUserWidget` e `RegistrationWidget` →
      `Actions/Filament/NormalizeFormSchemaAction`.
- [x] `PasswordExpiredWidget`: tolta variabile ridondante con commento obsoleto ("cast di mixed").
- [x] `ChangeTypeCommand`: tolto `@var string|Htmlable|mixed` senza variabile (non aveva effetto).
- [x] Rimosso `Contracts/UserContract.php.to_xot` (file non PHP dentro `app/`, mai caricato).
- `mixed` in `app/`: 192 → 186. I restanti sono confini reali: valori di `config()`, stato di form Filament,
  firme vendor (`ValidationRule::validate`, `Gate::before`, `toMailUsing`), Collection non tipizzate di laravel-trend.

## Verifiche
- PHPStan `Modules/User`: 0 errori prima e dopo.
- Pest: prima la suite non veniva raccolta (errore di bootstrap, 0 test eseguiti); dopo 1485 passati, 67 falliti,
  50 skipped, 25 risky, 6 todo (396 s).
  Alcuni fallimenti sono ambientali (progetto Fixcity, locale de/es mancanti) e non sono stati inseguiti.

- [x] Link verso documenti Xot rinominati senza data (`redundancy-audit`, `stato-qualita-progetto`) aggiornati.

## Rimasto da fare (proposte)
- [ ] Link rotti preesistenti verso Xot: `phpstan-patterns-dec-2025.md`, `phpstan-level-10-dry-kiss-analysis-2025-10-17.md`,
      `dry-kiss-model-refactoring-2025-10-15.md` non esistono in `Modules/Xot/docs` con nessun nome.
- [ ] 67 test falliti: in parte ambientali (Fixcity, locale de/es), in parte seeder/vincoli unique; da analizzare in una story dedicata.
- [ ] Codice non referenziato in questo progetto, da verificare negli altri progetti che usano il modulo
      condiviso `laraxot/module_user_fila5` prima di rimuoverlo: `Actions/Auth/StoreIntendedUrlAction`
      (sostituita da `RememberLoginReturnUrlAction`; un commento in `Themes/Sixteen/.../design-comuni.blade.php`
      la cita ancora), `Application/UseCases/Owners/*Contract` (interfacce senza implementazioni),
      `Actions/Shield/Resolve*ConfigurationAction`, `Actions/Activity/AuthenticationLogQueryAction`,
      `Actions/Auth/GetAuthenticationLogQueryAction`, `Datas/{UserContextData,CreateUserData,UpdateUserData}`,
      contratti stile Jetstream in `Contracts/` (`CreatesTeams`, `DeletesUsers`, ...).
- [ ] `docs/` ha ancora ~1000 file in radice con nomi quasi uguali (`actions-structure-1.md`, `-2.md`, ...):
      non sono duplicati esatti, vanno uniti leggendo il contenuto.
