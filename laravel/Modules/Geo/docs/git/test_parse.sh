#!/bin/bash

# Includi lo script di parsing
source ./bashscripts/lib/parse_gitmodules_ini.sh

# Chiama la funzione
parse_gitmodules gitmodules.ini

echo 'go';
total=${submodules_array["total"]}
for ((i=0; i<total; i++)); do
    echo "---------"
    echo "Submodule $i:"
    echo "  Path: ${submodules_array["path_${i}"]}"
    echo "  URL: ${submodules_array["url_${i}"]}"
done