# Story: Gap analysis utente + clean-up fase 1 (2026-09-22)

- **Epic**: USER-GAP-2026
- **Status**: done
- **Ambito**: `laravel/Modules/User`: analisi architetturale a sola lettura (report BMAD) + fase 1 di igiene (rimozione artefatti morti).
- **AC**:
  - Report prodotto in `laravel/Modules/User/docs/bmad/user-architecture-gap-analysis.md` (inventario, top gap, punti sani, work item).
  - Rimozione di soli file morti verificati: 0 riferimenti in produzione (rg su `laravel/`, escluso il file stesso).
  - Nessuna modifica a logica viva; unico edit `tests/Unit/Datas/UserDatasAndEnumsCoverageTest.php` (riferimenti a enum duplicata).
  - phpstan `Modules/User` a level max: 1665 file, 0 errori.
- **Artefatti toccati**:

Rimossi (git rm, 49 file tracked) tra cui:
- `app/Models/Models/BaseUser.php`, `app/Enums/Enums/LanguageEnum.php`,
  `app/Actions/CreateUserAction.php`, `app/Adapters/**` (3),
  `app/Http/Livewire/PrivacyPolicy.php`, `app/Http/Livewire/TermsOfService.php`,
  `app/Http/Volt/LogoutAction.php`, `app/Livewire/Logout.php`,
  residui `.bak/.old/.boh/.test/.wip/.no/.to_xot` in `app/`,
  `app/Filament/**/.php-cs-fixer.dist.php` (2),
  `tests/Unit/Adapters/**`, junk non-php in `database/migrations` (5),
  `resources/views/package.json` + `package-lock.json`.
- Rimozione fisica (non versionato): `resources/views/node_modules` (92 MB), `tests/Unit/graphify-out`.

**Da fare in follow-up**: deduplicazione risorse Passport/Socialite (cotern hero), unificazione pivot su Xot, harden BaseUser (write-on-read, hash password, tipi chiave), registrazione observer/policy, cleanup eventi+contract Fortify, unificazione logout Livewire/Volt, migrazioni "owner", seeders duplicati.