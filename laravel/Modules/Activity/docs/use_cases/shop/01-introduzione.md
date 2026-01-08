# Introduzione: Lo Shop Event Sourced Definitivo

## Visione e Filosofia

Costruire uno shop moderno non significa solo gestire prodotti e ordini, ma progettare un sistema che sia:
- **Auditabile**: ogni azione è tracciata, ogni stato è ricostruibile.
- **Estendibile**: ogni dominio (carrello, ordine, pagamento, inventario) è modulare e isolato.
- **Zen**: il codice è semplice, leggibile, ogni modulo fa una cosa sola e bene.
- **Politica della Trasparenza**: nessun dato viene perso, ogni cambiamento è un evento.
- **Religione della Separazione**: scrittura e lettura sono mondi separati (CQRS), la logica di business è nel dominio, la persistenza è un dettaglio.

## Perché Event Sourcing?
- **Storia completa**: puoi rispondere a "perché questo ordine è stato cancellato?".
- **Rollback e replay**: puoi correggere bug senza perdere dati.
- **Nuove proiezioni**: puoi aggiungere report, dashboard, viste senza cambiare la logica di business.

## Perché CQRS?
- **Performance**: letture ottimizzate, scritture atomiche.
- **Scalabilità**: puoi scalare lettura e scrittura separatamente.
- **Chiarezza**: ogni comando è un'intenzione esplicita, ogni query è una domanda chiara.

## Perché DDD?
- **Ubiquitous Language**: il codice parla il linguaggio del business.
- **Bounded Context**: ogni sottodominio (Order, Cart, Product, Payment) è autonomo.
- **Testabilità**: ogni regola è isolata e testabile.

## Obiettivo di questa documentazione
Questa guida non si limita a confrontare due progetti, ma spiega come **progettare da zero** uno shop event sourced, illustrando ogni scelta, pattern, tecnologia, con esempi e motivazioni profonde. Non solo codice, ma anche filosofia, zen, e "religione" architetturale. 
