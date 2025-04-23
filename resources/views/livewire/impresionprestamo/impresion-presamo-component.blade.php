@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection

<article class="container">
    <h3 class="">Responsiva: {{ $this->responsable($prestamo->reponsable) }}</h3>
    </div>
    <center>
        <img src="{{ url('img/logo.jpeg') }}" style="width:40%">
    </center>
    <div class="row">
        <div class="col-4">
            <b>Codigo:</b> {{ $prestamo->codigo }}
        </div>
        <div class="col-4">

        </div>
        <div class="col-4">
            <b>Fecha remision:</b> <?= date('d-m-Y') ?>
        </div>
        <div class="col-md-12"><br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ACCESORIOS INCLUIDOS</th>
                        <th>C</th>
                        <th>E</th>
                        <th>Comentarios</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tabla as $key)
                        <tr>
                            <td>{{ $this->herramientas($key->herr) }} NS: <b><?= $key->numserie ?></b>
                                MD: <b><?= $key->modelo ?></b></td>
                            @if ($key->modelo == '')
                                <td>{{ $this->suma($key->herr) }} </td>
                                <td>{{ $this->suma($key->herr) }}</td>
                            @else
                                <td>{{ $key->cantidad }}</td>
                                <td>{{ $key->cantidad }}</td>
                            @endif
                            <td>{{$key->com}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            C: cantidad  E: entrega R: recepci&oacute;n
            <div class="text-center" >
                <i>El cual me comprometo, mantener en buen estado y utilizarlo &uacute;nica y exclusivamente para asuntos relacionados con mi actividad laboral. En caso de su exxtravop. daño &oacute; uso inadecuado total o parcial, me responsabilizo oa pagar el costo de reaparaci&oacute;n o la reposici&oacute;n del equipo. La responsibilidad no es transferible.</i>
            
                </div>
                <div class="row">
                <div class="col-md-6">
                    FECHA DE ENTREGA:
                    </div>
                <div class="col-md-6">
                    <b> <?= date('d - m - Y');?></b>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-6 text-center" >             
                    <b>ENTREGA</b><br>
                    
                        <hr>
                        <b>Firma</b>
    
                <label>Nombre:</label><br>
                    {{$user}}<br>
                    <label>Cargo:</label><br>
                        admin
                    </div>
                    
                    <div class="col-md-6" >
                      <center>
                    <b>RECIBE</b><br>
                    <hr>
                        <label>NOMBRE:</label> <br>
                        {{ $this->responsable($prestamo->reponsable) }}<br>
                        <label>CARGO:</label><br>
                     {{ $this->datos_responsable($prestamo->reponsable) }}</b>
                      </center>
                    </div>
                    
                    
                    
                    <div class="col-md-12">
                        <label for="">Comentarios</label><br>
                        <textarea name="" id="" cols="30" rows="2" class="form-control"></textarea><br>
                    <center>
                    <div class="btn-group d-print-none">
                    
                    <button class="btn-info btn" onclick="window.print();">Imprimir</button>
                
                    </div>
                    </center>
                    </div>
                </div>
                    
        </div>
    </div>
</article>
