Aggiornamento governance Laraxot sulle relazioni many-to-many.

Regola ribadita e fissata come canonica:
- nel repository le relazioni many-to-many devono usare `belongsToManyX()`;
- `belongsToMany()` va trattato come deviazione architetturale da correggere.

Progressi eseguiti:
- verificato e riallineato `Modules/Meetup/app/Models/Event.php` su `attendees()` con `belongsToManyX()`;
- aggiunto test `Modules/Meetup/tests/Unit/Models/EventAttendeesRelationTest.php`;
- aggiunti i file canonici mancanti richiamati da `CLAUDE.md`:
  - `bashscripts/ai/.cursor/rules/belongstomanyx-critical.md`
  - `bashscripts/ai/.cursor/memories/belongstomanyx-laraxot.md`
- aggiornata la skill locale `bashscripts/ai/.codex/skills/php-quality-gates/SKILL.md`.

Nota: nel modulo `Meetup` l'unico uso runtime residuo trovato nel codice applicativo era la relazione attendees di `Event`.
