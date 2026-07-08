e type="text/css">
<!--
div.zone
{
    border: solid 2mm #66AACC;
    border-radius: 3mm;
    padding: 1mm;
    background-color: #FFEEEE;
    color: #440000;
}
div.zone_over
{
    width: 30mm;
    height: 35mm;
    overflow: hidden;
}
table
{
    width:  100%;

}
th
{
    text-align: center;
    border: solid 1px #113300;
    background: #EEFFEE;
}
td
{
    text-align: left;
    border-right: solid 1px darkgray;
    border-bottom: solid 1px darkgray;
}
td.col1
{
    border-right: solid 1px darkblue;
    border-bottom: solid 1px darkblue;
    text-align: right;
}
end_last_page div
{
    border: solid 1mm red;
    height: 27mm;
    margin: 0;
    padding: 0;
    text-align: center;
    font-weight: bold;
}
-->
</style>
<page style="font-size: 10pt" backtop="20mm" backbottom="10mm" backleft="5mm" backright="5mm">
	<h3> Stabi-Repar : {{ $row->stabi }}-{{ $row->repar }} <br/>Anno : {{ $row->anno }}</h3>
	<table>
		{{--  <col style="width: 5%" class="col1"> --}}
	    <col style="width: 20%">
	    <col style="width: 15%">
	    <col style="width: 12%">
	    <col style="width: 12%">
	    <col style="width: 12%">
	    <col style="width: 12%">
	    <col style="width: 12%">

	    <tr>
	    	<td>[<b style="color:navy">ID</b>] <br/> Dipendente</td>
	    	<td>Categoria</td>
	    	<td>dal<br/>al</td>
	    	<td>archivista<br/>informatico</td>
	        <td>relazioni<br/>pubblico</td>
	        <td>protezione<br/>civile</td>
	        <td>formatore<br/>professionale</td>
	    </tr>
	    @foreach($rows->get() as $row)
	    	<tr>
	    		<td>[<b style="color:navy">{{ $row->id }}</b>] <br/>
	    			{{ $row->ente }}-{{ $row->matr }}<br/>
	    			{{ $row->cognome }} {{ $row->nome }}
	    		</td>
	            <td><small>{{ $row->propro }}-{{ $row->posfun }}</small><br/>
	            	{{ str_replace('Posizione economica','',$row->categoria_eco) }}
	            </td>
	            <td>{{ $row->dali->format('d/m/Y') }} <br/>
	            	{{ $row->ali->format('d/m/Y') }}
	            </td>
	            <td>{{ $row->archivista_informatico }}</td>
	            <td>{{ $row->relazioni_pubblico }}</td>
	            <td>{{ $row->protezione_civile }}</td>
	            <td>{{ $row->formatore_professionale }}</td>
	    	</tr>
	    @endforeach
	</table>

</page>