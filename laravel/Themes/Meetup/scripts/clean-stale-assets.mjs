// Dopo `npm run build`: toglie da public/assets i file che il manifest di Vite non usa più.
// Vite scrive con emptyOutDir: false (public/ contiene anche favicon, sw.js, site.webmanifest), quindi ogni build
// lasciava il CSS/JS della build precedente: file morti nel repository e nella document root (symlink).
import { readFileSync, readdirSync, unlinkSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const publicDir = join(dirname(fileURLToPath(import.meta.url)), '..', 'public');
const manifest = JSON.parse(readFileSync(join(publicDir, 'manifest.json'), 'utf8'));
const used = new Set();
for (const entry of Object.values(manifest)) {
    for (const file of [entry.file, ...(entry.css ?? []), ...(entry.assets ?? [])]) {
        if (file) used.add(file);
    }
}

let removed = 0;
for (const name of readdirSync(join(publicDir, 'assets'))) {
    if (!used.has(`assets/${name}`)) {
        unlinkSync(join(publicDir, 'assets', name));
        removed++;
        console.log(`rimosso asset non più usato: assets/${name}`);
    }
}
console.log(removed ? `${removed} asset vecchi rimossi` : 'nessun asset vecchio');
