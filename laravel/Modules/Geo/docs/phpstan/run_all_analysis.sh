#!/bin/bash

# Script per eseguire tutti gli script di analisi in sequenza

cd $(dirname $0)

echo "Iniziando l'analisi completa dei moduli..."

# Prima analizziamo la struttura dei moduli
echo "1. Analisi della struttura dei moduli..."
bash analyze_modules_structure.sh

# Poi analizziamo le funzioni specifiche
echo "2. Analisi delle funzioni specifiche..."
bash analyze_specific_functions.sh

# Infine eseguiamo PHPStan su tutti i livelli
echo "3. Analisi PHPStan su tutti i livelli..."
bash run_phpstan_analysis_all_levels.sh

echo "Analisi completa terminata. Tutti i report sono stati generati nella cartella docs/phpstan/" 