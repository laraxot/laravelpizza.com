#!/usr/bin/env node

/**
 * MCP Server for Laravel Artisan
 * This server exposes a tool to run Artisan commands.
 */

const { Server } = require("@modelcontextprotocol/sdk/server/index.js");
const { StdioServerTransport } = require("@modelcontextprotocol/sdk/server/stdio.js");
const {
  CallToolRequestSchema,
  ListToolsRequestSchema,
} = require("@modelcontextprotocol/sdk/types.js");
const { exec } = require("child_process");
const path = require("path");

const LARAVEL_PATH = process.env.LARAVEL_PATH || ".";

const server = new Server(
  {
    name: "laravel-artisan-server",
    version: "1.0.0",
  },
  {
    capabilities: {
      tools: {},
    },
  }
);

server.setRequestHandler(ListToolsRequestSchema, async () => {
  return {
    tools: [
      {
        name: "artisan_command",
        description: "Run a Laravel Artisan command",
        inputSchema: {
          type: "object",
          properties: {
            command: {
              type: "string",
              description: "The artisan command to run (e.g. 'migrate:status', 'route:list')",
            },
            arguments: {
              type: "array",
              items: {
                type: "string",
              },
              description: "Optional arguments and flags for the command",
            },
          },
          required: ["command"],
        },
      },
    ],
  };
});

server.setRequestHandler(CallToolRequestSchema, async (request) => {
  if (request.params.name === "artisan_command") {
    const commandName = request.params.arguments.command;
    const args = request.params.arguments.arguments || [];
    
    // Validate command to prevent arbitrary shell execution if possible, 
    // but strictly for artisan commands.
    // Basic sanitization: ensure it starts with a letter and contains safe chars.
    if (!/^[a-zA-Z0-9:\-_]+$/.test(commandName)) {
       throw new Error("Invalid command name.");
    }

    const commandStr = `php artisan ${commandName} ${args.join(" ")}`;
    
    return new Promise((resolve, reject) => {
      exec(commandStr, { cwd: LARAVEL_PATH }, (error, stdout, stderr) => {
        if (error) {
          resolve({
            content: [
              {
                type: "text",
                text: `Error executing command: ${error.message}\nStderr: ${stderr}`,
              },
            ],
            isError: true,
          });
          return;
        }
        
        resolve({
          content: [
            {
              type: "text",
              text: stdout,
            },
          ],
        });
      });
    });
  }

  throw new Error("Tool not found");
});

const transport = new StdioServerTransport();
server.connect(transport).catch((error) => {
  console.error("Server error:", error);
  process.exit(1);
});
