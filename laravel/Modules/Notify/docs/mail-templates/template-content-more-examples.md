# Esempi Aggiuntivi di Contenuto per Template Email

Questo documento contiene esempi aggiuntivi di contenuto HTML per template email da memorizzare nel database, seguendo l'architettura corretta di `spatie/laravel-database-mail-templates`.

## Indice

- [Template di Reset Password](#template-di-reset-password)
- [Template di Appuntamento](#template-di-appuntamento)
- [Template di Notifica](#template-di-notifica)
- [Template di Newsletter](#template-di-newsletter)
- [Integrazione nel Database](#integrazione-nel-database)

## Template di Reset Password

```html
<div style="padding: 30px 20px; text-align: center; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; margin-bottom: 20px; border-radius: 8px 8px 0 0;">
    <h1 style="margin: 0; font-size: 26px; font-weight: 700;">Ripristino Password</h1>
    <p style="margin: 10px 0 0; font-size: 18px; opacity: 0.9;">Segui questi passaggi per ripristinare la tua password</p>
</div>

<div style="padding: 0 30px 30px;">
    <p>Gentile {{ $name }},</p>
    
    <p>Abbiamo ricevuto una richiesta di ripristino della password per il tuo account. Se non hai richiesto questo cambiamento, puoi ignorare questa email e la tua password rimarrà invariata.</p>
    
    <div style="background-color: #eff6ff; border-radius: 8px; border: 2px solid #bfdbfe; padding: 30px; margin: 25px 0; text-align: center;">
        <svg style="width: 60px; height: 60px; margin-bottom: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#3b82f6">
            <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
        </svg>
        <h2 style="color: #1e40af; margin: 0 0 15px; font-size: 22px;">Ripristina la tua password</h2>
        <p style="color: #1e40af; margin: 0 0 20px;">Clicca sul pulsante qui sotto per creare una nuova password sicura per il tuo account.</p>
        <a href="{{ $reset_url ?? $action_url }}" style="display: inline-block; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; text-decoration: none; padding: 16px 24px; border-radius: 6px; font-size: 18px; font-weight: 600; margin-bottom: 15px;">RIPRISTINA PASSWORD</a>
        
        <p style="color: #1e40af; margin: 20px 0 10px;">In alternativa, puoi anche inserire il seguente codice di verifica:</p>
        <div style="background-color: #f8fafc; border-radius: 6px; padding: 15px; display: inline-block; margin: 0 auto; border: 1px dashed #cbd5e1;">
            <p style="font-size: 24px; font-weight: 700; color: #334155; letter-spacing: 5px; margin: 0; font-family: monospace;">{{ $reset_code ?? '987654' }}</p>
        </div>
        <p style="font-size: 14px; color: #64748b; margin: 10px 0 0;">Questo codice scadrà tra 60 minuti.</p>
    </div>
    
    <div style="background-color: #f8fafc; border-radius: 8px; padding: 20px; margin: 30px 0;">
        <h3 style="color: #334155; margin: 0 0 15px; font-size: 18px;">Come ripristinare la password in sicurezza</h3>
        
        <div style="margin-bottom: 15px; display: flex; align-items: flex-start;">
            <div style="width: 30px; height: 30px; background-color: #3b82f6; color: white; border-radius: 50%; text-align: center; line-height: 30px; margin-right: 15px; flex-shrink: 0; font-weight: bold;">1</div>
            <div>
                <h4 style="margin: 0 0 5px; color: #334155; font-weight: 600;">Clicca sul pulsante di ripristino</h4>
                <p style="margin: 0; color: #64748b;">Utilizza il pulsante "Ripristina Password" qui sopra per essere indirizzato alla pagina di ripristino sicura.</p>
            </div>
        </div>
        
        <div style="margin-bottom: 15px; display: flex; align-items: flex-start;">
            <div style="width: 30px; height: 30px; background-color: #3b82f6; color: white; border-radius: 50%; text-align: center; line-height: 30px; margin-right: 15px; flex-shrink: 0; font-weight: bold;">2</div>
            <div>
                <h4 style="margin: 0 0 5px; color: #334155; font-weight: 600;">Crea una nuova password</h4>
                <p style="margin: 0; color: #64748b;">Scegli una password sicura di almeno 8 caratteri, contenente lettere maiuscole, minuscole, numeri e simboli.</p>
            </div>
        </div>
        
        <div style="margin-bottom: 15px; display: flex; align-items: flex-start;">
            <div style="width: 30px; height: 30px; background-color: #3b82f6; color: white; border-radius: 50%; text-align: center; line-height: 30px; margin-right: 15px; flex-shrink: 0; font-weight: bold;">3</div>
            <div>
                <h4 style="margin: 0 0 5px; color: #334155; font-weight: 600;">Conferma e accedi</h4>
                <p style="margin: 0; color: #64748b;">Dopo aver confermato la nuova password, sarai automaticamente reindirizzato alla pagina di accesso.</p>
            </div>
        </div>
    </div>
    
    <div style="background-color: #f8fafc; padding: 15px; border-radius: 6px; margin: 25px 0; border-left: 4px solid #cbd5e1;">
        <p style="margin: 0; font-size: 14px; color: #64748b;"><strong style="color: #334155;">Nota di sicurezza:</strong> Per proteggere il tuo account, non condividere mai questa email o il codice di ripristino con nessuno. {{ $app_name }} non ti chiederà mai la tua password tramite email, telefono o SMS.</p>
    </div>
    
    <div style="border-top: 1px solid #e2e8f0; margin: 30px 0; padding-top: 30px;">
        <p>Se hai problemi con il ripristino della password o hai altre domande sul tuo account, contatta il nostro team di supporto.</p>
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

## Template di Appuntamento

```html
<div style="padding: 30px 20px; text-align: center; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white; margin-bottom: 20px; border-radius: 8px 8px 0 0;">
    <h1 style="margin: 0; font-size: 26px; font-weight: 700;">Il tuo appuntamento</h1>
    <p style="margin: 10px 0 0; font-size: 18px; opacity: 0.9;">Dettagli e informazioni</p>
</div>

<div style="padding: 0 30px 30px;">
    <p>Gentile {{ $name }},</p>
    
    <p>Confermiamo il tuo appuntamento presso il nostro centro medico. Di seguito trovi tutti i dettagli.</p>
    
    <div style="background-color: #eef2ff; border-radius: 8px; border: 2px solid #c7d2fe; padding: 30px; margin: 25px 0;">
        <h2 style="text-align: center; color: #4338ca; margin: 0 0 20px; font-size: 22px;">Dettagli Appuntamento</h2>
        
        <div style="margin-bottom: 12px; display: flex; align-items: flex-start;">
            <svg style="width: 24px; height: 24px; margin-right: 15px; flex-shrink: 0;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4338ca">
                <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
            </svg>
            <div>
                <p style="margin: 0 0 2px; font-weight: 600; color: #4338ca;">{{ __('notify.appointment.fields.date.label') }}</p>
                <p style="margin: 0; font-size: 16px; color: #334155;">{{ $date ?? 'Lunedì, 20 Giugno 2024' }}</p>
            </div>
        </div>
        
        <div style="margin-bottom: 12px; display: flex; align-items: flex-start;">
            <svg style="width: 24px; height: 24px; margin-right: 15px; flex-shrink: 0;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4338ca">
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
            </svg>
            <div>
                <p style="margin: 0 0 2px; font-weight: 600; color: #4338ca;">{{ __('notify.appointment.fields.time.label') }}</p>
                <p style="margin: 0; font-size: 16px; color: #334155;">{{ $time ?? '10:30' }}</p>
            </div>
        </div>
        
        <div style="margin-bottom: 12px; display: flex; align-items: flex-start;">
            <svg style="width: 24px; height: 24px; margin-right: 15px; flex-shrink: 0;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4338ca">
                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
            </svg>
            <div>
                <p style="margin: 0 0 2px; font-weight: 600; color: #4338ca;">{{ __('notify.appointment.fields.doctor.label') }}</p>
                <p style="margin: 0; font-size: 16px; color: #334155;">{{ $doctor ?? 'Dott. Marco Rossi' }}</p>
            </div>
        </div>
        
        <div style="margin-bottom: 12px; display: flex; align-items: flex-start;">
            <svg style="width: 24px; height: 24px; margin-right: 15px; flex-shrink: 0;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4338ca">
                <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
            </svg>
            <div>
                <p style="margin: 0 0 2px; font-weight: 600; color: #4338ca;">{{ __('notify.appointment.fields.location.label') }}</p>
                <p style="margin: 0; font-size: 16px; color: #334155;">{{ $location ?? ' Centro Medico, Via Roma 123, 00100 Roma' }}</p>
                <p style="margin: 0; font-size: 16px; color: #334155;">{{ $location ?? '<nome progetto> Centro Medico, Via Roma 123, 00100 Roma' }}</p>
            </div>
        </div>
        
        <div style="margin-bottom: 20px; display: flex; align-items: flex-start;">
            <svg style="width: 24px; height: 24px; margin-right: 15px; flex-shrink: 0;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4338ca">
                <path fill-rule="evenodd" d="M2.25 6a3 3 0 013-3h13.5a3 3 0 013 3v12a3 3 0 01-3 3H5.25a3 3 0 01-3-3V6zm3.97.97a.75.75 0 011.06 0l2.25 2.25a.75.75 0 010 1.06l-2.25 2.25a.75.75 0 01-1.06-1.06l1.72-1.72-1.72-1.72a.75.75 0 010-1.06zm4.28 4.28a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z" clip-rule="evenodd" />
            </svg>
            <div>
                <p style="margin: 0 0 2px; font-weight: 600; color: #4338ca;">{{ __('notify.appointment.fields.service.label') }}</p>
                <p style="margin: 0; font-size: 16px; color: #334155;">{{ $service ?? 'Visita Cardiologica' }}</p>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ $confirm_url ?? '#' }}" style="display: inline-block; background-color: #4f46e5; color: white; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-size: 16px; font-weight: 600; margin: 0 5px 10px;">{{ $confirm_text ?? 'Conferma' }}</a>
            <a href="{{ $reschedule_url ?? '#' }}" style="display: inline-block; background-color: #f97316; color: white; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-size: 16px; font-weight: 600; margin: 0 5px 10px;">{{ $reschedule_text ?? 'Riprogramma' }}</a>
            <a href="{{ $cancel_url ?? '#' }}" style="display: inline-block; background-color: #ef4444; color: white; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-size: 16px; font-weight: 600; margin: 0 5px 10px;">{{ $cancel_text ?? 'Annulla' }}</a>
        </div>
    </div>
    
    <div style="background-color: #f8fafc; border-radius: 8px; padding: 20px; margin: 30px 0;">
        <h3 style="color: #334155; margin: 0 0 15px; font-size: 18px;">Preparazione alla visita</h3>
        <ul style="color: #64748b; padding-left: 20px; margin: 0;">
            <li style="margin-bottom: 10px;"><strong style="color: #334155;">Documenti necessari:</strong> Tessera sanitaria, documenti d'identità, impegnativa del medico se disponibile.</li>
            <li style="margin-bottom: 10px;"><strong style="color: #334155;">Esami precedenti:</strong> Porta con te referti di esami o visite precedenti pertinenti.</li>
            <li style="margin-bottom: 10px;"><strong style="color: #334155;">Farmaci:</strong> Prepara una lista dei farmaci che stai assumendo attualmente.</li>
            <li style="margin-bottom: 10px;"><strong style="color: #334155;">Arrivo:</strong> Ti consigliamo di arrivare 15 minuti prima dell'appuntamento per le procedure di accettazione.</li>
            <li style="margin-bottom: 10px;"><strong style="color: #334155;">Digiuno:</strong> {{ $fasting ?? 'Non è richiesto il digiuno per questa visita, puoi mangiare e bere normalmente.' }}</li>
        </ul>
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <img style="max-width: 100%; height: auto; border-radius: 8px;" src="{{ $map_image ?? asset('modules/notify/images/map.png') }}" alt="Mappa della posizione">
        <p style="margin: 10px 0 0; font-size: 14px; color: #64748b;">{{ $map_caption ?? ' Centro Medico, Via Roma 123, 00100 Roma' }}</p>
        <p style="margin: 10px 0 0; font-size: 14px; color: #64748b;">{{ $map_caption ?? '<nome progetto> Centro Medico, Via Roma 123, 00100 Roma' }}</p>
    </div>
    
    <div style="border-top: 1px solid #e2e8f0; margin: 30px 0; padding-top: 30px;">
        <p>In caso di domande o necessità, non esitare a contattarci. Siamo a tua disposizione per garantirti la migliore esperienza possibile.</p>
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
