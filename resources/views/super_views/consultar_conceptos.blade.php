@extends ('Layouts.super_admin')

@section ('titulo')
Conceptos
@stop


@section ('botones')
<a href="crear_concepto" class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
@stop

@section ('contenido')
<!-- Start Panel -->
    <div class="col-md-12">
    @if(Session::has('message'))
          <div  class="alert alert-{{ Session::get('class') }} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong> {{ Session::get('message')}} </strong>
          </div>
        @endif
      <div class="panel panel-default">
        <div class="panel-title">
          DAtaTables
        </div>
        <div class="panel-body table-responsive">

            <table id="example0" class="table display">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
             
                <tbody>
                    @foreach ($conceptos as $concepto)
                      <tr>
                        <td>{{$concepto->id}}</td>
                        <td>{{$concepto->nombre}}</td>
                        <td>
                        @if($concepto->estatus == 1)
                            <a  href="#" class="btn btn-rounded btn-success btn-xs">
                              <i class="fa fa-check"></i>
                              Habilitado
                            </a>
                        @elseif($concepto->estatus == 2)
                            <a href="#" class="btn btn-rounded btn-danger btn-xs">
                              <i class="fa fa-remove"></i>
                              Inhabilitado
                            </a>
                        @endif
                        
                        </td>
                        <td><a  href="editar_concepto/{{$concepto->id}}" class="btn btn-rounded btn-light">Editar</a></td>
                        
                       
                    </tr>
                  @endforeach
                </tbody>
            </table>


        </div>

      </div>
    </div>
    <!-- End Panel -->
@stop

@section ('js')
<script src="js/datatables/datatables.min.js"></script>
<script>
$(document).ready(function() {
    $('#example0').DataTable();
} );
</script>

@stop