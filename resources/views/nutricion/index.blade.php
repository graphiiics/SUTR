<?php
  if(Auth::user()->tipo==1)
  {
    $variable = "layouts.super_admin";
  }
  elseif(Auth::user()->tipo==2)
  {
    $variable = "layouts.admin";
  }
  elseif(Auth::user()->tipo==4)
  {
    $variable = "layouts.nutriologo";
  }
?>
@extends("$variable")
@section('titulo') Hoja nutricional 
@endsection
@section('tituloModulo')
Hoja nutricional  <i class="fa fa-home"></i>
@endsection
@section ('botones')

<a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i>Nuevo reporte</a>
@endsection
@section('panelBotones')
  <li class="checkbox checkbox-primary">
    <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light cerrarPanel"><i class="fa fa-plus"></i>Nuevo reporte</a>
  </li>
@endsection
 @section('contenido')
        <!-- Start Panel -->
    <div class="col-md-12 col-lg-12">
     @if(Session::has('message'))
          <div  class="alert alert-{{ Session::get('class') }} alert-dismissable kode-alert-click">
                <strong>{{ Session::get('message')}} </strong>
          </div>
        @endif
      <div class="panel panel-default">
        <div class="panel-title">
         
        </div>
        <div class="panel-body table-responsive">

            <table id="example0" class="table display">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Unidad</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                   {{--  @foreach ($reportes as $reporte)
                      <tr>
                        <td>{{$hoja->id}}</td>
                        <td>{{$hoja->paciente->nombre}}</td>
                        <td>{{$hoja->paciente->unidad->name}}</td>
                        <td>{{$hoja->fecha}}</td>
                        <td>Algo lleva aqui!</td>
                    </tr>
                  @endforeach --}}
                </tbody>
            </table>


        </div>

      </div>
    </div>
    <!-- End Panel -->
      <!-- Modal -->
                <div class="modal fade" id="modal_nuevo" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Nuevo Reporte</h4>
                      </div>
                      <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ route('guardarHojaNutricion') }}">
                        {!! csrf_field() !!}  
                        <div class="modal-body row">
                            <div class="col-lg-12 ">
                               <h4 class="center-block">ANTROPOMETRÍA</h4>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Grasa: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="grasa" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">MM: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="mm" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Agua: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="agua" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">GV: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="gv" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Peso seco: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="peso_seco" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>


                            <div class="col-lg-12 center-block">
                               <h4>ANÁLISIS BIOQUIMICO</h4>
                            </div>
                            <div class="col-lg-12 center-block">
                               <h5>QUÍMICA SANGUINEA</h5>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Glucosa: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="glucosa" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Urea: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="urea" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Creatitina: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="creatitina" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Ácido úrico: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="acido_urico" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                             <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">BUN: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="bun" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>

                            <div class="col-lg-12 center-block">
                               <h5>QUÍMICA HEMATICA</h5>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">HB: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="hb" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Hto: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="hto" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Leucocitos: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="leucocitos" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12 center-block">
                               <h5>PROTEINAS SERICAS</h5>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Albúmina: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="albumina" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">PTS Totales: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="pts_totales" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12 center-block">
                               <h5>PERFIL DE LIPIDOS</h5>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Colesterol: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="colesterol" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Triglecéridos: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="trigleceridos" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>.

                             <div class="col-lg-12 center-block">
                               <h5>ELECTROLITOS SERICOS</h5>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Potasio(K): </label>
                                <div class="col-sm-10">
                                  <input type="number" name="potasio" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Sodio(Na): </label>
                                <div class="col-sm-10">
                                  <input type="number" name="sodio" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                             <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Fosforo(P): </label>
                                <div class="col-sm-10">
                                  <input type="number" name="fosforo" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Calcio(Ca): </label>
                                <div class="col-sm-10">
                                  <input type="number" name="calcio" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Magnesio (Mg): </label>
                                <div class="col-sm-10">
                                  <input type="number" name="magnesio" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12 center-block">
                               <h4>TRATAMIENTO MÉDICO</h4>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Nifedipino: </label>
                                <div class="col-sm-10">
                                  <input type="text" name="nifedipino"  class="form-control form-control" placeholder="0-0-0 (Dosis)">
                                </div>
                              </div>
                            </div>
                           
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Furosemida: </label>
                                <div class="col-sm-10">
                                  <input type="text" name="furosemida"  class="form-control form-control" placeholder="0-0-0 (Dosis)">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Tribedoce: </label>
                                <div class="col-sm-10">
                                  <input type="text" name="tribedoce"  class="form-control form-control" placeholder="0-0-0 (Dosis)">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Omeprazol: </label>
                                <div class="col-sm-10">
                                  <input type="text" name="omeprazol"  class="form-control form-control" placeholder="0-0-0 (Dosis)">
                                </div>
                              </div>
                            </div>
                             <div class="col-lg-4">
                              <div class="form-group ">
                                <label " class="col-sm-2 control-label form-label">Ácido úrico: </label>
                                <div class="col-sm-10">
                                  <input type="text" name="acido_folico"  class="form-control form-control" placeholder="0-0-0 (Dosis)">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12 center-block">
                               <h4>VALORACIÓN NUTRICIONAL</h4>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group ">
                               <textarea class="form-control" name="valoracion" height="200px"></textarea>
                              </div>
                            </div>
                            <div class="col-lg-12 center-block">
                               <h4>INDICACIONES NUTRICIONALES</h4>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group ">
                               <textarea class="form-control" name="indicaciones" height="200px"></textarea>
                              </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn btn-default" onclick="enviar();">Guardar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

      <!-- End Modal Code -->
    
      
 
 @endsection

 @section ('js')
<script src="{{asset('js/datatables/datatables.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('#example0').DataTable();
} );
function enviar(){
  $('form').submit(function(){
  $(this).find(':submit').remove();
  $('#loading').append('<img class="img responsive" width="30" src="{{asset('img/loading.gif')}}">');
});
}
</script>


@stop


