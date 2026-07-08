#!/bin/bash

echo "MySQL Database Diagnostic Tool"
echo "=============================="

# Check MySQL version
echo "Checking MySQL version..."
mysql --version

# Check MySQL service status
echo -e "\nChecking MySQL service status..."
systemctl status mysql.service

# Check available storage engines
echo -e "\nChecking available storage engines..."
mysql -e "SHOW ENGINES;"

# Check InnoDB status
echo -e "\nChecking InnoDB status..."
mysql -e "SHOW VARIABLES LIKE 'innodb%';"

# Check table status
echo -e "\nChecking teams table status..."
mysql -e "SHOW TABLE STATUS WHERE Name = 'teams';"

# Check MySQL error log
echo -e "\nChecking MySQL error log (last 10 lines)..."
tail -n 10 /var/log/mysql/error.log

# Check MySQL configuration files
echo -e "\nLocating MySQL configuration files..."
mysql --help --verbose | grep "Default options" -A 1

# Memory usage
echo -e "\nChecking MySQL memory usage..."
ps aux | grep mysql | grep -v grep

echo -e "\nDiagnostic complete. Check results above for any issues."
