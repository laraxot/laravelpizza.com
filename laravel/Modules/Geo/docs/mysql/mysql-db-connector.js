#!/usr/bin/env node

// MYSQL_DB_CONNECTOR_PID_MARKER

/**
 * Script per creare un server MCP personalizzato per MySQL
 * Questo script legge le variabili di connessione dal file .env di Laravel
 * e fornisce un'interfaccia MCP per interagire con il database MySQL
 * 
 * Autore: Cascade AI Assistant
 * Data: 2025-05-13
 */

const fs = require('fs');
const path = require('path');
const mysql = require('mysql2/promise');
const dotenv = require('dotenv');

// Percorsi
const PROJECT_DIR = '/var/www/html/_bases/base_<nome progetto>_fila5_mono';
const LARAVEL_DIR = path.join(PROJECT_DIR, 'laravel');
const ENV_FILE = path.join(LARAVEL_DIR, '.env');

// Carica le variabili d'ambiente dal file .env
let dbConfig = {
  host: process.env.MYSQL_HOST || 'localhost',
  port: parseInt(process.env.MYSQL_PORT || '3306'),
  user: process.env.MYSQL_USER || 'root',
  password: process.env.MYSQL_PASSWORD || '',
  database: process.env.MYSQL_DATABASE || 'laravel'
};

// Leggi le variabili dal file .env se esiste
if (fs.existsSync(ENV_FILE)) {
  const envConfig = dotenv.parse(fs.readFileSync(ENV_FILE));
  
  dbConfig = {
    host: envConfig.DB_HOST || dbConfig.host,
    port: parseInt(envConfig.DB_PORT || dbConfig.port.toString()),
    user: envConfig.DB_USERNAME || dbConfig.user,
    password: envConfig.DB_PASSWORD || dbConfig.password,
    database: envConfig.DB_DATABASE || dbConfig.database
  };
}

console.log('🔍 Informazioni di connessione MySQL dal file .env:');
console.log(`  Host: ${dbConfig.host}`);
console.log(`  Port: ${dbConfig.port}`);
console.log(`  Database: ${dbConfig.database}`);
console.log(`  User: ${dbConfig.user}`);
console.log(`  Password: [nascosta]`);

// Crea una connessione al database
async function createConnection() {
  try {
    const connection = await mysql.createConnection(dbConfig);
    console.log('✅ Connessione al database MySQL stabilita');
    return connection;
  } catch (error) {
    console.error('❌ Errore nella connessione al database MySQL:', error.message);
    throw error;
  }
}

// Funzione per eseguire una query SQL
async function executeQuery(sql, params = []) {
  let connection;
  try {
    connection = await createConnection();
    const [results] = await connection.execute(sql, params);
    return results;
  } catch (error) {
    console.error('❌ Errore nell\'esecuzione della query:', error.message);
    throw error;
  } finally {
    if (connection) {
      await connection.end();
    }
  }
}

// Funzione per ottenere la struttura di una tabella
async function getTableStructure(tableName) {
  return executeQuery('DESCRIBE ??', [tableName]);
}

// Funzione per ottenere l'elenco delle tabelle
async function getTables() {
  const results = await executeQuery('SHOW TABLES');
  return results.map(row => Object.values(row)[0]);
}

// Implementazione del server MCP
const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
  terminal: false
});

console.log('🚀 Server MCP MySQL personalizzato avviato');
console.log('📝 In attesa di richieste...');

rl.on('line', async (line) => {
  try {
    const request = JSON.parse(line);
    
    // Gestisci la richiesta in base al metodo
    if (request.method === 'executeQuery') {
      const { sql, params } = request.params;
      const results = await executeQuery(sql, params || []);
      
      console.log(`✅ Query eseguita: ${sql}`);
      
      // Invia la risposta
      const response = {
        id: request.id,
        result: results
      };
      
      console.log(JSON.stringify(response));
    } 
    else if (request.method === 'getTableStructure') {
      const { tableName } = request.params;
      const structure = await getTableStructure(tableName);
      
      console.log(`✅ Struttura della tabella ottenuta: ${tableName}`);
      
      // Invia la risposta
      const response = {
        id: request.id,
        result: structure
      };
      
      console.log(JSON.stringify(response));
    }
    else if (request.method === 'getTables') {
      const tables = await getTables();
      
      console.log(`✅ Elenco delle tabelle ottenuto: ${tables.length} tabelle`);
      
      // Invia la risposta
      const response = {
        id: request.id,
        result: tables
      };
      
      console.log(JSON.stringify(response));
    }
    else {
      // Metodo non supportato
      const response = {
        id: request.id,
        error: {
          code: 'METHOD_NOT_SUPPORTED',
          message: `Il metodo ${request.method} non è supportato`
        }
      };
      
      console.log(JSON.stringify(response));
    }
  } catch (error) {
    // Errore nella gestione della richiesta
    const response = {
      id: request.id,
      error: {
        code: 'REQUEST_ERROR',
        message: error.message
      }
    };
    
    console.log(JSON.stringify(response));
  }
});

// Gestisci la chiusura del server
process.on('SIGINT', () => {
  console.log('👋 Server MCP MySQL personalizzato arrestato');
  process.exit(0);
});

process.on('SIGTERM', () => {
  console.log('👋 Server MCP MySQL personalizzato arrestato');
  process.exit(0);
});

// Segnala che il server è pronto
console.log('✅ Server MCP MySQL personalizzato pronto');
