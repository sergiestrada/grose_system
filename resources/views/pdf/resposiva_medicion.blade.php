<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<style>
.con{
	width:100%;
	margin: 0 auto;
}
.sc1{
	width:50%;
	float:left;
}
.cabecera{
	heigth:300px;
	width:100%;
}
.seconcbc{
	width:100%;
	font-size:75%;
}
table {
	width:100%;
	
}

th, td {
	text-align: left;
	vertical-align: top;

	border-spacing: 0;
}

</style>
		<div class='con'>
			<div class='cabecera'>
				<div style='width: 20%; float: left'>
                <img src="{{ url('img/logo.jpeg') }}"  style= 'width:100%' height:60><br>
				</div>
				<div style='width: 60%; padding-top: 18px; padding-bottom: 13px; float: left; font-size: 100%'>
					<center><b> ASIGNACIÓN<br> EQUIPO DE MEDICIÓN: <br></b></center>
				</div>
				<div style='width: 20%; float: left; height: 69px'><br>
					<center><b></b></center>
				</div>
			</div>
			<br><br><br><br>
			<div style='font-size:100%;width:100%;font-size:80%'>
				INSTRUMENTO: <b>{{  $info->nom_equi  }}</b>
			</div>
			<div class='seconcbc'>
				<div style='width:25%;float:left'>
					<b>CLAVE:</b><br>{{  $info->clave  }} 
				</div>
				<div style='width:25%;float:left'>
					<b>MARCA:</b><br> {{  $info->marca  }}
				</div>
				<div style='width:25%;float:left'>
					<b>MODELO:</b><br> {{  $info->modelo  }}
				</div>
				<div style='width:25%;float:left'>
					<b>SERIE:</b><br>{{  $info->serie  }}
				</div>
			</div>
			<br><br>
			<div class='sc1'>
				@foreach($imagenes as $val)
				<img src="{{ url('images')}}/{{ $val->Dir}}" style='width:100%;height:100px'><br>
				@endforeach
			</div>
			<div class='sc1' style='margin-bottom:80px;font-size:12px;font-family:arial'>
			<table>
		<tr>
			<th><b>ACCESORIOS INCLUIDOS</b></th>
			<th>C</th>
			<th>E</th>
			<th>R</th>
		</tr>
		@foreach($des as $key)
		<tr>
			<td>{{ DB::table('desc_form_med')->where('id',$key->herr)->get()[0]->Descripcion}}</td>
			<td>{{$key->cantidad }}</td>
			<td>{{$key->cantidad_e}}</td>
			<td></td>
		</tr>
		@endforeach
	</table>
</div>


</div>
<div style='width:100%'>
<br><br><br><br>
<div style='width:100%;margin-top:50%;font-size:12px'>
C: cantidad E: entrega R: recepción<br>
<i>El cual me comprometo, mantener en buen estado y utilizarlo única y exclusivamente para asuntos relacionados con mi actividad laboral. En caso de su extravío, daño o uso inadecuado total o parcial, me responsabilizo a pagar el costo de reparación o la reposición del equipo. La responsabilidad no es transferible.</i>

<table style='width:100%;'>
	<tr>
		<th>Empresa/Obra</th>
		<th> {{$res_med->obra}}</th> 
	</table>
	Fecha entrega:{{date('d m Y')}}
	<table style='width:100%'>
		<tr>
			<th>Entrega<br>
			Nombre:<br>
			Cargo:</th>
			<th>
				<br><center>{{$res_med->encargado}}<br>
					{{$res_med->cargo_e}}</center>
			</th>
			<th>
				<br><br>Firma
			</th>
		</tr>
		<tr>
			<th>Recibe<br>
			Nombre:<br>
			Cargo:</th>
			<th>
			@php
				$n  = DB::table('responsable')->where('id',$res_med->responsable)->get()[0]->Nombre;
				$ap = DB::table('responsable')->where('id',$res_med->responsable)->get()[0]->Apellido_P;
				$am = DB::table('responsable')->where('id',$res_med->responsable)->get()[0]->Apellido_M;
				$cargo = DB::table('responsable')->where('id',$res_med->responsable)->get()[0]->Cargo;
				@endphp
				<br><center>{{$n}}  {{$ap}} {{$am}} <br> {{$cargo }}</center>
			</th>
			<th>
				<br><br>Firma
			</th>
		</tr>
	</table>

	<b>Comentarios:</b>{{$res_med->com}}

</div>
</div>
</div>
</body>
</html>