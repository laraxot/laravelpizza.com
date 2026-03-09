Aggiornamento governance stack frontend/admin dopo studio fonti primarie:

- `livewire/volt`: da usare come layer single-file per componenti Livewire montati dai path registrati nel `VoltServiceProvider`;
- Livewire 4 components: confermata la separazione netta tra stato/eventi/componente e semplice Blade include;
- Filament 5.x: nel progetto coesistono panel completo a root (`filament/filament`) e package Filament modulari nel tema `Meetup`;
- plugin `filamentphp/spatie-laravel-google-fonts-plugin`: utile come plugin panel Filament, non come scorciatoia per i font del frontoffice pubblico.

Ho fissato le regole locali in:

- `docs/rules/livewire-volt-filament5-rule.md`
- `docs/memory/livewire-volt-filament5-memory.md`
- `docs/skills/livewire-volt-filament5-governance-skill.md`
- `laravel/Themes/Meetup/docs/livewire-volt-filament5-governance.md`
- `laravel/Modules/Cms/docs/volt-livewire-component-boundaries.md`

Effetto pratico: quando tocchiamo pagine pubbliche o block CMS, dobbiamo decidere prima se il file e' Folio, Volt, Blade plain o Filament component, invece di mischiare responsabilita'.
