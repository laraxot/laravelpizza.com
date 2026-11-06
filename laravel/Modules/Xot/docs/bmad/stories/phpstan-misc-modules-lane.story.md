---
id: phpstan-misc-modules-lane
title: PHPStan lane B - 14 errori sparsi in AI, Job, Media, Meetup, Rating, User, Xot
module: Xot
type: bugfix
status: done
tags: [phpstan, level-10, swarm, lane-b]
---

# Story: PHPStan lane B (errori sparsi in 7 moduli)

## Contesto

14 errori in 9 file, nessuna famiglia unica. Quando la lane e' partita il working tree era gia' stato toccato da altre sessioni:
tutti i file ripassati da PHPStan davano 0 errori, ma alcuni erano file nuovi non tracciati (rinomine Action in AI, Media, Xot) e
uno (`GetTaskCommandsAction`) veniva riscritto da un altro agente mentre lavoravo. Per ogni errore ho quindi ricostruito lo scopo,
verificato nel `vendor/` che la correzione fosse nella causa vera, e tolto solo quello che restava cosmetico o impreciso.

Versioni lette in `composer.lock`: laravel/framework v13.19.0, filament/actions v5.6.8, intervention/image 4.1.5.

## Errore -> scopo -> causa -> fix -> verifica

| Errore | Scopo del codice | Causa radice | Fix | Esito |
|---|---|---|---|---|
| `AI/.../AnalyzeBasicSentimentAction.php` isset.offset + alreadyNarrowedType | Conta parole positive/negative (con inversione da negazione) per il sentiment "basic" quando Transformers non c'e' | `Safe\preg_match_all` con PREG_PATTERN_ORDER e un pattern lancia su errore e riempie sempre `$matches[0]` come `list<string>`: `isset($matches[0])` e `is_string($token)` erano guardie morte | Guardie tolte, `$tokens = $matches[0]` (file gia' rifatto dalla sessione AI, sostituisce `BasicSentimentAnalyzer`) | fixed, PHPStan 0 |
| `Job/.../GetTaskCommandsAction.php` argument.type | Elenca i comandi Artisan ordinati, quelli senza `:` per primi | `sortBy` accetta `callable(TValue, TKey)`; `Artisan::all()` e' `array` non tipizzato, quindi `TValue = mixed` e un closure con parametro `Command` non e' compatibile | Closure con `mixed` + `instanceof Command` e ramo `getName() === null` (`Command::getName()` e' `?string`) | in-corso-altrui: file riscritto alle 09:03 e 09:04 da un'altra sessione, non toccato; PHPStan 0 |
| `Media/.../StripImageMetadataAction.php` argument.unknown | Ri-codifica JPEG/PNG senza EXIF/GPS/tEXt | Errore di API, non di major: in intervention/image 4.1.5 `JpegEncoder(quality, progressive, ?strip)` ha `strip`, `PngEncoder(interlaced, indexed)` no. Media richiede `"*"`. Il driver GD scrive solo pixel (nessun EXIF/tEXt), `StripMetaModifier` esiste solo nel driver Imagick | `new PngEncoder()` senza `strip`; JPEG mantiene `strip: true` | fixed, PHPStan 0 |
| `Meetup/.../Event.php` generics.notGeneric | `@use HasXotFactory<EventFactory>` voleva tipizzare la factory | `HasXotFactory` non ha `@template`; la factory si risolve per classe con `GetFactoryAction` | Tolto il `@use` e l'import `EventFactory` rimasto inutilizzato (il `@method static ... factory()` usa gia' il FQCN) | fixed, PHPStan 0 |
| `Event.php` class.notFound x2 + return.type | `getSocialShareData()` alimenta la condivisione social degli eventi (blocco tema `events/detail`) | `Modules\Seo\Data\SocialShareData` non esiste: la classe vive in `Modules\Seo\Datas\SocialShareData` (cartella `app/Datas`, vedi `Seo/docs/stories/phpstan-zero-errors-seo.story.md`). Il resto e' conseguenza: `from()` su classe ignota restituisce mixed | FQCN `Datas\SocialShareData` nel return type e nel `from([...])`; le chiavi `url,title,text,image` coincidono con il costruttore. Aggiornato il test `Meetup/tests/Unit/Models/EventTest.php:135` che asseriva ancora il vecchio FQCN | fixed, PHPStan 0 |
| `Meetup/.../Venue.php` missingType.generics | `HasAddress` e' generico `@template TModel of Model` | `use HasAddress` senza tipo | `/** @use HasAddress<Venue> */` (stesso uso del fixture `Geo/tests/Fixtures/Traits/HasAddressTestModel.php`) | fixed, PHPStan 0 |
| `Rating/.../RatingMorphInfolist.php`, `BaseRatingInfolist.php` method.static | Schema infolist della Resource | `XotBaseResourceInfolist::getInfolistSchema()` e' astratto di istanza; le due classi lo dichiaravano `static`. Migrazione form/infolist da statico a istanza gia' fatta nelle `*Form` accanto | `static` tolto. Chiamanti statici di `Schemas\*Infolist::getInfolistSchema(` in `app/`: nessuno | fixed, PHPStan 0 |
| `User/.../PrivacyPolicyWidget.php` return.type | Mostra la privacy policy markdown nel panel | `view()` con nome vista letterale e' tipizzata `View` dall'helper Laravel; il mixed veniva dalla versione precedente del metodo, gia' sostituita | Tolti variabile intermedia e `@var view-string` (cosmetici): `view('user::filament.widgets.privacy-policy', [...])` diretta | fixed, PHPStan 0 |
| `Xot/.../ShowArtisanErrorLogAction.php` nullCoalesce.offset | Estrae gli URL dei log di errore | `preg_match_all` PATTERN_ORDER con un gruppo: `$matches[1]` esiste sempre (lista vuota se nessun match). Il `??` non proteggeva alcun caso reale | `array_values(array_unique($matches[1]))`; tolto anche il `@var list<string>` ridondante | fixed, PHPStan 0 |
| `Xot/.../XotCreateXlsxFile.php` method.notFound | Job XLSX che legge il CSV con lo stesso escape con cui e' scritto e conserva le righe vuote | `configureXlsxWriterAfterOpen()` non esiste in filament/actions v5.6.8 (`rg` sul vendor: solo `configureXlsxWriterBeforeClose`) ne' in alcun commit (`git log --all -S`): era un hook inventato | Chiamata rimossa (gia' fatto); `handle()` ora coincide con `CreateXlsxFile::handle()` v5.6.8 piu' `setEscape`/`includeEmptyRecords`. Corretto il docblock, che citava "5.7.8" invece di 5.6.8 | fixed, PHPStan 0 |

## Verifica

```
cd laravel && APP_ENV=testing php artisan --version        # Laravel Framework 13.19.0
php -l <file toccati>                                      # nessun errore
flock -w 1800 /tmp/phpstan-gate.lock env APP_ENV=testing nice -n 10 ./vendor/bin/phpstan analyse \
  <i 9 file + Rating Schemas + Xot/app/Exports + Seo SocialShareData + AI Sentiment*> \
  --memory-limit=-1 --no-progress --error-format=json > $OUT 2> $OUT.err; echo $? > $OUT.exit
# $OUT.exit = 0, totals {errors: 0, file_errors: 0}
```

Pest non eseguito (isolamento del DB di test non verificato): `StripImageMetadataActionTest`, `GetTaskCommandsActionTest` e `EventTest` non sono stati lanciati.

## Decisioni aperte

- `Seo/app/Datas/` e' non tracciato in git (a HEAD esiste `app/Data/`): `Event::getSocialShareData()` dipende da quella cartella, va committata insieme alla rimozione di `app/Data/`.
- `Job/GetTaskCommandsAction`: il filtro a monte e l'`instanceof` dentro `sortBy` si duplicano. Con `whereInstanceOf(Command::class)` (tipo `static<TKey, Command>`) il closure potrebbe avere `Command` come parametro e restare senza ramo morto. Lasciato all'altra sessione.
- `Xot/tests/FilamentSchemaCoverage.php:169` chiama `$class::getInfolistSchema()` in statico su ogni `*Infolist`: sui metodi di istanza PHP lancia `Error`, il `catch (\Throwable)` lo conta come eseguito e il test passa a vuoto. Va istanziato l'oggetto (owner dei test Xot).
- `StripImageMetadataAction`: il driver GD non scrive metadati per costruzione, quindi `strip: true` sul JPEG e' solo esplicito; se Media passasse a Imagick, per PNG servirebbe `StripMetaModifier` (il `PngEncoder` non ha `strip`).
