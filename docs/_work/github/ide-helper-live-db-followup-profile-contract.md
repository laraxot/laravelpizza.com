Follow-up di governance dopo la wave `ide-helper:models -W`.

Ho verificato anche il livello di tipizzazione dei PHPDoc generati:

- per relazioni audit/profile come `$creator`, `$updater`, `$deleter`
- il tipo corretto **non** e' il model concreto `Modules\*\Models\Profile`
- il tipo corretto e' `\Modules\Xot\Contracts\ProfileContract|null`

Motivo:

- il chiamante dipende dal contratto, non dall'implementazione concreta del profilo;
- questo evita accoppiamento cross-modulo nei PHPDoc;
- impedisce che una wave `ide-helper` restringa i tipi a un model locale troppo specifico.

Ho allineato anche la documentazione locale:

- `docs/rules/profile-contract-phpdoc-rule.md`
- `docs/memory/profile-contract-phpdoc-memory.md`
- `docs/skills/profile-contract-phpdoc-skill.md`
- `docs/rules/ide-helper-models-governance-rule.md`
- `docs/memory/ide-helper-models-memory.md`
- `docs/skills/ide-helper-models-wave-skill.md`
- `laravel/Modules/Xot/docs/ide-helper-models-governance.md`
- `laravel/Modules/Meetup/docs/profile-contract-phpdoc-governance.md`

Stato attuale: non vedo piu' occorrenze residue di `@property-read \Modules\Meetup\Models\Profile|null $creator/$updater/$deleter` nei model attivi del tree `laravel/Modules`.
