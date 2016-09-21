<?php
  if(Auth::user()->tipo==1)
  {
    $variable = "layouts.super_admin";
  }
  elseif(Auth::user()->tipo==2)
  {
    $variable = "layouts.admin";
  }
  elseif(Auth::user()->tipo==3)
  {
    $variable = "layouts.gerente";
  }
?>
@extends("$variable")
@section('titulo') Empresas  
@endsection
@section('tituloModulo')
Empresas <i class="fa fa-home"></i>
@section ('botones')


<a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
@endsection
@section('panelBotones')

  <li class="checkbox checkbox-primary">
    <a href="#" data-toggle="modal" data-target="#modal_nuevo"  class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
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
                        <th>RFC</th>
                        <th>Telefóno</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Contacto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
             
                <tbody>
                    @foreach ($empresas as $empresa)
                      <tr>
                        <td>{{$empresa->id}}</td>
                        <td>{{$empresa->razon_social}}</td>
                        <td>{{$empresa->rfc}}</td>
                        <td>{{$empresa->telefono}}</td>
                        <td>{{$empresa->correo}}</td>
                        <td>{{$empresa->direccion}}</td>
                        <td>{{$empresa->persona_contacto}}</td>
                         <td><a  href="#" data-toggle="modal" data-target="#modal{{$empresa->id}}" class="btn btn-rounded btn-light">Editar</a>
                            <!-- Modal -->
                                <div class="modal fade" id="modal{{$empresa->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Editar {{$empresa->razon_social}}</h4>
                                      </div>
                                      <form class="form-horizontal" role="form" method="POST" action="{{ route('editarEmpresa',$empresa->id) }}">
                                        {!! csrf_field() !!}  
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Nombre: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="razon_social" value="{{$empresa->razon_social}}" class="form-control form-control-radius" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">RFC: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="rfc" value="{{$empresa->rfc}}" class="form-control form-control-radius" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Telefono: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="telefono" value="{{$empresa->telefono}}" class="form-control form-control-radius" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Correo: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="correo" value="{{$empresa->correo}}" class="form-control form-control-radius" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Dirección: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="direccion" value="{{$empresa->direccion}}" class="form-control form-control-radius" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label " class="col-sm-2 control-label form-label">Contacto: </label>
                                                <div class="col-sm-10">
                                                  <input type="text" name="persona_contacto" value="{{$empresa->persona_contacto}}" class="form-control form-control-radius" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                          
                                          <button type="submit" class="btn btn-default">Guardar</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                              <!-- End Modal Code -->

                        </td>
                       
                    </tr>
                  @endforeach
                </tbody>
            </table>


        </div>

      </div>
    </div>
    <!-- End Panel -->

       <!-- Modal -->
          <div class="modal fade" id="modal_nuevo" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Nuevo proveedor</h4>
                </div>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('guardarEmpresa') }}">
                  {!! csrf_field() !!}  
                  <div class="modal-body">
                      <div class="form-group">
                          <label " class="col-sm-2 control-label form-label">Nombre: </label>
                          <div class="col-sm-10">
                            <input type="text" name="razon_social"  placeholder="Razón social de la empresa" class="form-control form-control-radius" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label " class="col-sm-2 control-label form-label">RFC: </label>
                          <div class="col-sm-10">
                            <input type="text" name="rfc" placeholder="RFC con homoclave" class="form-control form-control-radius" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label " class="col-sm-2 control-label form-label">Telefono: </label>
                          <div class="col-sm-10">
                            <input type="text" name="telefono" placeholder="Número completo" class="form-control form-control-radius" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label " class="col-sm-2 control-label form-label">Correo: </label>
                          <div class="col-sm-10">
                            <input type="email" name="correo"   placeholder="Correo electrónico" class="form-control form-control-radius" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label " class="col-sm-2 control-label form-label">Dirección: </label>
                          <div class="col-sm-10">
                            <input type="text" name="direccion"  placeholder="Calle,Número,CP,Colonia,Municipio,Estado" class="form-control form-control-radius" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label " class="col-sm-2 control-label form-label">Contacto: </label>
                          <div class="col-sm-10">
                            <input type="text" name="persona_contacto" placeholder="Persona con quien contactarse"  class="form-control form-control-radius" >
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