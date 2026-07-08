<div>  
    <style>
        body {
            background-color: black;
            color: white;
        }
        
        .compact-table {
            font-size: 13px;
            width: 100%;
            max-width: 600px;
            border-collapse: collapse;
            margin: 10px 0;
            background-color: black;
            color: white;
        }
        
        .compact-table th,
        .compact-table td {
            border: 1px solid #555;
            padding: 4px 6px;
            vertical-align: top;
            background-color: transparent;
            color: white;
            text-align: left;
        }
        
        .compact-table th {
            background-color: #555;
            font-weight: bold;
            font-size: 14px;
        }
        
        .workgroup-col {
            width: 140px;
            max-width: 140px;
            word-wrap: break-word;
            font-weight: 500;
        }
        
        .employees-col {
            font-size: 12px;
            line-height: 1.2;
        }
        
        .employees-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        
        .employees-list li {
            margin: 1px 0;
            padding: 0;
        }
        
    </style>

    <table class="compact-table">
        <thead>
            <tr>
                <th class="workgroup-col">Gruppo di lavoro</th>
                <th>Dipendenti</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($workgroups as $workgroup)
                <tr>
                    <td class="workgroup-col" title="{{ $workgroup->denominazione }}">
                        {{ Str::limit($workgroup->denominazione, 35, '...') }}
                    </td>
                    <td class="employees-col">
                        <ul class="employees-list">
                            @foreach ($workgroup->employees as $employee)
                                 @if (!$loop->first)
                                , 
                                @endif
                                {{ $employee->nome }} {{ $employee->cognome }}
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>