# Model Context Protocol (MCP) – Guida Pratica e Best Practice

## Cos'è MCP?
Il [Model Context Protocol (MCP)](https://modelcontextprotocol.io/introduction) è uno standard open che permette di estendere le capacità degli agent LLM (come Cursor) collegando strumenti e fonti dati tramite interfacce standardizzate (plugin system). MCP consente di integrare tool custom, database, API, servizi esterni e di orchestrare l’accesso a risorse contestuali in modo sicuro e modulare.

Per approfondimenti: [Documentazione ufficiale Cursor MCP](https://docs.cursor.com/context/model-context-protocol)

---

## Trasporti MCP: stdio vs SSE

| Tipo     | Dove gira         | Gestione         | Accessibilità        | Use-case tipico           |
|----------|-------------------|------------------|----------------------|---------------------------|
| stdio    | Locale            | Cursor automatica| Solo locale          | Sviluppo locale, test     |
| SSE      | Locale/remoto     | Manuale          | Rete (LAN/Internet)  | Team, CI/CD, servizi cloud|

- **stdio**: Cursor lancia direttamente il server MCP come processo locale (es: Node.js, Python). Comunicazione via stdin/stdout. Config semplice.
- **SSE**: MCP server accessibile via endpoint di rete `/sse`. Più flessibile (multi-macchina, cloud), configurazione manuale.

---

## Configurazione MCP Server

### Esempio stdio (Node.js)
```jsonc
// .cursor/mcp.json
{
  "mcpServers": {
    "my-mcp-server": {
      "command": "npx",
      "args": ["-y", "mcp-server"],
      "env": {
        "API_KEY": "valore_tuo_api_key"
      }
    }
  }
}
```
**Motivazione:** Permette a Cursor di avviare automaticamente un server MCP Node.js tramite stdio.

### Esempio SSE
```jsonc
// .cursor/mcp.json
{
  "mcpServers": {
    "my-remote-server": {
      "url": "http://example.com:8000/sse",
      "env": {
        "API_KEY": "valore_tuo_api_key"
      }
    }
  }
}
```

- L’attributo `env` consente di passare variabili d’ambiente sensibili (es. API key) in modo sicuro.

---

## Esempi Pratici MCP

(Segue la sezione con esempi pratici già presenti, migliorata per chiarezza e aggiornamento sintattico dove necessario)

## 1. Configurazione MCP Server (Node.js, stdio)
```jsonc
// .cursor/mcp.json
{
  "mcpServers": {
    "my-mcp-server": {
      "command": "npx",
      "args": ["-y", "mcp-server"],
      "env": {
        "API_KEY": "valore_tuo_api_key"
      }
    }
  }
}
```
**Motivazione:** Permette a Cursor di avviare automaticamente un server MCP Node.js tramite stdio.

---

## 2. MCP Server Python (FastMCP)
```python
from fastmcp import FastMCP

mcp = FastMCP("MyServer")

@mcp.tool()
def somma(a: int, b: int) -> int:
    """Somma due numeri"""
    return a + b

@mcp.resource("data://{id}")
def get_data(id: str) -> str:
    return f"Dati per {id}"

if __name__ == "__main__":
    mcp.run()
```
**Motivazione:** Espone tool e risorse MCP in Python, accessibili da Cursor o altri client MCP.

---

## 3. Chiamata tool MCP da client Python
```python
from mcp import ClientSession, StdioServerParameters
from mcp.client.stdio import stdio_client

server_params = StdioServerParameters(
    command="python",
    args=["my_server.py"]
)

async with stdio_client(server_params) as (read, write):
    async with ClientSession(read, write) as session:
        await session.initialize()
        result = await session.call_tool("somma", arguments={"a": 2, "b": 3})
        print(result)  # Output: 5
```
**Motivazione:** Invoca un tool MCP da un client Python, utile per test e automazione.

---

## 4. Uso MCP in Laravel: Service Provider
```php
// config/mcp.php
return [
    'context_providers' => [
        App\MCP\Providers\TenantContextProvider::class,
        App\MCP\Providers\UserContextProvider::class,
    ],
];
```
**Motivazione:** Definisce i provider di contesto MCP per una gestione centralizzata e modulare in Laravel.

---

## 5. Middleware MCP in Laravel
```php
namespace App\MCP\Middleware;

class MCPContextMiddleware
{
    public function handle($request, $next)
    {
        $context = [
            'tenant_id' => $request->header('X-Tenant-ID'),
            'user_id' => auth()->id(),
            'permissions' => auth()->user()->permissions ?? [],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ];

        $request->merge(['mcp_context' => $context]);
        return $next($request);
    }
}
```
**Motivazione:** Inietta il contesto MCP in ogni richiesta, rendendo disponibili i dati di contesto a tutti i servizi downstream.

---

## 6. Tool MCP custom per automazione (Node.js)
```js
// server.js
const { MCPServer } = require('@anthropic-ai/mcp');

const server = new MCPServer();

server.tool('greet', async ({ name }) => {
  return { message: `Ciao, ${name}!` };
});

server.listen();
```
**Motivazione:** Espone un tool custom "greet" richiamabile da Cursor o altri client MCP.

---

## 7. Automazione test browser (UI) tramite MCP
```php
// Esempio di chiamata tool MCP per screenshot (Laravel)
$screenshotPath = $this->mcpService->puppeteer()->captureScreenshot(
    url: 'https://example.com',
    options: ['fullPage' => true]
);
```
**Motivazione:** Automatizza la generazione di screenshot tramite tool MCP, utile per test end-to-end e documentazione UI.

---

## Risorse e approfondimenti
- [Documentazione ufficiale Cursor MCP](https://docs.cursor.com/context/model-context-protocol)
- [model_context_protocol.md](../../../docs/model_context_protocol.md)
- [mcp_implementation_guide.md](../../../docs/mcp_implementation_guide.md)
- [mcp_implementation_correction.md](../../../docs/mcp_implementation_correction.md)
- [mcp_errors_and_lessons.md](../../../docs/mcp_errors_and_lessons.md)
- [Indice e collegamenti root](../../../docs/links.md) 