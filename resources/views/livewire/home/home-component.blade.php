
@section('title',$componentName.' | '.$pageTitle)
@section('content_header')
    
@endsection
<br>
<article class="container-fluid">
    <h3>{{$pageTitle}}</h3>

   
</article>
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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