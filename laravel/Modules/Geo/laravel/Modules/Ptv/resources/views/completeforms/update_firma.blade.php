rm::model($firma,['url' => $firma->update_url ]) }}
{{ csrf_field() }}
{{ method_field('PUT') }}
{{ Form::bsText('nome_stabi') }}
{{ Form::bsText('nome_diri') }}
<div class="form-group">
	<div class="col-md-8">
	</div>
	<div class="col-md-4">
		<button type="submit" name="_action" value="come_back" class="btn btn-primary">Modifica Firma</button>
	</div>
</div>
{{ Form::close() }}