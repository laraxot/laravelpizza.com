# Esempi di Contenuto per Template Email

Questo documento contiene esempi di contenuto HTML per i vari template email da memorizzare nel database, seguendo l'architettura corretta di `spatie/laravel-database-mail-templates`.

## Indice

- [Introduzione](#introduzione)
- [Template di Benvenuto](#template-di-benvenuto)
- [Template di Conferma](#template-di-conferma)
- [Template di Reset Password](#template-di-reset-password)
- [Template di Appuntamento](#template-di-appuntamento)
- [Template di Notifica](#template-di-notifica)
- [Integrazione nel Database](#integrazione-nel-database)

## Introduzione

Questi esempi mostrano il contenuto HTML che deve essere memorizzato nella colonna `html_template` della tabella `mail_templates`. Questi contenuti verranno inseriti nel placeholder `{{{ body }}}` dei layout base.

**Nota importante**: Questi contenuti NON devono essere salvati come file in `resources/mail-layouts/` ma inseriti nel database.

## Template di Benvenuto

```html
<div style="padding: 30px 20px; text-align: center; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; margin-bottom: 20px; border-radius: 8px 8px 0 0;">
    <h1 style="margin: 0; font-size: 26px; font-weight: 700;">Benvenuto in {{ $app_name }}</h1>
    <p style="margin: 10px 0 0; font-size: 18px; opacity: 0.9;">Il tuo account è stato creato con successo</p>
</div>

<div style="padding: 0 30px 30px;">
    <p>Gentile {{ $name }},</p>
    
    <p>Grazie per esserti registrato a {{ $app_name }}. Siamo lieti di averti come nuovo utente e siamo pronti ad aiutarti a prenderti cura della tua salute.</p>
    
    <div style="background-color: #f0fdfa; border-radius: 8px; border: 2px solid #99f6e4; padding: 20px; margin: 25px 0; text-align: center;">
        <h2 style="color: #0f766e; margin: 0 0 15px; font-size: 20px;">Verifica il tuo indirizzo email</h2>
        <p style="color: #0f766e; margin: 0 0 20px;">Per completare la registrazione e accedere a tutti i servizi, ti preghiamo di verificare il tuo indirizzo email.</p>
        <a href="{{ $verification_url ?? $action_url }}" style="display: inline-block; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-size: 16px; font-weight: 600;">VERIFICA EMAIL</a>
    </div>
    
    <h3 style="color: #334155; margin: 30px 0 15px; font-size: 18px;">Ecco cosa puoi fare con il tuo account:</h3>
    
    <ul style="color: #64748b; padding-left: 20px; margin-bottom: 30px;">
        <li style="margin-bottom: 10px;">Prenotare visite mediche online</li>
        <li style="margin-bottom: 10px;">Accedere alla tua cartella clinica digitale</li>
        <li style="margin-bottom: 10px;">Ricevere promemoria per appuntamenti</li>
        <li style="margin-bottom: 10px;">Comunicare con il tuo medico in modo sicuro</li>
    </ul>
    
    <div style="border-top: 1px solid #e2e8f0; margin: 30px 0; padding-top: 30px;">
        <p>Se hai domande o hai bisogno di assistenza, non esitare a contattarci.</p>
        <p>Cordiali saluti,<br>Il Team di {{ $app_name }}</p>
    </div>
</div>

<div style="background-color: #f8fafc; text-align: center; padding: 20px; font-size: 14px; color: #64748b; border-radius: 0 0 8px 8px;">
    <p style="margin: 0 0 10px;">© {{ date('Y') }} {{ $app_name }}. Tutti i diritti riservati.</p>
    <p style="margin: 0; font-size: 12px;">
        <a href="{{ $privacy_url ?? '#' }}" style="color: #64748b; text-decoration: underline;">Privacy Policy</a> | 
        <a href="{{ $terms_url ?? '#' }}" style="color: #64748b; text-decoration: underline;">Termini di Servizio</a>
    </p>
</div>
```

## Template di Conferma

```html
<div style="padding: 30px 20px; text-align: center; background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); color: white; margin-bottom: 20px; border-radius: 8px 8px 0 0;">
    <h1 style="margin: 0; font-size: 26px; font-weight: 700;">Conferma Email</h1>
    <p style="margin: 10px 0 0; font-size: 18px; opacity: 0.9;">Un ultimo passaggio per completare la registrazione</p>
</div>

<div style="padding: 0 30px 30px;">
    <p>Gentile {{ $name }},</p>
    
    <p>Grazie per esserti registrato a {{ $app_name }}. Per completare la procedura di registrazione e attivare il tuo account, ti chiediamo di confermare il tuo indirizzo email.</p>
    
    <div style="background-color: #f0fdfa; border-radius: 8px; border: 2px solid #99f6e4; padding: 30px; margin: 25px 0; text-align: center;">
        <svg style="width: 60px; height: 60px; margin-bottom: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#14b8a6">
            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
        </svg>
        <h2 style="color: #0f766e; margin: 0 0 15px; font-size: 22px;">Verifica il tuo indirizzo email</h2>
        <p style="color: #0f766e; margin: 0 0 20px;">Clicca sul pulsante qui sotto per verificare il tuo indirizzo email e attivare il tuo account.</p>
        <a href="{{ $verification_url ?? $action_url }}" style="display: inline-block; background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); color: white; text-decoration: none; padding: 16px 24px; border-radius: 6px; font-size: 18px; font-weight: 600; margin-bottom: 15px;">VERIFICA EMAIL</a>
        
        <p style="color: #0f766e; margin: 20px 0 10px;">In alternativa, puoi anche inserire il seguente codice di verifica:</p>
        <div style="background-color: #f8fafc; border-radius: 6px; padding: 15px; display: inline-block; margin: 0 auto; border: 1px dashed #cbd5e1;">
            <p style="font-size: 24px; font-weight: 700; color: #334155; letter-spacing: 5px; margin: 0; font-family: monospace;">{{ $verification_code ?? '123456' }}</p>
        </div>
        <p style="font-size: 14px; color: #64748b; margin: 10px 0 0;">Questo codice scadrà tra 24 ore.</p>
    </div>
    
    <div style="border-top: 1px solid #e2e8f0; margin: 30px 0; padding-top: 30px;">
        <p>Se non hai richiesto la creazione di un account, ti preghiamo di ignorare questa email.</p>
        <p>Cordiali saluti,<br>Il Team di {{ $app_name }}</p>
    </div>
</div>

<div style="background-color: #f8fafc; text-align: center; padding: 20px; font-size: 14px; color: #64748b; border-radius: 0 0 8px 8px;">
    <p style="margin: 0 0 10px;">© {{ date('Y') }} {{ $app_name }}. Tutti i diritti riservati.</p>
    <p style="margin: 0; font-size: 12px;">
        <a href="{{ $privacy_url ?? '#' }}" style="color: #64748b; text-decoration: underline;">Privacy Policy</a> | 
        <a href="{{ $terms_url ?? '#' }}" style="color: #64748b; text-decoration: underline;">Termini di Servizio</a>
    </p>
</div>
```
