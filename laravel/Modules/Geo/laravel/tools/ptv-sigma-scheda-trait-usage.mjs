/**
 * Scan esplicito: quali metodi di SchedaTrait compaiono nei consumer PHP.
 * Non rileva accessor Eloquent ($model->gg_in_sede).
 *
 * Uso: cd laravel && node tools/ptv-sigma-scheda-trait-usage.mjs
 */
import fs from 'fs';
import path from 'path';

const trait = fs.readFileSync('Modules/Sigma/app/Models/Traits/SchedaTrait.php', 'utf8');
const methods = [...trait.matchAll(/function\s+(\w+)\s*\(/g)].map((m) => m[1]);

const consumers = ['Modules/Ptv', 'Modules/Progressioni', 'Modules/Performance'];
const used = {};

function walk(dir, fn) {
  for (const e of fs.readdirSync(dir, { withFileTypes: true })) {
    const p = path.join(dir, e.name);
    if (e.isDirectory() && !['vendor', 'node_modules'].includes(e.name)) {
      walk(p, fn);
    } else if (e.isFile() && e.name.endsWith('.php')) {
      fn(p, fs.readFileSync(p, 'utf8'));
    }
  }
}

for (const mod of consumers) {
  used[mod] = {};
  for (const fn of methods) {
    const re = new RegExp(`\\b${fn}\\b`);
    const files = [];
    try {
      walk(mod, (filePath, text) => {
        if (re.test(text) && !filePath.includes('SchedaTrait.php')) {
          files.push(filePath.replace(/^Modules\//, ''));
        }
      });
    } catch {
      /* skip */
    }
    if (files.length) {
      used[mod][fn] = files.slice(0, 5);
    }
  }
}

console.log(
  JSON.stringify(
    {
      totalMethodsInSchedaTrait: methods.length,
      usedCount: Object.fromEntries(
        Object.entries(used).map(([k, v]) => [k, Object.keys(v).length]),
      ),
      used,
    },
    null,
    2,
  ),
);
