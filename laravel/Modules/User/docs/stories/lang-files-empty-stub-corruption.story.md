# Story: file di lingua User svuotati a stub senza return

Status: done

## GitHub (tracciamento)

| Artefatto | URL |
|---|---|
| Issue (module_user_fila5) | https://github.com/laraxot/module_user_fila5/issues/102 |

## Story

Come utente di `/user/admin`, voglio che il pannello si apra senza `TypeError`, cosi'
posso gestire utenti, ruoli e viste invece di vedere una schermata di errore.

## Acceptance Criteria

1. I 4 file `Modules/User/lang/it/{client,role,login,view_user}.php` contengono un
   `return [...]` reale e restituiscono un array, verificato con `include()`.
2. Provenienza dichiarata per byte: contenuto ripreso da un commit reale via
   `git show <sha>:<path>`, mai ricostruito a mano.
3. Il commit sospetto di aver introdotto la corruzione e' identificato e il suo
   diff-scope (se allargato ad altri file) e' segnalato come rischio aperto, non
   chiuso a forza in questa story.

## Tasks / Subtasks

- [x] Root-cause del crash live `/user/admin`: `array_replace_recursive(): Argument #2
      must be of type array, int given` in `Illuminate\Translation\FileLoader`,
      innescato da `Modules/Lang/app/Actions/Filament/AutoLabelAction.php:113` (AC: 1)
- [x] Isolare il file responsabile: uno dei 4 file User era ridotto a
      `<?php\n\ndeclare(strict_types=1);` senza `return`, quindi `include()`
      restituiva `int(1)` invece di un array (AC: 1)
- [x] Bisezionare la storia git per commit, per byte-count, del file corrotto vs i
      precedenti, senza mai usare `checkout`/`revert`/`reset` (regola second-brain
      `git-forward-only`) (AC: 2, 3)
- [x] Ripristinare i 4 file leggendo con `git show <sha>:<path>` e scrivendo il
      contenuto nel working tree come edit ordinario (AC: 2)
- [x] Verificare via `include()` + `gettype()` che ognuno restituisca `array` (AC: 1)
- [x] Lock protocol sui 4 path durante l'edit

## Dev Notes

### Meccanismo, diverso da quello di Activity/Job

Non e' corruzione byte-a-byte (niente pipe qui). E' un file PHP sintatticamente valido
che pero' non fa `return`. In PHP, `include()`/`require()` su un file che arriva in
fondo senza `return` esplicito **restituisce `int(1)`**. `Illuminate\Translation\FileLoader`
fa `array_replace_recursive($base, include $path)` per fondere le traduzioni di piu'
path: se uno qualsiasi dei path restituisce `1` invece di un array, l'intera chiamata
lancia `TypeError`. `php -l` non lo vede: il file e' sintatticamente perfetto, il difetto
e' semantico (manca lo statement finale).

### File e recupero

| file | commit sorgente | byte recuperati | chiavi |
|---|---|---:|---:|
| `client.php` | `ee7791cfc` | 4504 | 7 |
| `role.php` | `f62fd0acf` | 12416 | 13 |
| `login.php` | `f62fd0acf` | 2255 | 15 |
| `view_user.php` | `9d2362d94` | 1406 | 6 |

### Errore auto-inflitto durante il recupero, corretto nello stesso turno

Primo tentativo: `git show HEAD:Modules/User/lang/it/client.php > ...` da cwd
`laravel/`, path senza il prefisso `laravel/` richiesto (il repo git e' la root del
monorepo, `laravel/` e' una directory ordinaria dentro, non un submodule separato per
User via questo path). Il comando `git show` e' fallito (`fatal: path ... exists, but
not ...`), ma la redirezione `>` della shell ha comunque troncato il file target a 0
byte, perche' la redirezione avviene a livello di shell indipendentemente dall'esito
del comando. Rilevato subito con `wc -c` sui 4 file (tutti a 0), corretto rilanciando
`git show` con il path giusto (`laravel/Modules/User/lang/it/client.php`) e cwd alla
root del monorepo, prima di qualsiasi altra lettura/verifica di quei file. I file non
sono mai stati letti da altro in stato 0 byte.

### Falsa pista iniziale

`git status --porcelain` mostrava `M` per questi 4 file, il che aveva fatto pensare che
HEAD contenesse gia' la versione buona. Falso: HEAD stesso aveva gia' lo stub vuoto a
32 byte. Corretto bisezionando commit per commit (`git log --oneline -N -- <path>` +
conteggio byte per ciascun SHA), non fidandosi dell'assunzione "HEAD pulito, working
tree sporco".

### Commit sospetto, non ancora auditato

`0701a777a` ("feat(gitmodules): add new submodule for Setting module") e' il primo
commit in cui tutti e 4 i file risultano gia' ridotti allo stub vuoto; nei commit
immediatamente precedenti avevano contenuto reale. Il messaggio del commit non ha
alcuna relazione apparente con file di lingua di User: sospetto che il commit abbia
toccato altri file, in altri moduli, in modo non intenzionale. **Non verificato in
questa sessione**: nessun `git show --stat 0701a777a` esaustivo ne' controllo di altri
moduli. Rischio aperto, da chiudere con un audit dedicato se il team lo ritiene
prioritario.

### Correlato

- [`Modules/Activity/docs/stories/lang-files-pipe-corruption.story.md`](../../Activity/docs/stories/lang-files-pipe-corruption.story.md): stesso crash live, meccanismo di corruzione diverso (pipe, non stub vuoto)
- [`Modules/Job/docs/stories/lang-files-pipe-corruption-job.story.md`](../../Job/docs/stories/lang-files-pipe-corruption-job.story.md): idem
- [`Modules/User/docs/stories/user-profile-volt-instanceof-wrong-user-class.md`](user-profile-volt-instanceof-wrong-user-class.md): bug diverso, stessa sessione, stesso modulo

### Testing standards

Nessun test nuovo: proprieta' del file sorgente, non comportamento di dominio.
Verifica e' `include()` + `gettype()`, ripetibile a mano, non automatizzata qui.

## Dev Agent Record

### Completion Notes List

- 4/4 file restituiscono `array` (verificato via `include()`).
- `php -l` su tutti e 4: nessun errore di sintassi (atteso, non e' un indicatore
  affidabile per questa classe di difetto: vedi Dev Notes).
- Crash live risolto: `Modules/Lang/app/Actions/Filament/AutoLabelAction.php:113` non
  riceve piu' `int` da `array_replace_recursive` per questi 4 path.
- Non eseguito un audit repo-wide del commit `0701a777a`: segnalato come rischio
  aperto, non chiuso.

### File List

- `laravel/Modules/User/lang/it/client.php`: ripristinato da `ee7791cfc`
- `laravel/Modules/User/lang/it/role.php`: ripristinato da `f62fd0acf`
- `laravel/Modules/User/lang/it/login.php`: ripristinato da `f62fd0acf`
- `laravel/Modules/User/lang/it/view_user.php`: ripristinato da `9d2362d94`
