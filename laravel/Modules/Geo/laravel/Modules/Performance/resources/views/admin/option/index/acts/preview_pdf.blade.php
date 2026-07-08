nds('adm_theme::layouts.app')
@section('content')

    <table class="table table-bordered">
        @foreach ($options as $v)
            <tr>
                <td rowspan="{{ $v->sons->count() + 1 }}">
                    {!! $v->txt !!}
                </td>
            </tr>

            @foreach ($v->sons as $son)
                <tr>
                    <td>
                        {!! $son->txt !!}
                    </td>
                </tr>
            @endforeach



        @endforeach
    </table>
@endsection
