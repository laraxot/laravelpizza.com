nds('adm_theme::layouts.app')
@section('page_heading', 'Modifica Resposabilita Lett F')

@section('content')
    <style>
        table label {
            display: none;
        }

        table input[type='text'] {
            width: 100px;
            text-align: right;
        }

    </style>
    <a href="{{ $_panel->url('index') }}" class="btn btn-primary">&laquo; Torna alla lista </a>

    <livewire:lett-f.edit :row="$row">
    


    <br style="clear:both" />
    <br style="clear:both" />
    <br style="clear:both" />
    <br style="clear:both" />
    <br style="clear:both" />

@endsection
