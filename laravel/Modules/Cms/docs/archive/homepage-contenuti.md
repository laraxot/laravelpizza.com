# Contenuti Homepage il progetto

## Testo principale della homepage

Il testo seguente deve essere mostrato nella homepage del portale il progetto:

```
Benvenuta su <slogan>,

il portale che vuole garantire alle pazienti vulnerabili in
stato di gravidanza la possibilità di accedere a servizi
odontoiatrici di prevenzione a titolo completamente
gratuito.

Se sei una donna in stato di gravidanza residente in
Italia o in attesa di permesso di soggiorno, con un
valore ISEE pari a euro 20,000 o inferiore, e vuoi
partecipare a questa iniziativa clicca il pulsante qui
sotto:
```

## Elementi visivi associati

La homepage deve includere:

1. **Logo il progetto** nell'intestazione
2. **Selettore lingua** (IT/EN) nell'intestazione
3. **Pulsante "INIZIA ORA"** sotto il testo principale
4. **Loghi dei partner** nel piè di pagina

## Riferimento visivo

L'implementazione deve seguire il design mostrato nell'immagine di riferimento:
![Riferimento homepage](/var/www/html/_bases/<directory progetto>/docs/images/2.png)

## Note implementative

- Il testo deve mantenere la formattazione e gli a capo come specificato
- La versione mobile e desktop devono contenere lo stesso testo
- Il testo deve essere localizzato in italiano e inglese
- Il pulsante CTA deve portare alla pagina di registrazione/verifica idoneità

## Aggiornamenti

Se il contenuto della homepage deve essere modificato, è necessario:

1. Aggiornare questo documento
2. Aggiornare il file JSON corrispondente in `/var/www/html/_bases/<directory progetto>/laravel/config/local/<directory progetto>/database/content/pages/1.json`
3. Verificare che le modifiche siano correttamente visualizzate in tutte le versioni (mobile, tablet, desktop)
