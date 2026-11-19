// Assistente AI nel sito (story 7-5): chat AG-UI verso POST /meetup/assistant (MeetupAssistant).
//
// - Streaming della risposta con @ag-ui/client (stesso protocollo della demo datomatic/laravelday-2026, MIT).
// - Gli eventi restituiti dai tool di lettura diventano schede: i dati arrivano dal server, non dal testo del modello.
// - Iscrizione e cancellazione: il server mette in pausa il run, qui l'utente conferma o annulla.
// - Il testo del modello non entra mai come HTML: solo un sottoinsieme di Markdown (grassetto, corsivo, link, elenchi), su testo
//   già "escapato".
import { HttpAgent, buildResumeArray } from '@ag-ui/client';

const root = document.getElementById('meetup-assistant');

if (root) {
    const t = JSON.parse(root.dataset.i18n ?? '{}');
    const panel = root.querySelector('[data-assistant-panel]');
    const toggle = root.querySelector('[data-assistant-toggle]');
    const close = root.querySelector('[data-assistant-close]');
    const messages = root.querySelector('[data-assistant-messages]');
    const form = root.querySelector('[data-assistant-form]');
    const input = form.querySelector('textarea');
    const send = form.querySelector('button[type=submit]');
    const status = root.querySelector('[data-assistant-status]');

    const READ_TOOLS = ['search_events', 'my_events', 'show_event'];
    const MUTATING_TOOLS = ['join_event', 'leave_event'];

    const agent = new HttpAgent({
        url: root.dataset.agentUrl,
        threadId: root.dataset.threadId,
        headers: { 'X-CSRF-TOKEN': root.dataset.csrf, Accept: 'text/event-stream' },
    });

    const messageId = () => crypto.randomUUID?.() ?? `${Date.now().toString(36)}-${Math.random().toString(36).slice(2)}`;
    const toolNames = {};
    let bubble = null;
    let changed = false;

    // ---------- apertura e chiusura ----------
    const open = (value) => {
        panel.hidden = !value;
        toggle.setAttribute('aria-expanded', String(value));
        if (value) {
            input.focus();
        } else {
            toggle.focus();
        }
    };
    toggle.addEventListener('click', () => open(panel.hidden));
    close.addEventListener('click', () => open(false));
    panel.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            open(false);
        }
    });

    // ---------- rendering ----------
    const append = (element) => {
        messages.append(element);
        messages.scrollTop = messages.scrollHeight;

        return element;
    };

    const escapeHtml = (text) => text.replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c]);

    // Markdown minimo e sicuro: prima l'escape, poi solo **grassetto**, *corsivo*, [testo](url http/https o /percorso)
    // ed elenchi "- " / "* " (riconosciuti prima della formattazione, così il "*" dell'elenco non diventa corsivo).
    const inline = (text) => text
        .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
        .replace(/(^|[^*])\*([^*\s][^*]*?)\*(?!\*)/g, '$1<em>$2</em>')
        .replace(/\[([^\]]+)\]\(((?:https?:\/\/|\/)[^\s)]+)\)/g, '<a href="$2" class="font-semibold underline">$1</a>');

    const renderMarkdown = (text) => {
        let html = '';
        let inList = false;
        for (const raw of escapeHtml(text).split('\n')) {
            const item = raw.match(/^\s*[-*]\s+(.*)$/);
            if (item) {
                if (!inList) {
                    html += '<ul class="ml-4 list-disc space-y-1">';
                    inList = true;
                }
                html += `<li>${inline(item[1])}</li>`;
                continue;
            }
            if (inList) {
                html += '</ul>';
                inList = false;
            }
            html += raw.trim() === '' ? '' : `<p>${inline(raw)}</p>`;
        }

        return html + (inList ? '</ul>' : '');
    };

    const addBubble = (role, text = '') => {
        const element = document.createElement('div');
        element.className = role === 'user'
            ? 'ml-auto w-fit max-w-[85%] rounded-2xl rounded-br-sm bg-red-600 px-3.5 py-2 text-white'
            : 'mr-auto w-fit max-w-[90%] space-y-1 rounded-2xl rounded-bl-sm bg-slate-100 px-3.5 py-2 text-slate-900 dark:bg-slate-700 dark:text-white';
        element.textContent = text;

        return append(element);
    };

    const note = (text, tone = 'text-slate-500 dark:text-slate-400') => {
        const element = document.createElement('p');
        element.className = `text-xs ${tone}`;
        element.textContent = text;

        return append(element);
    };

    const formatDate = (iso) => {
        if (!iso) {
            return '';
        }

        return new Intl.DateTimeFormat(document.documentElement.lang || 'it', { dateStyle: 'medium', timeStyle: 'short', timeZone: 'Europe/Rome' }).format(new Date(iso));
    };

    // Schede evento costruite con textContent: i dati vengono dal tool, nessun HTML del modello.
    const eventCards = (events) => {
        if (!Array.isArray(events) || events.length === 0) {
            return;
        }
        const list = document.createElement('ul');
        list.className = 'space-y-2';
        for (const event of events.slice(0, 6)) {
            const item = document.createElement('li');
            const link = document.createElement('a');
            link.href = event.url;
            link.className = 'block rounded-xl border border-slate-200 bg-white p-3 transition hover:border-red-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 dark:border-slate-600 dark:bg-slate-800';
            const title = document.createElement('p');
            title.className = 'font-semibold text-slate-900 dark:text-white';
            title.textContent = event.title;
            const meta = document.createElement('p');
            meta.className = 'text-xs text-slate-600 dark:text-slate-300';
            meta.textContent = [formatDate(event.starts_at), event.city].filter(Boolean).join(' · ');
            const seats = document.createElement('p');
            seats.className = event.is_full ? 'text-xs font-semibold text-red-700 dark:text-red-300' : 'text-xs text-emerald-700 dark:text-emerald-300';
            seats.textContent = event.registered ? t.registered : (event.is_full ? t.full : t.spots.replace(':count', event.spots_left));
            link.append(title, meta, seats);
            item.append(link);
            list.append(item);
        }
        append(list);
    };

    const showToolResult = (name, content) => {
        let data;
        try {
            data = JSON.parse(content);
        } catch {
            return; // testo semplice (es. un errore): lo spiega il modello
        }
        if (name === 'show_event') {
            eventCards([data]);
        } else {
            eventCards(data.events);
        }
    };

    const approvalCard = (interrupt) => {
        const card = document.createElement('div');
        card.className = 'rounded-xl border border-amber-300 bg-amber-50 p-3 text-slate-900';
        card.setAttribute('role', 'group');
        card.setAttribute('aria-label', t.confirm_title);

        const text = document.createElement('p');
        text.className = 'text-sm font-medium';
        text.textContent = interrupt.message ?? t.confirm_title;

        const actions = document.createElement('div');
        actions.className = 'mt-2 flex gap-2';

        const decide = (approved) => {
            card.remove();
            note(approved ? t.approved : t.refused);
            run({ resume: buildResumeArray([interrupt], { [interrupt.id]: { status: 'resolved', payload: { approved } } }) });
        };

        for (const [label, approved, style] of [
            [t.confirm, true, 'bg-red-600 text-white hover:bg-red-700'],
            [t.cancel, false, 'border border-slate-300 bg-white hover:bg-slate-100'],
        ]) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = `rounded-lg px-3 py-1.5 text-sm font-semibold focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 ${style}`;
            button.textContent = label;
            button.addEventListener('click', () => decide(approved));
            actions.append(button);
        }

        card.append(text, actions);
        append(card);
        card.querySelector('button').focus();
    };

    // ---------- run ----------
    const setBusy = (busy) => {
        send.disabled = busy;
        input.disabled = busy;
        status.textContent = busy ? t.thinking : '';
        if (!busy) {
            input.focus();
        }
    };

    const subscriber = {
        onTextMessageStartEvent() {
            bubble = addBubble('assistant');
            bubble.dataset.markdown = '';
        },
        onTextMessageContentEvent({ event }) {
            bubble.dataset.markdown += event.delta;
            bubble.innerHTML = renderMarkdown(bubble.dataset.markdown);
            messages.scrollTop = messages.scrollHeight;
        },
        onToolCallStartEvent({ event }) {
            toolNames[event.toolCallId] = event.toolCallName;
        },
        onToolCallResultEvent({ event }) {
            const name = toolNames[event.toolCallId];
            if (READ_TOOLS.includes(name)) {
                showToolResult(name, event.content);
            }
            if (MUTATING_TOOLS.includes(name)) {
                changed = true;
            }
        },
        onRunErrorEvent({ event }) {
            note(`${t.error} ${event.message ?? ''}`, 'text-red-700 dark:text-red-300');
        },
    };

    // parameters: {} per un messaggio nuovo, { resume } per la risposta a una conferma.
    async function run(parameters = {}) {
        setBusy(true);
        try {
            await agent.runAgent(parameters, subscriber);
            agent.pendingInterrupts.forEach(approvalCard);
        } catch (error) {
            const message = String(error?.message ?? '');
            note(message.includes('503') ? t.unavailable : (message.includes('429') ? t.throttled : t.error), 'text-red-700 dark:text-red-300');
        } finally {
            // Con una conferma in sospeso si risponde con i pulsanti della scheda, non con un nuovo messaggio.
            setBusy(agent.pendingInterrupts.length > 0);
            if (agent.pendingInterrupts.length > 0) {
                status.textContent = t.waiting;
            }
            // Dopo un'iscrizione o una cancellazione i componenti Livewire della pagina (posti, pulsante) si aggiornano.
            if (changed && window.Livewire) {
                window.Livewire.all().forEach((component) => component.$wire.$refresh?.());
                changed = false;
            }
        }
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const text = input.value.trim();
        if (text === '' || send.disabled) {
            return;
        }
        input.value = '';
        addBubble('user', text);
        agent.addMessage({ id: messageId(), role: 'user', content: text });
        run();
    });

    input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            form.requestSubmit();
        }
    });

    root.querySelectorAll('[data-assistant-suggestion]').forEach((button) => {
        button.addEventListener('click', () => {
            input.value = button.textContent.trim();
            form.requestSubmit();
        });
    });
}
