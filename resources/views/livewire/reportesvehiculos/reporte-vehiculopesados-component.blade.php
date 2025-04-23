@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection
<article class="container-fluid">

    <div class="row">
        <section class="col-md-8"><br>
       
        </section>
        <section class="col-md-4 d-print-none" ><br>
            <button id="generatePDF"  class="btn btn-sm">Generar PDF</button>
            <button id="exportExcel" class="btn btn-sm">Exportar a Excel</button>
            <button class="btn btn-sm"  onclick="window.print();">Imprimir</button>
            
        </section>
        <section class="col-md-12" id="myContent">
            @php 
             $datos = App\Models\Bitacora_vehiculos_pesados::where('num_int',$numint)->first();
            @endphp
    <img  src="{{url('img/logo.jpeg')}}" style="width:20%;height:50px" id="salesImage" >
    <h2>{{ $pageTitle }}</h2><br>
         <h2> <b> @if($datos->Nombre_Vehiculo != ''){{$datos->Nombre_Vehiculo}}@endif</b></h2>
            <div class="table-responsive" wire:ignore>
                @php  $total = 0; @endphp
                <table class="table" id="example">
                    <thead>
                        <thead>
                            <th>Fecha actualizacion</th>
                            <th>Servicio</th>
                            <th>Proveedor</th>
                            <th>Mecanico</th>
                            <th>Tipo mecanico</th>
                            <th>Act</th>
                            <th>Prox.S</th>
                            <th>Comentario</th>
                            <th class="monto" style="display:">Monto</th>
                        </thead>

                    </thead>
                    <tbody>
                        @foreach ($tabla as $key)
                            <tr>
                                <td><?= $key->fecha ?></td>
                                <td><?= $key->servicio ?></td>
                                <td><?= App\Models\Proveedores::where('id', $key->proveedor)->first()->Nombre_Proveedor ?></td>
                                <td>
                                    @if ($key->t_mecanico == 1)
                                        @php    $data = App\Models\Mecanico_Interno::where('id', $key->mecanico)->first(); @endphp
                                    @else
                                        @php    $data = App\Models\Mecanico_Externo::where('id', $key->mecanico)->first();  @endphp
                                    @endif
                                    {{ $data->Nombre }}{{ $data->Apellido_P }} {{ $data->Apellido_M }}

                                </td>

                                <td><?php if($key->t_mecanico == 1){?> Interno <?php }else{ ?> Externo<?php }?></td>
                                <td><?= $key->km_anterior ?></td>
                                <td><?= $key->km_actual ?></td>

                               
                                <td><?= $key->comentario ?></td>
                             
                               @php $query = App\Models\Factura::where('iden', $tipo) 
                                ->where('tfactura',$key->id)
                                 ->where('Vh_ligado', $numint)
                                 ->first();
                                 @endphp

                                <td>@if(!empty($query))
                                    {{ number_format($query->monto,2)}} 
                                    @php $total = $total + App\Models\Factura::where('iden', $tipo) 
                                    ->where('tfactura',$key->id)
                                     ->where('Vh_ligado', $numint)
                                     ->get()->sum('monto');
                                     @endphp
                                  @endif
                                 
                                   
                                </td>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                            <td></td>
                           
                            <td>Total</td>
                            <td colspan="2"><b>$ {{number_format($total,2)}}</b></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </div>
</article>
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
      document.addEventListener('DOMContentLoaded', function() {
        $('#exportExcel').on('click', function() {
                // Crear un nuevo libro de trabajo
                var workbook = new ExcelJS.Workbook();
                var worksheet = workbook.addWorksheet("Reporte_vehiculos");

                // Extraer y agregar textos
                worksheet.addRow([$('#myContent h2').text()]);
                worksheet.addRow([$('#myContent p').first().text()]);

                // Extraer y agregar tablas
                $('#myContent table').each(function() {
                    $(this).find('tr').each(function() {
                        var rowData = [];
                        $(this).find('th, td').each(function() {
                            rowData.push($(this).text());
                        });
                        worksheet.addRow(rowData);
                    });
                });

                worksheet.addRow([]); // Añadir una fila vacía como separación
                worksheet.addRow([$('#myContent p').last().text()]);

                // Procesar imagen
                var img = document.getElementById('salesImage');
                var imgCanvas = document.createElement('canvas');
                var imgContext = imgCanvas.getContext('2d');

                // Asegurarse de que el canvas tenga las mismas dimensiones que la imagen
                imgCanvas.width = img.width;
                imgCanvas.height = img.height;

                // Dibujar la imagen en el canvas
                imgContext.drawImage(img, 0, 0, img.width, img.height);

                // Convertir el canvas a un Blob
                imgCanvas.toBlob(function(blob) {
                    var reader = new FileReader();
                    reader.onload = function() {
                        var imgBuffer = reader.result;

                        // Agregar la imagen al workbook
                        var imageId = workbook.addImage({
                            base64: imgBuffer,
                            extension: 'png',
                        });

                        worksheet.addImage(imageId, {
                            tl: { col: 0, row: worksheet.lastRow.number + 1 },
                            ext: { width: img.width, height: img.height }
                        });

                        // Generar el archivo Excel
                        workbook.xlsx.writeBuffer().then(function(buffer) {
                            var blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
                            saveAs(blob, "Reporte.xlsx");
                        });
                    };
                    reader.readAsDataURL(blob);
                });
            });
            $('#generatePDF').on('click', function() {
        // Selecciona el contenido del div que deseas exportar a PDF
        var content = document.getElementById('myContent');

        // Usa html2canvas para capturar el contenido como una imagen
        html2canvas(content).then(canvas => {
            var imgData = canvas.toDataURL('image/png');
            var pdf = new jspdf.jsPDF('p', 'mm', 'a4');
            var imgWidth = 210; // Ancho máximo de la página A4 en milímetros
            var pageHeight = 297; // Alto máximo de la página A4 en milímetros
            var imgHeight = canvas.height * imgWidth / canvas.width;
            var heightLeft = imgHeight;
            var position = 0;

            // Agrega la imagen capturada al PDF
            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            // Si el contenido es mayor que una página, se agregarán páginas adicionales
            while (heightLeft >= 0) {
                position = heightLeft - imgHeight;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }

            // Descargar el PDF
            pdf.save('Reporte_vehiculos.pdf');
        });
    });
    })
</script>
 @stop
