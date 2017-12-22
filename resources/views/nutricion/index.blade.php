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
                <div class="modal fade" id="modal_nuevo" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header"> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Nuevo Reporte del Nutriólogo</h4>
                      </div>
                     <!-- <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" a>-->
                      <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ route('guardarHojaNutricion') }}">
                        {!! csrf_field() !!}  
                        <div class="modal-body row">
                          <div id="paciente">
                            <div class="col-lg-12 ">
                               <h4 class="center-block">Seleccione un paciente</h4>
                            </div>

                            <div class="col-lg-12">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Paciente</label>
                                <div class="col-sm-10">
                                  <input type="text" name="paciente_id" list="pacientes" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="antropometria" style="height: 400px; overflow-y: scroll">
                            <div class="col-lg-12 ">
                               <h4 class="center-block">ANTROPOMETRÍA</h4>
                            </div>
                            <div class="col-lg-12 center-block">
                               <h5>COMPARTIMENTOS CORPORALES POR BIOIMPEDANCIA</h5>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Grasa: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="grasa" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">MM: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="mm" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Agua: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="agua" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">GV: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="gv" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">IMC: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="imc" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Peso seco: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="peso_seco" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12 center-block">
                               <h5>CIRCUNFERENCIAS Y PLIEGUES CUTANEOS</h5>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Estatura: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="estatura" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">CMB: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="cmb" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">C. Muñeca: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="c_m" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">PCT: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="pct" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Complexion: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="complexion" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">AMBd%: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="ambd" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="analisis-bio" style="height: 400px; overflow-y: scroll;">
                            <div class="col-lg-12 center-block">
                               <h4>ANÁLISIS BIOQUIMICO</h4>
                            </div>
                            <div class="col-lg-12 center-block">
                               <h5>QUÍMICA SANGUINEA</h5>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Glucosa: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="glucosa" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Urea: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="urea" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Creatitina: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="creatitina" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Ácido úrico: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="acido_urico" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                             <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">BUN: </label>
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
                                <label class="col-sm-2 control-label form-label">HB: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="hb" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Hto: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="hto" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">VCM: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="vcm" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">WBC: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="wbc" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">RBC: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="rbc" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">PLQ: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="plq" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Leucocitos: </label>
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
                                <label class="col-sm-2 control-label form-label">Albúmina: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="albumina" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">PTS Totales: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="pts_totales" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Globulinas: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="globulinas" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12 center-block">
                               <h5>PERFIL DE LIPIDOS</h5>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Colesterol: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="colesterol" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Triglecéridos: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="trigleceridos" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">HDL: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="hdl" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">LDL: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="ldl" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">VLDL: </label>
                                <div class="col-sm-10">
                                  <input type="number" name="vldl" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>

                             <div class="col-lg-12 center-block">
                               <h5>ELECTROLITOS SERICOS</h5>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Potasio(K): </label>
                                <div class="col-sm-10">
                                  <input type="number" name="potasio" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Sodio(Na): </label>
                                <div class="col-sm-10">
                                  <input type="number" name="sodio" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                             <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Fosforo(P): </label>
                                <div class="col-sm-10">
                                  <input type="number" name="fosforo" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Calcio(Ca): </label>
                                <div class="col-sm-10">
                                  <input type="number" name="calcio" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Magnesio (Mg): </label>
                                <div class="col-sm-10">
                                  <input type="number" name="magnesio" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Cloro (Cl): </label>
                                <div class="col-sm-10">
                                  <input type="number" name="cloro" step=".01" class="form-control form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                        </div>
                        <div id="exploracion-fisica">
                            <div class="col-lg-12 center-block">
                               <h4>EXPLORACION FISICA </h4>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group ">
                               <textarea class="form-control" name="exploracion_fisica" rows="10" height="200px"></textarea>
                              </div>
                            </div>
                        </div>
                        <div id="tratamiento-medico">
                            <div class="col-lg-12 center-block">
                               <h4>TRATAMIENTO MÉDICO</h4>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Nifedipino: </label>
                                <div class="col-sm-10">
                                  <input type="text" name="nifedipino"  class="form-control form-control" placeholder="0-0-0 (Dosis)">
                                </div>
                              </div>
                            </div>
                           
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Furosemida: </label>
                                <div class="col-sm-10">
                                  <input type="text" name="furosemida"  class="form-control form-control" placeholder="0-0-0 (Dosis)">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Tribedoce: </label>
                                <div class="col-sm-10">
                                  <input type="text" name="tribedoce"  class="form-control form-control" placeholder="0-0-0 (Dosis)">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Omeprazol: </label>
                                <div class="col-sm-10">
                                  <input type="text" name="omeprazol"  class="form-control form-control" placeholder="0-0-0 (Dosis)">
                                </div>
                              </div>
                            </div>
                             <div class="col-lg-4">
                              <div class="form-group ">
                                <label class="col-sm-2 control-label form-label">Ácido úrico: </label>
                                <div class="col-sm-10">
                                  <input type="text" name="acido_folico"  class="form-control form-control" placeholder="0-0-0 (Dosis)">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="valor-nutricional">
                            <div class="col-lg-12 center-block">
                               <h4>VALORACIÓN NUTRICIONAL</h4>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group ">
                               <textarea class="form-control" name="valoracion" rows="10" height="200px"></textarea>
                              </div>
                            </div>
                          </div>
                          <div id="indicaciones-nutricionales">
                            <div class="col-lg-12 center-block">
                               <h4>INDICACIONES NUTRICIONALES</h4>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group ">
                               <textarea class="form-control" name="indicaciones" rows="10" height="200px"></textarea>
                              </div>
                            </div>
                          </div>
                          <div id="valoracion-medica">
                            <div class="col-lg-12 center-block">
                               <h4>VALORACIÓN MEDICA </h4>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group ">
                               <textarea class="form-control" name="valoracion_medica" rows="10" height="200px"></textarea>
                              </div>
                            </div>
                          </div>
                          <div id="indicaciones-medicas">
                            <div class="col-lg-12 center-block">
                               <h4>INDICACIONES MEDICAS </h4>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group ">
                               <textarea class="form-control" name="indicaciones_medicas" rows="10" height="200px"></textarea>
                              </div>
                            </div>
                          </div>
                          <div id="nota-medica">
                            <div class="col-lg-12 center-block">
                               <h4>NOTA MEDICA DE SEGUIMIENTO</h4>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group ">
                               <textarea class="form-control" name="nota_medica" rows="10" height="200px"></textarea>
                              </div>
                            </div>
                          </div>
                          <div id="valoracion-nutricional-seguimiento">
                            <div class="col-lg-12 center-block">
                               <h4>VALORACION NUTRICIONAL DE SEGUIMIENTO </h4>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group ">
                               <textarea class="form-control" name="valoracion_nutricional_seguimiento" rows="10" height="200px"></textarea>
                              </div>
                            </div>
                          </div>

                          <div id="malnutricion" style="height: 400px; overflow-y: scroll;">
                            <div class="col-lg-12 center-block">
                               <h4>ESCALA DE MALNUTRICIÓN ADAPTADA DE LA SGA PARA PACIENTES EN HEMODIÁLISIS:</h4>
                            </div>
                            <div class="col-lg-12 center-block">
                              <h5>1.CAMBIO DE PESO (cambio total en los últimos 6 meses)</h5>
                                <div class="radio-inline">
                                  <input type="radio" name="cambio_de_peso" value="1">
                                  <label class="control-label form-label">1-Sin cambio de peso o ganancia</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="cambio_de_peso" value="2">
                                  <label class="control-label form-label">2-Pérdida de peso < 5%</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="cambio_de_peso" value="3">
                                  <label class="control-label form-label">3-Pérdida de peso de 5 a 10 %</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="cambio_de_peso" value="4">
                                  <label class="control-label form-label">4-Pérdida de peso de 10-15%</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="cambio_de_peso" value="5">
                                  <label class="control-label form-label">5-Pérdida de peso > 15%</label>
                                </div>
                            </div>
                            <div class="col-lg-12 center-block">
                              <h5>2.INGESTA DIETÉTICA</h5>
                                <div class="radio-inline">
                                  <input type="radio" name="ingesta_dietetica" value="1">
                                  <label class="control-label form-label">1-Sin cambio</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="ingesta_dietetica" value="2">
                                  <label class="control-label form-label">2-Dieta sólida sub-óptima</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="ingesta_dietetica" value="3">
                                  <label class="control-label form-label">3-Dieta líquida o disminución general moderada</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="ingesta_dietetica" value="4">
                                  <label class="control-label form-label">4-Liquida hipocalórica</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="ingesta_dietetica" value="5">
                                  <label class="control-label form-label">5-Anorexia, inanición</label>
                                </div>
                            </div>
                            <div class="col-lg-12 center-block">
                              <h5>3.SINTOMAS GASTROINTESTINALES</h5>
                                <div class="radio-inline">
                                  <input type="radio" name="sintomas_gastrointestinales" value="1">
                                  <label class="control-label form-label">1-Sin síntomas</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="sintomas_gastrointestinales" value="2">
                                  <label class="control-label form-label">2-Náusea</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="sintomas_gastrointestinales" value="3">
                                  <label class="control-label form-label">3-Vómito y síntomas GI moderados</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="sintomas_gastrointestinales" value="4">
                                  <label class="control-label form-label">4-Diarrea</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="sintomas_gastrointestinales" value="5">
                                  <label class="control-label form-label">5-Anorexia severa</label>
                                </div>
                            </div>
                            <div class="col-lg-12 center-block">
                              <h5>4.CAPACIDAD FUNCIONAL (Discapacidad funcional relacionado con la nutrición)</h5>
                                <div class="radio-inline">
                                  <input type="radio" name="capacidad_funcional" value="1">
                                  <label class="control-label form-label">1-Sin dificultad</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="capacidad_funcional" value="2">
                                  <label class="control-label form-label">2-Ambulación con dificultad</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="capacidad_funcional" value="3">
                                  <label class="control-label form-label">3-Actividad normal con dificultad</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="capacidad_funcional" value="4">
                                  <label class="control-label form-label">4-Actividad ligera</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="capacidad_funcional" value="5">
                                  <label class="control-label form-label">5-Muy poca actividad, silla-cama</label>
                                </div>
                            </div>
                            <div class="col-lg-12 center-block">
                              <h5>5.COMORBILIDADES</h5>
                                <div class="radio-inline">
                                  <input type="radio" name="comorbilidades" value="1">
                                  <label class="control-label form-label">1-MDH < 12 meses Y sano</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="comorbilidades" value="2">
                                  <label class="control-label form-label">2-MDH de 1 a 2 años y comorbilidad leve</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="comorbilidades" value="3">
                                  <label class="control-label form-label">3-MDH de 2 a 4 años >75 años y comorbilidad moderada</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="comorbilidades" value="4">
                                  <label class="control-label form-label">4- > de 4 años y comorbilidad severa </label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="comorbilidades" value="5">
                                  <label class="control-label form-label">5-Múltiples  y comorbilidades</label>
                                </div>
                            </div>
                            <div class="col-lg-12 center-block">
                              <h5>6.EXAMEN FISICO. PÉRDIDA DE GRASA SUBCUTÁNEA (debajo de ojos, bíceps, tríceps)</h5>
                                <div class="radio-inline">
                                  <input type="radio" name="examen_fisico" value="1">
                                  <label class="control-label form-label">1-Sin pérdida</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="examen_fisico" value="3">
                                  <label class="control-label form-label">3-Moderada </label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="examen_fisico" value="5">
                                  <label class="control-label form-label">5-Severa </label>
                                </div>
                            </div>
                            <div class="col-lg-12 center-block">
                              <h5>7.SIGNOS DE PÉRDIDA MUSCULAR (sienes, espalda alta, escapula, clavícula, cuádriceps, pantorrilla, hombros, dorso de mano)</h5>
                                <div class="radio-inline">
                                  <input type="radio" name="signos_perdida_muscular" value="1">
                                  <label class="control-label form-label">1-Sin pérdida</label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="signos_perdida_muscular" value="3">
                                  <label class="control-label form-label">3-Moderada </label>
                                </div>
                                <div class="radio-inline">
                                  <input type="radio" name="signos_perdida_muscular" value="5">
                                  <label class="control-label form-label">5-Severa </label>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-white" onclick="reporte.back()">Cerrar</button>
                          <button type="button" class="btn btn-default" onclick="reporte.next()">Siguiente</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

      <!-- End Modal Code -->
    
      <datalist id="pacientes">
        @foreach ($pacientes as $paciente)
          <option value="{{$paciente->id}}-{{$paciente->nombre}}-{{$paciente->unidad->name}}"></option>
        @endforeach
      </datalist>
 
 @endsection

 @section ('js')
<script src="{{asset('js/datatables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/nutricion-reportes.js')}}"></script>
<script>
$(document).ready(function() {
    $('#example0').DataTable();
} );
function enviar(){
  /*$('form').submit(function(){
  $(this).find(':submit').remove();
  $('#loading').append('<img class="img responsive" width="30" src="{{asset('img/loading.gif')}}">');
});*/
}
</script>


@stop


