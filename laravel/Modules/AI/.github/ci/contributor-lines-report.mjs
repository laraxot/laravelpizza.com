#!/usr/bin/env node
/**
 * Contributor + extension lines report (STORY-131).
 * Outputs: summary markdown + HTML with bar charts (no npm deps).
 *
 * Usage: node scripts/ci/contributor-lines-report.mjs [--since=30] [--out=reports/contributor-lines.html]
 */

import { execSync } from 'node:child_process';
import fs from 'node:fs';
import path from 'node:path';

const cwd = process.cwd();
const args = process.argv.slice(2);
let sinceDays = 90;
let outHtml = path.join(cwd, 'reports', 'contributor-lines.html');
let outSummary = path.join(cwd, 'reports', 'contributor-lines-summary.md');

for (const arg of args) {
    if (arg.startsWith('--since=')) {
        sinceDays = Number.parseInt(arg.split('=')[1], 10) || 90;
    } else if (arg.startsWith('--out=')) {
        outHtml = path.resolve(arg.split('=')[1]);
    } else if (arg.startsWith('--summary=')) {
        outSummary = path.resolve(arg.split('=')[1]);
    }
}

function sh(cmd) {
    return execSync(cmd, { cwd, encoding: 'utf8', maxBuffer: 64 * 1024 * 1024 }).trim();
}

function extOf(filePath) {
    const base = path.basename(filePath);
    const idx = base.lastIndexOf('.');
    if (idx <= 0) {
        return '(no ext)';
    }

    return base.slice(idx + 1).toLowerCase();
}

function sinceDate() {
    const d = new Date();
    d.setDate(d.getDate() - sinceDays);

    return d.toISOString().slice(0, 10);
}

function collectGitChurn() {
    const since = sinceDate();
    const log = sh(`git log --since="${since}" --numstat --pretty=format:'@@@%H|%an|%ae'`);
    const byAuthor = new Map();
    const byExt = new Map();

    let currentAuthor = 'unknown';

    for (const line of log.split('\n')) {
        if (line.startsWith('@@@')) {
            const parts = line.slice(3).split('|');
            currentAuthor = parts[1] || 'unknown';
            continue;
        }

        const m = line.match(/^(\d+|-)\s+(\d+|-)\s+(.+)$/);
        if (!m) {
            continue;
        }

        const added = m[1] === '-' ? 0 : Number.parseInt(m[1], 10);
        const removed = m[2] === '-' ? 0 : Number.parseInt(m[2], 10);
        const ext = extOf(m[3]);
        const churn = added + removed;

        if (!byAuthor.has(currentAuthor)) {
            byAuthor.set(currentAuthor, { added: 0, removed: 0, churn: 0 });
        }
        const a = byAuthor.get(currentAuthor);
        a.added += added;
        a.removed += removed;
        a.churn += churn;

        byExt.set(ext, (byExt.get(ext) || 0) + churn);
    }

    return { since, byAuthor, byExt };
}

function collectCloc() {
    try {
        const json = sh('cloc . --json --quiet --exclude-dir=vendor,node_modules,.git,public_html,storage');
        const data = JSON.parse(json);
        const byExt = new Map();

        for (const [lang, stats] of Object.entries(data)) {
            if (lang === 'header' || lang === 'SUM') {
                continue;
            }
            const code = stats.code ?? 0;
            byExt.set(lang, code);
        }

        return byExt;
    } catch {
        return new Map();
    }
}

function topEntries(map, limit = 12) {
    return [...map.entries()]
        .sort((a, b) => b[1] - a[1])
        .slice(0, limit);
}

function topAuthors(map, limit = 12) {
    return [...map.entries()]
        .sort((a, b) => b[1].churn - a[1].churn)
        .slice(0, limit);
}

function barChartSvg(items, { width = 640, barH = 22, gap = 6, labelW = 120 } = {}) {
    const max = Math.max(...items.map(([, v]) => (typeof v === 'number' ? v : v.churn)), 1);
    const height = items.length * (barH + gap) + 24;
    const chartW = width - labelW - 40;
    let y = 16;
    const bars = items.map(([label, value]) => {
        const n = typeof value === 'number' ? value : value.churn;
        const w = Math.max(4, Math.round((n / max) * chartW));
        const row = `<text x="8" y="${y + 14}" class="lbl">${escapeHtml(String(label).slice(0, 18))}</text>
<rect x="${labelW}" y="${y}" width="${w}" height="${barH}" rx="4" fill="#007a52"/>
<text x="${labelW + w + 6}" y="${y + 14}" class="val">${n.toLocaleString('it-IT')}</text>`;
        y += barH + gap;

        return row;
    }).join('\n');

    return `<svg xmlns="http://www.w3.org/2000/svg" width="${width}" height="${height}" role="img">${bars}</svg>`;
}

function escapeHtml(s) {
    return s
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function buildHtml({ since, byAuthor, byExt, clocByLang }) {
    const extChurn = topEntries(byExt, 14);
    const authors = topAuthors(byAuthor, 14);
    const clocTop = topEntries(clocByLang, 14);

    return `<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8"/>
  <title>Contributor lines report</title>
  <style>
    body { font-family: 'Titillium Web', system-ui, sans-serif; color: #17324d; margin: 2rem; background: #f8fafc; }
    h1, h2 { color: #17324d; }
    section { background: #fff; border-radius: 12px; padding: 1.25rem; margin-bottom: 1.5rem; box-shadow: 0 4px 16px rgba(15,23,42,.08); }
    .lbl { font-size: 12px; fill: #334155; }
    .val { font-size: 11px; fill: #64748b; }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th, td { padding: 0.4rem 0.6rem; border-bottom: 1px solid #e2e8f0; text-align: left; }
    th { background: #f1f5f9; }
  </style>
</head>
<body>
  <h1>Contributor &amp; LOC report</h1>
  <p>Periodo git: ultimi <strong>${sinceDays}</strong> giorni (da ${since}). Repo: <code>${escapeHtml(path.basename(cwd))}</code></p>

  <section>
    <h2>Churn per estensione (git numstat)</h2>
    ${barChartSvg(extChurn)}
  </section>

  <section>
    <h2>Churn per contributor</h2>
    ${barChartSvg(authors)}
    <table>
      <thead><tr><th>Author</th><th>+</th><th>−</th><th>Churn</th></tr></thead>
      <tbody>
        ${authors.map(([name, s]) => `<tr><td>${escapeHtml(name)}</td><td>${s.added}</td><td>${s.removed}</td><td>${s.churn}</td></tr>`).join('')}
      </tbody>
    </table>
  </section>

  <section>
    <h2>LOC per linguaggio (cloc snapshot)</h2>
    ${clocTop.length ? barChartSvg(clocTop) : '<p>cloc non disponibile in questo runner.</p>'}
  </section>
</body>
</html>`;
}

function buildSummary({ since, byAuthor, byExt, clocByLang }) {
    const lines = [
        `## Contributor lines report (${sinceDays}d, from ${since})`,
        '',
        '### Top extensions (churn)',
        ...topEntries(byExt, 10).map(([k, v]) => `- **.${k}**: ${v}`),
        '',
        '### Top contributors (churn)',
        ...topAuthors(byAuthor, 10).map(([k, v]) => `- **${k}**: +${v.added} / −${v.removed} (churn ${v.churn})`),
        '',
        '### LOC by language (cloc)',
        ...topEntries(clocByLang, 10).map(([k, v]) => `- **${k}**: ${v}`),
    ];

    return lines.join('\n');
}

const gitData = collectGitChurn();
const clocData = collectCloc();
const html = buildHtml({ ...gitData, clocByLang: clocData });
const summary = buildSummary({ ...gitData, clocByLang: clocData });

fs.mkdirSync(path.dirname(outHtml), { recursive: true });
fs.mkdirSync(path.dirname(outSummary), { recursive: true });
fs.writeFileSync(outHtml, html);
fs.writeFileSync(outSummary, summary);

console.log(`Wrote ${outHtml}`);
console.log(`Wrote ${outSummary}`);
console.log('---');
console.log(summary);
