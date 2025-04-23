@include('common.modalHead')

<h1>Comentarios</h1>
<div class="form-group">
    <label>Comentario</label>
    <textarea wire:model="comentario" class="form-control"></textarea>
</div>
<table class="table">
    <thead>
        <th>Fecha</th>
        <th>Comentario</th>
    </thead>
    <tbody>
        @foreach($comens as $row)
        <tr>
            <td>{{$row->created_at}}</td>
            <td>{{$row->comentario}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@include('common.modalFooter')