# Bad Practices – Activity

## ❌ Log delle attività senza livello di severità
Crea noise utile solo se si usa un filtro `level`.

## ❌ Mancanza di indicizzazione per query frequenti
Aggiungi indici su `user_id`, `log_name`, `created_at`.

## ❌ Dati duplicati nei "properties" JSON
Normalizza campi ricorrenti in tabelle distinte per query efficienti.
