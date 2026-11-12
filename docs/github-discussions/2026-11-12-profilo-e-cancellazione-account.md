Categoria: Announcements (o General) · Titolo: **Nuovo: modifica del profilo e cancellazione dell'account dal sito (+ 4 bug trovati lungo la strada)**

Da `/it/profile/edit` ogni partecipante può cambiare nome, biografia, foto, lingua e password, ed eliminare il proprio account (GDPR art. 17). Documentazione: `laravel/Themes/Meetup/docs/profile-edit-page.md`; manuale d'uso §2.6.

Bug trovati e corretti lavorando su questo:
1. **Password di 32 o più caratteri salvate in chiaro** (`BaseUserMutators::setPasswordAttribute` decideva con la lunghezza). Chi ha un database esistente: `SELECT id FROM users WHERE password NOT LIKE '$2y$%' AND password NOT LIKE '$argon%';` e reset per quegli utenti.
2. La tabella `profiles` del modulo Meetup non aveva `bio`, `locale`, `address`: la biografia del profilo pubblico non poteva mai comparire.
3. La tabella `consents` del modulo Gdpr non aveva `revoked_at`, `revoked_ip_address`, `metadata`: "elimina account" andava in errore 500.
4. Le pagine Folio di login e registrazione cambiavano la lingua dell'app quando si generava `route('login')`: le email inviate dalla coda o da CLI potevano uscire in italiano anche per chi aveva scelto un'altra lingua.

Più una lezione sui test: il TestCase del modulo Meetup usava `main_module = User`, diverso dalla produzione, e per questo non vedeva il bug 2.

**Domande**
- I punti 1, 3 e 4 riguardano moduli condivisi (User, Gdpr, Cms): li portiamo anche negli altri progetti?
- Serve anche il cambio email dal sito (con nuova verifica)? Oggi passa dalla pagina Contatti.
