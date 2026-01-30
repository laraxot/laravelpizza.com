# Sistema di Autenticazione Base

## Panoramica
Implementazione del sistema di autenticazione per l'accesso sicuro alla piattaforma <nome progetto>.

## Componenti Principali

### 1. Registrazione Utenti
- Form di registrazione con validazione lato client e server
- Verifica email obbligatoria
- Controllo requisiti password
- Accettazione termini e condizioni

### 2. Login/Logout
- Autenticazione sicura con email e password
- Gestione sessioni
- Protezione da attacchi brute force
- Logout sicuro

### 3. Recupero Password
- Richiesta reimpostazione password
- Link di reset con scadenza
- Conferma reimpostazione
- Notifica email di conferma

### 4. Verifica Email
- Invio email di verifica
- Validazione token
- Richiesta nuova email di verifica
- Gestione scadenza link

## Tecnologie Utilizzate
- Laravel Sanctum per l'autenticazione API
- JWT per i token di accesso
- Hashing password con bcrypt
- Protezione CSRF integrata

## Sicurezza
- Password con requisiti minimi di complessità
- Rate limiting per i tentativi di accesso
- Protezione XSS e SQL injection
- Log di sicurezza

## Stato Attuale
- [x] Registrazione base (completato)
- [x] Login/Logout (completato)
- [x] Recupero password (completato)
- [x] Verifica email (completato)
- [ ] Autenticazione 2FA (in corso)

## Collegamenti Utili
- [Registrazione Pazienti](./registrazione_pazienti.md)
- [Recupero Password](./recupero_password.md)
- [Verifica Email](./verifica_email.md)
- [2FA](./autenticazione_2fa.md)

---
[⬅️ Torna alla panoramica](../stato_avanzamento_lavori_2025_06_05.md)
