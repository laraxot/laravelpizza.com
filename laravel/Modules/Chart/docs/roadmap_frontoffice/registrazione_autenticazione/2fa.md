# Autenticazione a Due Fattori

## Descrizione
Implementazione del sistema di autenticazione a due fattori (2FA) per aumentare la sicurezza degli account paziente e odontoiatra.

## Stato Attuale
- **Completamento**: 65%
- **Responsabile**: Team Backend
- **Deadline**: Luglio 2025
- **Priorità**: Media

## Funzionalità in Sviluppo
- Integrazione autenticazione tramite app (Google Authenticator, Authy)
- Generazione codici TOTP (Time-based One-Time Password)
- Invio codice verifica via SMS come alternativa
- Codici di backup per recupero emergenza
- Memorizzazione dispositivi fidati
- Gestione disabilitazione 2FA

## Tecnologie Utilizzate
- Laravel Fortify 2FA
- TOTP RFC 6238
- API SMS
- Crittografia codici backup
- Session management avanzato

## Tabella di Marcia
| Fase | Descrizione | Stato | Completamento |
|------|-------------|-------|---------------|
| 1 | Analisi e progettazione | Completata | 100% |
| 2 | Implementazione backend | In corso | 80% |
| 3 | Interfaccia utente | In corso | 60% |
| 4 | Integrazione SMS | Pianificata | 30% |
| 5 | Test e ottimizzazione | Pianificata | 20% |

## Rischi e Mitigazioni
- **Usabilità**: Design UX semplificato con tutorial
- **Supporto dispositivi**: Implementazione di metodi alternativi
- **Gestione emergenza**: Sistema di codici di recupero
- **Costi SMS**: Ottimizzazione invio con rate limiting

## Prossimi Passi
1. Completamento interfaccia utente
2. Integrazione completa provider SMS
3. Testing su diversi dispositivi
4. Documentazione utente finale

## Documentazione Correlata
- [Login/Logout](./login-logout.md)
- [Verifica Email](./verifica-email.md)
- [Recupero Password](./recupero-password.md)

## Riferimento Principale
→ [Torna a Stato Avanzamento Lavori](../../stato_avanzamento_lavori_2025_06_05.md)
