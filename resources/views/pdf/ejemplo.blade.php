<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
     <style>
        .container{
            margin: 0ox auto;
          
        }
        .col-6{
            width: 50%;
            float: left;
        }
        .col-3{
            width: 33%;
            float: left;
        }
        table {
            width: 100%;
            border: 1px solid #000;
        }

        th,
        td {
            width: 25%;
            text-align: center;
            vertical-align: top;
            border: 1px solid #000;
            border-collapse: collapse;
            padding: 0.3em;
        }
    </style>
     <style>
        .gallery {
            width: 100%;
            overflow: hidden;
        }
        .gallery .item {
            float: left;
            width: 30%;
            margin: 5px;
            text-align: center;
        }
        .gallery .item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div >
        <div class="container"><br>
            <center>
                <img src="{{ url('img/logo.jpeg') }}" style="width:40%"><br>
             <h3>   EXTENSION DE HERRAMIENTAS A PRESTAMO </h3>
            </center>
            <div class="col-3">
                <h4>Responsiva:<br> {{$codigo}}</h4> 
   
        </div>
        <div class="col-3">
            <h4>Responsable:<br>{{$nombre}}</h4>
        </div>
        <div class="col-3">
    <h4>Fecha de prestamo: <br>{{date('d-m-Y')}}</h4>
        </div><br><br><br><br>

        <table class="table">
            <tr>
                
                <th>Numero serie</th>
                <th>Herramienta</th>
                <th>Cantidad</th>
                <th>Comentarios</th>
                <th>Imagen</th>
            </tr>
        
            @foreach ($prestamo as $val) 
    
            <tr>
                <td>{{$val->numser}}</td>
                <td>{{DB::table('herramientas')->where('id',$val->herr)->get()[0]->Herramienta}}</td>
                <td>{{$val->cantidad}}</td>
                <td>{{$val->com}}</td>
                <td> <img src="{{ url('img_herramienta')}}/{{$val->foto }}" class="img-thumbnail" style="width: 100%; height: 50px;">
                </tr>
            @endforeach
        
            </table>
            </div>
            <br><br><br>
            <div style='width:100%;margin-top:25%'>
                    <div style='width:50%;float:left'>
                        <center>
                            <hr>
                            Firma Entrega
                            <br>
                            <br><br>
                            <br>
                        </center <hr width=200>
                    </div>
                    <div style='width:50%;float:left'>
                        <center>
                            <hr>
                            Firma Recibe
                            <br>
                            <br><br>
                            <br>
                        </center <hr width=200>
                    </div>
                    </div>
                    <br>
        </div>
    </div>
    
       
</body>

</html>
