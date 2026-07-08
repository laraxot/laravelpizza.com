#!/bin/sh

# Funzione per copiare e rinominare le cartelle
move_config() {
  local dir_name="$1"  # Il nome della cartella (es. "Config")
  local dir_name_lower=$(echo "$dir_name" | tr '[:upper:]' '[:lower:]')  # Trasforma il nome in minuscolo

  # Verifica che la cartella esista
  if [ -d "$dir_name" ] && [ -d "$dir_name_lower" ]; then
    # Copia tutto il contenuto di dir_name_lower nella cartella passata come parametro
    cp -r "$dir_name_lower"/* "$dir_name"/
    
    # Rinomina dir_name_lower in dir_name e la cartella passata in dir_name_lower
    mv "$dir_name_lower" "$dir_name_lower"_old
    mv "$dir_name" "$dir_name_lower"
    echo "Operazione completata per $dir_name."
  else
    echo "Errore: Le cartelle $dir_name o $dir_name_lower non esistono."
  fi

  # Aggiungi il controllo per rinominare la cartella _old in caso di conflitto
  if [ -d "$dir_name_lower"_old ] && [ ! -d "$dir_name_lower" ]; then
    echo "Rinominando $dir_name_lower_old in $dir_name_lower..."
    mv "$dir_name_lower"_old "$dir_name_lower"
  fi
}




move_config "App"
move_config "Config"
move_config "Database"
move_config "Resources"
move_config "Routes"
move_config "Tests"
