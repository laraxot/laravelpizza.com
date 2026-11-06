---
type: legal-audit-story
title: Disclaimer verification across all channels
status: todo
links:
  github_issue: 0
  module: Cms
  related_stories:
    - linee-guida-operative.story.md
    - cookiebar-visual-audit.story.md
created: 2026-10-14T13:37:00Z
updated: 2026-10-14T13:37:00Z
---

# Verifica Disclaimer

## Obiettivo

Verificare che tutti i disclaimer legali siano presenti e corretti in tutti i canali del ristorante digitale: pagine web, email di notifica, PDF scontrini/fatture, e stampa ticket.

## Canali da Verificare

### 1. Email (Modulo Notify)

File: `laravel/Modules/Notify/resources/views/mail/promotion.blade.php`

- Linea 54-58: `{{ $disclaimer }}` è inserito se definito, ma **nessun valore di default** è fornito
- Linea 60-64: i termini sono presenti (`notify::mail.promotion.terms`)
- **Manca**: disclaimer standard per comunicazioni commerciali (art. 7 D.Lgs. 196/2009 + art. 13 GDPR)
- **Manca**: link a privacy policy e a informativa sui cookie

### 2. Pagine Web (Modulo Cms)

Il blocco `info` (`Modules/Cms/resources/views/components/blocks/info.blade.php`) documenta che può contenere "Copyright e disclaimer" nel footer.
- Verificare che tutti i layout FO includano il blocco info nel footer
- Verificare che il copyright annui sia dinamico (non hardcoded)
- Verificare la presenza di link a: Informativa Privacy, Cookie Policy, Termini & Condizioni, Dati Aziendali (ai sensi D.Lgs. 231/2007)

### 3. PDF Scontrini/Fatture (Modulo Restaurant)

File: `laravel/Modules/Restaurant/app/Actions/Haccp/GenerateHaccpSheetPdfAction.php` (esempio di pattern PDF)
- **Manca**: dati fiscali obbligatori (Partita IVA, Codice Fiscale, SDI, indirizzo) nel footer di ogni documento
- **Missa**: orario di apertura/chiusura e numero di registrazione della cassa
- Il `CompanyConfig` model ha i campi necessari (`tax_number`, `tax_id`, `sdi_code`, `rt_registration_number`, `address`, `phone`), verificare che vengano tutti inclusi nel PDF

### 4. Stampa Ticket (ESC/POS)

File: `laravel/Modules/Restaurant/app/Support/EscPos.php`
- Verificare che ogni ticket stampato includa:
  - Intestazione con dati aziendali (ragione sociale, indirizzo, P.IVA)
  - Footer con orario di stampa e numero di serie della cassa

## Discrepancies da Sistemare

1. **Notify/promotion.blade.php**: aggiungere disclaimer di default se non fornito
2. **Notify**: aggiungere link privacy policy e cookie policy nel footer di tutte le email
3. **Restaurant/BuildBillTicketAction.php**: verificare inclusione dati fiscali CompanyConfig nel ticket stampato
4. **CMS footer**: verificare che il blocco info sia presente in tutti i layout FO

## Acceptance Criteria

- [ ] Tutte le email di notifica includono disclaimer legale + link privacy policy
- [ ] Tutti i PDF/scontrini includono dati fiscali completi del locale
- [ ] Tutte le pagine web includono copyright + link a documenti legali nel footer
- [ ] I ticket stampati includono dati aziendali nel footer
- [ ] I test Pest verificano la presenza di disclaimer nei template email

## Prossimi Passi

1. Leggere `Modules/Notify/resources/views/mail/promotion.blade.php` (fatto — vedi sopra)
2. Leggere `Modules/Restaurant/app/Actions/Print/BuildBillTicketAction.php` per verificare i dati fiscali
3. Leggere i layout FO per verificare il footer
4. Aggiungere test Pest per il disclaimer

## Related Links

- `Modules/Cms/docs/blocks/info.md` — documentazione blocco info
- `Modules/Restaurant/app/Models/CompanyConfig.php` — dati fiscali disponibili
- Convention: `bashscripts/docs/prompts/55-md-conventions.md`
