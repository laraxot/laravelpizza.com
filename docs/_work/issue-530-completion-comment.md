Implementazione completata sulla pagina `http://127.0.0.1:8000/it/events/id-id-quidem-quae-eveniet-Jy1p`.

## Miglioramenti applicati
1. **Disponibilita' posti coerente**
   - Corretto il testo finale della card RSVP: ora e' dinamico (`sold_out` / `spots_filling_fast` / `spots_available_regular`) in base a `availableSpots`.
2. **Sezione partecipanti con empty state chiaro**
   - Con `attendees_count = 0` mostra stato esplicito localizzato: `Nessun partecipante confermato per ora` + prompt.
3. **Microcopy social share localizzata**
   - Nel componente SEO sostituiti hardcoded inglesi (`Copy to clipboard`, `URL Copied!`) con chiavi tradotte (`Copia link`, `Link copiato`).
4. **Test Pest rafforzato**
   - Aggiornato `Modules/Meetup/tests/Feature/EventDetailPageTest.php` con assert su:
     - organizer e dettagli
     - empty state partecipanti
     - messaggio disponibilita' coerente
     - assenza regressioni (`Conferma prenotazione`, `URL Copied!`).

## Verifiche eseguite
- Runtime URL check: `200 OK`
- Verifica HTML finale pagina target:
  - presente `Nessun partecipante confermato per ora`
  - presente `Ci sono ancora molti posti disponibili`
  - presente `Link copiato`
  - non presente `Posti in esaurimento!` su questo evento
- Pest: `Modules/Meetup/tests/Feature/EventDetailPageTest.php` ✅ (`1 passed, 13 assertions`)
- PHPStan:
  - `Modules/Seo` ✅ no errors
  - `Modules/Meetup` ❌ 41 errori **preesistenti** (non introdotti da questo fix)
- PHPInsights ✅ (con warning stile preesistenti su storage/views)
- PHPMD: non disponibile in vendor (`./vendor/bin/phpmd` assente)

Documentazione aggiornata:
- `Themes/Meetup/docs/troubleshooting/event-detail-ux-gaps-id-id-quidem.md`
- `Modules/Seo/docs/social-share-copy-localization.md`
