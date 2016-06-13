@extends ('Layouts.super_admin')

@section ('titulo')
Recibos
@stop


@section ('botones')
<div class="btn-group" role="group" aria-label="...">
	<a href="index.html" class="btn btn-light">Dashboard</a>
	<a href="#" class="btn btn-light"><i class="fa fa-refresh"></i></a>
	<a href="#" class="btn btn-light"><i class="fa fa-search"></i></a>
	<a href="#" class="btn btn-light" id="topstats"><i class="fa fa-line-chart"></i></a>
</div>
@stop

@section ('contenido')
<!-- Start Panel -->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-title">
          DAtaTables
        </div>
        <div class="panel-body table-responsive">

            <table id="example0" class="table display">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Paciente</th>
                        <th>Unidad</th>
                        <th>Concepto</th>
                        <th>Beneficio</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
             
                <tbody>
                    @foreach ($recibos as $recibo)
                      <tr>
                        <td>{{$recibo->id}}</td>
                        <td>{{$recibo->paciente->nombre}}</td>
                        <td>{{$recibo->unidad->nombre}}</td>
                        <td>{{$recibo->concepto->nombre}}</td>
                        <td>{{$recibo->beneficio->empresa->razon_social}}</td>
                        <td>{{$recibo->cantidad}}</td>
                        <td>{{$recibo->fecha}}</td>
                        <td></td>
                        
                       
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