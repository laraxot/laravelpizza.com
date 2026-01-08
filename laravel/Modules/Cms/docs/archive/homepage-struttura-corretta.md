# Struttura e Contenuto Corretto dell'Homepage di il progetto

## Introduzione

Questo documento descrive in dettaglio la struttura e il contenuto corretto che **deve** essere mostrato nell'homepage del portale il progetto, basato sulle specifiche ufficiali del progetto contenute nel file `/var/www/html/_bases/<directory progetto>/docs/images/2.md`.

## Contenuto Testuale Ufficiale

### Titolo Principale
"Benvenuta su <slogan>,"

### Testo Principale
Il testo principale da mostrare è:

"il portale che vuole garantire alle pazienti vulnerabili in stato di gravidanza la possibilità di accedere a servizi odontoiatrici di prevenzione a titolo completamente gratuito."

### Testo Secondario (Requisiti)
"Se sei una donna in stato di gravidanza residente in Italia o in attesa di permesso di soggiorno, con un valore ISEE pari a euro 20,000 o inferiore, e vuoi partecipare a questa iniziativa clicca il pulsante qui sotto:"

### Call-to-Action
Il pulsante deve contenere il testo: "INIZIA ORA"

## Elementi Visivi Richiesti

1. **Intestazione**:
   - Logo "<slogan>" (con la "O" stilizzata) 
   - Selettore lingua (IT/EN)

2. **Sezione Centrale**:
   - Sfondo blu navy
   - Testo in bianco per massimo contrasto
   - Pulsante CTA prominente con bordi arrotondati

3. **Piè di Pagina**:
   - Loghi dei partner del progetto (COI, INMP/NIHMP, Fondazione ANDI)

## Layout Complessivo

Il layout dell'homepage deve essere strutturato in modo chiaro e accessibile:

1. **Versione Mobile**:
   - Organizzazione verticale con elementi impilati
   - Intestazione compatta
   - Testo centrato per facilitare la lettura su schermi piccoli
   - Pulsante CTA grande e facilmente toccabile

2. **Versione Desktop**:
   - Layout più orizzontale che sfrutta lo spazio aggiuntivo
   - Sezione informativa più estesa a sinistra
   - Possibilità di mostrare più contenuti senza scorrimento
   - Loghi dei partner più evidenti nel piè di pagina

## Implementazione nel File JSON

Il contenuto sopra descritto deve essere correttamente implementato nel file `/var/www/html/_bases/<directory progetto>/laravel/config/local/<directory progetto>/database/content/pages/1.json` attraverso i blocchi di tipo "hero" e "paragraph", mantenendo la fedeltà assoluta al testo specificato.

## Verifica dell'Implementazione

Per verificare che l'implementazione sia corretta:

1. Confrontare il contenuto del file JSON con il testo specificato in questo documento
2. Visualizzare l'homepage sia in versione mobile che desktop
3. Confermare che tutti gli elementi visivi richiesti siano presenti
4. Verificare che i loghi dei partner siano correttamente visualizzati

## Importanza dell'Accuratezza

È fondamentale che il contenuto mostrato sia esattamente quello specificato nelle linee guida ufficiali del progetto. Eventuali discrepanze potrebbero:

1. Creare confusione nelle utenti
2. Alterare i requisiti di partecipazione
3. Compromettere l'efficacia comunicativa del portale
4. Non rispettare gli accordi con i partner del progetto

Questo documento serve come riferimento definitivo per il contenuto dell'homepage e deve essere consultato prima di qualsiasi modifica all'interfaccia utente del portale il progetto. 
