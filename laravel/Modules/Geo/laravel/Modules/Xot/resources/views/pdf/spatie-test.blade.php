<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 14px;
            margin: 32px;
        }

        h1 {
            margin: 0 0 12px;
            font-size: 24px;
        }

        .meta {
            margin-bottom: 24px;
            color: #4b5563;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            text-align: left;
            padding: 8px 10px;
            vertical-align: top;
        }

        th {
            width: 30%;
            background: #f3f4f6;
        }

        .empty {
            color: #6b7280;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="meta">
        Generato il {{ $generated_at->format('d/m/Y H:i:s') }}
    </div>

    @if($payload === [])
        <p class="empty">Nessun dato fornito.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Chiave</th>
                    <th>Valore</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payload as $key => $value)
                    <tr>
                        <th>{{ (string) $key }}</th>
                        <td>
                            @if (is_scalar($value) || $value === null)
                                {{ $value === null ? 'null' : (string) $value }}
                            @else
                                <pre>{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
