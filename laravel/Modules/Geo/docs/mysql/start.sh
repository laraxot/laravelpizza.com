#!/bin/bash

# Crea la directory necessaria
sudo mkdir -p /var/run/mysqld
sudo chown mysql:mysql /var/run/mysqld
sudo chmod 755 /var/run/mysqld

# Ora avvia MySQL Safe
sudo mysqld_safe --user=mysql &

# Controlla i processi
ps aux | grep mysqld

# Controlla la porta
sudo netstat -tlnp | grep :3306