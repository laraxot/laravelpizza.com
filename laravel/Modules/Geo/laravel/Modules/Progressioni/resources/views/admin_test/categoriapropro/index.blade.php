nds('adm_theme::layouts.app')
@section('page_heading', 'Categoria Propro')
@section('section')
    <x-filament::badge> flash-message </x-filament::badge>


    {!! Form::bsYearNav(['routename' => 'progressioni.categoria_propro.anno.index']) !!}
    {!! Form::bsBtnCreate() !!}
    @if (count($rows) == 0)
        {{-- \Modules\Progressioni\Models\Pesi::copyFromLastYear() --}}
    @endif
    {{-- $params['anno'] --}}
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <td>[ID]</td>
                <td>categoria</td>
                <td>lista propro</td>
                <td>lista propro sup</td>
                <td>anno</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $k => $v)
                <tr>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->categoria }}</td>
                    <td>{{ $v->lista_propro }}</td>
                    <td>{{ $v->lista_propro_sup }}</td>
                    <td>{{ $v->anno }}</td>
                    <td>{!! Form::bsBtnEdit(['row' => $v]) !!}</td>
                </tr>
        </tbody>
        @endforeach

    </table>
    {{ $rows->links() }}
@endsection
