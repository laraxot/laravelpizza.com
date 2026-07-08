nds('adm_theme::layouts.app')
@section('content')

<h3>{{ $rows->count() }} Stabi/Repar to Fix </h3>
<table class="table table-bordered">
    @foreach($rows as $row)
    <tr>
        <td>{{ $row->id }}</td>
        <td>{{ $row->ente }}-{{ $row->matr }}<br/>{{ $row->cognome }} {{ $row->nome }}</td>
        <td>{{ $row->stabi }}-{{ $row->repar }}</td>
        <td>{{ $row->rep2kd }} - {{ $row->rep2ka }}</td>
    </tr>
    @endforeach
</table>
@endsection
