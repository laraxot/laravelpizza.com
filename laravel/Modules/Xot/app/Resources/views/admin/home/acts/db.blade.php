<?php

declare(strict_types=1);

?>
@extends('adm_theme::layouts.app')
@section('content')

<form action="{{ Request::fullUrl() }}" method="POST" enctype="multipart/form-data">
                @csrf
    <input type="text" name="search" class="form-control">
    <button class="btn btn-primary">search</button>
</form>

<table class="table table-bordered">
    <tr>
        <th>Table name</th>
        <th>Fields</th>
    </tr>
    @foreach ($rows as $row)
        <tr>
            <td>{{ $row['name'] }}
                <br/>model exists ?
                @if ($model_service->modelExistsByTableName($row['name']))
                <b style="color:darkgreen">SI</b>
                @else
                <b style="color:darkred">NO</b>
                @endif

            </td>
            <td>
                <table  class="table table-bordered">
                    <tr>
                        <th>Field Name</th>
                        <th>Field Type</th>
                    </tr>
                    @foreach ($row['fields'] as $field)
                        <tr><td>{{ $field['name'] }}</td><td>{{ $field['type'] }}</td></tr>
                    @endforeach
                </table>
            </td>
        </tr>
    @endforeach
</table>

@endsection
