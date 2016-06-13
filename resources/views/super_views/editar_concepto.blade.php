@extends ('Layouts.in_super_admin')

@section ('titulo')
Editar concepto
@stop


@section ('botones')
<a href="#" class="btn btn-light"><i class="fa fa-plus"></i> Crear Nuevo</a>
@stop

@section ('contenido')
 <!-- Start Row -->
  <div class="row">

    <div class="col-md-12">
      <div class="panel panel-default">

        <div class="panel-title">
          Formulario
          <ul class="panel-tools">
            <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
            <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>

            <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="{{URL::to('actualizar_concepto/').'/'.$concepto->id}}" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="nombre" class="col-sm-2 control-label form-label">Nombre</label>
                  <div class="col-sm-10">
                    <input type="text" value="{{ $concepto->nombre}}"  name="nombre" class="form-control" required>
                  </div>
                </div>

                <button type="submit" class="btn btn-default">Actualizar</button>
              </form> 

            </div>

      </div>
    </div>

  </div>
  <!-- End Row -->
@stop

