nds('adm_theme::layouts.app')
@section('content')
    @php

    //dddx(get_defined_vars());
    $options=$row->mails->map(function($row){
        $row->label= $row->matr.' ['.$row->email.']['.$row->ha_diritto.'] '.$row->cognome.' '.$row->nome.' ';
        return $row;
    })->sortBy('cognome')

    ->pluck('label','id')
        ->unique()
        ->all();

    $field_options=[
        'field'=>(object)[
            'options'=>$options
        ]
    ];
    //dddx($field_options);

    @endphp
    {{-- {!! Panel::make()->get($row)->url('index') !!} <br/>
{!! $_panel->url('index') !!} --}}

    <a href="{{ $_panel->url('index') }}" class="btn btn-primary">&laquo; Torna alla lista </a>
    {{-- {!! Form::bsOpen($row,'store') !!} --}}
    {!! Form::model($row, ['url' => Request::fullUrl()]) !!}
    @method('post')
    {{--
    <ol>
    @foreach($row->mails as $mail)
        <li>{{ $mail->ente }} {{ $mail->matr }} {{ $mail->cognome }} {{ $mail->nome }} {{ $mail->email }}</li>
        <li>{{ $mail->stabi }} {{ $mail->repar }} {{ $mail->anno }} </li>
    @endforeach
    </ol>
    --}}
    {{-- Form::bsSelect2Sides('mails',null,get_defined_vars()) --}}
    {{ Form::bsSelect2Sides('mails',null,get_defined_vars(),$field_options) }}
    {{ Form::bsSubmit('manda mail') }}
    {{ Form::close() }}

    @include($view.'.report')
@endsection
