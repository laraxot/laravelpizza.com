# No Filament Labels Rule

**REGOLA PERMANENTE**: Nessun utilizzo di `->label()`, `->placeholder()`, o `->helperText()` nei widget Filament.

### Come funziona
- Le traduzioni devono essere gestite tramite `LangServiceProvider` con chiavi a 5 elementi structure
- Esempio di chiave corretta: `user::socialite.providers.google.client_secret`
- Ogni chiave deve contenere:
  1. Modulo (`user`)<br>
  2. Composizione (`socialite.providers.google.client_secret`)<br>
  3. Azione (`login`/`register`/`profile`)
  4. Tipologia (`client_id`/`client_secret`/`scopes`)
  5. Lingua (`it`/`en`/`es`)

### Perché
- Evita duplicazione di software transazioni
- Permette reapplicazione automatica degli aggiornamenti traduzioni
- Facilita gestione centralizzata delle stringhe

### Applicazione
- Tutte le risorse Filament nel modulo User devono seguire questa regola
- File di traduzione devono contenere esattamente 5 elementi per ogni chiave

### Verifica
```bash
# Cerca violazioni nel modulo User
grep -r '->label\(' laravel/Modules/User
# Dovrebbe restituire 0 risultati
```