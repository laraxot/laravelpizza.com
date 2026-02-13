# User vs Profile: Architectural Deep-Dive

## 🎯 Il Concetto: Account vs Informazione

In un'architettura **Senior** e **Robust**, la distinzione tra `User` e `Profile` non è solo una scelta tecnica, ma una decisione di business logic fondamentale.

### 1. User (L'Identità/Account)
Il modello `User` rappresenta l'**identità digitale**. È l'entità che "bussa alla porta" del sistema.
- **Responsabilità**: Autenticazione (Login), Autorizzazione (Ruoli/Permessi), Stato dell'account (Attivo/Bannato).
- **Dati Tipici**: Email, Password, UUID, Lang (lingua di sistema), Two-Factor settings.
- **Frequenza di Accesso**: Altissima (caricato a ogni richiesta/sessione).

### 2. Profile (L'Individuo/Entità)
Il modello `Profile` rappresenta l'**essere umano** o l'**entità business** dietro l'account.
- **Responsabilità**: Rappresentazione pubblica/privata, preferenze personali, dati anagrafici.
- **Dati Tipici**: Bio, Avatar, Indirizzo, Telefono, Social Links, Skill, Interessi.
- **Frequenza di Accesso**: Media (solo quando serve visualizzare o modificare i dettagli dell'utente).

---

## 📊 Analisi Statistica e Casi d'Uso

| Tipo di Progetto | Architettura Suggerita | Percentuale di Utilizzo | Perché? |
| :--- | :--- | :--- | :--- |
| **Simple Blog / MVP** | Single Table (`users`) | ~80% | Velocità di esecuzione, pochi campi. |
| **Enterprise / SaaS** | Separate (`User` + `Profile`) | ~95% | Scalabilità, gestione billing vs auth. |
| **Marketplace** | Separate (`User` + Multi-Profiles) | ~100% | Un utente può essere "Venditore" e "Compratore" con dati diversi. |
| **Social Network** | Hybrid / High-Performance | ~90% | Caricare migliaia di account richiede una tabella `users` magrissima. |

---

## 🧠 Riflessioni Senior: "Perché separarli?"

### A. Performance (Lean Core)
Laravel carica l'utente autenticato in ogni singola richiesta. Se la tabella `users` ha 50 colonne (bio, indirizzo, url vari), sprechi memoria e DB I/O costantemente. Separando i profili, la query di auth è istantanea.

### B. Privacy & GDPR (Data Isolation)
È molto più semplice implementare il "Diritto all'Oblio". Puoi cancellare l'intero `Profile` (dati personali) mantenendo il record `User` (anonimizzato) per non rompere l'integrità referenziale dei log o degli ordini passati.

### C. Pattern Laraxot: Spatie Schemaless Attributes
In Laraxot, il `Profile` usa spesso `Spatie\SchemalessAttributes`. Questo permette di aggiungere campi dinamici (es. `social_links`, `preferences`) senza dover fare una migrazione per ogni minima modifica, mantenendo il database pulito.

---

## 🏗️ Implementazione Laraxot (Case Study)

Nel nostro progetto:
1. **`User`**: Estende `BaseUser`, implementa `UserContract`. Gestisce la lingua (`lang`) e la connessione al database `user`.
2. **`Profile/BaseProfile`**: Gestisce la logica di `avatar` (con Gravatar fallback), `full_name` e attributi extra.
3. **Relazione**: Il `User` ha un metodo `profile()` che risolve dinamicamente la classe corretta tramite `XotData::make()->getProfileClass()`.

> [!IMPORTANT]
> **Regola d'Oro**: Se un dato serve per identificare o far entrare l'utente (Auth), va in `User`. Se serve per descriverlo o contattarlo (Info), va in `Profile`.

---

## 🚀 Casi di Studio Reali

### Caso 1: Il Marketplace Multi-Ruolo
Un utente si registra. È un **User**. Vuole vendere pizza? Crea un **Profile Professionista**. Vuole solo comprarla? Usa un **Profile Cliente**. Entrambi i profili sono legati allo stesso **User** via UUID.

### Caso 2: Sistema Multilingua "Intelligente" (Richiesta Utente)
L'utente cambia lingua in frontend. Se salviamo `lang` solo in sessione, al login successivo la perde. 
- **User Solution**: Salviamo `lang` nella tabella `users`. Essendo il modello di "identità", il sistema legge la lingua preferita non appena l'account viene identificato, garantendo un'esperienza senior e persistente.
