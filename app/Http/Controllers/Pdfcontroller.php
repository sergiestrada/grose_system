<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Prestamos;
use App\Models\Responsables;
use App\Models\Prestamos_medicion;
use App\Models\Responsivas_medicion;
use App\Models\Formato;
use App\Models\Historial_responsivas;
use App\Models\Imagenes_medicion;
use App\Models\Maquinaria;
use App\Models\PrestamosMaquinaria;


class Pdfcontroller extends Controller

{
    public function bouche(Request $request){
        $id = $request->id;
    
        $idprestamo = Historial_responsivas::where('id',$id)->first();
        $dato_prestamo = Prestamos::where('codigo',$idprestamo->codigo)->first();
        $prestamo = Prestamos::whereDate('fecha', '=', now()->toDateString())->where('codigo',$idprestamo->codigo)
        ->get();
		if($dato_prestamo != null){
       $nombre_responsable = Responsables::find($dato_prestamo->responsable);
	   $nombre = $nombre_responsable->Nombre." ".$nombre_responsable->Apellido_P." ".$nombre_responsable->Apellido_M;
		}else{
		$nombre_responsable ='';
		$nombre = '';
		}
        $codigo = $idprestamo->codigo;
        
        $data = array('codigo'=>$codigo,'nombre'=>$nombre,'prestamo'=>$prestamo);
       
        $pdf = Pdf::loadView('pdf.ejemplo',$data);
        return $pdf->stream();
    }
    public function bouche_maquinaria(Request $request){
        $id = $request->id;
        $idprestamo = PrestamosMaquinaria::where('id',$id)->get();
        $datos =  PrestamosMaquinaria::where('id',$id)->first();
        $nombre_responsable = Responsables::find($datos->responsable);
        $codigo = $datos->codigo;
        $nombre = $nombre_responsable->Nombre." ".$nombre_responsable->Apellido_P." ".$nombre_responsable->Apellido_M;
        $data = array('codigo'=>$codigo,'nombre'=>$nombre,'prestamo'=>$idprestamo,'datos'=>$datos);
        $pdf = Pdf::loadView('pdf.ejemplo1',$data);
        return $pdf->stream();
    }
    public function responsiva_pdf(Request $request){
   
       $id = $request->rep;
       $res = $request->id;
       $info_general = Formato::find($id);
       $imagenes = Imagenes_medicion::where('Resp',$id)->get();
       $des = Prestamos_medicion::where('id_resp',$res)->get();
       $res_med = Responsivas_medicion::find($res);
      
       $data = array(
                'id' =>$id,
                'responsiva' =>$res,
                'info' =>$info_general,
                'imagenes' =>$imagenes,
                'des' => $des,
                'res_med' => $res_med
            );
       $pdf = Pdf::loadView('pdf.resposiva_medicion',$data);

       return $pdf->stream();
       /* $id = $request->id;
    
        $idprestamo = Prestamos::where('id',$id)->first();
        $prestamo = Prestamos::where('id',$id)->where('fecha',date('Y-m-d'))->get();
        $nombre_responsable = Responsables::find($idprestamo->responsable);
        $codigo = $idprestamo->codigo;
        $nombre = $nombre_responsable->Nombre." ".$nombre_responsable->Apellido_P." ".$nombre_responsable->Apellido_M;
        $data = array('codigo'=>$codigo,'nombre'=>$nombre,'prestamo'=>$prestamo);
            
      
        $pdf = Pdf::loadView('pdf.ejemplo',$data);
        return $pdf->stream();*/
    }
}
