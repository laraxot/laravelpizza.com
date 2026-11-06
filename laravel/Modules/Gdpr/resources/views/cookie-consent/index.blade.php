{{--
    Banner dei cookie (DCP-153). Sostituisce la vista di statikbe/laravel-cookie-consent, di cui restano il middleware che inietta questo
    file prima di </body>, la chiave del cookie e i suoi valori (true = analitici e marketing, 2 = analitici, 3 = marketing, false = nessuno).
    Non usa lo script del pacchetto: quello rende inerte tutta la pagina e mostra uno sfondo finche' non si sceglie, cioe' un blocco della
    navigazione che le linee guida del Garante (provv. 10.6.2021 n. 231) non ammettono; qui la barra non blocca nulla.

    Due modi, decisi da GetCookieInventoryAction e non da un flag:
    - solo cookie tecnici (oggi): barra informativa con "Ho capito"; nessuna scelta da fare, quindi nessun "Rifiuta";
    - almeno un cookie non tecnico dichiarato in gdpr.config.cookie.extra: "Accetta tutti" e "Rifiuta tutti" con lo stesso peso, "Personalizza",
      chiusura con la X = rifiuto. Nessuna casella preselezionata.
    Il markup della barra segue il contratto di Bootstrap Italia (regione con aria-label, due controlli), senza Bootstrap.
    Posizione: fissa in basso, salvo che copra un controllo del primo schermo (o il viewport sia basso): allora data-layout="flow" la mette in
    flusso in cima alla pagina. Un tema con header fisso aggancia quell'attributo per spostarla sotto l'header (vedi Themes/Two/resources/css/app.css).
    Se un layout usa CSP con nonce, aggiungere il nonce a <style> e <script>.
--}}
@php
    use Modules\Gdpr\Actions\Cookie\GetCookieInventoryAction;
    use Modules\Gdpr\Datas\GdprConfigData;
    use Modules\Gdpr\Enums\CookieCategory;

    $inventory = app(GetCookieInventoryAction::class)->execute();
    $withConsent = $inventory->requiresConsent();
    $settings = GdprConfigData::make();
    $policyUrl = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeURL($settings->policy_path);
    $t = static fn (string $key): string => (string) trans('cookie-consent::texts.'.$key);
    $categories = [
        ['id' => 'analytics', 'case' => CookieCategory::Analytics, 'label' => 'setting_analytics', 'text' => 'setting_analytics_text'],
        ['id' => 'marketing', 'case' => CookieCategory::Marketing, 'label' => 'setting_marketing', 'text' => 'setting_marketing_text'],
    ];
@endphp
<style>
    .gdpr-cookiebar, .gdpr-cookiedialog { font-family: inherit; font-size: 1rem; line-height: 1.5; color: #1a1a1a; }
    .gdpr-cookiebar { --gdpr-pad-y: 1rem; --gdpr-pad-x: 1rem; position: fixed; z-index: 2147483000; left: 0; right: 0; bottom: 0; background: #fff; border-top: 3px solid var(--bs-primary, #0057ad); box-shadow: 0 -2px 12px rgba(0, 0, 0, .15); /* area sicura (notch, barra dei gesti) solo con viewport-fit=cover: altrimenti env() vale 0 */ padding: var(--gdpr-pad-y) max(var(--gdpr-pad-x), env(safe-area-inset-right, 0px)) calc(var(--gdpr-pad-y) + env(safe-area-inset-bottom, 0px)) max(var(--gdpr-pad-x), env(safe-area-inset-left, 0px)); }
    .gdpr-cookiebar[hidden] { display: none; }
    /* Il testo della pagina non deve restare sotto la barra fissa (bug FO blog dettaglio). In flusso la barra occupa il suo spazio: niente riserva. */
    body:has(.gdpr-cookiebar:not([hidden], [data-layout="flow"])) { padding-bottom: 11rem; }
    /* WCAG 2.4.11 (DCP-291): il campo che prende il focus viene portato sopra la barra, non lasciato sotto. Valore esatto aggiornato da pad(). */
    html:has(.gdpr-cookiebar:not([hidden], [data-layout="flow"])) { scroll-padding-bottom: 11rem; }
    @media print { .gdpr-cookiebar { display: none; } }
    /* In flusso (data-layout="flow", deciso da place() nello script): la barra sta in cima alla pagina e scorre via, senza coprire nulla.
       Succede quando la barra fissa coprirebbe un controllo del primo schermo e sui viewport bassi (400% di zoom, 320x256: alta 255 px
       riempiva lo schermo). Un tema con header fisso la sposta sotto l'header con `margin-top`. */
    .gdpr-cookiebar[data-layout="flow"] { position: static; border-top-width: 0; border-bottom: 3px solid var(--bs-primary, #0057ad); box-shadow: none; padding-bottom: var(--gdpr-pad-y); }
    .gdpr-cookiebar__inner { position: relative; max-width: 72rem; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; gap: 1rem 1.5rem; padding-right: 2rem; }
    .gdpr-cookiebar__text { flex: 1 1 24rem; min-width: 0; }
    .gdpr-cookiebar__title { margin: 0 0 .25rem; font-weight: 700; }
    .gdpr-cookiebar__body { margin: 0; }
    .gdpr-cookiebar a, .gdpr-cookiedialog a { color: var(--bs-primary, #0057ad); text-decoration: underline; }
    .gdpr-cookiebar__actions { display: flex; flex-wrap: wrap; gap: .75rem; }
    .gdpr-cookiebar .gdpr-btn.gdpr-btn, .gdpr-cookiedialog .gdpr-btn.gdpr-btn { appearance: none; cursor: pointer; font: inherit; font-weight: 600; min-height: 2.75rem; padding: .5rem 1.25rem; border-radius: .25rem; border: 2px solid var(--bs-primary, #0057ad); background: var(--bs-primary, #0057ad); color: #fff; text-decoration: none; }
    .gdpr-cookiebar .gdpr-btn.gdpr-btn--outline, .gdpr-cookiedialog .gdpr-btn.gdpr-btn--outline { background: #fff; color: var(--bs-primary, #0057ad); }
    .gdpr-cookiebar .gdpr-btn.gdpr-btn:focus-visible, .gdpr-cookiedialog .gdpr-btn.gdpr-btn:focus-visible, .gdpr-cookiebar .gdpr-close.gdpr-close:focus-visible, .gdpr-cookiedialog .gdpr-close.gdpr-close:focus-visible { outline: 3px solid #1a1a1a; outline-offset: 2px; }
    .gdpr-cookiebar .gdpr-close.gdpr-close, .gdpr-cookiedialog .gdpr-close.gdpr-close { appearance: none; position: absolute; top: -.25rem; right: -.25rem; width: 2.75rem; height: 2.75rem; border: 0; background: transparent; color: #1a1a1a; font: inherit; font-size: 1.75rem; line-height: 1; cursor: pointer; }
    .gdpr-cookiedialog { width: min(40rem, calc(100vw - 2rem)); max-height: calc(100vh - 2rem); padding: 1.5rem; border: 0; border-radius: .5rem; background: #fff; box-shadow: 0 8px 32px rgba(0, 0, 0, .35); }
    .gdpr-cookiedialog::backdrop { background: rgba(0, 0, 0, .55); }
    .gdpr-cookiedialog h2 { margin: 0 2rem .75rem 0; font-size: 1.5rem; }
    .gdpr-cookiedialog fieldset { margin: 1rem 0 0; padding: 0 0 1rem; border: 0; border-bottom: 1px solid #d9d9d9; }
    .gdpr-cookiedialog label { display: flex; align-items: center; gap: .75rem; font-weight: 700; cursor: pointer; }
    /* Casella disegnata qui: il CSS del tema azzera `appearance` e il bordo, e una casella nativa risulterebbe invisibile. */
    .gdpr-cookiedialog input.gdpr-check.gdpr-check { appearance: none; -webkit-appearance: none; box-sizing: border-box; flex: none; width: 1.5rem; height: 1.5rem; margin: 0; padding: 0; border: 2px solid #1a1a1a; border-radius: .25rem; background: #fff center / 80% no-repeat; cursor: pointer; }
    .gdpr-cookiedialog input.gdpr-check.gdpr-check:checked { border-color: var(--bs-primary, #0057ad); background-color: var(--bs-primary, #0057ad); background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23fff' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round' d='M3.5 8.5l3 3 6-7'/%3E%3C/svg%3E"); }
    .gdpr-cookiedialog input.gdpr-check.gdpr-check:disabled { cursor: not-allowed; opacity: .55; }
    .gdpr-cookiedialog input.gdpr-check.gdpr-check:focus-visible { outline: 3px solid #1a1a1a; outline-offset: 2px; }
    .gdpr-cookiedialog h2:focus { outline: none; }
    .gdpr-cookiedialog fieldset p { margin: .35rem 0 0 2.25rem; }
    .gdpr-cookiedialog .gdpr-cookiedialog__actions { display: flex; flex-wrap: wrap; gap: .75rem; margin-top: 1.25rem; }
    @media (max-width: 575.98px) {
        .gdpr-cookiebar { --gdpr-pad-y: .5rem; --gdpr-pad-x: .75rem; }
        .gdpr-cookiebar__inner { gap: .5rem; padding-right: 0; }
        .gdpr-cookiebar__title { margin: 0 2.5rem .15rem 0; font-size: 1rem; }
        .gdpr-cookiebar__body { font-size: .875rem; line-height: 1.4; }
        /* modalita' info: il titolo ripete il testo, resta per gli screen reader (nome del gruppo) ma non occupa schermo */
        .gdpr-cookiebar[data-cookiebar="info"] .gdpr-cookiebar__title { position: absolute; width: 1px; height: 1px; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; }
        .gdpr-cookiebar__actions { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; width: 100%; }
        .gdpr-cookiebar .gdpr-btn.gdpr-btn { padding: .4rem .5rem; }
        .gdpr-cookiebar__actions .gdpr-btn:only-child, .gdpr-cookiebar__actions .gdpr-btn[data-cookie-action="settings"] { grid-column: 1 / -1; }
    }
    @media (min-width: 360px) and (max-width: 575.98px) {
        .gdpr-cookiebar[data-cookiebar="info"] .gdpr-cookiebar__inner { flex-wrap: nowrap; align-items: center; }
        .gdpr-cookiebar[data-cookiebar="info"] .gdpr-cookiebar__text { flex: 1 1 auto; }
        .gdpr-cookiebar[data-cookiebar="info"] .gdpr-cookiebar__actions { display: block; width: auto; flex: none; }
    }
</style>

<section class="gdpr-cookiebar" data-cookiebar="{{ $withConsent ? 'consent' : 'info' }}" role="region" aria-label="{{ $t('alert_aria') }}" hidden
    data-cookie-key="{{ config('cookie-consent.cookie_key') }}"
    data-cookie-value-analytics="{{ config('cookie-consent.cookie_value_analytics') }}"
    data-cookie-value-marketing="{{ config('cookie-consent.cookie_value_marketing') }}"
    data-cookie-value-both="{{ config('cookie-consent.cookie_value_both') }}"
    data-cookie-value-none="{{ config('cookie-consent.cookie_value_none') }}"
    data-cookie-days="{{ $settings->consent_lifetime }}"
    data-cookie-secure="{{ request()->isSecure() ? '1' : '' }}">
    <div class="gdpr-cookiebar__inner">
        <div class="gdpr-cookiebar__text">
            <p class="gdpr-cookiebar__title">{{ $t($withConsent ? 'alert_title_consent' : 'alert_title_info') }}</p>
            <p class="gdpr-cookiebar__body">
                {{ $t($withConsent ? 'alert_text_consent' : 'alert_text_info') }}
                <a href="{{ $policyUrl }}">{{ $t('alert_more') }}<span class="sr-only visually-hidden"> ({{ $t('policy_title') }})</span></a>
            </p>
        </div>
        <div class="gdpr-cookiebar__actions">
            @if ($withConsent)
                <button type="button" class="gdpr-btn" data-cookie-action="accept">{{ $t('alert_accept') }}</button>
                <button type="button" class="gdpr-btn" data-cookie-action="reject">{{ $t('alert_reject') }}</button>
                <button type="button" class="gdpr-btn gdpr-btn--outline" data-cookie-action="settings">{{ $t('alert_settings') }}</button>
            @else
                <button type="button" class="gdpr-btn" data-cookie-action="reject">{{ $t('alert_ok') }}</button>
            @endif
        </div>
        @if ($withConsent)
            <button type="button" class="gdpr-close" data-cookie-action="reject" aria-label="{{ $t('alert_close') }}"><span aria-hidden="true">&times;</span></button>
        @endif
    </div>
</section>

<dialog class="gdpr-cookiedialog" id="gdpr-cookie-dialog" aria-labelledby="gdpr-cookie-dialog-title">
    <button type="button" class="gdpr-close" data-cookie-action="close" aria-label="{{ $t('settings_close') }}"><span aria-hidden="true">&times;</span></button>
    <h2 id="gdpr-cookie-dialog-title" tabindex="-1">{{ $t('settings_title') }}</h2>
    <p>{{ $t('settings_text') }} <a href="{{ $policyUrl }}">{{ $t('settings_policy_link') }}</a></p>
    <fieldset>
        <label for="gdpr-cookie-necessary"><input type="checkbox" class="gdpr-check" id="gdpr-cookie-necessary" checked disabled aria-describedby="gdpr-cookie-necessary-d"> {{ $t('setting_essential') }}</label>
        <p id="gdpr-cookie-necessary-d">{{ $t('setting_essential_text') }}</p>
    </fieldset>
    @foreach ($categories as $category)
        <fieldset>
            <label for="gdpr-cookie-{{ $category['id'] }}"><input type="checkbox" class="gdpr-check" id="gdpr-cookie-{{ $category['id'] }}" data-cookie-category="{{ $category['id'] }}" @disabled(! $inventory->has($category['case'])) aria-describedby="gdpr-cookie-{{ $category['id'] }}-d"> {{ $t($category['label']) }}</label>
            <p id="gdpr-cookie-{{ $category['id'] }}-d">{{ $inventory->has($category['case']) ? $t($category['text']) : $t('setting_unused') }}</p>
        </fieldset>
    @endforeach
    <div class="gdpr-cookiedialog__actions">
        @if ($withConsent)
            <button type="button" class="gdpr-btn" data-cookie-action="save">{{ $t('settings_save') }}</button>
            <button type="button" class="gdpr-btn" data-cookie-action="accept">{{ $t('settings_accept_all') }}</button>
        @else
            <button type="button" class="gdpr-btn gdpr-btn--outline" data-cookie-action="close">{{ $t('settings_close') }}</button>
        @endif
    </div>
</dialog>

<script>
(() => {
    const bar = document.querySelector('.gdpr-cookiebar');
    const dialog = document.getElementById('gdpr-cookie-dialog');
    if (!bar || !dialog || /bot|crawl|spider|google|bing|yandex|duckduckbot/i.test(navigator.userAgent)) return;
    const d = bar.dataset;
    const read = () => { const m = document.cookie.match(new RegExp('(?:^|; )' + encodeURIComponent(d.cookieKey) + '=([^;]*)')); return m ? decodeURIComponent(m[1]) : null; };
    const boxes = [...dialog.querySelectorAll('[data-cookie-category]')];
    const write = (value) => {
        const hadFocus = [bar, dialog].some((root) => root.contains(document.activeElement)) && document.activeElement.matches(':focus-visible');
        const expires = new Date(Date.now() + d.cookieDays * 864e5).toUTCString();
        document.cookie = `${encodeURIComponent(d.cookieKey)}=${encodeURIComponent(value)}; expires=${expires}; path=/; SameSite=Lax${d.cookieSecure ? '; Secure' : ''}`;
        const granted = { analytics: value === d.cookieValueBoth || value === d.cookieValueAnalytics, marketing: value === d.cookieValueBoth || value === d.cookieValueMarketing };
        // Aggancio per chi carica uno script non tecnico: ascoltare questo evento e leggere il cookie al caricamento della pagina.
        document.dispatchEvent(new CustomEvent('cookie-consent:changed', { detail: { value, ...granted } }));
        bar.hidden = true;
        pad();
        leave(hadFocus);
    };
    // la barra e' fissa in basso: finche' e' visibile lascia sotto il contenuto lo spazio che occupa, cosi' il footer resta raggiungibile e il
    // browser porta il campo con il focus sopra la barra (scroll-padding). Nel flusso (viewport basso) non serve nessuno dei due.
    const pad = () => {
        const space = !bar.hidden && getComputedStyle(bar).position === 'fixed' ? `${bar.offsetHeight}px` : '';
        document.body.style.paddingBottom = space;
        document.documentElement.style.scrollPaddingBottom = space;
    };
    // La barra resta fissa in basso solo se non copre nessun controllo del primo schermo (WCAG 2.4.11, e il CTA sotto il fold non e' piu'
    // raggiungibile finche' la barra e' li'); altrimenti va in flusso, in cima, e occupa il proprio spazio. Sui viewport bassi (zoom 400%) sempre in flusso.
    const controls = 'a[href], button, input:not([type="hidden"]), select, textarea, summary, [tabindex]:not([tabindex="-1"])';
    const shown = (el) => (el.checkVisibility ? el.checkVisibility({ checkOpacity: true, checkVisibilityCSS: true }) : el.getClientRects().length > 0);
    const covers = () => {
        const top = bar.getBoundingClientRect().top;
        return [...document.querySelectorAll(controls)].some((el) => {
            if (bar.contains(el) || dialog.contains(el) || !shown(el)) return false;
            const r = el.getBoundingClientRect();
            return r.width > 1 && r.height > 1 && r.top < innerHeight && r.bottom - top > 4; // 4 px: il bordo della barra non conta
        });
    };
    // Decide solo a pagina in cima (primo caricamento, rotazione): chi ha gia' scorso non deve vedere la barra sparire verso l'alto.
    const place = () => {
        if (bar.hidden) return;
        const short = matchMedia('(max-height: 30rem)').matches;
        if (short || scrollY < 1) {
            bar.removeAttribute('data-layout');
            if (short || covers()) bar.dataset.layout = 'flow';
        }
        pad();
    };
    // chi stava con la tastiera sulla barra (o nel suo dialogo) passa al prossimo stop della pagina invece di cadere sul body
    const leave = (hadFocus) => {
        if (!hadFocus) return;
        const next = () => (document.querySelector('.skiplink a') ?? document.getElementById('main-container') ?? document.getElementById('main-content'))?.focus();
        dialog.open ? dialog.addEventListener('close', next, { once: true }) : next();
    };
    window.addEventListener('resize', place);
    const valueFor = (a, m) => (a && m ? d.cookieValueBoth : a ? d.cookieValueAnalytics : m ? d.cookieValueMarketing : d.cookieValueNone);
    const sync = () => { const v = read(); boxes.forEach((b) => { b.checked = !b.disabled && (v === d.cookieValueBoth || v === (b.dataset.cookieCategory === 'analytics' ? d.cookieValueAnalytics : d.cookieValueMarketing)); }); };
    const actions = {
        accept: () => { write(d.cookieValueBoth); dialog.open && dialog.close(); },
        reject: () => { write(d.cookieValueNone); dialog.open && dialog.close(); },
        save: () => { write(valueFor(...['analytics', 'marketing'].map((c) => boxes.find((b) => b.dataset.cookieCategory === c)?.checked ?? false))); dialog.close(); },
        settings: () => { sync(); dialog.showModal(); dialog.querySelector('h2')?.focus(); }, // il titolo, non la X: niente anello di focus sul pulsante di chiusura
        close: () => dialog.close(),
    };
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-cookie-action], [data-cookie-preferences]');
        if (!trigger) return;
        if (trigger.matches('[data-cookie-preferences]')) { e.preventDefault(); actions.settings(); return; }
        actions[trigger.dataset.cookieAction]?.();
    });
    dialog.addEventListener('click', (e) => { if (e.target === dialog) dialog.close(); });
    if (read() === null) {
        // dopo lo skip link (primo figlio del body), non prima: il link per saltare i blocchi deve essere il primo stop di Tab
        const skip = document.querySelector('body > a[href^="#"], body > .skiplink');
        skip ? skip.after(bar) : document.body.prepend(bar);
        bar.hidden = false;
        place();
    }
})();
</script>
