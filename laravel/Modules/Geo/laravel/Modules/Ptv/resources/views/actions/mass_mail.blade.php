nds('adm_theme::layouts.app')
@section('content')
    @php
    //dddx($row); //individualeDip
    //dddx(get_defined_vars());
    @endphp
    <a href="{{ Panel::make()->get($row)->url('index') }}" class="btn btn-primary">&laquo; Torna alla lista </a>
    {{-- {!! Form::bsOpen($row,'store') !!} --}}
    {!! Form::model($row, ['url' => Request::fullUrl()]) !!}

    {{ Form::bsSelect2SidesRows('mails') }}

    {{ Form::bsSubmit('manda mail') }}
    {{ Form::close() }}


    <table class="table">
        @foreach ($rows->get() /*->where('ha_diritto',1)*/ as $v)
            <tr>
                <td>{{ $v->id }} <br /> {{ $v->cognome }} {{ $v->nome }} <br /> {{ $v->email }}</td>
                <td>
                    @foreach ($v->mailInviate as $vm)
                        @if ($loop->first)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>data</th>
                                        <th>utente</th>
                                        {{-- <th>punt progressione</th>
							<th>punt progressione finale</th> --}}
                                    </tr>
                                </thead>
                        @endif
            <tr>
                <td>{{ $vm->created_at }}</td>
                <td>{{ $vm->created_by }}</td>
                {{-- <td>{{ $vm->data['punt_progressione'] }}</td>
					<td>{{ $vm->data['punt_progressione_finale'] }}</td> --}}
            </tr>
            @if ($loop->last)
    </table>
    @endif
    @endforeach

    </td>
    </tr>
    @endforeach
    </table>

@endsection
