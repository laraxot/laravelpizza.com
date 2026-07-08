#!/bin/bash

# Metodo 1: Shutdown pulito (preferito)
sudo mysqladmin shutdown -u root -p

# Metodo 2: Se non hai password o sei in recovery mode
sudo mysqladmin shutdown -u root

# Metodo 3: Kill del processo (se i metodi sopra non funzionano)
sudo pkill -f mysqld

# Metodo 4: Kill più aggressivo (solo se necessario)
sudo pkill -9 -f mysqld

# Controlla che non ci siano più processi MySQL
ps aux | grep mysqld

# Dovrebbe non restituire niente (o solo il comando grep stesso)