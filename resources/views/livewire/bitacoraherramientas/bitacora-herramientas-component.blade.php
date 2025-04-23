@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection
<article class="container-fluid">

    <div class="row">
   
       
        <section class="col-md-12">
            <div class="row d-print-none">
                <section class="col-md-2">
<div class="form-group">
    <label>Fecha Inicial</label>
    <input class="form-control" wire:model="fecha_inicial" type="date">
</div>
                </section>
                <section class="col-md-2">
                    <div class="form-group">
                        <label>Fecha Final</label>
                        <input class="form-control" wire:model="fecha_fin" type="date">
                    </div>
                </section>
                <section class="col-md-3">
                    <div class="form-group">
                        <label>Estatus</label>
                        <select class="form-control" wire:model="estatus">
                            <option></option>
                            <option value="0">Pendiente..</option>
                            <option value="1">Resuelto</option>
                        </select>
                    </div>
                </section>
                <section class="col-md-4"><br>
                    <button id="generatePDF"  class="btn btn-dark">Generar PDF</button>
                    <button id="exportExcel" class="btn btn-dark">Exportar a Excel</button>
                    <button class="btn btn-dark"  onclick="window.print();">Imprimir</button>
                </section>


            </div>
        </section>
        <div  id="myContent">
            <section class="col-md-10"><br>
                <img  src="{{url('img/logo.jpeg')}}" style="width:20%;height:50px" id="salesImage" >     
                 <h2>Bitacora de herramientas {{ $pageTitle }}</h2>
            </section>
       <table class="table">
            <thead class="bg-dark">
                <th>Fecha</th>
                <th>Codigo</th>
                <th>Codigo de barras</th>
                <th>Herramienta</th>
                <th>Comentario</th>
                <th>Fecha de reparacion</th>
                <th>Estatus</th>
            </thead>
            <tbody class="bg-light">
            @foreach($table as $row)
            <tr>
                <td>{{$row->fecha}}</td>
                <td>{{$row->codigo}}</td>
                <td>{{$row->cod_barras}}</td>
                <td>{{$this->herramientas($row->id_her)}}</td>
                <td>{{$row->comentario}}</td>
                <td>{{$row->rep_fecha}}</td>
                <td> @if($row->stat == 0) PENDIENTE...  @else <span class="text-success">Resuelto</span> @endif</td>
            </tr>
            
            @endforeach
            </tbody>
    </table>
       
        </section>
        </div>
    </div>
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
            @if($rol == 'herramientas')
            $('.admin').hide();
            $('.medicion').hide();
            $('.mantenimiento').hide();
@endif
    
        @if($rol == 'medicion')
            $('.admin').hide();
            $('.herramientas').hide();
            $('.mantenimiento').hide();

        
        @endif
        @if($rol == 'mantenimiento')
            $('.admin').hide();
            $('.medicion').hide();
            $('.herramientas').hide();

        
        @endif
         

    })
       



            
</script>
 @stop
