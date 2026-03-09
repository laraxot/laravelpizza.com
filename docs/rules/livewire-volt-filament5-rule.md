# Livewire Volt Filament 5 Rule

## Regola

Nel progetto Volt, Livewire 4 e Filament 5 vanno usati secondo il loro ruolo reale, senza mescolare pattern incompatibili.

## Ruoli canonici

- `laravel/folio`: routing file-based del frontoffice;
- `livewire/volt`: componenti Livewire single-file montati dai path registrati in `VoltServiceProvider`;
- `livewire/livewire` 4.x: stato, eventi, interazione dei componenti;
- `filament/filament` 5.x: panel completo lato app;
- pacchetti `filament/*` nel tema: componenti singoli, non panel implicito;
- `filamentphp/spatie-laravel-google-fonts-plugin`: plugin Filament per font Google nel panel, non regola generale per il frontoffice pubblico.

## Regole operative

- usare Volt solo in path montati da `Volt::mount(...)`;
- nelle pagine Folio + Volt, evitare estrazione manuale dei route params quando il binding e' gia' disponibile;
- mantenere il page file Folio minimale e delegare logica business ad Action / model / presenter;
- usare Filament 5 nel tema solo per i package dichiarati in `Themes/Meetup/composer.json`;
- non trattare il plugin Google Fonts come scorciatoia per caricare font pubblici del sito fuori dal contesto Filament panel/plugin.

## Anti-pattern

- duplicare la stessa responsabilita' tra Folio page, Volt component e Blade include;
- usare componenti Filament panel come se fossero automaticamente disponibili nel frontoffice tema;
- documentare Volt/Livewire con pattern di versioni precedenti senza verificare il runtime locale.
