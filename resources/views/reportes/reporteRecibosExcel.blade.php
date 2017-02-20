<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte hemo</title>

  </head>
  <body>

    <main>

      <table>
        <thead >
          <tr>
            <th ># </th>
            <th >Fecha</th>
            <th >Paciente</th>
            <th >Folio</th>
            <th >Forma de pago</th>
            <th >Precio</th>
          </tr>
        </thead>
          <tbody>
           @foreach($recibos as $key => $recibo)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$recibo->fecha}}</td>
              <td>{{$recibo->paciente->nombre}}</td>
              <td>{{$recibo->folio}}</td>
              <td>{{$recibo->tipo_pago}}</td>
              <td>{{$recibo->cantidad}}</td>
             @endforeach
          </tbody>
        
      </table>
  </body>
</html>