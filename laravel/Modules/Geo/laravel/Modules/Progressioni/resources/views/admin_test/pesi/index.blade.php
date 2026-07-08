nds('adm_theme::layouts.app')
@section('page_heading', 'Pesi')
@section('section')
    <x-filament::badge> flash-message </x-filament::badge>


    {!! Form::bsYearNav(['routename' => 'progressioni.anno_pesi.index']) !!}
    {!! Form::bsBtnCreate() !!}
    @if (count($rows) == 0)
        {{ \Modules\Progressioni\Models\Pesi::copyFromLastYear() }}
    @endif
    {{-- $params['anno'] --}}
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <td>[ID]</td>
                <td>lista propro</td>
                <td>descr</td>
                <td>peso esperienza acquisita</td>
                <td>peso risultati ottenuti</td>
                <td>peso arricchimento professionale</td>
                <td>peso impegno</td>
                <td>peso qualita prestazione</td>
                <td>anno</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $k => $v)
                <tr>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->lista_propro }}</td>
                    <td>{{ $v->descr }}</td>
                    <td>{{ $v->peso_esperienza_acquisita }}</td>
                    <td>{{ $v->peso_risultati_ottenuti }}</td>
                    <td>{{ $v->peso_arricchimento_professionale }}</td>
                    <td>{{ $v->peso_impegno }}</td>
                    <td>{{ $v->peso_qualita_prestazione }}</td>
                    <td>{{ $v->anno }}</td>
                    <td>{!! Form::bsBtnEdit(['id_pesi' => $v->id]) !!}</td>
                </tr>
        </tbody>
        @endforeach

    </table>
    {{ $rows->links() }}
@endsection
