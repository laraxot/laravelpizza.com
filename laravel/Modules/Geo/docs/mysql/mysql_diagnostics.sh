#!/bin/bash

echo "=== MYSQL DIAGNOSTIC SCRIPT ==="
echo "Data: $(date)"
echo ""

echo "1. Controllo se MySQL è installato..."
if command -v mysql &> /dev/null; then
    echo "✓ MySQL client trovato: $(mysql --version)"
else
    echo "✗ MySQL client non trovato"
fi

if command -v mysqld &> /dev/null; then
    echo "✓ MySQL server trovato: $(mysqld --version)"
else
    echo "✗ MySQL server non trovato"
fi
echo ""

echo "2. Stato attuale del servizio MySQL..."
sudo service mysql status
echo ""

echo "3. Processi MySQL attivi..."
ps aux | grep mysql | grep -v grep
echo ""

echo "4. Porte MySQL in ascolto..."
sudo netstat -tlnp | grep :3306
echo ""

echo "5. Controllo socket MySQL..."
if [ -e /var/run/mysqld/mysqld.sock ]; then
    echo "✓ Socket trovato: /var/run/mysqld/mysqld.sock"
    ls -la /var/run/mysqld/mysqld.sock
else
    echo "✗ Socket NON trovato: /var/run/mysqld/mysqld.sock"
fi
echo ""

echo "6. Directory /var/run/mysqld..."
if [ -d /var/run/mysqld ]; then
    echo "✓ Directory exists:"
    ls -la /var/run/mysqld/
else
    echo "✗ Directory /var/run/mysqld NON esiste"
fi
echo ""

echo "7. Controllo permessi /var/lib/mysql..."
if [ -d /var/lib/mysql ]; then
    echo "✓ Directory /var/lib/mysql exists:"
    ls -la /var/lib/mysql/ | head -5
    echo "Owner: $(stat -c '%U:%G' /var/lib/mysql)"
else
    echo "✗ Directory /var/lib/mysql NON esiste"
fi
echo ""

echo "8. Tentativo di avvio MySQL..."
sudo service mysql start
echo ""

echo "9. Stato dopo tentativo di avvio..."
sudo service mysql status
echo ""

echo "10. Log errori MySQL (ultime 10 righe)..."
if [ -f /var/log/mysql/error.log ]; then
    echo "Da /var/log/mysql/error.log:"
    sudo tail -10 /var/log/mysql/error.log
else
    echo "File di log /var/log/mysql/error.log non trovato"
fi
echo ""

echo "11. Test connessione MySQL..."
if mysql -u root -e "SELECT 1;" 2>/dev/null; then
    echo "✓ Connessione MySQL riuscita senza password"
elif mysql -u root -p -e "SELECT 1;" <<< "" 2>/dev/null; then
    echo "✓ Connessione MySQL riuscita con password vuota"
else
    echo "✗ Connessione MySQL fallita - serve password o altri problemi"
fi
echo ""

echo "12. Verifica Webmin MySQL module..."
if [ -f /etc/webmin/mysql/config ]; then
    echo "Configurazione Webmin MySQL:"
    cat /etc/webmin/mysql/config | head -10
else
    echo "Configurazione Webmin MySQL non trovata"
fi
echo ""

echo "=== FINE DIAGNOSTICA ==="