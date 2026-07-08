#!/bin/bash

# Script per la verifica della connessione MySQL
# Questo script verifica la connessione al database MySQL e le sue configurazioni

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Funzione per il logging
log_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

log_warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Verifica se MySQL è installato
if ! command -v mysql &> /dev/null; then
    log_error "MySQL non è installato"
    exit 1
fi

# Verifica se il servizio MySQL è in esecuzione
if ! systemctl is-active --quiet mysql; then
    log_error "Il servizio MySQL non è in esecuzione"
    exit 1
fi

# Verifica la connessione al database
log_info "Verifica connessione al database..."
if mysql -u root -e "SELECT 1" > /dev/null 2>&1; then
    log_info "Connessione al database riuscita"
else
    log_error "Impossibile connettersi al database"
    exit 1
fi

# Verifica le configurazioni
log_info "Verifica configurazioni MySQL..."
mysql -u root -e "SHOW VARIABLES LIKE 'max_connections'" | grep max_connections
mysql -u root -e "SHOW VARIABLES LIKE 'innodb_buffer_pool_size'" | grep innodb_buffer_pool_size
mysql -u root -e "SHOW VARIABLES LIKE 'query_cache_size'" | grep query_cache_size

# Verifica lo stato del server
log_info "Verifica stato del server..."
mysql -u root -e "SHOW STATUS LIKE 'Threads_connected'"
mysql -u root -e "SHOW STATUS LIKE 'Slow_queries'"
mysql -u root -e "SHOW STATUS LIKE 'Questions'"

# Verifica i database
log_info "Verifica database..."
mysql -u root -e "SHOW DATABASES"

# Verifica i privilegi
log_info "Verifica privilegi..."
mysql -u root -e "SHOW GRANTS FOR CURRENT_USER"

log_info "Verifica completata con successo"
