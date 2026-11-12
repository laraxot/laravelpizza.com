{{--
    Pagina di errore autonoma (500, 503 e ripiego se il tema non è caricato): niente database, sessione,
    Livewire o Vite, così funziona anche quando il problema è proprio lì. Stile inline, colori del tema Meetup.
--}}
@php
    $code = (string) ($code ?? 500);
    $t = static function (string $key, string $fallback): string {
        $value = __('pub_theme::errors.'.$key);

        return is_string($value) && $value !== 'pub_theme::errors.'.$key ? $value : $fallback;
    };
    $title = $t($code.'.title', $code === '503' ? 'Back soon' : 'Something went wrong');
    $message = $t($code.'.message', 'Please try again in a few minutes.');
    $locale = app()->getLocale();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ $title }} - Laravel Pizza Meetups</title>
    <style>
        *{box-sizing:border-box}
        body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem 1rem;
            font-family:ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
            background:linear-gradient(135deg,#0f172a 0%,#1e293b 55%,#7f1d1d 100%);color:#fff;text-align:center}
        main{max-width:36rem}
        .code{font-size:6rem;font-weight:900;line-height:1;margin:0;color:#f87171}
        h1{font-size:2rem;margin:1rem 0 .75rem}
        p{color:#cbd5e1;font-size:1.125rem;line-height:1.6;margin:0}
        a{display:inline-block;margin-top:2rem;padding:.75rem 1.5rem;border-radius:.75rem;background:#dc2626;color:#fff;font-weight:700;text-decoration:none}
        a:hover{background:#ef4444}
        a:focus-visible{outline:3px solid #fca5a5;outline-offset:3px}
    </style>
</head>
<body>
    <main>
        <p class="code" aria-hidden="true">{{ $code }}</p>
        <h1>{{ $title }}</h1>
        <p>{{ $message }}</p>
        @if($code !== '503')
            <a href="{{ url('/'.$locale) }}">{{ $t('actions.home', 'Back to home') }}</a>
        @endif
    </main>
</body>
</html>
